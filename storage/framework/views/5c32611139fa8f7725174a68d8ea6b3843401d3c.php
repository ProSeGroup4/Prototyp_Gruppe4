<?php use \App\Http\Controllers\dragController;?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>dragable Gantt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  </head>
  <body>

  <div class="containerGantt">
      <div class="chart"> 
       <div class="chart-row chart-period" style = "grid-template-columns: 125px repeat(<?php echo e(dragController::setGrid($aufträge)); ?>, 1fr)"> <!-- setzt die Anzhal an Spalten -->
          <div class="chart-row-item"></div>
          <?php for($i=30;$i <= dragController::setGrid($aufträge);$i += 30): ?>
          <span style= "grid-column: <?php echo e(dragController::setValue($i)); ?>;"><?php echo e(dragController::setTimes($aufträge,$i)); ?></span> <!-- setzt die Zeiteinheiten in die Kopfzeile -->
          <?php endfor; ?>
        </div>
      <div class="chart-row">
        <div class="chart-row-item">M1.1 Walze</div>
        <ul class="chart-row-bars" style="grid-template-columns: repeat(<?php echo e(dragController::setGrid($aufträge)); ?>, 1fr);"> <!-- setzt den Auftrag auf die richtige Position -->
          <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($auftrag["Maschine"] == "M1.1"): ?>
                <li title=<?php echo e(dragController::showTimes($auftrag["Start"],$auftrag["Ende"])); ?> style="background-color: <?php echo e(dragController::setColor($auftrag, $farben)); ?>; grid-column: <?php echo e(dragController::calcTimeSlot($aufträge,$auftrag)); ?>" class="chart-li-one"><?php echo e($auftrag["Auftrag"]); ?></li> <!-- gibt information über den Auftrag -->
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="chart-row" >
        <div class="chart-row-item" >M1.2 Walze</div>
        <ul class="chart-row-bars" style="grid-template-columns: repeat(<?php echo e(dragController::setGrid($aufträge)); ?>, 1fr);">
          <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($auftrag["Maschine"] == "M1.2"): ?>
                <li title=<?php echo e(dragController::showTimes($auftrag["Start"],$auftrag["Ende"])); ?> style="background-color: <?php echo e(dragController::setColor($auftrag, $farben)); ?>; grid-column: <?php echo e(dragController::calcTimeSlot($aufträge,$auftrag)); ?>" class="chart-li-one"><?php echo e($auftrag["Auftrag"]); ?></li>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>          
        </ul>
      </div>
      <div class="chart-row">
        <div class="chart-row-item">M1.3 Walze</div>
        <ul class="chart-row-bars" style="grid-template-columns: repeat(<?php echo e(dragController::setGrid($aufträge)); ?>, 1fr);">
          <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($auftrag["Maschine"] == "M1.3"): ?>
                <li title=<?php echo e(dragController::showTimes($auftrag["Start"],$auftrag["Ende"])); ?> style="background-color: <?php echo e(dragController::setColor($auftrag, $farben)); ?>; grid-column: <?php echo e(dragController::calcTimeSlot($aufträge,$auftrag)); ?>" class="chart-li-one"><?php echo e($auftrag["Auftrag"]); ?></li>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="chart-row">
        <div class="chart-row-item">M2.1 Drehen</div>
        <ul class="chart-row-bars" style="grid-template-columns: repeat(<?php echo e(dragController::setGrid($aufträge)); ?>, 1fr);">
          <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($auftrag["Maschine"] == "M2.1"): ?>
                <li title=<?php echo e(dragController::showTimes($auftrag["Start"],$auftrag["Ende"])); ?> style="background-color: <?php echo e(dragController::setColor($auftrag, $farben)); ?>; grid-column: <?php echo e(dragController::calcTimeSlot($aufträge,$auftrag)); ?>" class="chart-li-one"><?php echo e($auftrag["Auftrag"]); ?></li>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="chart-row">
        <div class="chart-row-item">M2.2 Drehen</div>
        <ul class="chart-row-bars" style="grid-template-columns: repeat(<?php echo e(dragController::setGrid($aufträge)); ?>, 1fr);">
          <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($auftrag["Maschine"] == "M2.2"): ?>
                <li title=<?php echo e(dragController::showTimes($auftrag["Start"],$auftrag["Ende"])); ?> style="background-color: <?php echo e(dragController::setColor($auftrag, $farben)); ?>; grid-column: <?php echo e(dragController::calcTimeSlot($aufträge,$auftrag)); ?>" class="chart-li-one"><?php echo e($auftrag["Auftrag"]); ?></li>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="chart-row">
        <div class="chart-row-item">M3.1 Presse</div>
        <ul class="chart-row-bars" style="grid-template-columns: repeat(<?php echo e(dragController::setGrid($aufträge)); ?>, 1fr);">
          <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($auftrag["Maschine"] == "M3.1"): ?>
                <li title=<?php echo e(dragController::showTimes($auftrag["Start"],$auftrag["Ende"])); ?> style="background-color: <?php echo e(dragController::setColor($auftrag, $farben)); ?>; grid-column: <?php echo e(dragController::calcTimeSlot($aufträge,$auftrag)); ?>" class="chart-li-one"><?php echo e($auftrag["Auftrag"]); ?></li>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="chart-row">
        <div class="chart-row-item">M3.2 Presse</div>
        <ul class="chart-row-bars" style="grid-template-columns: repeat(<?php echo e(dragController::setGrid($aufträge)); ?>, 1fr);">
          <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($auftrag["Maschine"] == "M3.2"): ?>
                <li title=<?php echo e(dragController::showTimes($auftrag["Start"],$auftrag["Ende"])); ?> style="background-color: <?php echo e(dragController::setColor($auftrag, $farben)); ?>; grid-column: <?php echo e(dragController::calcTimeSlot($aufträge,$auftrag)); ?>" class="chart-li-one"><?php echo e($auftrag["Auftrag"]); ?></li>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="chart-row">
        <div class="chart-row-item">M4.1 Presse</div>
        <ul class="chart-row-bars" style="grid-template-columns: repeat(<?php echo e(dragController::setGrid($aufträge)); ?>, 1fr);">
          <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($auftrag["Maschine"] == "M4.1"): ?>
                <li title=<?php echo e(dragController::showTimes($auftrag["Start"],$auftrag["Ende"])); ?> style="background-color: <?php echo e(dragController::setColor($auftrag, $farben)); ?>; grid-column: <?php echo e(dragController::calcTimeSlot($aufträge,$auftrag)); ?>" class="chart-li-one"><?php echo e($auftrag["Auftrag"]); ?></li>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="chart-row">
        <div class="chart-row-item">M4.2 Presse</div>
        <ul class="chart-row-bars" style="grid-template-columns: repeat(<?php echo e(dragController::setGrid($aufträge)); ?>, 1fr);">
          <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($auftrag["Maschine"] == "M4.2"): ?>
                <li title=<?php echo e(dragController::showTimes($auftrag["Start"],$auftrag["Ende"])); ?> style="background-color: <?php echo e(dragController::setColor($auftrag, $farben)); ?>;grid-column: <?php echo e(dragController::calcTimeSlot($aufträge,$auftrag)); ?>" class="chart-li-one"><?php echo e($auftrag["Auftrag"]); ?></li>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="chart-row">
        <div class="chart-row-item">M5.1 Schweißen</div>
        <ul class="chart-row-bars" style="grid-template-columns: repeat(<?php echo e(dragController::setGrid($aufträge)); ?>, 1fr);">
          <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($auftrag["Maschine"] == "M5.1"): ?>
                <li title=<?php echo e(dragController::showTimes($auftrag["Start"],$auftrag["Ende"])); ?> style="background-color: <?php echo e(dragController::setColor($auftrag, $farben)); ?>;grid-column: <?php echo e(dragController::calcTimeSlot($aufträge,$auftrag )); ?>" class="chart-li-one"><?php echo e($auftrag["Auftrag"]); ?></li>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="chart-row">
        <div class="chart-row-item">M5.2 Schweißen</div>
        <ul class="chart-row-bars" style="grid-template-columns: repeat(<?php echo e(dragController::setGrid($aufträge)); ?>, 1fr);">
          <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($auftrag["Maschine"] == "M5.2"): ?>
                <li title=<?php echo e(dragController::showTimes($auftrag["Start"],$auftrag["Ende"])); ?> style="background-color: <?php echo e(dragController::setColor($auftrag, $farben)); ?>;grid-column: <?php echo e(dragController::calcTimeSlot($aufträge,$auftrag )); ?>" class="chart-li-one"><?php echo e($auftrag["Auftrag"]); ?></li>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="chart-row">
        <div class="chart-row-item">M6.1 Beschich.</div>
        <ul class="chart-row-bars" style="grid-template-columns: repeat(<?php echo e(dragController::setGrid($aufträge)); ?>, 1fr);">
          <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($auftrag["Maschine"] == "M6.1"): ?>
                <li title=<?php echo e(dragController::showTimes($auftrag["Start"],$auftrag["Ende"])); ?> style="background-color: <?php echo e(dragController::setColor($auftrag, $farben)); ?>;grid-column: <?php echo e(dragController::calcTimeSlot($aufträge,$auftrag )); ?>" class="chart-li-one"><?php echo e($auftrag["Auftrag"]); ?></li>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="chart-row">
        <div class="chart-row-item">M6.2 Beschich.</div>
        <ul class="chart-row-bars" style="grid-template-columns: repeat(<?php echo e(dragController::setGrid($aufträge)); ?>, 1fr);">
          <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($auftrag["Maschine"] == "M6.2"): ?>
                <li title=<?php echo e(dragController::showTimes($auftrag["Start"],$auftrag["Ende"])); ?> style="background-color: <?php echo e(dragController::setColor($auftrag, $farben)); ?>;grid-column: <?php echo e(dragController::calcTimeSlot($aufträge,$auftrag )); ?>" class="chart-li-one"><?php echo e($auftrag["Auftrag"]); ?></li>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="chart-row">
        <div class="chart-row-item">M7.1 Lackieren</div>
        <ul class="chart-row-bars" style="grid-template-columns: repeat(<?php echo e(dragController::setGrid($aufträge)); ?>, 1fr);">
          <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($auftrag["Maschine"] == "M7.1"): ?>
                <li title=<?php echo e(dragController::showTimes($auftrag["Start"],$auftrag["Ende"])); ?> style="background-color: <?php echo e(dragController::setColor($auftrag, $farben)); ?>;grid-column: <?php echo e(dragController::calcTimeSlot($aufträge,$auftrag )); ?>" class="chart-li-one"><?php echo e($auftrag["Auftrag"]); ?></li>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="chart-row">
        <div class="chart-row-item">M7.2 Lackieren</div>
        <ul class="chart-row-bars" style="grid-template-columns: repeat(<?php echo e(dragController::setGrid($aufträge)); ?>, 1fr);">
          <?php $__currentLoopData = $aufträge; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auftrag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($auftrag["Maschine"] == "M7.2"): ?>
                <li title=<?php echo e(dragController::showTimes($auftrag["Start"],$auftrag["Ende"])); ?> style="background-color: <?php echo e(dragController::setColor($auftrag, $farben)); ?>;grid-column: <?php echo e(dragController::calcTimeSlot($aufträge,$auftrag )); ?>" class="chart-li-one"><?php echo e($auftrag["Auftrag"]); ?></li>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    </div>
   </div>
   
  <button class="open-button" onclick="openForm()">Werte ändern</button> <!-- Formular zum manipulieren der Aufträge -->
  <div class="form-popup" id="myForm">
  <form action="<?php echo e(route('post')); ?>" class="form-container">
