# FinAegis Version Roadmap

## Strategic Vision

Transform FinAegis from a **technically excellent prototype** into the **premier open-source core banking platform** with world-class developer experience and production-ready deployment capabilities.

---

## Version 1.1.0 - Foundation Hardening (COMPLETED)

**Release Date**: January 11, 2026
**Theme**: Code Quality & Test Coverage

### Achievements

| Metric | Before | After | Improvement |
|--------|--------|-------|-------------|
| PHPStan Level | 5 | **8** | +3 levels |
| PHPStan Baseline | 54,632 lines | 9,007 lines | **83% reduction** |
| Test Files | 458 | 499 | +41 files |
| Behat Features | 1 | 22 | +21 features |
| Domain Test Suites | Partial | Complete | 6 new suites |

### Delivered Features
- Comprehensive domain unit tests (Banking, Governance, User, Compliance, Treasury, Lending)
- PHPStan Level 8 compliance with null-safe operators
- CI/CD security audit enforcement
- Event sourcing aggregate return type fixes

---

## Version 1.2.0 - Feature Completion (COMPLETED)

**Release Date**: January 13, 2026
**Theme**: Complete the Platform, Bridge the Gaps

### Achievements

| Category | Deliverables |
|----------|--------------|
| Integration Bridges | Agent-Payment, Agent-KYC, Agent-MCP bridges |
| Enhanced Features | Yield Optimization, EDD Workflows, Batch Processing |
| Observability | 10 Grafana dashboards, Prometheus alerting rules |
| Domain Completions | StablecoinReserve model, Paysera integration |
| TODO Cleanup | 10 TODOs resolved, 2 deferred (external blockers) |

### Focus Areas

```
┌─────────────────────────────────────────────────────────────────────────┐
│                    v1.2.0 FEATURE COMPLETION                            │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                         │
│  ┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐    │
│  │   INTEGRATION   │    │    ENHANCED     │    │   PRODUCTION    │    │
│  │     BRIDGES     │    │    FEATURES     │    │    READINESS    │    │
│  │                 │    │                 │    │                 │    │
│  │ • Agent-Payment │    │ • Yield Optim.  │    │ • Metrics       │    │
│  │ • Agent-KYC     │    │ • EDD Workflows │    │ • Dashboards    │    │
│  │ • Agent-AI      │    │ • Batch Process │    │ • Alerting      │    │
│  └─────────────────┘    └─────────────────┘    └─────────────────┘    │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
```

### Priority 1: Integration Bridges (Phase 6 Completion)

#### 1.1 Agent Payment Bridge
```php
// Connect Agent Protocol to Payment System
class AgentPaymentBridgeService
{
    public function linkWalletToAccount(string $agentDid, string $accountId): void;
    public function processAgentPayment(AgentTransaction $tx): PaymentResult;
    public function syncBalances(string $agentDid): void;
}
```
**Impact**: Enables AI agents to execute real financial transactions
**Effort**: Medium | **Value**: Critical

#### 1.2 Agent Compliance Bridge
```php
// Unified KYC across human and AI agents
class AgentComplianceBridgeService
{
    public function inheritKycFromUser(string $agentDid, string $userId): void;
    public function mapAgentKycTier(AgentKycLevel $level): ComplianceTier;
    public function verifyAgentCompliance(string $agentDid): ComplianceResult;
}
```
**Impact**: Regulatory compliance for AI-driven transactions
**Effort**: Medium | **Value**: Critical

#### 1.3 Agent MCP Bridge
```php
// AI Framework integration with Agent Protocol
class AgentMCPBridgeService
{
    public function executeToolAsAgent(string $agentDid, MCPTool $tool): ToolResult;
    public function registerAgentTools(Agent $agent): void;
    public function auditAgentToolUsage(string $agentDid): AuditLog;
}
```
**Impact**: AI agents can use banking tools with proper authorization
**Effort**: Medium | **Value**: High

### Priority 2: Enhanced Features

#### 2.1 Treasury Yield Optimization
```php
// Complete the portfolio optimization system
class YieldOptimizationService
{
    public function optimizePortfolio(Portfolio $portfolio): OptimizationResult;
    public function calculateExpectedYield(Portfolio $portfolio): YieldProjection;
    public function suggestRebalancing(Portfolio $portfolio): RebalancingPlan;
    public function backtest(Strategy $strategy, DateRange $period): BacktestResult;
}
```
**Impact**: Automated treasury management
**Effort**: High | **Value**: High

#### 2.2 Enhanced Due Diligence (EDD)
```php
// Advanced compliance workflows
class EnhancedDueDiligenceService
{
    public function initiateEDD(string $customerId): EDDWorkflow;
    public function collectDocuments(EDDWorkflow $workflow, array $documents): void;
    public function performRiskAssessment(EDDWorkflow $workflow): RiskScore;
    public function schedulePeriodicReview(string $customerId, Interval $interval): void;
}
```
**Impact**: Regulatory compliance for high-risk customers
**Effort**: Medium | **Value**: High

