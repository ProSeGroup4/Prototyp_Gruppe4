<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Ausgabe extends Controller
{
    // Routet zur Ausgabe
    public function index() {
        return view("ausgabe.ausgabe");
    }

    
}