<?php echo csrf_field(); ?>
    
      <label for="email"><b>Startzeit verschieben</b></label>
      <div class="row">
        <div class="col"><input type="text" id="hour" name="hour" placeholder="Stunden" value=""></div>
        <div class="col"><input type="text" id="min" name="min" placeholder="Minuten" value=""></div>
      
    <b>Vorschieben oder Zurückschieben</b>
    <div = "container">
        <select id="richtung" name="richtung">
           <option value="vor">Vor</option>
           <option value="zurück">Zurück</option>
        </select>
    </div>
    <br>
    <b>Maschine wählen</b>
    <div = "container">
        <select id="maschine" name="maschine">
            <option value="M1.1">M1.1</option>
            <option value="M1.2">M1.2</option>
            <option value="M1.3">M1.3</option>
            <option value="M2.1">M2.1</option>
            <option value="M2.2">M2.2</option>
            <option value="M3.1">M3.1</option>
            <option value="M3.2">M3.2</option>
            <option value="M4.1">M4.1</option>
            <option value="M4.2">M4.2</option>
            <option value="M5.1">M5.1</option>
            <option value="M5.2">M5.2</option>
            <option value="M6.1">M6.1</option>
            <option value="M6.2">M6.2</option>
            <option value="M7.1">M7.1</option>
            <option value="M7.2">M7.2</option>
        </select>
    </div>
    <br>
    <b>Auftrag wählen</b>
    <input type="text" id="auftrag" name="auftrag" placeholder ="Auftragsnummer" value=""><br>

    <b>Maschine wechseln</b>
    <div class="container">
        <input type="radio" id="ja" name="wechsel" value="ja">
        <label for="html">Ja</label>
        <input type="radio" id="nein" name="wechsel" value="nein" checked="checked">
        <label for="css">Nein</label>
        <input type="text" id="maschineNeu" name="maschineNeu" placeholder="Maschinenname" value=""><br>
    </div>
    <button type="submit" class="btn">Bestätigen</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Abbrechen</button> <!-- Formular schließen -->
  </form>
