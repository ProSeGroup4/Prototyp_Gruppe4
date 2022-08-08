<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Auftrag;
use App\Http\Controllers\Maschine;

include("Maschine.php");


class Chromosom extends Controller
{

    public array $chromosom = []; //hier wird die Aktuelle Lösung gespeichert
    public array $maschinenArray = []; //hier wird die Aktuelle Lösung gespeichert
    public int $fitness = 0;    // dies ist der Score von dem Aktuellen objekt
    public int $kosten; // hier werden die Kosten berechnet und gespeichert
    public $kostenSaver = array( // hier werden die Kosten vorheriger Iterationen zwischen gespeichert
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0,
        6 => 0,
        7 => 0,
        8 => 0
    );
    public int $max_dauer = 0;
    public float $probability = 0.0;
    public $lastMaschine;
    public $lastMaschineSaverM2;
    public $lastMaschineSaverM4;
    public $startZeit =0;


    function __construct($kosten)
    {
        $this->kosten = $kosten;

    }

    function getFitnessScore() // gibt den FitnessScore
    {
        return $this->fitness;
    }

    function setFitnessScore($newScore) // berechnet den neuen FitnessScore und überschreibt den aktuellen
    {
        $this->fitness += $newScore;
    }

    public function doChromosom(array $auftraege)
    {
        shuffle($auftraege);
        $this->maschinenArray = $this->generateMaschinenArray();
        foreach ($auftraege as $auftrag) {
            //hier wird von aussen das Maschinen array übergeben mit dem ein Chromosom erzeugt wird.
            //Es wird immer wieder von der Methode zurückgegeben, damit man für jeden Auftrag den Stand vom letzten Auftrag hat.
            $this->maschinenArray = $this->generateSolution($auftrag, $this->maschinenArray);
            $auftrag->zeitTrackerG1 = 0;
            $auftrag->zeitTrackerG2 = 0;
            $auftrag->zeitTrackerG3 = 0;
        }
    }

    function generateMaschinenArray(): array
    {
 
        $m11 = new Maschine("M1.1", 2, 3, 1, true, "Schlitz", 0, 0);
        $m12 = new Maschine("M1.2", 2, 3, 1, true, "Schlitz", 0, 0);
        $m13 = new Maschine("M1.3", 2, 3, 1, true, "Schlitz", 0, 0);
        $m21 = new Maschine("M2.1", 2, 3, 1, true, "Schlitz", 0, 0);
        $m22 = new Maschine("M2.2", 2, 3, 1, true, "Schlitz", 0, 0);
        $m31 = new Maschine("M3.1", 2, 3, 1, true, "Schlitz", 0, 0);
        $m32 = new Maschine("M3.2", 2, 3, 1, true, "Schlitz", 0, 0);
        $m41 = new Maschine("M4.1", 2, 3, 1, true, "Schlitz", 0, 0);
        $m42 = new Maschine("M4.2", 2, 3, 1, true, "Schlitz", 0, 0);
        $m51 = new Maschine("M5.1", 2, 3, 1, true, "Schlitz", 0, 0);
        $m52 = new Maschine("M5.2", 2, 3, 1, true, "Schlitz", 0, 0);
        $m61 = new Maschine("M6.1", 2, 3, 1, true, "Schlitz", 0, 0);
        $m62 = new Maschine("M6.2", 2, 3, 1, true, "Schlitz", 0, 0);
        $m63 = new Maschine("M6.3", 2, 3, 1, true, "Schlitz", 0, 0);
        $m71 = new Maschine("M7.1", 2, 3, 1, true, "Schlitz", 0, 0);
        $m72 = new Maschine("M7.2", 2, 3, 1, true, "Schlitz", 0, 0);

        return array(
            "M1.1" => $m11,
            "M1.2" => $m12,
            "M1.3" => $m13,
            "M2.1" => $m21,
            "M2.2" => $m22,
            "M3.1" => $m31,
            "M3.2" => $m32,
            "M4.1" => $m41,
            "M4.2" => $m42,
            "M5.1" => $m51,
            "M5.2" => $m52,
            "M6.1" => $m61,
            "M6.2" => $m62,
            "M6.3" => $m63,
            "M7.1" => $m71,
            "M7.2" => $m72);
    }

