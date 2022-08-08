<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Maschine extends Controller
{
    //Variablen
    public $name;
    public $durchlaufzeit_pro_stueck;
    public $kosten_pro_stueck;
    public $umruestzeit;
    public $is_avaliable;
    public $aktuellerAufsatz;
    public int $startZeit;
    public int $endZeit;

    //Construktor
    function __construct($name, $durchlaufzeit_pro_stueck, $kosten_pro_stueck, $umruestzeit, $is_avaliable, $aktuellerAufsatz, $startZeit, $endZeit)
    {
        $this->name = $name;
        $this->durchlaufzeit_pro_stueck = $durchlaufzeit_pro_stueck;
        $this->kosten_pro_stueck = $kosten_pro_stueck;
        $this->umruestzeit = $umruestzeit;
        $this->is_avaliable = $is_avaliable;
        $this->aktuellerAufsatz = $aktuellerAufsatz;
        $this->startZeit = $startZeit;
        $this->endZeit = $endZeit;
    }

    function getDurchlaufzeit($menge, $faktor)
    {
        return $this->durchlaufzeit_pro_stueck * $menge * $faktor;
    }

    function umruestzeit(Auftrag $auftrag, int $maschine): int
    {
        switch ($maschine) {
            case 2:
                if ($this->aktuellerAufsatz == $auftrag->getArtikel()->getGewinde()) {
                    return 0;
                } else {
                    return $this->umruestzeit;
                }
            case 4:
                if ($this->aktuellerAufsatz == $auftrag->getArtikel()->getKopf()) {
                    return 0;
                } else {
                    return $this->umruestzeit;
                }
            default:
                return 0;
        }


    }

    function ffef()
    {
        $schritt = array("Maschine" => "M1.ggg1", "Start" => "M1dddd.1", "Ende" => "M1.1", "Auftrag)" => 1);
        $schritt1 = array("Maschine" => "M2.ggg1", "Start" => "M1dddd.1", "Ende" => "M1.1", "Auftrag" => 1);
        $schritt2 = array("Maschine" => "M3.ggg1", "Start" => "M1dddd.1", "Ende" => "M1.1", "Auftrag" => 1);
        $schritt3 = array("Maschine" => "M4.ggg1", "Start" => "M1dddd.1", "Ende" => "M1.1", "Auftrag" => 1);


        //echo $schritt['Maschine'];

        $auftragSchritte = []; //alle schritte eines Auftrages 1
        $auftragSchritte[] = $schritt;
        $auftragSchritte[] = $schritt1;
        $auftragSchritte[] = $schritt2;
        $auftragSchritte[] = $schritt3;


        $auftragSchritte1 = []; //alle schritte eines Auftrages 2
        $auftragSchritte1[] = $schritt;
        $auftragSchritte1[] = $schritt2;
        $auftragSchritte1[] = $schritt1;
        $auftragSchritte1[] = $schritt3;

        $alles = array(); // hier das ganze fertige chromosom, mit alles Aufträgen
        $alles['Auf1'] = $auftragSchritte;
        $alles['Auf2'] = $auftragSchritte1;

        foreach ($alles as $a) {
            foreach ($a as $gg) {
                echo $gg['Maschine'];
            }
        }

        echo $alles['Auf1'][3]['Maschine'];

    }
}
