<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Artikel extends Controller
{
    //Variablen
    private $artikelID;
    private $faktor;
    private $gewinde;
    private $kopf;

    //Constructor
    function __construct($artikelID, $faktor, $gewinde, $kopf)
    {
        $this->artikelID = $artikelID;
        $this->faktor = $faktor;
        $this->gewinde = $gewinde;
        $this->kopf = $kopf;
    }

    //Function
    function getID()
    {
        echo($this->artikelID);
    }

    function getFaktor()
    {
        return $this->faktor;
    }

    function getGewinde()
    {
        return $this->gewinde;
    }

    function getKopf()
    {
        return $this->kopf;
    }

    function setName($name)
    {
        $this->artikelID = $name;
    }

    function setFaktor($faktor)
    {
        $this->faktor = $faktor;
    }

    function setGewinde($gewinde)
    {
        $this->gewinde = $gewinde;
    }

    function setKopf($kopf)
    {
        $this->kopf = $kopf;
    }
}