#### 2.3 Batch Processing Completion
```php
// Complete scheduled and cancellation logic
class BatchProcessingService
{
    public function scheduleBatch(Batch $batch, Carbon $executeAt): string;
    public function cancelScheduledBatch(string $batchId): bool;
    public function processBatchWithProgress(Batch $batch): BatchResult;
    public function retryFailedItems(string $batchId): BatchResult;
}
```
**Impact**: Efficient bulk operations
**Effort**: Low | **Value**: Medium

### Priority 3: Production Readiness

#### 3.1 Observability Stack
```yaml
Metrics:
  - API response times (p50, p95, p99)
  - Transaction processing latency
  - Queue depths and processing times
  - Event sourcing replay times
  - NAV calculation accuracy

Dashboards:
  - Platform Health Overview
  - Domain-specific dashboards (Exchange, Lending, Treasury)
  - Agent Protocol activity
  - Compliance monitoring
  - Financial reconciliation
```

#### 3.2 Alerting Rules
```yaml
Critical Alerts:
  - Transaction settlement failures
  - Compliance check timeouts
  - NAV calculation deviations > 0.1%
  - Database replication lag > 5s
  - Queue backlog > 10,000 items

Warning Alerts:
  - API error rate > 1%
  - Response time p99 > 2s
  - Cache hit rate < 80%
  - Disk usage > 80%
```

### Success Metrics v1.2.0

| Metric | Current | Target |
|--------|---------|--------|
| TODO/FIXME Items | 14 | 0 |
| Phase 6 Integration | Incomplete | Complete |
| Grafana Dashboards | 0 | 10+ |
| Alert Rules | Basic | Comprehensive |
| Agent Protocol Coverage | 60% | 95% |

---

## Version 1.4.1 - Cache Configuration Fix (COMPLETED)

**Release Date**: January 27, 2026
**Theme**: Production Stability Patch

### Summary

Fixes a critical issue where `php artisan optimize` fails in production with "Access denied for user 'root'@'localhost'" error during the `laravel-data` caching step.

### Root Cause

When `DB_CACHE_CONNECTION` was not set in the environment file, Laravel's database cache driver would not properly inherit the configured database credentials, instead falling back to hardcoded MySQL defaults (`root` with empty password).

### Fix Applied

| File | Change |
|------|--------|
| `config/cache.php` | `DB_CACHE_CONNECTION` now defaults to `DB_CONNECTION` value |
| `config/cache.php` | `lock_connection` also inherits from `DB_CONNECTION` |
| `.env.example` | Added documentation for `DB_CACHE_CONNECTION` option |

### Upgrade Notes

No action required. The fix automatically uses your configured `DB_CONNECTION` for cache operations when `DB_CACHE_CONNECTION` is not explicitly set.

---

## Version 1.4.0 - Test Coverage Expansion (COMPLETED)

**Release Date**: January 27, 2026
**Theme**: Comprehensive Domain Test Coverage

### Achievements

| Category | Deliverables |
|----------|--------------|
| AI Domain | 55 unit tests (ConsensusBuilder, AIAgentService, ToolRegistry) |
| Batch Domain | 37 unit tests (ProcessBatchItemActivity, BatchJobData) |
| CGO Domain | 70 unit tests (CgoKycService, InvestmentAgreementService, etc.) |
| FinancialInstitution Domain | 65 unit tests (ComplianceCheckService, PaymentVerificationService, etc.) |
| Fraud Domain | 18 unit tests for FraudDetectionService |
| Wallet Domain | 37 unit tests (KeyManagementService + Value Objects) |
| Regulatory Domain | 13 unit tests for ReportGeneratorService |
| Stablecoin Domain | 24 unit tests for Value Objects |
| Test Utilities | InvokesPrivateMethods helper trait |
| **Total** | **319 new domain tests** |

### Security Hardening

| Fix | Impact |
|-----|--------|
| Rate limiting threshold | Reduced auth attempts from 5 to 3 (brute force protection) |
| Session limit | Reduced max concurrent sessions from 5 to 3 |
| Token expiration | All auth controllers now use `createTokenWithScopes()` |
| API scope bypass | Removed backward compatibility bypass in `CheckApiScope` |
| Agent scope bypass | `AgentScope::hasScope()` returns false for empty scopes |

### CI/CD Improvements

- Deploy workflow improvements with proper skip handling
- Redis service for pre-deployment tests
- Fixed tar file changed warning
- APP_KEY environment variable for build artifacts

---

## Version 1.3.0 - Platform Modularity ✅ COMPLETED

**Release Date**: January 25, 2026
**GitHub Release**: https://github.com/FinAegis/core-banking-prototype-laravel/releases/tag/v1.3.0
**Theme**: Pick-and-Choose Domain Installation

