<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImportedComics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imported_comics_data', function (Blueprint $table) {
            // Schema::connection('crm_proxy')->create('usbed_lead_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();


            $table->string('slug')->nullable();
            $table->string('name')->nullable();
            $table->string('img')->nullable();

            $table->longText('bio')->nullable();

            $table->string('active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imported_comics_data');
    }
}
