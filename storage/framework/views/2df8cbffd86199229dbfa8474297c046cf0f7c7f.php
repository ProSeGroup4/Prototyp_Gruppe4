<?php use \App\Http\Controllers\dragController;?>
<?php $__env->startSection("content"); ?>
    <div class="container">
        <h1> Produktionsplan </h1>

        <link rel="stylesheet" href="css/ausgabe.css">

        <?php echo e(dragController::callDiagramm($aufträge)); ?>


        <button class="open-button" onclick="openForm()">Werte ändern</button>
        <div class="form-popup" id="myForm">


        <?php echo csrf_field(); ?> 

        <h3>Werte ändern</h3>

        <label for="email"><b>Startzeit verschieben</b></label>
                <input type="text" id="hour" name="hour" value="Stunden"><br>
                <input type="text" id="min" name="min" value="Minuten"><br>

            <br>
            <b>Maschine wählen</b>
            <select id="maschine" name="maschine">
                <option value="M1.1">M1.1</option>
                <option value="M1.2">M1.2</option>
                <option value="M1.3">M1.3</option>
                <option value="M2.1">M2.1</option>
                <option value="M2.2">M2.2</option>
            </select>
            <br>
            <b>Vor oder Zurück</b>
                <select id="richtung" name="richtung">
                <option value="vor">Vor</option>
                <option value="zurück">Zurück</option>
            </select>
            <br>
            <b>Auftrag wählen</b>
            <input type="text" id="auftrag" name="auftrag" value="Hier auftragsnummer"><br>
            <br>
            <b>Maschine wechseln</b>
            <input type="radio" id="ja" name="wechsel" value="ja">
            <label for="html">Ja</label><br>
            <input type="radio" id="nein" name="wechsel" value="nein" checked="checked">
            <label for="css">Nein</label><br>
            <br>
            <input type="text" id="maschineNeu" name="maschineNeu" value="Maschinenname"><br>

            <button type="submit" class="btn">Bestätigen</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Abbrechen</button>
        </form>
        </div>

            <script src="<?php echo e(url('js/script.js')); ?>"></script>

            <div class="d-flex align-items-center justify-content-between bd-highlight mb-3">
                <a href="/public" class="btn btn-primary">zurück</a>
                </div>
            </div>
        </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/phpvhosts/mob224/htdocs/resources/views/ausgabe/ausgabe.blade.php ENDPATH**/ ?>