### Architecture Vision

```
┌─────────────────────────────────────────────────────────────────────────┐
│                    v1.3.0 MODULAR ARCHITECTURE                          │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                         │
│  ┌───────────────────────────────────────────────────────────────────┐ │
│  │                         CORE PLATFORM                              │ │
│  │  ┌─────────┐  ┌─────────┐  ┌─────────┐  ┌─────────┐             │ │
│  │  │ Account │  │Compliance│  │  CQRS   │  │  Event  │             │ │
│  │  │ Domain  │  │  Domain  │  │   Bus   │  │Sourcing │             │ │
│  │  └─────────┘  └─────────┘  └─────────┘  └─────────┘             │ │
│  └───────────────────────────────────────────────────────────────────┘ │
│                              ▲ Required                                 │
│  ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─│─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ │
│                              ▼ Optional                                 │
│  ┌───────────────────────────────────────────────────────────────────┐ │
│  │                        OPTIONAL MODULES                            │ │
│  │  ┌─────────┐  ┌─────────┐  ┌─────────┐  ┌─────────┐             │ │
│  │  │Exchange │  │ Lending │  │Treasury │  │Stablecn │             │ │
│  │  └─────────┘  └─────────┘  └─────────┘  └─────────┘             │ │
│  │  ┌─────────┐  ┌─────────┐  ┌─────────┐  ┌─────────┐             │ │
│  │  │Governnce│  │  Agent  │  │   AI    │  │  Wallet │             │ │
│  │  │         │  │Protocol │  │Framework│  │         │             │ │
│  │  └─────────┘  └─────────┘  └─────────┘  └─────────┘             │ │
│  └───────────────────────────────────────────────────────────────────┘ │
│                                                                         │
│  ┌───────────────────────────────────────────────────────────────────┐ │
│  │                     REFERENCE IMPLEMENTATIONS                      │ │
│  │  ┌─────────────────────────────────────────────────────────────┐  │ │
│  │  │                         GCU BASKET                           │  │ │
│  │  │      (Global Currency Unit - Complete Example)               │  │ │
│  │  └─────────────────────────────────────────────────────────────┘  │ │
│  └───────────────────────────────────────────────────────────────────┘ │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
```

### Domain Decoupling Strategy

#### 3.1 Interface Extraction
```php
// Shared contracts for cross-domain communication
namespace App\Domain\Shared\Contracts;

interface AccountOperationsInterface
{
    public function debit(AccountId $id, Money $amount, string $reference): void;
    public function credit(AccountId $id, Money $amount, string $reference): void;
    public function getBalance(AccountId $id, ?Currency $currency = null): Money;
    public function freeze(AccountId $id, string $reason): void;
}

interface ComplianceGatewayInterface
{
    public function checkKycStatus(string $entityId): KycStatus;
    public function performAmlScreening(Transaction $tx): ScreeningResult;
    public function validateTransactionLimits(Transaction $tx): ValidationResult;
}

interface ExchangeRateProviderInterface
{
    public function getRate(Currency $from, Currency $to): ExchangeRate;
    public function convert(Money $amount, Currency $targetCurrency): Money;
}
```

#### 3.2 Module Manifest System
```json
// app/Domain/Exchange/module.json
{
    "name": "finaegis/exchange",
    "version": "1.0.0",
    "description": "Trading and order matching engine",
    "dependencies": {
        "finaegis/account": "^1.0",
        "finaegis/compliance": "^1.0"
    },
    "optional": {
        "finaegis/wallet": "^1.0"
    },
    "provides": {
        "services": [
            "OrderMatchingServiceInterface",
            "LiquidityPoolServiceInterface"
        ],
        "events": [
            "OrderPlaced", "OrderMatched", "TradeExecuted"
        ]
    },
    "routes": "Routes/api.php",
    "migrations": "Database/Migrations",
    "config": "Config/exchange.php"
}
```

#### 3.3 Domain Installation Commands
```bash
# Install specific domains
php artisan domain:install exchange
php artisan domain:install lending
php artisan domain:install governance

# List available domains
php artisan domain:list

# Check domain dependencies
php artisan domain:dependencies exchange

# Remove unused domain
php artisan domain:remove lending --force
```

### GCU Reference Separation

#### 3.4 Example Directory Structure
```
examples/
└── gcu-basket/
    ├── README.md                 # Installation guide
    ├── composer.json             # Package dependencies
    ├── src/
    │   ├── GCUServiceProvider.php
    │   ├── Config/
    │   │   └── gcu.php          # Basket composition config
    │   ├── Services/
    │   │   ├── GCUBasketService.php
    │   │   ├── NAVCalculationService.php
    │   │   └── RebalancingService.php
    │   ├── Aggregates/
    │   ├── Events/
    │   └── Workflows/
    ├── database/
    ├── routes/
    └── tests/
```

