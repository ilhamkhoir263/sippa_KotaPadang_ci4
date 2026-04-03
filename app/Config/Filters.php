<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        // Tambahan Alias untuk Proteksi Role (Langkah 2)
        'roleAuth'      => \App\Filters\AdminFilter::class,
    ];

    /**
     * List of special required filters.
     */
    public array $required = [
        'before' => [
            'forcehttps', 
            'pagecache',  
        ],
        'after' => [
            'pagecache',   
            'performance', 
            'toolbar',     
        ],
    ];

    /**
     * List of filter aliases that are always applied.
     */
    public array $globals = [
        'before' => [
            // 'honeypot',
            'csrf', // AKTIFKAN: Ini sangat penting untuk keamanan form input_kasus
            'invalidchars',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a particular HTTP method.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any before or after URI patterns.
     */
    public array $filters = [];
}