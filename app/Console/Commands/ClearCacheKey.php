<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearCacheKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-key {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear a specific cache key';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $key = $this->argument('key');

        if (Cache::forget($key)) {
            $this->info("Cache key '{$key}' cleared successfully.");
        } else {
            $this->warn("Cache key '{$key}' does not exist or could not be cleared.");
        }

        return 0;
    }
}