### Success Metrics v1.3.0

| Metric | Current | Target |
|--------|---------|--------|
| Cross-domain Dependencies | Tight | Loose (Interface-based) |
| Module Installation Time | N/A | < 5 minutes |
| Domain Removal | Breaking | Non-breaking |
| GCU Separation | Integrated | Standalone Package |
| Developer Onboarding | 2+ hours | < 30 minutes |

---

## Version 2.0.0 - Multi-Tenancy ✅ COMPLETED

**Release Date**: January 28, 2026
**GitHub Release**: https://github.com/FinAegis/core-banking-prototype-laravel/releases/tag/v2.0.0
**Theme**: Enterprise-Ready Multi-Tenant Platform

### Delivered Features

| Phase | Deliverable | PR |
|-------|-------------|----|
| Phase 1 | Foundation POC - stancl/tenancy v3.9 setup | #328 |
| Phase 2 | Migration Infrastructure - 14 tenant migrations | #329, #337 |
| Phase 3 | Event Sourcing Integration | #330 |
| Phase 4 | Model Scoping - 83 models | #331 |
| Phase 5 | Queue Job Tenant Context | #332 |
| Phase 6 | WebSocket Channel Authorization | #333 |
| Phase 7 | Filament Admin Tenant Filtering | #334 |
| Phase 8 | Data Migration Tooling | #335 |
| Phase 9 | Security Audit | #336 |

---

## Version 2.1.0 - Security & Enterprise Features ✅ COMPLETED

**Release Date**: January 30, 2026
**GitHub Release**: https://github.com/FinAegis/core-banking-prototype-laravel/releases/tag/v2.1.0
**Theme**: Security Hardening & Enterprise Features

### Delivered Features

| Feature | Status | PR |
|---------|--------|-----|
| Hardware Wallet Integration (Ledger, Trezor) | ✅ Complete | #341 |
| Multi-Signature Wallet Support (M-of-N) | ✅ Complete | #342 |
| Real-time WebSocket Streaming | ✅ Complete | #343 |
| Kubernetes Native (Helm Charts, HPA, Istio) | ✅ Complete | #344 |
| Security Hardening (ECDSA, PBKDF2, EIP-2) | ✅ Complete | #345 |

### Strategic Pillars

```
┌─────────────────────────────────────────────────────────────────────────┐
│                       v2.0.0 MAJOR EVOLUTION                            │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                         │
│  ┌─────────────────────────────────────────────────────────────────┐   │
│  │                     MULTI-TENANCY                                │   │
│  │  • Tenant isolation at database level                           │   │
│  │  • Per-tenant configuration and branding                        │   │
│  │  • Cross-tenant compliance boundaries                           │   │
│  └─────────────────────────────────────────────────────────────────┘   │
│                                                                         │
│  ┌─────────────────────────────────────────────────────────────────┐   │
│  │                     BLOCKCHAIN NATIVE                            │   │
│  │  • Multi-signature wallet support                               │   │
│  │  • Hardware wallet integration (Ledger, Trezor)                 │   │
│  │  • Cross-chain bridges (EVM, Solana, Cosmos)                    │   │
│  │  • Smart contract deployment and management                     │   │
│  └─────────────────────────────────────────────────────────────────┘   │
│                                                                         │
│  ┌─────────────────────────────────────────────────────────────────┐   │
│  │                     REAL-TIME INFRASTRUCTURE                     │   │
│  │  • WebSocket event streaming                                    │   │
│  │  • Real-time order book updates                                 │   │
│  │  • Live NAV calculations                                        │   │
│  │  • Push notifications for transactions                          │   │
│  └─────────────────────────────────────────────────────────────────┘   │
│                                                                         │
│  ┌─────────────────────────────────────────────────────────────────┐   │
│  │                     KUBERNETES NATIVE                            │   │
│  │  • Helm charts for all components                               │   │
│  │  • Horizontal Pod Autoscaling                                   │   │
│  │  • Service mesh integration (Istio)                             │   │
│  │  • GitOps deployment workflows                                  │   │
│  └─────────────────────────────────────────────────────────────────┘   │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
```

### Feature Set

#### Multi-Tenancy Architecture
```php
// Tenant-aware infrastructure
class TenantManager
{
    public function setCurrentTenant(Tenant $tenant): void;
    public function getCurrentTenant(): ?Tenant;
    public function runForTenant(Tenant $tenant, callable $callback): mixed;
}

// Database scoping
class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('tenant_id', TenantManager::getCurrentTenant()->id);
    }
}
```

