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

    // Spalten der Datenbank definieren, alles strings, außer Primärschlüssel (integer)
    public function up()
    {
        Schema::create('aufträge', function (Blueprint $table) {
            $table->id();                                   // Primärschlüssel
            $table->string('InputOrderID')->nullable();     // Diese Zeile darf keinen Wert besitzen (Null), da dieser Wert erst in der Funktion boot() im Model "User" zugewiesen wird
            $table->string('InputClient');
            $table->string('InputItemNumber');
            $table->bigInteger('InputAmount');
            $table->string('InputColour');
            $table->string('Coating');
            $table->string('InputTime');
            $table->string('Checkbox')->nullable();
            $table->timestamps();                           // Erstellt "created_at" und "updated_at"
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aufträge');
    }
};
