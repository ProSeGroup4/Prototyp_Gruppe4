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
        Schema::create('maschinen', function (Blueprint $table) {
            $table->bigIncrements('Maschinen_ID');           /*bigIncrements für primary key und fortlaufende Nummerierung.*/   
            $table->string('Name')->default('M1.1');
            $table->bigInteger('Durchlaufzeit_pro_Stueck')->default('2');
            $table->bigInteger('Umruestzeit')->default('1');
            $table->string('is_available')->nullable();
            $table->string('aktuellerAufsatz')->default('Schlitz');
            $table->bigInteger('Startzeit')->default('240');
            $table->bigInteger('Endzeit')->default('240');
            $table->timestamps();                           /*Erstellt "created_at" und "updated_at"*/
        });   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maschinen');
    }
};
