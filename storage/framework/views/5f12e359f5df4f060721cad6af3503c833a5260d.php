<?php $__env->startSection("content"); ?>

    <div class="tab-content">
        <div id="Start" data-tab-content class="active">
        <h1> Konfiguration </h1>
        <input type="checkbox" onClick="toggle(this)">
        Alle Aufträge Auswählen

        <div class="table-responsive" style="height: 145px;">  <!--Table schauen ab wann scrollbar-->

            <?php 
                $aufträge = DB::table('aufträge')->get();
            ?>



            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Auftragsnummer</th>
                        <th>Auftraggeber</th>
                        <th>Artikelnummer</th>
                        <th>Menge</th>
                        <th>Farbe</th>
                        <th>Uhrzeit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><input type="checkbox" onclick="auswahl()" id=<?php echo e($auftrag->InputOrderID); ?> name="foo"></td> <!--Name foo änern-->
                        <td><?php echo e($auftrag->InputOrderID); ?></td>
                        <td><?php echo e($auftrag->InputClient); ?></td>
                        <td><?php echo e($auftrag->InputItemNumber); ?></td>
                        <td><?php echo e($auftrag->InputAmount); ?></td>
                        <td><?php echo e($auftrag->InputColour); ?></td>
                        <td><?php echo e($auftrag->InputTime); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
             </table> 


        </div>                    
    </div>                 

          <!--Abfragen welche inputs aus Aufträge "an" sind-->
        <div class="d-flex p-2 border border-grey border-1">                            
            <b>Ausgewählte Aufträge:</b>
            <b id="ausgewählteAufträge"></b>
        </div>
        <p></p>

            <div class="Optimieren">
            <div>
                <b>Optimieren nach:</b>
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
        <b>Genetischen Algorithmus konfigurieren:</b>
        <br>
        
        <label for="Population">Populationsgröße:</label>
        <input required type="number" class="form-control" min="20" max="100" id="Population" placeholder="20 - 100">
        
        <label for="mutationRate">Mutationsrate:</label>
        <input required type="number" class="form-control" min="0.05" max="0.2" id="mutationRate" placeholder="0.05 - 0.2">

        <label for="cycles">Maximale Durchlaufzeit:</label>
        <p><input required type="number" class="form-control" min="1" max="5" id="cycles" placeholder="1 - 5 min."></p>


        <a href="<?php echo e(route('ausgabe')); ?>" class="btn btn-primary">ausführen</a>
    
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Prototyp3 (UUID)/resources/views/start/index.blade.php ENDPATH**/ ?>