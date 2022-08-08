<?php $__env->startSection("content"); ?>
    <h1> Auftragserstellung </h1>


  
    <form action="<?php echo e(route ('eingabe')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        
        

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
$message = $__bag->first($__errorArgs[0]); ?> <!-- Felder umbenennen -->
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
                <option selected>#10111</option>
                <option>#10222</option>
                <option>#11131</option>
                <option>#11242</option>
                <option>#20111</option>
                <option>#20222</option>
                <option>#21131</option>
                <option>#21242</option>
                <option>#30111</option>
                <option>#30222</option>
                <option>#31131</option>
                <option>#31242</option>
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
$message = $__bag->first($__errorArgs[0]); ?> <!-- Felder umbenennen -->
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
            <label for="InputTime">(((Deadline))):</label>
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
$message = $__bag->first($__errorArgs[0]); ?> <!-- Felder umbenennen -->
                <div class="text-danger">
                    <?php echo e($message = "Das ist ein Pflichtfeld"); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <p></p>
        </div>

        <button class="btn btn-primary" href="/start">hinzufügen</button>
        
    </form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Prototyp2/resources/views/eingabe/eingabe.blade.php ENDPATH**/ ?>