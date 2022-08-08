<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class Auftragserstellung extends Controller
{
    // View eingabe aufrufen
    public function index() {
        return view("eingabe.eingabe");
    }

    public function store(Request $request) {
        //Validieren der übergeben Parameter, alle Inputfelder ohne Dropdown müssen required sein, damit kein Wert fehlt, ansonsten @error in "eingabe.blade.php" werfen
        $this -> validate($request, [
            "InputClient" => "required",
            "InputItemNumber" => array("required","regex:/#[0-9]{5}/"), // regex: Eingabe auf korrekte Eingabe überprüfen
                                                                        // /.../ als "Begrenzer" des Regex-Befehls
                                                                        // #[0-9]{5}: erstes Zeichen muss "#" sein danach nur Zahlen von 1 bis 9 welche eine Länge von 5 haben müssen
                                                                        
            "InputAmount" => "required|min:1|max:1000",                 // Menge mindestens 1 und maximal 1000 
            "InputTime" => "required"
        ]);

        //Auftrag speichern über das Model "User"
        User::create([
            "InputOrderID" => $request -> InputOrderID,
            "InputClient" => $request -> InputClient,
            "InputItemNumber" => $request -> InputItemNumber,
            "InputAmount" => $request -> InputAmount,
            "Coating" => $request -> Coating,
            "InputColour" => $request -> InputColour,
            "InputTime" => $request -> InputTime,
        ]);

        //redirect zur View "start"
        return redirect() -> route('index');
    }
}
