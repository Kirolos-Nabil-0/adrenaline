<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDebug3ToSettingWebs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting_webs', function (Blueprint $table) {
            $table->boolean('is_debug_3')->nullable()->default(false)->after('is_debug_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setting_webs', function (Blueprint $table) {
            $table->dropColumn('is_debug_3');
        });
    }
}