#### Hardware Wallet Integration
```php
interface HardwareWalletInterface
{
    public function connect(DeviceType $device): HardwareWallet;
    public function getAccounts(HardwareWallet $wallet): array;
    public function signTransaction(HardwareWallet $wallet, Transaction $tx): SignedTransaction;
    public function verifyAddress(HardwareWallet $wallet, string $path): Address;
}

// Supported devices
enum DeviceType: string
{
    case LEDGER_NANO_S = 'ledger_nano_s';
    case LEDGER_NANO_X = 'ledger_nano_x';
    case TREZOR_ONE = 'trezor_one';
    case TREZOR_MODEL_T = 'trezor_model_t';
}
```

#### Multi-Signature Support
```php
class MultiSigWallet
{
    public function __construct(
        private array $signers,
        private int $requiredSignatures,
    ) {}

    public function initiateTransaction(Transaction $tx, Signer $initiator): PendingTx;
    public function addSignature(PendingTx $tx, Signer $signer, Signature $sig): void;
    public function canExecute(PendingTx $tx): bool;
    public function execute(PendingTx $tx): TransactionResult;
}
```

#### Real-Time Event Streaming
```php
// WebSocket channels
class OrderBookChannel implements PresenceChannel
{
    public function subscribe(string $tradingPair): void;

    public function onOrderPlaced(OrderPlaced $event): void
    {
        $this->broadcast('order.placed', $event->toArray());
    }

    public function onTradeExecuted(TradeExecuted $event): void
    {
        $this->broadcast('trade.executed', $event->toArray());
    }
}

// Client SDK
const orderBook = new FinAegisWebSocket();
orderBook.subscribe('BTC/USD', {
    onOrder: (order) => updateOrderBook(order),
    onTrade: (trade) => updateTrades(trade),
    onNAV: (nav) => updateNAV(nav),
});
```

### Success Metrics v2.0.0

| Metric | Target |
|--------|--------|
| Multi-tenant Support | Full isolation |
| Hardware Wallet Coverage | Ledger + Trezor |
| Real-time Latency | < 50ms |
| Kubernetes Deployment | One-click |
| Cross-chain Support | 5+ networks |

---

## Version 2.2.0 - Mobile Wallet Application (PLANNED)

**Target**: Q1-Q2 2026
**Theme**: Mobile-First Banking Experience
**Repository**: `finaegis-mobile` (separate repository)

### Overview

Build a production-ready Android/iOS mobile wallet application using **Expo (EAS)** that connects to the FinAegis Core Banking API. The mobile app will provide standard wallet functionality including balance management, top-ups, transfers, and real-time notifications.

```
┌─────────────────────────────────────────────────────────────────────────┐
│                    v2.2.0 MOBILE WALLET ARCHITECTURE                     │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                         │
│  ┌───────────────────────────────────────────────────────────────────┐ │
│  │                     MOBILE APP (Expo/React Native)                 │ │
│  │  ┌─────────┐  ┌─────────┐  ┌─────────┐  ┌─────────┐             │ │
│  │  │ Wallet  │  │ Top-Up  │  │Transfer │  │ Trading │             │ │
│  │  │  Home   │  │ Screen  │  │ Screen  │  │ Screen  │             │ │
│  │  └─────────┘  └─────────┘  └─────────┘  └─────────┘             │ │
│  │  ┌─────────┐  ┌─────────┐  ┌─────────┐  ┌─────────┐             │ │
│  │  │  Cards  │  │ History │  │  KYC    │  │Settings │             │ │
│  │  │  Mgmt   │  │  View   │  │ Upload  │  │ Profile │             │ │
│  │  └─────────┘  └─────────┘  └─────────┘  └─────────┘             │ │
│  └───────────────────────────────────────────────────────────────────┘ │
│                              │                                          │
│  ┌───────────────────────────▼───────────────────────────────────────┐ │
│  │                     API LAYER (TypeScript SDK)                     │ │
│  │  • REST Client   • WebSocket Client   • Push Handler              │ │
│  └───────────────────────────────────────────────────────────────────┘ │
│                              │                                          │
│  ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─│─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ │
│                              ▼                                          │
│  ┌───────────────────────────────────────────────────────────────────┐ │
│  │                 BACKEND ENHANCEMENTS (Core Banking)                │ │
│  │  • Mobile Auth (Biometric)  • Push Notifications (FCM/APNS)       │ │
│  │  • Device Management        • WebSocket Broadcasting               │ │
│  └───────────────────────────────────────────────────────────────────┘ │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
```

### Phase 1: Backend API Enhancements (2-3 weeks)

#### 1.1 Mobile Device Management
```php
// New endpoints for device registration
POST   /api/mobile/devices                    # Register device
DELETE /api/mobile/devices/{device_id}        # Unregister device
GET    /api/mobile/devices                    # List user devices

// Device model tracks:
- device_id (UUID)
- user_id (FK)
- platform (ios/android)
- push_token (FCM/APNS token)
- device_name
- app_version
- last_active_at
- biometric_enabled (boolean)
```

