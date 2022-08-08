<?php $__env->startSection("content"); ?>

    <div class="tab-content">
        <div id="Start" data-tab-content class="active">
        <h1> Konfiguration </h1>
        <input type="checkbox" onClick="toggle(this)">
        Alle Aufträge Auswählen

        <div class="table-responsive">  <!--Table-->
        <table class="table table-sortable">
        <thead>
            <tr>
                <th></th>
                <th>Auftragsnummer</th>
                <th>Autragsgeber</th>
                <th>Artikelnummer</th>
                <th>Menge</th>
                <th>Farbe</th>
                <th>Uhrzeit</th>
            </tr>
            </thead>
        <tbody>
            <tr>
                <td><input type="checkbox" onclick="auswahl()" id="#2000" name="foo"></td>
                <td>#2000</td>
                <td>OBI</td>
                <td>#10002</td>
                <td>100</td>
                <td>Schwarz</td>
                <td>09:00</td>
            </tr>
            <tr>
                <td><input type="checkbox" onclick="auswahl()" id="#2002" name="foo"></td>
                <td>#2001</td>
                <td>OBI</td>
                <td>#10003</td>
                <td>100</td>
                <td>Blau</td>
                <td>08:30</td>
            </tr>
            <tr>
                <td><input type="checkbox" onclick="auswahl()" id="#2001" name="foo"></td>
                <td>#2002</td>
                <td>Bauhaus</td>
                <td>#10004</td>
                <td>100</td>
                <td>Blau</td>
                <td>09:00</td>
            </tr>
        </tbody>
        </table>                    
    </div>                 

        <div class="ausgewählte Aufträge">  <!--Abfragen welche inputs aus Aufträge "an" sind-->
                                    
            Ausgewählte Aufträge:
            <b><p id="ausgewählteAufträge"></p></b>
        </div>
            <div class="Optimieren">
            <div>
                Optimieren nach:
            </div>
        <div class="Auswahlliste" role="group">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
            <label class="form-check-label" for="flexRadioDefault1">
            Durchlaufzeit
        </label>
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
            <label class="form-check-label" for="flexRadioDefault2">
            Termintreue
        </label>
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
            <label class="form-check-label" for="flexRadioDefault3">
            Kosten
        </label>
        </div>

        <p></p>
        Genetischen Algorithmus konfigurieren:
        <br>
        <label for="Population">Populationsgröße:</label>
        <input required type="number" class="form-control" min="20" max="100" id="Population" placeholder="20 - 100">
        
        <label for="mutationRate">Mutationsrate:</label>
        <input required type="number" class="form-control" min="0.05" max="0.2" id="mutationRate" placeholder="0.05 - 0.2">

        <label for="cycles">Maximale Durchlaufzeit:</label>
        <input required type="number" class="form-control" min="1" max="5" id="cycles" placeholder="1 - 5 min.">


        <div class="Button">    <!--Ausführen-->
            <input type="button" onclick="produktionsausgabe();" value="Ausführen">
        </div>       
    
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Prototyp2/resources/views/subviews/index.blade.php ENDPATH**/ ?>