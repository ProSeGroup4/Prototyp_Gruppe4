<!-- Diesen View mit View "layouts.app" erweitern, um u. a. Navigationsleiste zu haben -->


<!-- Ab hier wird der Content der Eingabe geladen -->
<?php $__env->startSection("content"); ?>
    <div class="container">
        <h1> Auftragserstellung </h1>
    
        <form action="<?php echo e(route('eingabe')); ?>" method="POST">
            
            <!-- Letzte ID aus Datenbank nehmen für die automatische Auftrags-ID-Generierung -->
            <?php
                $lastID = DB::table('aufträge')->latest('id')->first();
            ?>
                <!-- "cross-site request forgery" generiert einen geheimen Token innerhalb der HTTP-Request,
                um Hacker zu hindern den Web Service zu manipulieren.-->   
            <?php echo csrf_field(); ?>

            <!-- Alle Eingabefelder wurden untenstehend mit Errorabfragen erweitert, falls das Feld nicht ausgefüllt wurde
            dann kommt eine Fehlermeldung.
            Wenn eine Fehlermeldung kommt bleiben die bereits eingetragenen Wert mit 'old' bestehen -->

            <div class="form-group">
                <label for="InputOrderID">Auftragsnummer:</label>
                <input type="text" class="form-control" value="<?php echo e('#' . str_pad($lastID->id+1, 4, '0', STR_PAD_LEFT)); ?>" readonly> <!-- Setze am Anfang ein # addiere die ID um 1 und setze die am "Ende" des Strings, fülle den Rest der Stringlänge 4 mit 0 auf -->
                <p></p>
            </div>

            <div class="form-group">
                <label for="InputClient">Auftraggeber:</label>
                <input type="text" class="form-control <?php $__errorArgs = ["InputClient"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="InputClient" placeholder="Bauhaus" value="<?php echo e(old("InputClient")); ?>">

                <?php $__errorArgs = ["InputClient"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger">
                        <?php echo e($message = "Das ist ein Pflichtfeld"); ?>

                    </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <p></p>
            </div>

            <div class="form-group">
                <label for="InputItemNumber">Artikelnummer:</label>
                <select class="form-control" name="InputItemNumber" value="<?php echo e(old("InputItemNumber")); ?>">
                    <option selected>#10111 Stahl-Grobgewinde-Rundkopf-Sechskantschraube</option>
                    <option>#10222 Stahl-Feingewinde-Flachkopf-Kreuzschraube</option>
                    <option>#11131 Stahl-Grobgewinde-Flachrundkopf-Sechskantschraube</option>
                    <option>#11242 Stahl-Feingewinde-Trompetenkopf-Kreuzschraube</option>
                    <option>#20111 Edelstahl-Grobgewinde-Rundkopf-Sechskantschraube</option>
                    <option>#20222 Edelstahl-Feingewinde-Flachkopf-Kreuzschraube</option>
                    <option>#21131 Edelstahl-Grobgewinde-Flachrundkopf-Sechskantschraube</option>
                    <option>#21242 Edelstahl-Feingewinde-Trompetenkopf-Kreuzschraube</option>
                    <option>#30111 Messing-Grobgewinde-Rundkopf-Sechskantschraube</option>
                    <option>#30222 Messing-Feingewinde-Flachkopf-Kreuzschraube</option>
                    <option>#31131 Messing-Grobgewinde-Flachrundkopf-Sechskantschraube</option>
                    <option>#31242 Messing-Feingewinde-Trompetenkopf-Kreuzschraube</option>
                <p></select></p>
            </div>

            <div class="form-group">
                <label for="InputAmount">Menge:</label>
                <input type="number" class="form-control <?php $__errorArgs = ["InputAmount"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" min="1" max="1000" name="InputAmount" placeholder="1-1000" value="<?php echo e(old("InputAmount")); ?>">

                <?php $__errorArgs = ["InputAmount"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger">
                        <?php echo e($message = "Das ist ein Pflichtfeld"); ?>

                    </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <p></p>
            </div>

            <div class="form-group">
                <label for="InputColour">Farbe:</label>
                <select class="form-control" name="InputColour" value="<?php echo e(old("InputColour")); ?>">
                    <option selected>Standard</option>
                    <option>Schwarz</option>
                    <option>Gelb</option>
                    <option>Blau</option>
                <p></select></p>
            </div>

            <div class="form-group">
                <label for="Coating">Beschichtungen:</label>
                <select class="form-control" name="Coating" value="<?php echo e(old("Coating")); ?>">
                    <option selected>0</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                <p></select></p>
            </div>

            <div class="form-group">
                <label for="InputTime">Deadline:</label>
                <input type="time" class="form-control <?php $__errorArgs = ["InputTime"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="InputTime" value="<?php echo e(old("InputTime")); ?>"> 

                <?php $__errorArgs = ["InputTime"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                    <div class="text-danger">
                        <?php echo e($message = "Das ist ein Pflichtfeld"); ?>

                    </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <p></p>
            </div>

        <!-- Button zum ausführen, Werte werden auf der Datenbank hinterlegt -->
        <button class="btn btn-primary">hinzufügen</button>
            
        </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/phpvhosts/mob224/htdocs/resources/views/eingabe/eingabe.blade.php ENDPATH**/ ?>