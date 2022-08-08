<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Chromosom;
use App\Http\Controllers\Start;
use DB;


class Population extends Controller
{

    public array $population; // hier ist der Array, wo alle Chromosomen gespeichert werden
    private array $auftraege; // hier ist der Array, wo alle Aufträge gespeichert werden
    private array $artikel; // hier ist der Array, wo alle Aufträge gespeichert werden
    private array $newPopulation; // nach der Mutation wird hier die neue Population gespeichert
    public array $aufträge;


    function __construct()
    {

    }

    
    //Hier werden die einzelnen Chromosomen erzeugt und zwischen gespeichert
    function generatePopulation():Array
    {

        $art = new Artikel(1, 2, "Feingewinde", "kreuz");
        $art1 = new Artikel(2, 2, "Grobgewinde", "kreuz2");

        $auf1 = new Auftrag(1, $art, 10, true, true, 1);
        $auf2 = new Auftrag(2, $art1, 10, true, false, 1);
        $auf3 = new Auftrag(3, $art1, 10, false, false, 1);
        $auf4 = new Auftrag(4, $art1, 10, false, true, 1);

        $this->auftraege[] = $auf1;
        $this->auftraege[] = $auf2;
        $this->auftraege[] = $auf3;
        $this->auftraege[] = $auf4;

        $anz_chromo = 0;
        $datashare = DB::table('datashare')->latest()->first();
        while ($anz_chromo <= $datashare->Populationsgroeße) {  //  Itteriert durch die Chromosome, bis alle durch itteriert wurden
            $chromosom = new Chromosom(0);  // erstellt neues Objekt Chromosom
            $chromosom->doChromosom($this->auftraege);  // ruft doChromosom mit gegebenen Auftrag auf
            $this->population[] = $chromosom;   // das chromosom wird in dem Populations-Array gespeichert
            $anz_chromo++;  // Zähler zum durchitterieren wird einen hoch gestellt
        }

        for ($i = 2; $i<7 ;$i++){
            $this->calculateFitnessScore(3);
            $this->crossover($i);
            $this->mutation();
        }


        foreach($this->population[5]->chromosom as $auftrag){ // Das beste Chromosom wird immer in dem letzten Array-Eintrag der Population gespeichert
            for ($i = 0; $i < count($auftrag); $i++){ //Itteriert durch alle Aufträge
                $this->aufträge[] = $auftrag[$i]; // speichert den aktuellen auftrag in dem Aufträge-Array
                }
        }
        return $this->aufträge;
    }

