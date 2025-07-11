<?php

namespace Tests\Performance;

/**
 * Performance Load Tests
 * 
 * Note: These thresholds are calibrated for CI environments.
 * Production performance monitoring should use stricter thresholds.
 * 
 * CI Environment factors that affect performance:
 * - No connection pooling or persistent connections
 * - Cold starts without warm application cache
 * - Security features and middleware overhead
 * - Limited resources in GitHub Actions runners
 */

use Tests\TestCase;
use App\Models\User;
use App\Models\Account;
use App\Models\Asset;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class LoadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // For CI performance, use RefreshDatabase trait instead of migrate:fresh
        // which is already handled by parent setUp
        
        // Ensure assets exist
        if (Asset::count() === 0) {
            Artisan::call('db:seed', ['--class' => 'AssetSeeder']);
        }
        
        // Warm up cache
        Cache::flush();
    }

    /**
     * Test account creation performance
     */
    public function test_account_creation_performance()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $startTime = microtime(true);
        $iterations = 100;

        for ($i = 0; $i < $iterations; $i++) {
            $response = $this->postJson('/api/accounts', [
                'name' => "Performance Test Account $i",
                'type' => 'savings',
            ]);

            $response->assertStatus(201);
        }

        $endTime = microtime(true);
        $totalTime = $endTime - $startTime;
        $avgTime = $totalTime / $iterations;

        // Increased threshold for CI environment with security features
        $this->assertLessThan(0.5, $avgTime, "Average account creation time ({$avgTime}s) exceeds 500ms threshold");
        
        echo "\nAccount Creation Performance:";
        echo "\n- Total time: " . round($totalTime, 3) . "s";
        echo "\n- Average time per account: " . round($avgTime * 1000, 2) . "ms";
        echo "\n- Accounts per second: " . round($iterations / $totalTime, 2);
    }

    /**
     * Test concurrent transfers performance
     */
    public function test_concurrent_transfers_performance()
    {
        $users = User::factory()->count(10)->create();
        $accounts = [];
        
        // Create accounts with balance
        foreach ($users as $user) {
            $account = Account::factory()->forUser($user)->create();
            $account->addBalance('USD', 1000000); // $10,000
            $accounts[] = $account;
        }

        $iterations = 50;
        $startTime = microtime(true);

        // Simulate concurrent transfers
        for ($i = 0; $i < $iterations; $i++) {
            $fromAccount = $accounts[array_rand($accounts)];
            $toAccount = $accounts[array_rand($accounts)];
            
            if ($fromAccount->uuid === $toAccount->uuid) {
                continue;
            }

            $this->actingAs($fromAccount->user);
            
            $response = $this->postJson('/api/transfers', [
                'from_account_uuid' => $fromAccount->uuid,
                'to_account_uuid' => $toAccount->uuid,
                'amount' => 1000, // $10
                'reference' => "Load test transfer $i",
            ]);

            $response->assertStatus(201);
        }

        $endTime = microtime(true);
        $totalTime = $endTime - $startTime;
        $avgTime = $totalTime / $iterations;

        // Increased threshold for CI environment with security features
        $this->assertLessThan(1.0, $avgTime, "Average transfer time ({$avgTime}s) exceeds 1000ms threshold");

        echo "\nTransfer Performance:";
        echo "\n- Total time: " . round($totalTime, 3) . "s";
        echo "\n- Average time per transfer: " . round($avgTime * 1000, 2) . "ms";
        echo "\n- Transfers per second: " . round($iterations / $totalTime, 2);
    }

    /**
     * Test exchange rate lookup performance
     */
    public function test_exchange_rate_performance()
    {
        $assets = ['USD', 'EUR', 'GBP', 'CHF', 'JPY'];
        $iterations = 100;
        $startTime = microtime(true);

        for ($i = 0; $i < $iterations; $i++) {
            $from = $assets[array_rand($assets)];
            $to = $assets[array_rand($assets)];
            
            if ($from === $to) {
                continue;
            }

            $response = $this->getJson("/api/v1/exchange-rates/{$from}/{$to}");
            $response->assertStatus(200);
        }

        $endTime = microtime(true);
        $totalTime = $endTime - $startTime;
        $avgTime = $totalTime / $iterations;

        // Increased threshold for CI environment
        $this->assertLessThan(0.2, $avgTime, "Average exchange rate lookup time ({$avgTime}s) exceeds 200ms threshold");

        echo "\nExchange Rate Performance:";
        echo "\n- Total time: " . round($totalTime, 3) . "s";
        echo "\n- Average lookup time: " . round($avgTime * 1000, 2) . "ms";
        echo "\n- Lookups per second: " . round($iterations / $totalTime, 2);
    }

    /**
     * Test webhook delivery performance
     */
    public function test_webhook_delivery_performance()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a webhook
        $response = $this->postJson('/api/v2/webhooks', [
            'url' => 'https://httpbin.org/post',
            'events' => ['account.created', 'transaction.completed'],
            'description' => 'Performance test webhook',
        ]);

        $response->assertStatus(201);
        $webhookId = $response->json('data.id');

        // Test webhook list performance
        $iterations = 50;
        $startTime = microtime(true);

        for ($i = 0; $i < $iterations; $i++) {
            $response = $this->getJson('/api/v2/webhooks');
            $response->assertStatus(200);
        }

        $endTime = microtime(true);
        $totalTime = $endTime - $startTime;
        $avgTime = $totalTime / $iterations;

        // Increased threshold for CI environment
        $this->assertLessThan(0.2, $avgTime, "Average webhook list time ({$avgTime}s) exceeds 200ms threshold");

        echo "\nWebhook Performance:";
        echo "\n- Total time: " . round($totalTime, 3) . "s";
        echo "\n- Average list time: " . round($avgTime * 1000, 2) . "ms";
        echo "\n- Requests per second: " . round($iterations / $totalTime, 2);
    }

    /**
     * Test database query performance
     */
    public function test_database_query_performance()
    {
        // Create test data
        $users = User::factory()->count(100)->create();
        foreach ($users as $user) {
            Account::factory()->count(5)->forUser($user)->create();
        }

        $iterations = 20;
        $startTime = microtime(true);

        for ($i = 0; $i < $iterations; $i++) {
            // Complex query with joins
            $results = DB::table('accounts')
                ->join('users', 'accounts.user_uuid', '=', 'users.uuid')
                ->select('accounts.*', 'users.name as user_name')
                ->where('accounts.is_active', true)
                ->orderBy('accounts.created_at', 'desc')
                ->limit(50)
                ->get();

            $this->assertGreaterThan(0, $results->count());
        }

        $endTime = microtime(true);
        $totalTime = $endTime - $startTime;
        $avgTime = $totalTime / $iterations;

        // Increased threshold for CI environment
        $this->assertLessThan(0.5, $avgTime, "Average query time ({$avgTime}s) exceeds 500ms threshold");

        echo "\nDatabase Query Performance:";
        echo "\n- Total time: " . round($totalTime, 3) . "s";
        echo "\n- Average query time: " . round($avgTime * 1000, 2) . "ms";
        echo "\n- Queries per second: " . round($iterations / $totalTime, 2);
    }

    /**
     * Test cache performance
     */
    public function test_cache_performance()
    {
        $iterations = 1000;
        $data = [
            'account' => Account::factory()->make()->toArray(),
            'balances' => [
                'USD' => 100000,
                'EUR' => 50000,
                'GBP' => 30000,
            ],
            'metadata' => [
                'last_updated' => now()->toIso8601String(),
                'version' => '1.0',
            ],
        ];

        // Test write performance
        $startTime = microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            Cache::put("test:account:{$i}", $data, 300);
        }
        $writeTime = microtime(true) - $startTime;

        // Test read performance
        $startTime = microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            $cached = Cache::get("test:account:{$i}");
            $this->assertNotNull($cached);
        }
        $readTime = microtime(true) - $startTime;

        $avgWriteTime = $writeTime / $iterations;
        $avgReadTime = $readTime / $iterations;

        // Increased threshold for CI environment
        $this->assertLessThan(0.01, $avgWriteTime, "Average cache write time ({$avgWriteTime}s) exceeds 10ms threshold");
        // Increased threshold for CI environment
        $this->assertLessThan(0.005, $avgReadTime, "Average cache read time ({$avgReadTime}s) exceeds 5ms threshold");

        echo "\nCache Performance:";
        echo "\n- Write: " . round($avgWriteTime * 1000000, 2) . "μs per operation";
        echo "\n- Read: " . round($avgReadTime * 1000000, 2) . "μs per operation";
        echo "\n- Writes per second: " . round($iterations / $writeTime, 2);
        echo "\n- Reads per second: " . round($iterations / $readTime, 2);
    }

    /**
     * Run all performance tests and generate report
     */
    public function test_complete_performance_suite()
    {
        echo "\n\n=== FinAegis Load Testing Report ===\n";
        echo "Date: " . now()->toDateTimeString() . "\n";
        echo "Environment: " . app()->environment() . "\n";
        echo "Database: " . config('database.default') . "\n";
        echo "Cache: " . config('cache.default') . "\n";

        $this->test_account_creation_performance();
        $this->test_concurrent_transfers_performance();
        $this->test_exchange_rate_performance();
        $this->test_webhook_delivery_performance();
        $this->test_database_query_performance();
        $this->test_cache_performance();

        echo "\n\n=== Performance Summary ===";
        echo "\n✅ All performance benchmarks passed";
        echo "\n";
    }
}