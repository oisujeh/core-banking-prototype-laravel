<?php

declare(strict_types=1);

namespace App\Infrastructure\Plugins;

use Illuminate\Support\Facades\File;

class PluginSecurityScanner
{
    /**
     * Dangerous patterns to detect in plugin code.
     *
     * @var array<string, string>
     */
    private array $patterns = [
        'eval' => '/\beval\s*\(/i',
        'exec' => '/\bexec\s*\(/i',
        'shell_exec' => '/\bshell_exec\s*\(/i',
        'system' => '/\bsystem\s*\(/i',
        'passthru' => '/\bpassthru\s*\(/i',
        'proc_open' => '/\bproc_open\s*\(/i',
        'popen' => '/\bpopen\s*\(/i',
        'backtick' => '/`[^`]+`/',
        'raw_sql' => '/\bDB::raw\s*\(/i',
        'raw_query' => '/\bDB::statement\s*\(/i',
        'file_get_contents' => '/\bfile_get_contents\s*\(\s*[\'"]https?:/i',
        'curl' => '/\bcurl_exec\s*\(/i',
        'unserialize' => '/\bunserialize\s*\(/i',
        'base64_decode_exec' => '/\bbase64_decode\s*\(.*\beval\b/i',
        'env_access' => '/\benv\s*\(\s*[\'"][A-Z_]*(?:KEY|SECRET|PASSWORD|TOKEN)/i',
    ];

    /**
     * Scan a plugin directory for security issues.
     *
     * @return array{safe: bool, issues: array<array{file: string, line: int, type: string, code: string}>}
     */
    public function scan(string $pluginPath): array
    {
        $issues = [];

        if (! File::isDirectory($pluginPath)) {
            return ['safe' => true, 'issues' => []];
        }

        $files = File::allFiles($pluginPath);

        foreach ($files as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $content = $file->getContents();
            $lines = explode("\n", $content);

            foreach ($lines as $lineNumber => $line) {
                foreach ($this->patterns as $type => $pattern) {
                    if (preg_match($pattern, $line)) {
                        $issues[] = [
                            'file' => $file->getRelativePathname(),
                            'line' => $lineNumber + 1,
                            'type' => $type,
                            'code' => trim($line),
                        ];
                    }
                }
            }
        }

        return [
            'safe' => empty($issues),
            'issues' => $issues,
        ];
    }

    /**
     * Get a summary of scan results.
     *
     * @param  array<array{file: string, line: int, type: string, code: string}>  $issues
     * @return array<string, int>
     */
    public function summarize(array $issues): array
    {
        $summary = [];
        foreach ($issues as $issue) {
            $type = $issue['type'];
            $summary[$type] = ($summary[$type] ?? 0) + 1;
        }
        return $summary;
    }

    /**
     * Get the severity level for an issue type.
     */
    public function getSeverity(string $type): string
    {
        $critical = ['eval', 'exec', 'shell_exec', 'system', 'passthru', 'proc_open', 'popen', 'backtick'];
        $high = ['raw_sql', 'raw_query', 'unserialize', 'base64_decode_exec', 'env_access'];
        $medium = ['file_get_contents', 'curl'];

        if (in_array($type, $critical, true)) {
            return 'critical';
        }
        if (in_array($type, $high, true)) {
            return 'high';
        }
        if (in_array($type, $medium, true)) {
            return 'medium';
        }
        return 'low';
    }
}