    //Hier wird für jedes einzelne Chromosom der FS erstellt.
    function calculateFitnessScore(int $fScore)
    {
        // Termintreue, der Auftrag muss vor der gegebenen Zeit fertig sein // vergleich von spätester Endzeit des Auftrags im Vergleich zur Deadline
        if ($fScore == 1) {
            foreach ($this->auftraege as $auftrag) {
                //selektion der letzten Maschine die für den auftrag genutzt wurde
                $temp = count($this->population[0]->chromosom[$auftrag->getAuftragID()]);
                //Ende Zeit der letzten Maschine selektieren
                $endzeit = $this->population[0]->chromosom[$auftrag->getAuftragID()][$temp - 1]['Ende'];
                for ($i = 0; $i < count($this->population); $i++) {
                    if ($auftrag->time >= $endzeit) {
                        $this->population[$i]->fitness = 1; // niedriger Score, wenn die Termintreue nicht eingehalten wird
                    } else {
                        $this->population[$i]->fitness = 5; // hoher Score, wenn die Termintreu gegeben ist
                    }
                }
            }
        } 
        // Kürzeste Zeit, die Zeit bei dem die Aufträge am schnellsten durch sind // frühste Startzeit und spätester Endzeit von alle Aufträgen suptrahieren
        // Sortiert die Population anhand der Max_Dauer jedes einzelenen Chromosoms, sodass vorne im Array die Kürzesten Durchlaufzeiten und somit besten Lösungen sind
        // Vergleicht dank den zwei For_schleifen jedes Chromosom mit jedem anderen Chromosom einmal
        elseif ($fScore == 2) {
            for ($i = 0; $i < count($this->population); $i++) {
                for ($j = 0; $j < count($this->population); $j++) {
                    if ($this->population[$i]->max_dauer < $this->population[$j]->max_dauer) {
                        $temp = $this->population[$i];
                        $this->population[$i] = $this->population[$j];
                        $this->population[$j] = $temp;
                    }
                }
            }
            // setzt den Fitness score für alle Chromosome in Population
            // Itteriert durch die Population und vergleicht die max_Durchlaufzeit des aktuellen chromosoms ungleich mit der Länge des nächsten Chromosoms ist;
            // wenn dass der fall, dann wir der Score vergeben und der Score anschließend hochgesetzt, ist es nicht der Fall, wird der score nicht hochgestezt.
            // Gleiche Max_dauer hat so den gleichen Score
            $score = 1;
            for ($i = 0; $i < count($this->population); $i++) {
                if($i!=(count($this->population))-1) {
                    if ($this->population[$i]->max_dauer != $this->population[$i + 1]->max_dauer) {
                        $this->population[$i]->fitness = $score;
                        $score++;
                    }else{
                        $this->population[$i]->fitness = $score;
                    }
                }

            }
            shuffle($this->population); // Population wird gemischt
        } // niedrigste Kosten, wo alle Maschinen am Kosten günstigesten sind // kosten aus dem Chromosom verlgeichen
        else {
            for ($i = 0; $i < count($this->population); $i++) {  // Es wird wieder jedes Chromosom mit jedem anderen Chromosom verglichen und dann anhand ihrer Kosten soriert; je günstiger desto weiter vorne im Array
                for ($j = 0; $j < count($this->population); $j++) {
                    if ($this->population[$i]->kosten < $this->population[$j]->kosten) {
                        $temp = $this->population[$i];
                        $this->population[$i] = $this->population[$j];
                        $this->population[$j] = $temp;
                    }
                }
            }
            // hier wird das jeweilige Chromosom mit dem jeweilig nächsten Chromosom im Array verglichen
            // wenn die Kosten ungleich sind, dann wird der Score einen hoch gesetzt, wenn sie gleich sind, dann bleibt der Score bei dem Wert
            $score = 1;
            for ($i = 0; $i < count($this->population); $i++) {
                if($i!=(count($this->population))-1) {
                    if ($this->population[$i]->kosten != $this->population[$i + 1]->kosten) {
                        $this->population[$i]->fitness = $score;
                        $score++;
                    }else{
                        $this->population[$i]->fitness = $score;
                    }
                }


            }
            shuffle($this->population);
        }
    }
    // Parent wird ausgewählt anhand seines Fittnessscors, je besser der Score, desto wahrscheinlicher wird das Chromosom gewählt
    function selectParent(): Chromosom
    {
        $max_fitness = 0; // Max_fitness variable wird mit 0 initilaisiert
        for ($i = 0; $i < count($this->population); $i++) { // in der if Schleife werden alle FittnesScores zusammen addiert und in ma_fitness Gespeichert
            $max_fitness += $this->population[$i]->fitness;
        }

        for ($i = 0; $i < count($this->population); $i++) {
            $this->population[$i]->probability = $this->population[$i]->fitness / $max_fitness; // der Wahrschinlichkeitswert eines jeden Chromosoms wird errechnet
        }

        $rndNumber = lcg_value(); // wählt eine random Nummer zwischen 0 und 1
        $offset = 0.0;

        for ($i = 0; $i < count($this->population); $i++) { // itteriert durch die Anzahl der Chromosome in der Population
            $offset += $this->population[$i]->probability; // offset ist unser counter und wird immer um den jeweiligen wahrscheinlichkeitswert erhöht
            if ($rndNumber < $offset) { // wenn die random Nummer kleiner als unser Offset ist, dann gebe das Chromosom wieder
                return $this->population[$i];
            }
        }
        return $this->population[rand(count($this->population), 1)];
    }