    function generateSolution(Auftrag $auftrag, array $maschinenArray): array
    {
        $auftragSchritte = []; //alle schritte eines Auftrages sind hier enthalten
        $aktuelleMaschine = 1; // Var aktuelleMaschine wird mit 1 Initialisiert
        while ($aktuelleMaschine < 8) { // Schleife die alle Maschinen durchläuft
            switch ($aktuelleMaschine) { // jeder Maschinentyp hat seinen eigenen Case
                case 1:
                    $randomNumber = Chromosom::checkMaschineAvailable3(1, 3, $maschinenArray['M1.1'], $maschinenArray['M1.2'], $maschinenArray['M1.3']); //gucken welche Maschine überhaupt verfügbar ist, am besten eine neue Methode die guckt, ab die Maschine auf passt sonst noch mal eine neue random number

                    if ($randomNumber == 1) { // wenn Number 1 ist, dann soll Maschine 1.1 belegt werden
                        $this->lastMaschine='M1.1';
                        $this->kosten += $maschinenArray['M1.1']->kosten_pro_stueck * $auftrag->getMenge(); // kosten werden berechnet; Kosten die Maschine pro Stück hat * die Menge im Auftrag
                        $this->kostenSaver[2] += $maschinenArray['M1.1']->kosten_pro_stueck * $auftrag->getMenge(); // Kosten werden zusätzlich in KostenSaver_Array gespeichert um später auf die Kosten zugreifen zu können(Kosten werden bei jeder Iteration überschrieben)
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if ($maschinenArray['M1.1']->startZeit > $auftrag->zeitTrackerG1) {
                            $this->startZeit = $maschinenArray['M1.1']->startZeit;
                        } else {
                            $this->startZeit = $auftrag->zeitTrackerG1;
                        }
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $maschinenArray['M1.1']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M1.1'], $auftrag, $aktuelleMaschine);

                        $schritt = array( //im Schritt array werden nun die wichtigen daten gespeichert: welche Maschine, Start-und Endzeit sowie die AuftragsID
                            "Maschine" => "M1.1",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M1.1']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $auftragSchritte[] = $schritt; // das Schritt array wird in einem weiteren Array gespeichert(dem Auftragsarray)
                        $auftrag->zeitTrackerG1 += Chromosom::claculateZeit($maschinenArray['M1.1'], $auftrag, $aktuelleMaschine); // Der ZetTrackerG1 trackt die zeit für die ersten beiden Maschinen( Case1 und Case2)
                        $auftrag->zeitSaverG1[0] = $auftrag->zeitTrackerG1; // die Zeit aus Zeittracker wird im Zeitsaver für spätere Iterationen gespeichert; Array-belegung 0 für Maschine 1
                        $maschinenArray['M1.1']->startZeit = $maschinenArray['M1.1']->endZeit;
                    } elseif ($randomNumber == 2) { // Gleiches Szenarion wie bie bei 1, nur das für Maschine 1.2
                        $this->lastMaschine='M1.2';
                        $this->kosten += $maschinenArray['M1.2']->kosten_pro_stueck * $auftrag->getMenge();
                        $this->kostenSaver[2] += $maschinenArray['M1.2']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if ($maschinenArray['M1.2']->startZeit > $auftrag->zeitTrackerG1) {
                            $this->startZeit = $maschinenArray['M1.2']->startZeit;
                        } else {
                            $this->startZeit = $auftrag->zeitTrackerG1;
                        }
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $maschinenArray['M1.2']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M1.2'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M1.2",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M1.2']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $auftragSchritte[] = $schritt;
                        $auftrag->zeitTrackerG1 += Chromosom::claculateZeit($maschinenArray['M1.2'], $auftrag, $aktuelleMaschine);
                        $auftrag->zeitSaverG1[1] = $auftrag->zeitTrackerG1; // Array-belegung 1 für Maschine 2
                        $maschinenArray['M1.2']->startZeit = $maschinenArray['M1.2']->endZeit;
                    } else {
                        $this->lastMaschine='M1.3';
                        $this->kosten += $maschinenArray['M1.3']->kosten_pro_stueck * $auftrag->getMenge();
                        $this->kostenSaver[2] += $maschinenArray['M1.3']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if ($maschinenArray['M1.3']->startZeit > $auftrag->zeitTrackerG1) {
                            $this->startZeit = $maschinenArray['M1.3']->startZeit;
                        } else {
                            $this->startZeit = $auftrag->zeitTrackerG1;
                        }
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $maschinenArray['M1.3']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M1.3'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M1.3",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M1.3']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $auftragSchritte[] = $schritt;
                        $auftrag->zeitTrackerG1 += Chromosom::claculateZeit($maschinenArray['M1.3'], $auftrag, $aktuelleMaschine);
                        $auftrag->zeitSaverG1[2] = $auftrag->zeitTrackerG1; // Array-belegung 2 für Maschine 3
                        $maschinenArray['M1.3']->startZeit = $maschinenArray['M1.3']->endZeit;
                    }
                    $aktuelleMaschine++; // Maschine wird hochgesetzt, sodass die nächste Iteration starten kann und wir in den nächsten Case kommen
                    break;
                case 2:
                    $randomNumber = Chromosom::checkMaschineAvailable2(1, 2, $maschinenArray['M2.1'], $maschinenArray['M2.2']); //gucken welche Maschine überhaupt verfügbar ist, am besten eine neue Methode die guckt, ab die Maschine auf passt sonst noch mal eine neue random number
                    
                    if ($randomNumber == 1) { // wie Case 1 nur für Maschinen von Typ 2
                        $this->kosten += $maschinenArray['M2.1']->kosten_pro_stueck * $auftrag->getMenge();
                        $this->kostenSaver[3] += $maschinenArray['M2.1']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if($this->lastMaschine =='M1.1'){
                            $this->startZeit= max($maschinenArray['M1.1']->startZeit,$maschinenArray['M2.1']->startZeit, $auftrag->zeitTrackerG1);
                        }elseif($this->lastMaschine =='M1.2'){
                            $this->startZeit= max($maschinenArray['M1.2']->startZeit, $maschinenArray['M2.1']->startZeit, $auftrag->zeitTrackerG1);
                        }elseif($this->lastMaschine =='M1.3') {
                            $this->startZeit = max($maschinenArray['M1.3']->startZeit, $maschinenArray['M2.1']->startZeit, $auftrag->zeitTrackerG1);
                        }
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $this->lastMaschine='M2.1';
                        $this->lastMaschineSaverM2='M2.1';
                        $maschinenArray['M2.1']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M2.1'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M2.1",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M2.1']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $auftragSchritte[] = $schritt;
                        $auftrag->zeitTrackerG1 += Chromosom::claculateZeit($maschinenArray['M2.1'], $auftrag, $aktuelleMaschine);
                        $auftrag->zeitSaverG1[0] = $auftrag->zeitTrackerG1;
                        $maschinenArray['M2.1']->startZeit = $maschinenArray['M2.1']->endZeit;
                    } else {
                        $this->kosten += $maschinenArray['M2.2']->kosten_pro_stueck * $auftrag->getMenge();
                        $this->kostenSaver[3] += $maschinenArray['M2.2']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if($this->lastMaschine =='M1.1'){
                            $this->startZeit= max($maschinenArray['M1.1']->startZeit,$maschinenArray['M2.2']->startZeit, $auftrag->zeitTrackerG1);
                        }elseif($this->lastMaschine =='M1.2'){
                            $this->startZeit= max($maschinenArray['M1.2']->startZeit, $maschinenArray['M2.2']->startZeit, $auftrag->zeitTrackerG1);
                        }elseif($this->lastMaschine =='M1.3') {
                            $this->startZeit = max($maschinenArray['M1.3']->startZeit, $maschinenArray['M2.2']->startZeit, $auftrag->zeitTrackerG1);
                        }
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $this->lastMaschine='M2.2';
                        $this->lastMaschineSaverM2='M2.2';
                        $maschinenArray['M2.2']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M2.2'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M2.2",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M2.2']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $auftragSchritte[] = $schritt;
                        $auftrag->zeitTrackerG1 += Chromosom::claculateZeit($maschinenArray['M2.2'], $auftrag, $aktuelleMaschine);
                        $auftrag->zeitSaverG1[1] = $auftrag->zeitTrackerG1;
                        $maschinenArray['M2.2']->startZeit = $maschinenArray['M2.2']->endZeit;
                    }
                    $aktuelleMaschine++;
                    break;
                case 3: // wie Case 1 nur für die Maschinen von typ 3
                    $randomNumber = Chromosom::checkMaschineAvailable2(1, 2, $maschinenArray['M3.1'], $maschinenArray['M3.2']); //gucken welche Maschine überhaupt verfügbar ist, am besten eine neue Methode die guckt, ab die Maschine auf passt sonst noch mal eine neue random number

