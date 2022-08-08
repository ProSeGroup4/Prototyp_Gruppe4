<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class dragController extends Controller
{
    
    public static int $var = 0;

    public static function getData(Request $request){
        $pop = new Population();

        $aufträge = $pop->generatePopulation();
        $maschine = $request->maschine;//requeste alle benötigten Werte aus dem Fomluar
        $hour = $request->hour;
        $hoursInMin = intval($hour)*60;
        $min = intval($request->min);
        $richtung = $request->richtung;
        $auftragRequest = $request->auftrag;
        $wechsel = $request->wechsel;
        $maschineNeu = $request->maschineNeu;

        foreach($aufträge as $key => $auftrag){
            if($auftrag["Maschine"] == $maschine){//Prüfe ob richtige Maschine gewählt wurde
                if($auftrag["Auftrag"] == $auftragRequest){//Prüfe ob richtiger Auftrag gewählt wurde
                    if($richtung == "vor"){//Prüfe ob Auftrag vor oder Zurück verschoben soll
                        $auftrag["Start"] += ($hoursInMin + $min);
                        $auftrag["Ende"] += ($hoursInMin + $min);
                        $aufträge[$key] = $auftrag;//Speicher wieder im Schritte Array
                    }
                    elseif($richtung == "zurück"){
                        $auftrag["Start"] -= ($hoursInMin + $min);
                        $auftrag["Ende"] -= ($hoursInMin + $min);
                        $aufträge[$key] = $auftrag;
                    }
                    if($wechsel == "ja"){ //Prüfe ob Maschine gewechselt werden soll und Wechsel dann
                        $auftrag["Maschine"] = $maschineNeu;
                        $aufträge[$key] = $auftrag;
                    }
                }
            }
        }
        return view('ausgabe.ausgabe')->with('aufträge',$aufträge);// return ans Gantt
    }
    public static function callDiagramm($aufträge){

        $temp = count($aufträge)-1;
        $arr = $aufträge[$temp];
        $countZeiten = $arr["Ende"];//finde letztes Array und speicher die Endzeit
        $farben = array();

        foreach($aufträge as $auftrag){
            if($auftrag["Auftrag"] == 1){
                $farben[$auftrag["Auftrag"]] = "#1F618D";//füge jedem Auftrag eine Farbe hinzu
            }
            if($auftrag["Auftrag"] == 2){
                $farben[$auftrag["Auftrag"]] = "#1E8449";//füge jedem Auftrag eine Farbe hinzu
            }
            if($auftrag["Auftrag"] == 3){
                $farben[$auftrag["Auftrag"]] = "#A04000";//füge jedem Auftrag eine Farbe hinzu
            }
            if($auftrag["Auftrag"] == 4){
                $farben[$auftrag["Auftrag"]] = "#6C3483";//füge jedem Auftrag eine Farbe hinzu
            }
            if($auftrag["Auftrag"] == 5){
                $farben[$auftrag["Auftrag"]] = "#212F3D";//füge jedem Auftrag eine Farbe hinzu
            }
                //$farben[$auftrag["Auftrag"]] = '#' . str_pad(dechex(mt_rand(0 , 0xFFFFF)), 6, '0', STR_PAD_LEFT);//füge jedem Auftrag eine Farbe hinzu
        }
        
        return view('diagramm')
                        ->with('aufträge',$aufträge)
                        ->with('countZeiten',$countZeiten)
                        ->with('farben',$farben);
    }

    public static function calcTimeSlot($aufträge,$auftrag){
        
        $first = $aufträge[0];
        $first = $first["Start"]; //finde erstes Array

        $start = $auftrag["Start"] - $first;  //ziehe von jeder Zeit die Startzeit des ersten Arrays ab
        $ende = $auftrag["Ende"] - $first; //ziehe von jeder Zeit die Endzeit des ersten Arrays ab

        if($start == 0){
            $start +=1;  //plus 1 damit vom ersten Grid gestartet wird
        }
        return $start."/".$ende; //setze die Breite des Schritts fest
    }

    public static function setColor($auftrag, $farben){
        $farbe = $farben[$auftrag["Auftrag"]];  //return passende Farbe zu jeweiligen Auftrag
        return $farbe;  
    }

    public static function setGrid($aufträge){//bestimmt die Anzahl an Grids in der Tabelle
        $start = $aufträge[0];
        $start = $start["Start"]; 

        $temp = count($aufträge)-1;
        $arr = $aufträge[$temp];
        $grid = $arr["Ende"];
        $grid = $grid - $start;  //ziehe Startzeit von der Endzeit ab

        return $grid;
    }

    public static function setTimes($aufträge,$zeit){// bestimmt die Uhrzeiten in der ersten Zeile
        $start = $aufträge[0];
        $zeit = $zeit + $start["Start"]; //füge jeder Zeiteinheit die Startzeit dazu
        return date("H:i", mktime(0,$zeit));  
    }

    public static function showTimes($start,$ende){//zeigt beim Hovern den Zeitraum des Schritts an
        $start =  date("H:i", mktime(0,$start));
        $ende =  date("H:i", mktime(0,$ende));
        return "Laufzeit:".$start."-".$ende;
    }

    public static function setValue($i){  //setz die Uhrzeit auf ein bestimmtes Grid
        return $i."/".$i;
    }
}
?>