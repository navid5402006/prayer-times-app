<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\PrayerTimeController;

class UpdatePrayerMeta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:prayer-meta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all prayer times meta descriptions with random variants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting prayer times meta description update...');
        $this->newLine();
        
        // Create controller instance
        $controller = new PrayerTimeController();
        
        // Run the update - FIXED: Changed to bulkUpdateMetaDescriptions()
        $result = $controller->bulkUpdateMetaDescriptions();
        
        // Display result
        $this->line($result);
        
        $this->newLine();
        $this->info('Meta description update completed successfully!');
        
        return Command::SUCCESS;
    }
}