    function crossover(int $durchlauf)
    {
        for ($i = 0; $i < 0.5 * strlen('datashare'); $i++) {
            // nur eine parent, weil wir den zweiten dazu crossen eh alles überschreiben würden.
            // hier könnten wir zwar prüfen, ob einige Maschinen Belegungen passen würden, aber das prüfen würde mehr Zeit in anspruch nehmen, als wenn wir die komplett neu machen
            $parent1 = $this->selectParent(); // return aus crossover
            $this->newPopulation[] = $parent1;
        }
        $this->population = array();
        $this->population = $this->newPopulation;
        $this->newPopulation= array();
        $this->doRepair($durchlauf);
    }
    // setz von allen Maschinen des typs 2 die Start- und Endzeit zurück
    public function clearMaschine2(Chromosom $aktuellesChromosom)
    {
        $aktuellesChromosom->maschinenArray['M2.1']->startZeit = 0;
        $aktuellesChromosom->maschinenArray['M2.1']->endZeit = 0;
        $aktuellesChromosom->maschinenArray['M2.2']->startZeit = 0;
        $aktuellesChromosom->maschinenArray['M2.2']->endZeit = 0;
    }
    // setz von allen Maschinen des typs 3 die Start- und Endzeit zurück
    public function clearMaschine3(Chromosom $aktuellesChromosom)
    {
        $aktuellesChromosom->maschinenArray['M3.1']->startZeit = 0;
        $aktuellesChromosom->maschinenArray['M3.1']->endZeit = 0;
        $aktuellesChromosom->maschinenArray['M3.2']->startZeit = 0;
        $aktuellesChromosom->maschinenArray['M3.2']->endZeit = 0;
    }
    // setz von allen Maschinen des typs 4 die Start- und Endzeit zurück
    public function clearMaschine4(Chromosom $aktuellesChromosom)
    {
        $aktuellesChromosom->maschinenArray['M4.1']->startZeit = 0;
        $aktuellesChromosom->maschinenArray['M4.1']->endZeit = 0;
        $aktuellesChromosom->maschinenArray['M4.2']->startZeit = 0;
        $aktuellesChromosom->maschinenArray['M4.2']->endZeit = 0;
    }
    // setz von allen Maschinen des typs 5 die Start- und Endzeit zurück
    public function clearMaschine5(Chromosom $aktuellesChromosom)
    {
        $aktuellesChromosom->maschinenArray['M5.1']->startZeit = 0;
        $aktuellesChromosom->maschinenArray['M5.1']->endZeit = 0;
        $aktuellesChromosom->maschinenArray['M5.2']->startZeit = 0;
        $aktuellesChromosom->maschinenArray['M5.2']->endZeit = 0;
    }
    // setz von allen Maschinen des typs 6 die Start- und Endzeit zurück
    public function clearMaschine6(Chromosom $aktuellesChromosom)
    {
        $aktuellesChromosom->maschinenArray['M6.1']->startZeit = 0;
        $aktuellesChromosom->maschinenArray['M6.1']->endZeit = 0;
        $aktuellesChromosom->maschinenArray['M6.2']->startZeit = 0;
        $aktuellesChromosom->maschinenArray['M6.2']->endZeit = 0;
        $aktuellesChromosom->maschinenArray['M6.3']->startZeit = 0;
        $aktuellesChromosom->maschinenArray['M6.3']->endZeit = 0;
    }
    // setz von allen Maschinen des typs 7 die Start- und Endzeit zurück
    public function clearMaschine7(Chromosom $aktuellesChromosom)
    {
        $aktuellesChromosom->maschinenArray['M7.1']->startZeit = 0;
        $aktuellesChromosom->maschinenArray['M7.1']->endZeit = 0;
        $aktuellesChromosom->maschinenArray['M7.2']->startZeit = 0;
        $aktuellesChromosom->maschinenArray['M7.2']->endZeit = 0;
    }
    // ist die ReparierFunktion, welche die "zerschossenen" neuen Chromosome wieder herstellt und von der Crossover aufgerufen wird
    // dazu wird immer die Kosten resettet und auf den Wert des Kostensaver gesetzt
    // anschießed werden je nach Generation, die Maschinen zurück gesetzt
    public function doRepair(int $durchlauf)
    {
        foreach ($this->population as $aktuellesChromosom) {
            $aktuellesChromosom->kosten = 0;
            $aktuellesChromosom->setKostenRepair($durchlauf);
            switch ($durchlauf){
                case 2:
                    $this->clearMaschine2($aktuellesChromosom);
                    $this->clearMaschine3($aktuellesChromosom);
                    $this->clearMaschine4($aktuellesChromosom);
                    $this->clearMaschine5($aktuellesChromosom);
                    $this->clearMaschine6($aktuellesChromosom);
                    $this->clearMaschine7($aktuellesChromosom);
                    break;
                case 3:
                    $this->clearMaschine3($aktuellesChromosom);
                    $this->clearMaschine4($aktuellesChromosom);
                    $this->clearMaschine5($aktuellesChromosom);
                    $this->clearMaschine6($aktuellesChromosom);
                    $this->clearMaschine7($aktuellesChromosom);
                    break;
                case 4:
                    $this->clearMaschine4($aktuellesChromosom);
                    $this->clearMaschine5($aktuellesChromosom);
                    $this->clearMaschine6($aktuellesChromosom);
                    $this->clearMaschine7($aktuellesChromosom);
                    break;
                case 5:
                    $this->clearMaschine5($aktuellesChromosom);
                    $this->clearMaschine6($aktuellesChromosom);
                    $this->clearMaschine7($aktuellesChromosom);
                    break;
                case 6:
                    $this->clearMaschine6($aktuellesChromosom);
                    $this->clearMaschine7($aktuellesChromosom);
                    break;
                case 7:
                    $this->clearMaschine7($aktuellesChromosom);
                    break;

            }
            //einmal alle Aufträge des aktuellen Chromosoms durchgehen
            foreach ($aktuellesChromosom->chromosom as $aktuellesChromosom1) {
                // hier ist die AuftragsID übertragen
                for ($i = 0; $i < count($this->auftraege); $i++) {
                    if ($this->auftraege[$i]->getAuftragID() === $aktuellesChromosom1[1]['Auftrag']) {

                        $aktuellesChromosom->maschinenArray = $aktuellesChromosom->crossoverMutationRepair($this->auftraege[$i], $aktuellesChromosom->maschinenArray, $durchlauf);
                    }
                }
            }
        }
        //hier wird von aussen das Maschinen array übergeben mit dem ein Chromosom erzeugt wird.
        //Es wird immer wieder von der Methode zurückgegeben, damit man für jeden Auftrag den Stand vom letzten Auftrag hat.
    }

    function mutation()
    // die Mutationsfunktion generiert Komplett neue random Chromosome in die neuen Generation; so wird die Richtigkeit von Logik und Abhängigkeiten sichergestellt
    // kann lokales Tiefpunktproblem verhindern
    {
        for ($i = 0; $i < 0.5 * strlen('datashare'); $i++) {
            $aktuellesChromosom = new Chromosom(0);
            $aktuellesChromosom->doChromosom($this->auftraege);
            $this->population[] = $aktuellesChromosom;
        }
    }
}