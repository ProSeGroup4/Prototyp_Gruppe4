<?php $__env->startSection("content"); ?>
    <?php
        use App\Http\Controllers\Artikel;
        use App\Http\Controllers\Population;
    ?>


    <div class="container">
        <div id="Start" data-tab-content class="active">
        <h1> Konfiguration </h1>

        <div class="d-flex align-items-center justify-content-between ">
            <div class="p-2 bd-highlight">
                <input type="checkbox" onClick="toggle(this)"> Alle Aufträge Auswählen</input>
            </div>
            
            
            <div class="p-2 justify-content-end">
                Schnittstellenimport:
                <button>importieren</button>                   <!--Nicht funktionaler Button fuer Schnittstellenimport (Ausblick)-->
            </div>
        </div>
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Auftragsgeber...">
        <p></p>
        <div class="table-responsive" style="height: 145px;">  <!--Table um Aufträge anzuzeigen-->

            <!-- Integration der Datenbank in HTML Tabelle -->
            <?php 
                $aufträge = DB::table('aufträge')->get(); 
            ?>

            <table class="table table-sortable" id="myTable">
                <thead> <!-- Tabellen kopfzeile -->
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
                <tbody> <!-- Tabellenkörper mit Inhalt -->
                    <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <!-- Daten abrufen von Datenbank -->
                    <tr>
                        <td><input type="checkbox" onclick="auswahl()" id=<?php echo e($auftrag->InputOrderID); ?> name="foo"></td> 
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

          <!--Abfragen welche Inputs aus Aufträge "markiert" sind-->
        <div class="d-flex p-2 border border-grey border-1">                            
            <b>Ausgewählte Aufträge:</b>
            <b id="ausgewählteAufträge" name="ausgewählteAufträge"></b>
        </div>
        <p></p>


        <form action="<?php echo e(route('start')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <!-- "cross-site request forgery" generiert einen geheimen Token innerhalb der HTTP-Request,
            um Hacker zu hindern, den Web Service zu manipulieren.-->    


                    
            <div class="container">                 <!--Radio buttons für Genetischen Algorithmus - wonach optimiert wird-->
                    <b>Optimieren nach:</b>
                    <div class="Auswahlliste" role="group">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" value= "3" checked>
                        <label class="form-check-label" for="flexRadioDefault3">
                            Kosten
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value= "1">
                        <label class="form-check-label" for="flexRadioDefault2">
                            Termintreue
                        </label>
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value= "2">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Durchlaufzeit
                        </label>
                        
                        </label>
                    </div>
                </div>
                <p></p>

                <!--Dropdown Menue zur Auswahl eines oder mehreren Maschinendefekts. data-live search fuer Suchfunktion.-->
                <label for="InputMachine"><b>Auswählen bei Maschinendefekt:</b></label>
                <select class="form-control selectpicker" name="InputMachine" multiple data-live-search="true" value="<?php echo e(old("InputMachine")); ?>">
                    <option>M1.1</option>
                    <option>M1.2</option>
                    <option>M1.3</option>
                    <option>M2.1</option>
                    <option>M2.2</option>
                    <option>M3.1</option>
                    <option>M3.2</option>
                    <option>M3.3</option>
                    <option>M3.4</option>
                    <option>M4.1</option>
                    <option>M4.2</option>
                    <option>M5.1</option>
                    <option>M5.2</option>
                    <option>M5.3</option>
                    <option>M6.1</option>
                    <option>M6.2</option>
                <p></select></p>


                <p></p>
                <b>Genetischen Algorithmus konfigurieren:</b>
                <br>

                <label for="Population">Populationsgröße:</label>
                <input required type="number" class="form-control <?php $__errorArgs = ["Population"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" min="100" id="Population" placeholder="100" name="Population" step="10">
            
                <?php $__errorArgs = ["Population"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger">
                        <?php echo e($message="Populationsgröße muss innerhalb von 20 - 100 sein!"); ?>

                    </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <p></p>

                <label for="cycles">Maximale Durchlaufzeit:</label>
                <p><input required type="number" class="form-control <?php $__errorArgs = ["cycles"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" max="5" id="cycles" placeholder="5 Min." name="cycles"></p> <!--Added the names for referencing in Start.php -->

                <?php $__errorArgs = ["cycles"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger">
                        <?php echo e($message="Die max. Durchlaufzeit darf maximal 5 Min. sein!"); ?>

                    </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <p></p>
            
                 <!-- Button für die Datenschnittstelle zwischen Front- und Backend, POST findet im Controller Start.php statt.-->                                                                                                                                                                                                                                 
                <a type="submit" class="btn btn-primary" href="./ausgabe" method="POST">ausführen</a>
                                                                                                
            </div>
        </form>
    <script>
       document.querySelectorAll(".table-sortable th").forEach(headerCell => { // ausführen der Sortierfunktion
            headerCell.addEventListener("click", () => { // Kopfzeile Clickable
                // Konstanten übergeben
                const tableElement = headerCell.parentElement.parentElement.parentElement;
                const headerIndex = Array.prototype.indexOf.call(headerCell.parentElement.children, headerCell);
                const currentIsAscending = headerCell.classList.contains("th-sort-asc");

                sortTableByColumn(tableElement, headerIndex, !currentIsAscending);
            });
        });
    </script>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/phpvhosts/mob224/htdocs/resources/views/start/index.blade.php ENDPATH**/ ?>