                    if ($randomNumber == 1) {
                        $this->lastMaschine='M3.1';
                        $this->kosten += $maschinenArray['M3.1']->kosten_pro_stueck * $auftrag->getMenge();
                        $this->kostenSaver[4] += $maschinenArray['M3.1']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if ($maschinenArray['M3.1']->startZeit > $auftrag->zeitTrackerG2) {
                            $this->startZeit = $maschinenArray['M3.1']->startZeit;
                        } else {
                            $this->startZeit = $auftrag->zeitTrackerG2;
                        }
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $maschinenArray['M3.1']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M3.1'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M3.1",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M3.1']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $auftragSchritte[] = $schritt;
                        $auftrag->zeitTrackerG2 += Chromosom::claculateZeit($maschinenArray['M3.1'], $auftrag, $aktuelleMaschine);
                        $auftrag->zeitSaverG2[0] = $auftrag->zeitTrackerG2;
                        $maschinenArray['M3.1']->startZeit = $maschinenArray['M3.1']->endZeit;
                    } else {
                        $this->lastMaschine='M3.2';
                        $this->kosten += $maschinenArray['M3.2']->kosten_pro_stueck * $auftrag->getMenge();
                        $this->kostenSaver[4] += $maschinenArray['M3.2']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if ($maschinenArray['M3.2']->startZeit > $auftrag->zeitTrackerG2) {
                            $this->startZeit = $maschinenArray['M3.2']->startZeit;
                        } else {
                            $this->startZeit = $auftrag->zeitTrackerG2;
                        }
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $maschinenArray['M3.2']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M3.2'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M3.2",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M3.2']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $auftragSchritte[] = $schritt;
                        $auftrag->zeitTrackerG2 += Chromosom::claculateZeit($maschinenArray['M3.2'], $auftrag, $aktuelleMaschine);
                        $auftrag->zeitSaverG2[1] = $auftrag->zeitTrackerG2;
                        $maschinenArray['M3.2']->startZeit = $maschinenArray['M3.2']->endZeit;
                    }
                    $aktuelleMaschine++;
                    break;
                case 4: // wie Case 1 nur für Maschinen von Typ 4
                    $randomNumber = Chromosom::checkMaschineAvailable2(1, 2, $maschinenArray['M4.1'], $maschinenArray['M4.2']); //gucken welche Maschine überhaupt verfügbar ist, am besten eine neue Methode die guckt, ab die Maschine auf passt sonst noch mal eine neue random number

                    if ($randomNumber == 1) {
                        $this->kosten += $maschinenArray['M4.1']->kosten_pro_stueck * $auftrag->getMenge();
                        $this->kostenSaver[5] += $maschinenArray['M4.1']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if($this->lastMaschine =='M3.1'){
                            $this->startZeit= max($maschinenArray['M3.1']->startZeit,$maschinenArray['M4.1']->startZeit, $auftrag->zeitTrackerG2);
                        }elseif($this->lastMaschine =='M3.2'){
                            $this->startZeit= max($maschinenArray['M3.2']->startZeit, $maschinenArray['M4.1']->startZeit, $auftrag->zeitTrackerG2);
                        }
                         //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $this->lastMaschine='M4.1';
                        $this->lastMaschineSaverM4='M4.1';
                        $maschinenArray['M4.1']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M4.1'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M4.1",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M4.1']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $auftragSchritte[] = $schritt;
                        $auftrag->zeitTrackerG2 += Chromosom::claculateZeit($maschinenArray['M4.1'], $auftrag, $aktuelleMaschine);
                        $auftrag->zeitSaverG2[0] = $auftrag->zeitTrackerG2;
                        $maschinenArray['M4.1']->startZeit = $maschinenArray['M4.1']->endZeit;
                    } else {
                        $this->kosten += $maschinenArray['M4.2']->kosten_pro_stueck * $auftrag->getMenge();
                        $this->kostenSaver[5] += $maschinenArray['M4.2']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if($this->lastMaschine =='M3.1'){
                            $this->startZeit= max($maschinenArray['M3.1']->startZeit,$maschinenArray['M4.2']->startZeit, $auftrag->zeitTrackerG2);
                        }elseif($this->lastMaschine =='M3.2'){
                            $this->startZeit= max($maschinenArray['M3.2']->startZeit, $maschinenArray['M4.2']->startZeit, $auftrag->zeitTrackerG2);
                        }
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $this->lastMaschine='M4.2';
                        $this->lastMaschineSaverM4='M4.2';
                        $maschinenArray['M4.2']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M4.2'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M4.2",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M4.2']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $auftragSchritte[] = $schritt;
                        $auftrag->zeitTrackerG2 += Chromosom::claculateZeit($maschinenArray['M4.2'], $auftrag, $aktuelleMaschine);
                        $auftrag->zeitSaverG2[1] = $auftrag->zeitTrackerG2;
                        $maschinenArray['M4.2']->startZeit = $maschinenArray['M4.2']->endZeit;
                    }
                    $aktuelleMaschine++;
                    break;
                case 5: // wie Case 1 nur für Maschinen von type 5
                    $randomNumber = Chromosom::checkMaschineAvailable2(1, 2, $maschinenArray['M5.1'], $maschinenArray['M5.2']); //gucken welche Maschine überhaupt verfügbar ist, am besten eine neue Methode die guckt, ab die Maschine auf passt sonst noch mal eine neue random number

                    if ($randomNumber == 1) {
                        $this->kosten += $maschinenArray['M5.1']->kosten_pro_stueck * $auftrag->getMenge();
                        $this->kostenSaver[6] += $maschinenArray['M5.1']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if($this->lastMaschineSaverM2 =='M2.1' && $this->lastMaschineSaverM4 =='M4.1'){
                            $this->startZeit= max($maschinenArray['M2.1']->startZeit,$maschinenArray['M4.1']->startZeit,$maschinenArray['M5.1']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        }elseif($this->lastMaschineSaverM2 =='M2.1' && $this->lastMaschineSaverM4 =='M4.2'){
                            $this->startZeit= max($maschinenArray['M2.1']->startZeit,$maschinenArray['M4.2']->startZeit, $maschinenArray['M5.1']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        }elseif($this->lastMaschineSaverM2 =='M2.2' && $this->lastMaschineSaverM4 =='M4.1'){
                            $this->startZeit= max($maschinenArray['M2.2']->startZeit, $maschinenArray['M4.1']->startZeit, $maschinenArray['M5.1']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        }elseif($this->lastMaschineSaverM2 =='M2.2' && $this->lastMaschineSaverM4 =='M4.2') {
                            $this->startZeit = max($maschinenArray['M2.2']->startZeit, $maschinenArray['M4.2']->startZeit, $maschinenArray['M5.1']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        }
                        //$this->startZeit = max($maschinenArray['M2.1']->startZeit,$maschinenArray['M2.2']->startZeit,$maschinenArray['M4.1']->startZeit,$maschinenArray['M4.2']->startZeit,$maschinenArray['M5.1']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        $auftrag->zeitTrackerG3 = max($auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $this->lastMaschine='M5.1';
                        $maschinenArray['M5.1']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M5.1'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M5.1",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M5.1']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $auftragSchritte[] = $schritt;
                        $auftrag->zeitTrackerG3 += Chromosom::claculateZeit($maschinenArray['M5.1'], $auftrag, $aktuelleMaschine);
                        $auftrag->zeitSaverG3[0] = $auftrag->zeitTrackerG3;
                        $maschinenArray['M5.1']->startZeit = $maschinenArray['M5.1']->endZeit;
                    } else {
                        $this->kosten += $maschinenArray['M5.2']->kosten_pro_stueck * $auftrag->getMenge();
                        $this->kostenSaver[6] += $maschinenArray['M5.2']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if($this->lastMaschineSaverM2 =='M2.1' && $this->lastMaschineSaverM4 =='M4.1'){
                            $this->startZeit= max($maschinenArray['M2.1']->startZeit,$maschinenArray['M4.1']->startZeit,$maschinenArray['M5.2']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        }elseif($this->lastMaschineSaverM2 =='M2.1' && $this->lastMaschineSaverM4 =='M4.2'){
                            $this->startZeit= max($maschinenArray['M2.1']->startZeit,$maschinenArray['M4.2']->startZeit, $maschinenArray['M5.2']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        }elseif($this->lastMaschineSaverM2 =='M2.2' && $this->lastMaschineSaverM4 =='M4.1'){
                            $this->startZeit= max($maschinenArray['M2.2']->startZeit, $maschinenArray['M4.1']->startZeit, $maschinenArray['M5.2']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        }elseif($this->lastMaschineSaverM2 =='M2.2' && $this->lastMaschineSaverM4 =='M4.2') {
                            $this->startZeit = max($maschinenArray['M2.2']->startZeit, $maschinenArray['M4.2']->startZeit, $maschinenArray['M5.2']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        }
                        //$this->startZeit = max($maschinenArray['M2.1']->startZeit,$maschinenArray['M2.2']->startZeit,$maschinenArray['M4.1']->startZeit,$maschinenArray['M4.2']->startZeit,$maschinenArray['M5.2']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);                        $auftrag->zeitTrackerG3 = max($auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $this->lastMaschine='M5.2';
                        $maschinenArray['M5.2']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M5.2'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M5.2",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M5.2']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $auftragSchritte[] = $schritt;
                        $auftrag->zeitTrackerG3 += Chromosom::claculateZeit($maschinenArray['M5.2'], $auftrag, $aktuelleMaschine);
                        $auftrag->zeitSaverG3[1] = $auftrag->zeitTrackerG3;
                        $maschinenArray['M5.2']->startZeit = $maschinenArray['M5.2']->endZeit;
                    }
                    $aktuelleMaschine++;
                    break;
                case 6:
                    //prüfen ob der Auftrag überhaupt auf diese Maschiene muss.
                    if ($auftrag->beschichtung) {
                        $randomNumber = Chromosom::checkMaschineAvailable3(1, 3, $maschinenArray['M6.1'], $maschinenArray['M6.2'], $maschinenArray['M6.3']); //gucken welche Maschine überhaupt verfügbar ist, am besten eine neue Methode die guckt, ab die Maschine auf passt sonst noch mal eine neue random number

                        if ($randomNumber == 1) {
                            $this->kosten += $maschinenArray['M6.1']->kosten_pro_stueck * $auftrag->getMenge();
                            $this->kostenSaver[7] += $maschinenArray['M6.1']->kosten_pro_stueck * $auftrag->getMenge();
                            //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                            if($this->lastMaschine =='M5.1'){
                                $this->startZeit= max($maschinenArray['M5.1']->startZeit,$maschinenArray['M6.1']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M5.2'){
                                $this->startZeit= max($maschinenArray['M5.2']->startZeit, $maschinenArray['M6.1']->startZeit, $auftrag->zeitTrackerG3);
                           }
                            //$this->startZeit = max($maschinenArray['M5.1']->startZeit, $maschinenArray['M5.2']->startZeit, $maschinenArray['M6.1']->startZeit, $auftrag->zeitTrackerG3);
                            //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                            $this->lastMaschine='M6.1';
                            $maschinenArray['M6.1']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M6.1'], $auftrag, $aktuelleMaschine);

                            $schritt = array(
                                "Maschine" => "M6.1",
                                "Start" => $this->startZeit,
                                "Ende" => $maschinenArray['M6.1']->endZeit,
                                "Auftrag" => $auftrag->getAuftragID()
                            );
                            $auftragSchritte[] = $schritt;
                            $auftrag->zeitTrackerG3 += Chromosom::claculateZeit($maschinenArray['M6.1'], $auftrag, $aktuelleMaschine);
                            $auftrag->zeitSaverG3[0] = $auftrag->zeitTrackerG3;
                            $maschinenArray['M6.1']->startZeit = $maschinenArray['M6.1']->endZeit;
                        } elseif ($randomNumber == 2) {
                            $this->kosten += $maschinenArray['M6.2']->kosten_pro_stueck * $auftrag->getMenge();
                            $this->kostenSaver[7] += $maschinenArray['M6.2']->kosten_pro_stueck * $auftrag->getMenge();
                            //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                            if($this->lastMaschine =='M5.1'){
                                $this->startZeit= max($maschinenArray['M5.1']->startZeit,$maschinenArray['M6.2']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M5.2'){
                                $this->startZeit= max($maschinenArray['M5.2']->startZeit, $maschinenArray['M6.2']->startZeit, $auftrag->zeitTrackerG3);
                            }
                            //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                            $this->lastMaschine='M6.2';
                            $maschinenArray['M6.2']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M6.2'], $auftrag, $aktuelleMaschine);

                            $schritt = array(
                                "Maschine" => "M6.2",
                                "Start" => $this->startZeit,
                                "Ende" => $maschinenArray['M6.2']->endZeit,
                                "Auftrag" => $auftrag->getAuftragID()
                            );
                            $auftragSchritte[] = $schritt;
                            $auftrag->zeitTrackerG3 += Chromosom::claculateZeit($maschinenArray['M6.2'], $auftrag, $aktuelleMaschine);
                            $auftrag->zeitSaverG3[1] = $auftrag->zeitTrackerG3;
                            $maschinenArray['M6.2']->startZeit = $maschinenArray['M6.2']->endZeit;
                        } else {
                            $this->kosten += $maschinenArray['M6.3']->kosten_pro_stueck * $auftrag->getMenge();
                            $this->kostenSaver[7] += $maschinenArray['M6.3']->kosten_pro_stueck * $auftrag->getMenge();
                            //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                            if($this->lastMaschine =='M5.1'){
                                $this->startZeit= max($maschinenArray['M5.1']->startZeit,$maschinenArray['M6.3']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M5.2'){
                                $this->startZeit= max($maschinenArray['M5.2']->startZeit, $maschinenArray['M6.3']->startZeit, $auftrag->zeitTrackerG3);
                            }
                            //$this->startZeit = max($maschinenArray['M5.1']->startZeit, $maschinenArray['M5.2']->startZeit, $maschinenArray['M6.3']->startZeit, $auftrag->zeitTrackerG3);
                            //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                            $this->lastMaschine='M6.3';
                            $maschinenArray['M6.3']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M6.3'], $auftrag, $aktuelleMaschine);

                            $schritt = array(
                                "Maschine" => "M6.3",
                                "Start" => $this->startZeit,
                                "Ende" => $maschinenArray['M6.3']->endZeit,
                                "Auftrag" => $auftrag->getAuftragID()
                            );
                            $auftragSchritte[] = $schritt;
                            $auftrag->zeitTrackerG3 += Chromosom::claculateZeit($maschinenArray['M6.3'], $auftrag, $aktuelleMaschine);
                            $auftrag->zeitSaverG3[2] = $auftrag->zeitTrackerG3;
                            $maschinenArray['M6.3']->startZeit = $maschinenArray['M6.3']->endZeit;
                        }
                    }
                    $aktuelleMaschine++;
                    break;
                case 7:
                    if ($auftrag->lackierung) {
                        $randomNumber = Chromosom::checkMaschineAvailable2(1, 2, $maschinenArray['M7.1'], $maschinenArray['M7.2']); //gucken welche Maschine überhaupt verfügbar ist, am besten eine neue Methode die guckt, ab die Maschine auf passt sonst noch mal eine neue random number

                        if ($randomNumber == 1) {
                            $this->kosten += $maschinenArray['M7.1']->kosten_pro_stueck * $auftrag->getMenge();
                            $this->kostenSaver[8] += $maschinenArray['M7.1']->kosten_pro_stueck * $auftrag->getMenge();
                            //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                            if($this->lastMaschine =='M6.1'){
                                $this->startZeit= max($maschinenArray['M6.1']->startZeit,$maschinenArray['M7.1']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M6.2'){
                                $this->startZeit= max($maschinenArray['M6.2']->startZeit, $maschinenArray['M7.1']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M6.3') {
                                $this->startZeit = max($maschinenArray['M6.3']->startZeit, $maschinenArray['M7.1']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M5.1') {
                                $this->startZeit = max($maschinenArray['M5.1']->startZeit, $maschinenArray['M7.1']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M5.2') {
                                $this->startZeit = max($maschinenArray['M5.2']->startZeit, $maschinenArray['M7.1']->startZeit, $auftrag->zeitTrackerG3);
                            }
                            //$this->startZeit = max($maschinenArray['M6.1']->startZeit,$maschinenArray['M6.2']->startZeit,$maschinenArray['M6.3']->startZeit,$maschinenArray['M7.1']->startZeit,$auftrag->zeitTrackerG3);
                            //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                            $this->lastMaschine='M7.1';
                            $maschinenArray['M7.1']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M7.1'], $auftrag, $aktuelleMaschine);

                            $schritt = array(
                                "Maschine" => "M7.1",
                                "Start" => $this->startZeit,
                                "Ende" => $maschinenArray['M7.1']->endZeit,
                                "Auftrag" => $auftrag->getAuftragID()
                            );
                            $auftragSchritte[] = $schritt;
                            $auftrag->zeitTrackerG3 += Chromosom::claculateZeit($maschinenArray['M7.1'], $auftrag, $aktuelleMaschine);
                            $auftrag->zeitSaverG3[0] = $auftrag->zeitTrackerG3;
                            $maschinenArray['M7.1']->startZeit = $maschinenArray['M7.1']->endZeit;
                        } else {
                            $this->kosten += $maschinenArray['M7.2']->kosten_pro_stueck * $auftrag->getMenge();
                            $this->kostenSaver[8] += $maschinenArray['M7.2']->kosten_pro_stueck * $auftrag->getMenge();
                            //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                            if($this->lastMaschine =='M6.1'){
                                $this->startZeit= max($maschinenArray['M6.1']->startZeit,$maschinenArray['M7.2']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M6.2'){
                                $this->startZeit= max($maschinenArray['M6.2']->startZeit, $maschinenArray['M7.2']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M6.3') {
                                $this->startZeit = max($maschinenArray['M6.3']->startZeit, $maschinenArray['M7.2']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M5.1') {
                                $this->startZeit = max($maschinenArray['M5.1']->startZeit, $maschinenArray['M7.2']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M5.2') {
                                $this->startZeit = max($maschinenArray['M5.2']->startZeit, $maschinenArray['M7.2']->startZeit, $auftrag->zeitTrackerG3);
                            }
                            //$this->startZeit = max($maschinenArray['M6.1']->startZeit,$maschinenArray['M6.2']->startZeit,$maschinenArray['M6.3']->startZeit,$maschinenArray['M7.1']->startZeit,$auftrag->zeitTrackerG3);
                            //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                            $this->lastMaschine='M7.2';
                            $maschinenArray['M7.2']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M7.2'], $auftrag, $aktuelleMaschine);

                            $schritt = array(
                                "Maschine" => "M7.2",
                                "Start" => $this->startZeit,
                                "Ende" => $maschinenArray['M7.2']->endZeit,
                                "Auftrag" => $auftrag->getAuftragID()
                            );
                            $auftragSchritte[] = $schritt;
                            $auftrag->zeitTrackerG3 += Chromosom::claculateZeit($maschinenArray['M7.2'], $auftrag, $aktuelleMaschine);
                            $auftrag->zeitSaverG3[1] = $auftrag->zeitTrackerG3;
                            $maschinenArray['M7.2']->startZeit = $maschinenArray['M7.2']->endZeit;
                        }
                    }
                    $aktuelleMaschine++;
                    break;
            }
        } // beste Chromosom zurück?
        $this->chromosom[$auftrag->getAuftragID()] = $auftragSchritte;
        $temp = count($auftragSchritte);
        $this->max_dauer = $auftragSchritte[$temp - 1]['Ende'];
        return $maschinenArray;
    }
        // setzt für jeden durchlauf die jeweilgigen Kosten auf die Kosten, die wir im KostenSaver aus der Generation davor gespeichert haben
        // jede Generation beginnen wir einen Maschinentyp später
    function setKostenRepair(int $durchlauf){
        for ($i=2; $i<=$durchlauf;$i++){
            $this->kosten += $this->kostenSaver[$i];
        }
    }

    function crossoverMutationRepair(Auftrag $auftrag, array $maschinenArray, int $durchlauf): array
    {
         // die Function crosst das gewählte Chromosom mit einem mutierten Chromosom und repariert das vorgehen, sodass eine valide Lösung rauskommt
        // dazu wird durch die einzelnen Maschinentypen itteriert, beginnt bei dem im Durchlauf übergebenen Maschinentypen
        $auftragSchritte = []; //alle schritte eines Auftrages sind hier enthalten
        $aktuelleMaschine = $durchlauf; // der aktuelle Durchlauf wird in aktuelleMaschine gespeichert
        while ($aktuelleMaschine < 8) { // läuft solange bis alle Maschinentypen abgedeckt sind
            switch ($aktuelleMaschine) { // jeder Maschinentyp hat einen Case
                case 1:
                    $randomNumber = Chromosom::checkMaschineAvailable3(1, 3, $maschinenArray['M1.1'], $maschinenArray['M1.2'], $maschinenArray['M1.3']); //gucken welche Maschine überhaupt verfügbar ist, am besten eine neue Methode die guckt, ab die Maschine auf passt sonst noch mal eine neue random number
                    if ($randomNumber == 1) {
                        $this->lastMaschine='M1.1';
                        $this->kosten += $maschinenArray['M1.1']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if ($maschinenArray['M1.1']->startZeit > $auftrag->zeitTrackerG1) {
                            $this->startZeit = $maschinenArray['M1.1']->startZeit;
                        } else {
                            $this->startZeit = $auftrag->zeitTrackerG1;
                        }
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $maschinenArray['M1.1']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M1.1'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M1.1",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M1.1']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $auftragSchritte[] = $schritt;
                        $auftrag->zeitTrackerG1 += Chromosom::claculateZeit($maschinenArray['M1.1'], $auftrag, $aktuelleMaschine);
                        $maschinenArray['M1.1']->startZeit = $maschinenArray['M1.1']->endZeit;
                    } elseif ($randomNumber == 2) {
                        $this->lastMaschine='M1.2';
                        $this->kosten += $maschinenArray['M1.2']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if ($maschinenArray['M1.2']->startZeit > $auftrag->zeitTrackerG1) {
                            $this->startZeit = $maschinenArray['M1.2']->startZeit;
                        } else {
                            $this->startZeit = $auftrag->zeitTrackerG1;
                        }
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $maschinenArray['M1.2']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M1.2'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M1.2",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M1.2']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $auftragSchritte[] = $schritt;
                        $auftrag->zeitTrackerG1 += Chromosom::claculateZeit($maschinenArray['M1.2'], $auftrag, $aktuelleMaschine);
                        $maschinenArray['M1.2']->startZeit = $maschinenArray['M1.2']->endZeit;
                    } else {
                        $this->kosten += $maschinenArray['M1.3']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if ($maschinenArray['M1.3']->startZeit > $auftrag->zeitTrackerG1) {
                            $this->startZeit = $maschinenArray['M1.3']->startZeit;
                        } else {
                            $this->lastMaschine='M1.3';
                            $this->startZeit = $auftrag->zeitTrackerG1;
                        }
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $maschinenArray['M1.3']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M1.3'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M1.3",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M1.3']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $auftragSchritte[] = $schritt;
                        $auftrag->zeitTrackerG1 += Chromosom::claculateZeit($maschinenArray['M1.3'], $auftrag, $aktuelleMaschine);
                        $maschinenArray['M1.3']->startZeit = $maschinenArray['M1.3']->endZeit;
                    }
                    $aktuelleMaschine++;
                    break;
                case 2:
                    $randomNumber = Chromosom::checkMaschineAvailable2(1, 2, $maschinenArray['M2.1'], $maschinenArray['M2.2']); //gucken welche Maschine überhaupt verfügbar ist, am besten eine neue Methode die guckt, ab die Maschine auf passt sonst noch mal eine neue random number
                    $randomNumber = 1;
                    if ($randomNumber == 1) {
                        $auftrag->zeitTrackerG1 = max($auftrag->zeitSaverG1);
                        $this->kosten += $maschinenArray['M2.1']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if($this->lastMaschine =='M1.1'){
                            $this->startZeit= max($maschinenArray['M1.1']->startZeit,$maschinenArray['M2.1']->startZeit, $auftrag->zeitTrackerG1);
                        }elseif($this->lastMaschine =='M1.2'){
                            $this->startZeit= max($maschinenArray['M1.2']->startZeit, $maschinenArray['M2.1']->startZeit, $auftrag->zeitTrackerG1);
                        }elseif($this->lastMaschine =='M1.3') {
                            $this->startZeit = max($maschinenArray['M1.3']->startZeit, $maschinenArray['M2.1']->startZeit, $auftrag->zeitTrackerG1);
                        }
                        //$this->startZeit= max($maschinenArray['M1.1']->startZeit, $maschinenArray['M1.2']->startZeit, $maschinenArray['M1.3']->startZeit,$maschinenArray['M2.1']->startZeit, $auftrag->zeitTrackerG1);
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $this->lastMaschine = 'M2.1';
                        $this->lastMaschineSaverM2='M2.1';
                        $maschinenArray['M2.1']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M2.1'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M2.1",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M2.1']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $this->chromosom[$auftrag->getAuftragID()][1] = $schritt;
                        $auftragSchritte[] = $schritt;
                        $auftrag->zeitTrackerG1 += Chromosom::claculateZeit($maschinenArray['M2.1'], $auftrag, $aktuelleMaschine);
                        $maschinenArray['M2.1']->startZeit = $maschinenArray['M2.1']->endZeit;
                    } else {
                        $auftrag->zeitTrackerG1 = max($auftrag->zeitSaverG1);
                        $this->kosten += $maschinenArray['M2.2']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if($this->lastMaschine =='M1.1'){
                            $this->startZeit= max($maschinenArray['M1.1']->startZeit,$maschinenArray['M2.2']->startZeit, $auftrag->zeitTrackerG1);
                        }elseif($this->lastMaschine =='M1.2'){
                            $this->startZeit= max($maschinenArray['M1.2']->startZeit, $maschinenArray['M2.2']->startZeit, $auftrag->zeitTrackerG1);
                        }elseif($this->lastMaschine =='M1.3') {
                            $this->startZeit = max($maschinenArray['M1.3']->startZeit, $maschinenArray['M2.2']->startZeit, $auftrag->zeitTrackerG1);
                        }
                        //$this->startZeit= max($maschinenArray['M1.1']->startZeit, $maschinenArray['M1.2']->startZeit, $maschinenArray['M1.3']->startZeit,$maschinenArray['M2.2']->startZeit, $auftrag->zeitTrackerG1);
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $this->lastMaschine = 'M2.2';
                        $this->lastMaschineSaverM2='M2.2';
                        $maschinenArray['M2.2']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M2.2'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M2.2",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M2.2']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $this->chromosom[$auftrag->getAuftragID()][1] = $schritt;
                        $auftrag->zeitTrackerG1 += Chromosom::claculateZeit($maschinenArray['M2.2'], $auftrag, $aktuelleMaschine);
                        $maschinenArray['M2.2']->startZeit = $maschinenArray['M2.1']->endZeit;
                    }
                    $aktuelleMaschine++;
                    break;
                case 3:
                    $randomNumber = Chromosom::checkMaschineAvailable2(1, 2, $maschinenArray['M3.1'], $maschinenArray['M3.2']); //gucken welche Maschine überhaupt verfügbar ist, am besten eine neue Methode die guckt, ab die Maschine auf passt sonst noch mal eine neue random number
                    if ($randomNumber == 1) {
                        $this->lastMaschine='M3.1';
                        $auftrag->zeitTrackerG2 = 0;
                        $this->kosten += $maschinenArray['M3.1']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if ($maschinenArray['M3.1']->startZeit > $auftrag->zeitTrackerG2) {
                            $this->startZeit = $maschinenArray['M3.1']->startZeit;
                        } else {
                            $this->startZeit = $auftrag->zeitTrackerG2;
                        }
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $maschinenArray['M3.1']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M3.1'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M3.1",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M3.1']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $this->chromosom[$auftrag->getAuftragID()][2] = $schritt;
                        $auftrag->zeitTrackerG2 += Chromosom::claculateZeit($maschinenArray['M3.1'], $auftrag, $aktuelleMaschine);
                        $maschinenArray['M3.1']->startZeit = $maschinenArray['M3.1']->endZeit;
                    } else {
                        $this->lastMaschine='M3.2';
                        $auftrag->zeitTrackerG2 = 0;
                        $this->kosten += $maschinenArray['M3.2']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if ($maschinenArray['M3.2']->startZeit > $auftrag->zeitTrackerG2) {
                            $this->startZeit = $maschinenArray['M3.2']->startZeit;
                        } else {
                            $this->startZeit = $auftrag->zeitTrackerG2;
                        }
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $maschinenArray['M3.2']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M3.2'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M3.2",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M3.2']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $this->chromosom[$auftrag->getAuftragID()][2] = $schritt;
                        $auftrag->zeitTrackerG2 += Chromosom::claculateZeit($maschinenArray['M3.2'], $auftrag, $aktuelleMaschine);
                        $maschinenArray['M3.2']->startZeit = $maschinenArray['M3.2']->endZeit;
                    }
                    $aktuelleMaschine++;
                    break;
                case 4:
                    $randomNumber = Chromosom::checkMaschineAvailable2(1, 2, $maschinenArray['M4.1'], $maschinenArray['M4.2']); //gucken welche Maschine überhaupt verfügbar ist, am besten eine neue Methode die guckt, ab die Maschine auf passt sonst noch mal eine neue random number
                    $randomNumber = 2;
                    if ($randomNumber == 1) {
                        $auftrag->zeitTrackerG2 = max($auftrag->zeitSaverG2);
                        $this->kosten += $maschinenArray['M4.1']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if($this->lastMaschine =='M3.1'){
                            $this->startZeit= max($maschinenArray['M3.1']->startZeit,$maschinenArray['M4.1']->startZeit, $auftrag->zeitTrackerG2);
                        }elseif($this->lastMaschine =='M3.2'){
                            $this->startZeit= max($maschinenArray['M3.2']->startZeit, $maschinenArray['M4.1']->startZeit, $auftrag->zeitTrackerG2);
                        }
                        //$this->startZeit= max($maschinenArray['M3.1']->startZeit, $maschinenArray['M3.2']->startZeit, $maschinenArray['M4.1']->startZeit, $auftrag->zeitTrackerG2);
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $this->lastMaschine='M4.1';
                        $this->lastMaschineSaverM4='M4.1';
                        $maschinenArray['M4.1']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M4.1'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M4.1",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M4.1']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $this->chromosom[$auftrag->getAuftragID()][3] = $schritt;
                        $auftrag->zeitTrackerG2 += Chromosom::claculateZeit($maschinenArray['M4.1'], $auftrag, $aktuelleMaschine);
                        $maschinenArray['M4.1']->startZeit = $maschinenArray['M4.1']->endZeit;
                    } else {
                        $auftrag->zeitTrackerG2 = max($auftrag->zeitSaverG2);
                        $this->kosten += $maschinenArray['M4.2']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if($this->lastMaschine =='M3.1'){
                            $this->startZeit= max($maschinenArray['M3.1']->startZeit,$maschinenArray['M4.2']->startZeit, $auftrag->zeitTrackerG2);
                        }elseif($this->lastMaschine =='M3.2'){
                            $this->startZeit= max($maschinenArray['M3.2']->startZeit, $maschinenArray['M4.2']->startZeit, $auftrag->zeitTrackerG2);
                        }
                        //$this->startZeit= max($maschinenArray['M3.1']->startZeit, $maschinenArray['M3.2']->startZeit, $maschinenArray['M4.2']->startZeit, $auftrag->zeitTrackerG2);
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $this->lastMaschine='M4.2';
                        $this->lastMaschineSaverM4='M4.2';
                        $maschinenArray['M4.2']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M4.2'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M4.2",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M4.2']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $this->chromosom[$auftrag->getAuftragID()][3] = $schritt;
                        $auftrag->zeitTrackerG2 += Chromosom::claculateZeit($maschinenArray['M4.2'], $auftrag, $aktuelleMaschine);
                        $maschinenArray['M4.2']->startZeit = $maschinenArray['M4.2']->endZeit;
                    }
                    $aktuelleMaschine++;
                    break;
                case 5:
                    $randomNumber = Chromosom::checkMaschineAvailable2(1, 2, $maschinenArray['M5.1'], $maschinenArray['M5.2']); //gucken welche Maschine überhaupt verfügbar ist, am besten eine neue Methode die guckt, ab die Maschine auf passt sonst noch mal eine neue random number
                    if ($randomNumber == 1) {
                        $auftrag->zeitTrackerG1 = max($auftrag->zeitSaverG1);
                        $auftrag->zeitTrackerG2 = max($auftrag->zeitSaverG2);
                        $this->kosten += $maschinenArray['M5.1']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if($this->lastMaschineSaverM2 =='M2.1' && $this->lastMaschineSaverM4 =='M4.1'){
                            $this->startZeit= max($maschinenArray['M2.1']->startZeit,$maschinenArray['M4.1']->startZeit,$maschinenArray['M5.1']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        }elseif($this->lastMaschineSaverM2 =='M2.1' && $this->lastMaschineSaverM4 =='M4.2'){
                            $this->startZeit= max($maschinenArray['M2.1']->startZeit,$maschinenArray['M4.2']->startZeit, $maschinenArray['M5.1']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        }elseif($this->lastMaschineSaverM2 =='M2.2' && $this->lastMaschineSaverM4 =='M4.1'){
                            $this->startZeit= max($maschinenArray['M2.2']->startZeit, $maschinenArray['M4.1']->startZeit, $maschinenArray['M5.1']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        }elseif($this->lastMaschineSaverM2 =='M2.2' && $this->lastMaschineSaverM4 =='M4.2') {
                            $this->startZeit = max($maschinenArray['M2.2']->startZeit, $maschinenArray['M4.2']->startZeit, $maschinenArray['M5.1']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        }
                        //$this->startZeit = max($maschinenArray['M2.1']->startZeit,$maschinenArray['M4.2']->startZeit,$maschinenArray['M5.1']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        $auftrag->zeitTrackerG3 = max($auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $this->lastMaschine='M5.1';
                        $maschinenArray['M5.1']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M5.1'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M5.1",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M5.1']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $this->chromosom[$auftrag->getAuftragID()][4] = $schritt;
                        $auftrag->zeitTrackerG3 += Chromosom::claculateZeit($maschinenArray['M5.1'], $auftrag, $aktuelleMaschine);
                        $maschinenArray['M5.1']->startZeit = $maschinenArray['M5.1']->endZeit;
                    } else {
                        $auftrag->zeitTrackerG1 = max($auftrag->zeitSaverG1);
                        $auftrag->zeitTrackerG2 = max($auftrag->zeitSaverG2);
                        $this->kosten += $maschinenArray['M5.2']->kosten_pro_stueck * $auftrag->getMenge();
                        //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                        if($this->lastMaschineSaverM2 =='M2.1' && $this->lastMaschineSaverM4 =='M4.1'){
                            $this->startZeit= max($maschinenArray['M2.1']->startZeit,$maschinenArray['M4.1']->startZeit,$maschinenArray['M5.2']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        }elseif($this->lastMaschineSaverM2 =='M2.1' && $this->lastMaschineSaverM4 =='M4.2'){
                            $this->startZeit= max($maschinenArray['M2.1']->startZeit,$maschinenArray['M4.2']->startZeit, $maschinenArray['M5.2']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        }elseif($this->lastMaschineSaverM2 =='M2.2' && $this->lastMaschineSaverM4 =='M4.1'){
                            $this->startZeit= max($maschinenArray['M2.2']->startZeit, $maschinenArray['M4.1']->startZeit, $maschinenArray['M5.2']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        }elseif($this->lastMaschineSaverM2 =='M2.2' && $this->lastMaschineSaverM4 =='M4.2') {
                            $this->startZeit = max($maschinenArray['M2.2']->startZeit, $maschinenArray['M4.2']->startZeit, $maschinenArray['M5.2']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        }
                        //$this->startZeit = max($maschinenArray['M2.2']->startZeit,$maschinenArray['M4.2']->startZeit,$maschinenArray['M5.2']->startZeit, $auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        $auftrag->zeitTrackerG3 = max($auftrag->zeitTrackerG1, $auftrag->zeitTrackerG2);
                        //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                        $this->lastMaschine='M5.2';
                        $maschinenArray['M5.2']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M5.2'], $auftrag, $aktuelleMaschine);

                        $schritt = array(
                            "Maschine" => "M5.2",
                            "Start" => $this->startZeit,
                            "Ende" => $maschinenArray['M5.2']->endZeit,
                            "Auftrag" => $auftrag->getAuftragID()
                        );
                        $this->chromosom[$auftrag->getAuftragID()][4] = $schritt;
                        $auftrag->zeitTrackerG3 += Chromosom::claculateZeit($maschinenArray['M5.2'], $auftrag, $aktuelleMaschine);
                        $maschinenArray['M5.2']->startZeit = $maschinenArray['M5.2']->endZeit;
                    }
                    $aktuelleMaschine++;
                    break;
                case 6:
                    //prüfen ob der Auftrag überhaupt auf diese Maschine muss.
                    if ($auftrag->beschichtung) {
                        $randomNumber = Chromosom::checkMaschineAvailable3(1, 3, $maschinenArray['M6.1'], $maschinenArray['M6.2'], $maschinenArray['M6.3']); //gucken welche Maschine überhaupt verfügbar ist, am besten eine neue Methode die guckt, ab die Maschine auf passt sonst noch mal eine neue random number
                        if ($randomNumber == 1) {
                            $auftrag->zeitTrackerG3 = max($auftrag->zeitSaverG3);
                            $this->kosten += $maschinenArray['M6.1']->kosten_pro_stueck * $auftrag->getMenge();
                            //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                            if($this->lastMaschine =='M5.1'){
                                $this->startZeit= max($maschinenArray['M5.1']->startZeit,$maschinenArray['M6.1']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M5.2'){
                                $this->startZeit= max($maschinenArray['M5.2']->startZeit, $maschinenArray['M6.1']->startZeit, $auftrag->zeitTrackerG3);
                            }
                            //$this->startZeit = max($maschinenArray['M5.1']->startZeit,$maschinenArray['M5.2']->startZeit,$maschinenArray['M6.1']->startZeit,$auftrag->zeitTrackerG3);
                            //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                            $this->lastMaschine='M6.1';
                            $maschinenArray['M6.1']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M6.1'], $auftrag, $aktuelleMaschine);

                            $schritt = array(
                                "Maschine" => "M6.1",
                                "Start" => $this->startZeit,
                                "Ende" => $maschinenArray['M6.1']->endZeit,
                                "Auftrag" => $auftrag->getAuftragID()
                            );
                            $this->chromosom[$auftrag->getAuftragID()][5] = $schritt;
                            $auftrag->zeitTrackerG3 += Chromosom::claculateZeit($maschinenArray['M6.1'], $auftrag, $aktuelleMaschine);
                            $maschinenArray['M6.1']->startZeit = $maschinenArray['M6.1']->endZeit;
                        } elseif ($randomNumber == 2) {
                            $auftrag->zeitTrackerG3 = max($auftrag->zeitSaverG3);
                            $this->kosten += $maschinenArray['M6.2']->kosten_pro_stueck * $auftrag->getMenge();
                            //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                            if($this->lastMaschine =='M5.1'){
                                $this->startZeit= max($maschinenArray['M5.1']->startZeit,$maschinenArray['M6.2']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M5.2'){
                                $this->startZeit= max($maschinenArray['M5.2']->startZeit, $maschinenArray['M6.2']->startZeit, $auftrag->zeitTrackerG3);
                            }
                            //$this->startZeit = max($maschinenArray['M5.1']->startZeit,$maschinenArray['M5.2']->startZeit,$maschinenArray['M6.2']->startZeit,$auftrag->zeitTrackerG3);
                            //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                            $this->lastMaschine='M6.2';
                            $maschinenArray['M6.2']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M6.2'], $auftrag, $aktuelleMaschine);

                            $schritt = array(
                                "Maschine" => "M6.2",
                                "Start" => $this->startZeit,
                                "Ende" => $maschinenArray['M6.2']->endZeit,
                                "Auftrag" => $auftrag->getAuftragID()
                            );
                            $this->chromosom[$auftrag->getAuftragID()][5] = $schritt;
                            $auftrag->zeitTrackerG3 += Chromosom::claculateZeit($maschinenArray['M6.2'], $auftrag, $aktuelleMaschine);
                            $maschinenArray['M6.2']->startZeit = $maschinenArray['M6.2']->endZeit;
                        } else {
                            $auftrag->zeitTrackerG3 = max($auftrag->zeitSaverG3);
                            $this->kosten += $maschinenArray['M6.3']->kosten_pro_stueck * $auftrag->getMenge();
                            //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                            if($this->lastMaschine =='M5.1'){
                                $this->startZeit= max($maschinenArray['M5.1']->startZeit,$maschinenArray['M6.3']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M5.2'){
                                $this->startZeit= max($maschinenArray['M5.2']->startZeit, $maschinenArray['M6.3']->startZeit, $auftrag->zeitTrackerG3);
                            }
                            //$this->startZeit = max($maschinenArray['M5.1']->startZeit,$maschinenArray['M5.2']->startZeit,$maschinenArray['M6.3']->startZeit,$auftrag->zeitTrackerG3);
                            //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                            $this->lastMaschine='M6.3';
                            $maschinenArray['M6.3']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M6.3'], $auftrag, $aktuelleMaschine);

                            $schritt = array(
                                "Maschine" => "M6.3",
                                "Start" => $this->startZeit,
                                "Ende" => $maschinenArray['M6.3']->endZeit,
                                "Auftrag" => $auftrag->getAuftragID()
                            );
                            $this->chromosom[$auftrag->getAuftragID()][5] = $schritt;
                            $auftrag->zeitTrackerG3 += Chromosom::claculateZeit($maschinenArray['M6.3'], $auftrag, $aktuelleMaschine);
                            $maschinenArray['M6.3']->startZeit = $maschinenArray['M6.3']->endZeit;
                        }
                    }
                    $aktuelleMaschine++;
                    break;
                case 7:
                    if ($auftrag->lackierung) {
                        $randomNumber = Chromosom::checkMaschineAvailable2(1, 2, $maschinenArray['M7.1'], $maschinenArray['M7.2']); //gucken welche Maschine überhaupt verfügbar ist, am besten eine neue Methode die guckt, ab die Maschine auf passt sonst noch mal eine neue random number
                        if ($randomNumber == 1) {
                            $auftrag->zeitTrackerG3 = max($auftrag->zeitSaverG3);
                            $this->kosten += $maschinenArray['M7.1']->kosten_pro_stueck * $auftrag->getMenge();
                            //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                            if($this->lastMaschine =='M6.1'){
                                $this->startZeit= max($maschinenArray['M6.1']->startZeit,$maschinenArray['M7.1']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M6.2'){
                                $this->startZeit= max($maschinenArray['M6.2']->startZeit, $maschinenArray['M7.1']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M6.3') {
                                $this->startZeit = max($maschinenArray['M6.3']->startZeit, $maschinenArray['M7.1']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M5.1') {
                                $this->startZeit = max($maschinenArray['M5.1']->startZeit, $maschinenArray['M7.1']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M5.2') {
                                $this->startZeit = max($maschinenArray['M5.2']->startZeit, $maschinenArray['M7.1']->startZeit, $auftrag->zeitTrackerG3);
                            }
                            //$this->startZeit = max($maschinenArray['M6.1']->startZeit,$maschinenArray['M6.2']->startZeit,$maschinenArray['M6.3']->startZeit,$maschinenArray['M7.1']->startZeit,$auftrag->zeitTrackerG3);
                            //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                            $this->lastMaschine='M7.1';
                            $maschinenArray['M7.1']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M7.1'], $auftrag, $aktuelleMaschine);

                            $schritt = array(
                                "Maschine" => "M7.1",
                                "Start" => $this->startZeit,
                                "Ende" => $maschinenArray['M7.1']->endZeit,
                                "Auftrag" => $auftrag->getAuftragID()
                            );
                            if ($auftrag->beschichtung){
                                $this->chromosom[$auftrag->getAuftragID()][6] = $schritt;
                            }else{
                                $this->chromosom[$auftrag->getAuftragID()][5] = $schritt;
                            }
                            $auftrag->zeitTrackerG3 += Chromosom::claculateZeit($maschinenArray['M7.1'], $auftrag, $aktuelleMaschine);
                            $maschinenArray['M7.1']->startZeit = $maschinenArray['M7.1']->endZeit;
                        } else {
                            $auftrag->zeitTrackerG3 = max($auftrag->zeitSaverG3);
                            $this->kosten += $maschinenArray['M7.2']->kosten_pro_stueck * $auftrag->getMenge();
                            //speichert die Zeit ab, wann der Auftrag mit der Maschine fertig ist, um zu Prüfen wann der Auftrag weiter machen kann
                            if($this->lastMaschine =='M6.1'){
                                $this->startZeit= max($maschinenArray['M6.1']->startZeit,$maschinenArray['M7.2']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M6.2'){
                                $this->startZeit= max($maschinenArray['M6.2']->startZeit, $maschinenArray['M7.2']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M6.3') {
                                $this->startZeit = max($maschinenArray['M6.3']->startZeit, $maschinenArray['M7.2']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M5.1') {
                                $this->startZeit = max($maschinenArray['M5.1']->startZeit, $maschinenArray['M7.2']->startZeit, $auftrag->zeitTrackerG3);
                            }elseif($this->lastMaschine =='M5.2') {
                                $this->startZeit = max($maschinenArray['M5.2']->startZeit, $maschinenArray['M7.2']->startZeit, $auftrag->zeitTrackerG3);
                            }
                            //$this->startZeit = max($maschinenArray['M6.1']->startZeit,$maschinenArray['M6.2']->startZeit,$maschinenArray['M6.3']->startZeit,$maschinenArray['M7.2']->startZeit,$auftrag->zeitTrackerG3);
                            //speichert die letzte Zeit ab, die der Auftrag auf der Maschine ist, um zu prüfen wann der nächste auftrag auf die Maschine kann
                            $this->lastMaschine='M7.2';
                            $maschinenArray['M7.2']->endZeit = $this->startZeit + Chromosom::claculateZeit($maschinenArray['M7.2'], $auftrag, $aktuelleMaschine);

                            $schritt = array(
                                "Maschine" => "M7.2",
                                "Start" => $this->startZeit,
                                "Ende" => $maschinenArray['M7.2']->endZeit,
                                "Auftrag" => $auftrag->getAuftragID()
                            );
                            if ($auftrag->beschichtung){
                                $this->chromosom[$auftrag->getAuftragID()][6] = $schritt;
                            }else{
                                $this->chromosom[$auftrag->getAuftragID()][5] = $schritt;
                            }
                            $auftrag->zeitTrackerG3 += Chromosom::claculateZeit($maschinenArray['M7.2'], $auftrag, $aktuelleMaschine);
                            $maschinenArray['M7.2']->startZeit = $maschinenArray['M7.2']->endZeit;
                        }
                    }
                    $aktuelleMaschine++;
                    break;
            }
        }
        //$this->chromosom[$auftrag->getAuftragID()] = $auftragSchritte;


        $count = 0;
        foreach ($this->chromosom as $c){
            $temp = (count($c)) -1;
            $this->max_dauer = $c[$temp]['Ende'];

            if ($this->max_dauer < $count){
                $this->max_dauer = $count;
            }
            $count =$this->max_dauer;
        }
        return $maschinenArray;
    }
    // function die, die Zeit anahnd der Menge, dem Faktor sowie der Umrüstzeit errechnet
    function claculateZeit(Maschine $maschine, Auftrag $auftrag, int $akmaschine)
    {
        return ($maschine->getDurchlaufzeit($auftrag->getMenge(), $auftrag->getArtikel()->getFaktor()) + $maschine->umruestzeit($auftrag, $akmaschine));
    }
        // checkt ob die jeweilige Maschine verfügbar ist, dazu wird random Nummer gewählt, diese Nummer mit der Maschine abgeglichen. Wenn verfügbar, dann wird die Maschine zurück gegeben
        // ist für Maschinentypen (Cases) wo es nur 2 verschidene Maschinen gibt
    function checkMaschineAvailable3($min, $max, Maschine $m1, Maschine $m2, Maschine $m3): int
    {
        $tempArray = [];
        $tempArray[] = $m1;
        $tempArray[] = $m2;
        $tempArray[] = $m3;
        while (true) {
            $number = rand($min, $max);

            if ($number == 1 && $tempArray[$number - 1]->is_avaliable) {
                return $number;
            }
            if ($number == 2 && $tempArray[$number - 1]->is_avaliable) {
                return $number;
            }
            if ($number == 3 && $tempArray[$number - 1]->is_avaliable) {
                return $number;
            }
        }
    }
    // checkt ob die jeweilige Maschine verfügbar ist, dazu wird random Nummer gewählt, diese Nummer mit der Maschine abgeglichen. Wenn verfügbar, dann wird die Maschine zurück gegeben
    // ist für Maschinentypen (Cases) wo es nur 2 verschidene Maschinen gibt
    function checkMaschineAvailable2($min, $max, $m1, $m2): int
    {
        $tempArray = [];
        $tempArray[] = $m1;
        $tempArray[] = $m2;
        while (true) {
            $number = rand($min, $max);

            if ($number == 1 && $tempArray[$number - 1]->is_avaliable) {
                return $number;
            }
            if ($number == 2 && $tempArray[$number - 1]->is_avaliable) {
                return $number;
            }
        }
    }

    /**
     * @return array
     */
    public function getChromosom(): array
    {
        return $this->chromosom;
    }

    /**
     * @param array $chromosom
     */
    public function setChromosom(array $chromosom): void
    {
        $this->chromosom = $chromosom;
    }
}

?>

