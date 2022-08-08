<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datashare', function (Blueprint $table) {     
            $table->bigInteger('Optimieren');
            $table->bigInteger('Populationsgroeße');
            $table->bigInteger('MaxDurchlaufzeit');
            $table->timestamps();               /*Erstellt "created_at" und "updated_at"*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datashare');
    }
};
