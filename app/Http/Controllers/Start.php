<?php

namespace App\Http\Controllers;

use App\Models\Datashare;
use App\Models\Maschinen;
use Illuminate\Http\Request;
use DB;

class Start extends Controller
{
    public function index() {
        return view("/public");
    }

    /*Hier werden die Eingabedaten aus Konfiguration übernommen und in die Datenbank eingespeist.*/
    public function store(Request $request) {

        $dataShare = new Datashare();

        $dataShare->optimieren = request('flexRadioDefault'); /*1 = Termintreue; 2 = Durchlaufzeit; 3 = Kosten*/
        $dataShare->populationsgroeße = request('Population');
        $dataShare->maxdurchlaufzeit = request('cycles');
        
        $dataShare->save();
    
        $machine = $request->InputMachine;

        /*Hier wird die Maschinendatenbank geupdated im Falle eines Maschinendefekts.*/
        DB::table('maschinen')
            ->where('Name', $machine)
            ->update(['is_available' => "0"]);      /*Update Spalte is_available bei der Reihe, bei welcher Maschinenname vom Dropdown uebereinstimmt.*/
                                                    /*is_available ist hier ein tinyInt wobei 0=false*/

        $checkboxAuftrag = $request->ausgewählteAufträge;

        DB::table('aufträge')
            ->where('id', $checkboxAuftrag)
            ->update(['Checkbox' => "1"]);
        
        return redirect() -> route('index'); // Ausgabe routen
    }
    
}
?>