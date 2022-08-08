<?php $__env->startSection("content"); ?>
    <h1> Auftragserstellung </h1>
                
    <form name="formular" action="">
        
        <div class="form-group">
            <label for="InputOrderID">AuftragsID:</label>
            <input required type="text" class="form-control" pattern="#[0-9]{4}" id="InputOrderID" placeholder="#0001" size="5">
        </div>
        <div class="form-group">
            <label for="InputClient">Auftraggeber:</label>
            <input required type="text" class="form-control" id="InputClient" placeholder="Bauhaus">
        </div>
        <div class="form-group">
            <label for="InputItemNumber">Artikelnummer:</label>
            <input required type="text" class="form-control" pattern="#[0-9]{5}" id="InputItemNumber" placeholder="#00001" size="6">
        </div>
        <div class="form-group">
            <label for="InputAmount">Menge:</label>
            <input required type="number" class="form-control" min="1" max="1000" id="InputAmount" placeholder="1-1000">
        </div>
        <div class="form-group">
            <label for="InputColour">Farbe</label>
            <select class="form-control" id="InputColour">
                <option selected>Standard</option>
                <option>Schwarz</option>
                <option>Gelb</option>
                <option>Blau</option>
            </select>
        <div class="form-group">
            <label for="InputTime">Uhrzeit:</label>
            <input required type="time" class="form-control" id="InputTime">
        </div>

            <button onclick="sichern(); return false;" data-tab-target="#Start" type="submit" id="Autraghinzufügen">Auftrag hinzufügen</button> <!-- Funktionen zusammenlegen? -->

        </div>
        
    </form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Prototyp2/resources/views/eingabe/auftragserstellung.blade.php ENDPATH**/ ?>