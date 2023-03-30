<?php
/**
 * Created by VsCode.
 * php version 8.0
 * Date: 25/2/23
 * Time: 01:30 م
 *
 * @category CodeSniffer
 * @author   karimhemida
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AddOfferBranchIdToBookingsTable
 *
 * @package App\database\migrations
 */
class AddOfferBranchIdToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(
            'bookings',
            function (Blueprint $table): void {
                $table->unsignedInteger('offer_branch_id')->nullable()->after('branch_id');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table(
            'bookings',
            function (Blueprint $table): void {
                $table->dropColumn('offer_branch_id');
            }
        );
    }
}