#### 1.2 Push Notification Infrastructure
```php
// Firebase Cloud Messaging (FCM) for Android
// Apple Push Notification Service (APNS) for iOS

// Notification types:
- transaction.received    # Incoming payment
- transaction.sent        # Outgoing payment confirmed
- transaction.failed      # Transaction failure
- balance.low             # Low balance alert
- kyc.status_changed      # KYC verification update
- security.login          # New device login
- price.alert             # Price movement alert (optional)
```

#### 1.3 Biometric Authentication
```php
// Device-bound authentication
POST   /api/mobile/auth/biometric/enable     # Enable biometric
POST   /api/mobile/auth/biometric/verify     # Verify biometric token
DELETE /api/mobile/auth/biometric/disable    # Disable biometric

// Flow:
1. User logs in with email/password
2. Prompts to enable biometric
3. Stores device-bound key in secure enclave
4. Future logins use biometric + device key
```

#### 1.4 WebSocket Broadcasting Activation
```php
// Enable Soketi for real-time updates
// Wire domain events to broadcasts:

AccountBalanceUpdated    → tenant.{id}.accounts
TransactionCompleted     → tenant.{id}.transactions
OrderPlaced/Matched      → tenant.{id}.exchange
```

### Phase 2: Mobile App Foundation (3-4 weeks)

#### 2.1 Technology Stack

| Layer | Technology |
|-------|------------|
| **Framework** | Expo SDK 52+ (React Native) |
| **Build Service** | EAS Build (Expo Application Services) |
| **State Management** | Zustand + React Query |
| **Navigation** | Expo Router (file-based) |
| **UI Components** | NativeWind (Tailwind for RN) + Expo UI |
| **Secure Storage** | expo-secure-store |
| **Biometrics** | expo-local-authentication |
| **Push Notifications** | expo-notifications + FCM/APNS |
| **WebSocket** | Socket.io or Pusher React Native |
| **Forms** | React Hook Form + Zod |
| **Charts** | Victory Native or react-native-charts-wrapper |

#### 2.2 App Screens

```
finaegis-mobile/
├── app/                          # Expo Router screens
│   ├── (auth)/                   # Auth group (unauthenticated)
│   │   ├── login.tsx
│   │   ├── register.tsx
│   │   ├── forgot-password.tsx
│   │   └── verify-2fa.tsx
│   ├── (tabs)/                   # Main app (authenticated)
│   │   ├── index.tsx             # Home/Dashboard
│   │   ├── wallet.tsx            # Wallet & Balances
│   │   ├── transactions.tsx      # Transaction History
│   │   ├── exchange.tsx          # Trading (optional Phase 2)
│   │   └── settings.tsx          # Settings & Profile
│   ├── topup/
│   │   ├── index.tsx             # Top-up methods
│   │   ├── bank-transfer.tsx     # Bank transfer instructions
│   │   └── card.tsx              # Card top-up (future)
│   ├── transfer/
│   │   ├── index.tsx             # Send money
│   │   ├── recipient.tsx         # Select recipient
│   │   ├── amount.tsx            # Enter amount
│   │   └── confirm.tsx           # Confirm & send
│   ├── receive/
│   │   └── index.tsx             # QR code & account details
│   ├── kyc/
│   │   ├── index.tsx             # KYC status
│   │   └── upload.tsx            # Document upload
│   └── _layout.tsx               # Root layout
├── components/                    # Shared components
│   ├── BalanceCard.tsx
│   ├── TransactionItem.tsx
│   ├── BiometricPrompt.tsx
│   └── ...
├── services/                      # API services
│   ├── api.ts                    # REST client
│   ├── websocket.ts              # WebSocket client
│   └── push.ts                   # Push notification handler
├── stores/                        # Zustand stores
│   ├── auth.ts
│   ├── wallet.ts
│   └── settings.ts
└── utils/                         # Utilities
    ├── formatters.ts
    ├── validators.ts
    └── crypto.ts
```

### Phase 3: Core Features Implementation (4-5 weeks)

#### 3.1 Authentication & Security

| Feature | Description |
|---------|-------------|
| Email/Password Login | Standard login with Sanctum tokens |
| 2FA Support | TOTP verification screen |
| Biometric Login | Face ID / Fingerprint after initial setup |
| Session Management | Automatic token refresh, logout on inactivity |
| Device Binding | Link biometric auth to specific device |

#### 3.2 Wallet & Balances

| Feature | Description |
|---------|-------------|
| Multi-Asset Dashboard | Show all asset balances (fiat, crypto, GCU) |
| Balance Refresh | Pull-to-refresh + real-time WebSocket updates |
| Asset Details | Tap asset for detailed view with mini-chart |
| Portfolio Value | Total value in user's preferred currency |

#### 3.3 Top-Up Methods

| Method | Implementation |
|--------|----------------|
| Bank Transfer | Display IBAN/account details for manual transfer |
| Custodian Banks | Paysera, Deutsche Bank integration |
| Crypto Deposit | Show wallet address with QR code |
| Card Payment | Future: Stripe integration for card top-ups |

