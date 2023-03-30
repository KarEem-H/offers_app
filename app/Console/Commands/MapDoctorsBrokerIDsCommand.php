<?php

namespace App\Console\Commands;

use App\Models\BrokerBusinessUnit;
use App\Models\BrokerDoctor;
use App\Models\BusinessUnit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MapDoctorsBrokerIDsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doctors:map_doctors_broker_ids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Map doctors broker ids from online booking db';

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
        DB::beginTransaction();

        $bu = BusinessUnit::where('name', env('BUSINESS_UNIT', 'HJH'))->first();

        $entityIDs = BrokerBusinessUnit::where('business_unit_id', $bu->id)
            ->active()->pluck('EntityID')->toArray();

        $doctors = DB::connection('sqlsrv2')->table('doctor')->whereIn('EntityID', $entityIDs)->get();

        $this->info("Mapping doctors...!");

        foreach ($doctors as $doctor) {
            $brokerDoctor = BrokerDoctor::where('ADS_ID', $doctor->ADS_ID)->whereIn('EntityID', $entityIDs)->first();

            if ($brokerDoctor) {
                $brokerDoctor->update([
                    'booking_broker_id' => $doctor->Broker_ID
                ]);
            }
        }

        $this->info("Mapped successfully!");

        DB::commit();
    }
}
