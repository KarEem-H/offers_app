<?php

/**
 * Created by VsCode.
 * php version 8.0
 * Date: 25/2/23
 * Time: 01:30 م
 *
 * @category CodeSniffer
 * @author   karim <karim.hemida>
 */

namespace App\Console\Commands;

use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * ExpireOffers Command
 */
class ExpireOffers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offer:expire_offers_end_date_less_than_today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire offers that end date less than today';

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
        \Log::info("Expire offers...");
        Offer::whereDate('end_at', '<', Carbon::now()->format('Y-m-d'))
            ->orWhere('status' , 0)
            ->update(['status' => 0, 'show_home' => 0]);
        $this->info('Expired successfully');
    }
}
