<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // Tabelle als "aufträge" definieren
    protected $table = 'aufträge';

    // Model mit den jeweiligen Auftragsdaten erstellen
    protected $fillable = [
        'id',
        'InputOrderID',
        'InputClient',
        'InputItemNumber',
        'InputAmount',
        'Coating',
        'Checkbox',
        'InputColour',
        'InputTime',
    ];

    // Model-Event, nachdem Model gespeichert wird wird diese Methode "getriggert"
    // Die statische Methode bekommt eine Funktion die die Parameter als Instanz hat, welches vorher gespeichert wurde.
    public static function boot() {
    
        // Aufruf der boot-Methode für die Klasse die dadurch erweitert (extend) wurde
        parent::boot();

        // Model-event "Created" wird aufgerufen um Parameter zu "bearbeiten"
        static::created(function($auftrag) {
            $auftrag->InputOrderID .= '#' . str_pad($auftrag->id, 4, '0', STR_PAD_LEFT);    // ... aus aufträge wird aufgerufen und mit einem "#" und einer vierstelligen Zahl konkateniert 
                                                                                            // insgesamt soll die vierstellige Zahl die Länge 4 haben, die Restlänge von id soll links davon mit Nullen aufgefüllt werden
            $auftrag->save();       // Speicher den vierstelligen string welcher in der Variable "aufträge" in Datenbank ab
        });
    }

}
