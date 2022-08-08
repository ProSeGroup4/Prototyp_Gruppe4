<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Auftrag extends Controller
{
        //Variablen
    private $auftragID;
    private Artikel $artikel;
    private $menge;
    public bool $beschichtung;
    public bool $lackierung;
    public $zeitTrackerG1;
    public $zeitTrackerG2;
    public $zeitTrackerG3;
    public array $zeitSaverG1;
    public array $zeitSaverG2;
    public array $zeitSaverG3;

    public $time;

    //Constructor
    function __construct($auftragID, $artikel, $menge, $beschichtung, $lackierung, $time)
    {
        $this->auftragID = $auftragID;
        $this->artikel = $artikel;
        $this->menge = $menge;
        $this->beschichtung = $beschichtung;
        $this->lackierung = $lackierung;
        $this->time = $time;
    }

    //Funktionen
    function getAuftragID() : int
    {
        return $this->auftragID;
    }

    function getAuftragsPos()
    {
        return $this->artikel;
    }

    function setauftragID($auftragID)
    {
        $this->auftragID = $auftragID;
    }

    /**
     * @return mixed
     */
    public function getMenge()
    {
        return $this->menge;
    }

    /**
     * @param mixed $menge
     */
    public function setMenge($menge): void
    {
        $this->menge = $menge;
    }

    /**
     * @return mixed
     */
    public function getArtikel() : Artikel
    {
        return $this->artikel;
    }

    /**
     * @param mixed $artikel
     */
    public function setArtikel($artikel): void
    {
        $this->artikel = $artikel;
    }

    /**
     * @return mixed
     */
    public function getBeschichtung()
    {
        return $this->beschichtung;
    }

    /**
     * @param mixed $beschichtung
     */
    public function setBeschichtung($beschichtung): void
    {
        $this->beschichtung = $beschichtung;
    }

    /**
     * @return mixed
     */
    public function getZeitTrackerG1()
    {
        return $this->zeitTrackerG1;
    }

    /**
     * @param mixed $zeitTrackerG1
     */
    public function setZeitTrackerG1($zeitTrackerG1): void
    {
        $this->zeitTrackerG1 = $zeitTrackerG1;
    }
}