</div>
</div>

  </body>

  <style>
#div1 {
    width: 350px;
    height: 70px;
    padding: 10px;
    border: 1px solid #aaaaaa;
}

table.fixed {
    table-layout: fixed;
}

table, th, td {
    border: 1px solid black;
}

table {
    width: 100%;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.containerGantt {
    max-width: 100%;
    min-width: 100%;
    margin: 0 auto;
    padding: 5px;
}

.chart {
    display: grid;
    border: 2px solid #000;
    position: relative;
    overflow: hidden;
}

.chart-row {
    display: grid;
    grid-template-columns: 125px 1fr;
    background-color: #DCDCDC;
}

    .chart-row:nth-child(odd) {
        background-color: #C0C0C0;
    }

.chart-period {
    color: #fff;
    background-color: #708090 !important;
    border-bottom: 2px solid #000;
}

.chart-lines {
    position: absolute;
    height: 100%;
    width: 100%;
    background-color: transparent;
}

.chart-period > span {
    text-align: center;
    font-size: 13px;
    align-self: center;
    font-weight: bold;
    padding: 15px 0;
}

.chart-lines > span {
    display: block;
    border-right: 0px solid rgba(0, 0, 0, 0.3);
}

.vl {
  border-left: 6px solid green;
  height: 500px;
}

.chart-row-item {
    background-color: #808080;
    border: 1px solid #000;
    border-top: 1px;
    border-left: 1px;
    padding: 20px 0;
    font-size: 15px;
    font-weight: bold;
    text-align: center;
}

.chart-row-bars {
    cursor: pointer;
    list-style: none;
    display: grid;
    padding: 15px 0;
    margin: 0;
    grid-gap: 10px 0;
    border-bottom: 1px solid #000;
}

li {
    font-weight: 450;
    text-align: center;
    font-weight: 700;
    font-size: 15px;
    min-height: 15px;
    padding: 5px 15px;
    color: white;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    border-radius: 15px;
}

.open-button {
    background-color: #555;
    color: white;
    padding: 16px 20px;
    border: none;
    cursor: pointer;
    opacity: 0.8;
    position: fixed;
    bottom: 23px;
    right: 28px;
    width: 280px;
}

/* The popup form - hidden by default */
.form-popup {
    display: none;
    position: fixed;
    bottom: 0;
    right: 15px;
    z-index: 9;
    
}

/* Add styles to the form container */
.form-container {
    margin: auto;
    width: 100%;
    padding: 15px;
    background-color: white;
}

    /* Full-width input fields */
    .form-container input[type=text], .form-container input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 10px 0 25px 0;
        border: none;
        background: #f1f1f1;
    }

        /* When the inputs get focus, do something */
        .form-container input[type=text]:focus, .form-container input[type=password]:focus {
            background-color: #ddd;
            outline: none;
        }

    /* Set a style for the submit/login button */
    .form-container .btn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        border: none;
        cursor: pointer;
        width: 100%;
        margin-bottom: 10px;
        opacity: 0.8;
    }

    /* Add a red background color to the cancel button */
    .form-container .cancel {
        background-color: red;
    }

    /* Add some hover effects to buttons */
    .form-container .btn:hover, .open-button:hover {
        opacity: 1;
    }
  </style>
</html>
<script src="<?php echo e(url('js/script.js')); ?>"></script>
<?php /**PATH /var/www/phpvhosts/mob224/htdocs/resources/views/diagramm.blade.php ENDPATH**/ ?>