#### 3.4 Transfers & Payments

| Feature | Description |
|---------|-------------|
| P2P Transfer | Send to another FinAegis account |
| External Transfer | Bank transfers via custodian |
| QR Code Payments | Scan QR to pay, generate QR to receive |
| Transaction Confirmation | Biometric/PIN confirmation for sends |
| Transfer History | Filterable transaction list |

#### 3.5 Transaction History

| Feature | Description |
|---------|-------------|
| Infinite Scroll | Paginated history with lazy loading |
| Filters | By date, type, asset, status |
| Search | Search by reference, recipient, amount |
| Export | Download CSV/PDF statement |
| Real-time Updates | Push notification + list refresh |

### Phase 4: Advanced Features (3-4 weeks)

#### 4.1 GCU Trading

| Feature | Description |
|---------|-------------|
| Buy GCU | Purchase GCU with fiat/crypto |
| Sell GCU | Redeem GCU to fiat/crypto |
| Price Chart | Historical GCU price visualization |
| Trading Limits | Display user's daily/monthly limits |

#### 4.2 KYC/Compliance

| Feature | Description |
|---------|-------------|
| KYC Status | Show current verification level |
| Document Upload | Camera/gallery for ID documents |
| Selfie Verification | Liveness check integration |
| Status Tracking | Push notification on approval/rejection |

#### 4.3 Notifications

| Feature | Description |
|---------|-------------|
| Push Notifications | FCM (Android) / APNS (iOS) |
| In-App Notifications | Notification center with history |
| Notification Preferences | User can toggle notification types |

### Success Metrics v2.2.0

| Metric | Target |
|--------|--------|
| App Store Rating | 4.5+ stars |
| Crash-Free Sessions | 99.5%+ |
| Cold Start Time | < 2 seconds |
| API Response Time | < 500ms (p95) |
| Push Delivery Rate | > 95% |
| Biometric Adoption | > 70% of users |
| Daily Active Users | Track baseline |

### Backend Changes Required (Core Banking)

| File/Feature | Changes |
|--------------|---------|
| `app/Models/MobileDevice.php` | New model for device tracking |
| `database/migrations/` | Mobile devices table |
| `app/Http/Controllers/Api/MobileController.php` | Device & biometric endpoints |
| `app/Services/PushNotificationService.php` | FCM/APNS integration |
| `config/broadcasting.php` | Soketi configuration |
| `app/Listeners/BroadcastEventListener.php` | Wire events to broadcasts |
| `.env.example` | Add FCM/APNS credentials |

### New Repository Structure

```
finaegis-mobile/
├── .github/
│   └── workflows/
│       ├── build-android.yml      # EAS build for Android
│       ├── build-ios.yml          # EAS build for iOS
│       └── test.yml               # Jest tests
├── app/                           # Expo Router pages
├── assets/                        # Images, fonts
├── components/                    # Reusable UI components
├── services/                      # API clients
├── stores/                        # State management
├── utils/                         # Helpers
├── app.json                       # Expo configuration
├── eas.json                       # EAS Build configuration
├── package.json
├── tsconfig.json
└── README.md
```

---

## Version 2.3.0 - Industry Leadership (PLANNED)

**Target**: Q3-Q4 2026
**Theme**: AI & Embedded Finance

### Features (Moved from v2.2.0)

#### AI-Powered Banking
```
• Natural language transaction queries
• Anomaly detection with ML models
• Predictive cash flow analysis
• Automated compliance decisions
• Smart contract code generation
```

#### Regulatory Technology (RegTech)
```
• Automated regulatory reporting (MiFID II, GDPR, MiCA)
• Real-time transaction monitoring AI
• Cross-border compliance automation
• Regulatory sandbox integration
```

#### Embedded Finance
```
• Banking-as-a-Service APIs
• White-label mobile SDKs
• Embeddable payment widgets
• Partner integration marketplace
```

#### Decentralized Finance (DeFi) Bridge
```
• DEX aggregation
• Yield farming integration
• Liquidity provision across protocols
• Cross-chain asset management
```

---

## UX/UI Roadmap

### Current State Assessment

```
┌─────────────────────────────────────────────────────────────────────────┐
│                    CURRENT UI/UX INVENTORY                              │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                         │
│  ADMIN PANEL (Filament 3.0)                                            │
│  ├── Account Management ............... ██████████ Complete            │
│  ├── Compliance Dashboard ............. ████████░░ 80%                 │
│  ├── Exchange Monitoring .............. ██████░░░░ 60%                 │
│  ├── Treasury Operations .............. ████░░░░░░ 40%                 │
│  └── Agent Protocol Admin ............. ██████░░░░ 60%                 │
│                                                                         │
│  PUBLIC WEBSITE                                                         │
│  ├── Landing Pages .................... ██████████ Complete            │
│  ├── Documentation .................... ████████░░ 80%                 │
│  └── API Playground ................... ░░░░░░░░░░ Not Started         │
│                                                                         │
│  API DOCUMENTATION (Swagger)                                            │
│  ├── Account API ...................... ██████████ Complete            │
│  ├── Exchange API ..................... ████████░░ 80%                 │
│  ├── Agent Protocol API ............... ██████░░░░ 60%                 │
│  └── Interactive Examples ............. ██░░░░░░░░ 20%                 │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
```

### UX Improvements by Version

#### v1.2.0 - Operational Excellence
```
Priority UX Enhancements:
• Real-time transaction status indicators
• Compliance workflow progress visualization
• Enhanced error messages with recovery suggestions
• Dashboard widgets for key metrics
• Notification center with action items
```

#### v1.3.0 - Developer Experience
```
Developer-Focused UX:
• Interactive API playground with code generation
• Domain installation wizard
• Visual dependency graph explorer
• Configuration validation UI
• One-click demo environment
```

#### v2.0.0 - Professional Polish
```
Enterprise UX Features:
• Multi-tenant dashboard customization
• White-label theming engine
• Accessibility compliance (WCAG 2.1 AA)
• Mobile-responsive admin panel
• Dark mode across all interfaces
• Keyboard shortcuts for power users
```

---

## Risk Mitigation

### Technical Risks

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| Breaking changes in modularity | Medium | High | Comprehensive integration tests |
| Performance regression | Low | High | Benchmark suite, load testing |
| Security vulnerabilities | Low | Critical | Regular security audits, bug bounty |
| Third-party dependency issues | Medium | Medium | Dependency pinning, alternatives |

### Organizational Risks

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|------------|
| Scope creep | High | Medium | Strict version boundaries |
| Resource constraints | Medium | High | Prioritization, community contributions |
| Market timing | Low | Medium | Continuous delivery model |

---

## Governance & Release Process

### Version Numbering

```
MAJOR.MINOR.PATCH

MAJOR: Breaking changes, significant architecture shifts
MINOR: New features, non-breaking enhancements
PATCH: Bug fixes, security updates, documentation
```

### Release Cadence

```
┌─────────────────────────────────────────────────────────────────────────┐
│                      RELEASE SCHEDULE                                   │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                         │
│  MINOR RELEASES (1.x.0)                                                │
│  └── Every 8-12 weeks                                                  │
│                                                                         │
│  PATCH RELEASES (1.x.y)                                                │
│  └── As needed (security within 24-48 hours)                           │
│                                                                         │
│  MAJOR RELEASES (x.0.0)                                                │
│  └── Every 6-12 months                                                 │
│                                                                         │
│  LTS RELEASES                                                          │
│  └── Major versions receive 2 years of security support               │
│                                                                         │
└─────────────────────────────────────────────────────────────────────────┘
```

### Branch Strategy

```
main ─────────●─────────●─────────●─────────●─────────→
              │         │         │         │
              ▼         ▼         ▼         ▼
           release/   release/   release/   release/
           v1.2.0     v1.3.0     v2.0.0     v2.1.0
              │         │         │         │
              ▼         ▼         ▼         ▼
            v1.2.0    v1.3.0    v2.0.0    v2.1.0
            (tag)     (tag)     (tag)     (tag)
```

---

## Summary

| Version | Theme | Key Deliverables | Status |
|---------|-------|------------------|--------|
| **v1.1.0** | Foundation Hardening | PHPStan L8, Test Coverage | ✅ Released 2026-01-11 |
| **v1.2.0** | Feature Completion | Agent Bridges, Yield Optimization | ✅ Released 2026-01-13 |
| **v1.3.0** | Platform Modularity | Domain Decoupling, Module System | ✅ Released 2026-01-25 |
| **v1.4.0** | Test Coverage Expansion | 319 Domain Tests, Security Hardening | ✅ Released 2026-01-27 |
| **v1.4.1** | Patch Release | Database Cache Connection Fix | ✅ Released 2026-01-27 |
| **v2.0.0** | Multi-Tenancy | Team-Based Isolation, 9 Phases | ✅ Released 2026-01-28 |
| **v2.1.0** | Security & Enterprise | Hardware Wallets, K8s, Security Hardening | ✅ Released 2026-01-30 |
| **v2.2.0** | Mobile Wallet App | Expo/EAS Android/iOS, Push Notifications, Biometric Auth | 🎯 Q1-Q2 2026 |
| **v2.3.0** | Industry Leadership | AI Banking, RegTech, Embedded Finance, DeFi | 🎯 Q3-Q4 2026 |

---

*Document Version: 2.2*
*Created: January 11, 2026*
*Updated: January 30, 2026 (v2.2.0 Mobile App Planned)*
*Next Review: After v2.2.0 MVP Release*
