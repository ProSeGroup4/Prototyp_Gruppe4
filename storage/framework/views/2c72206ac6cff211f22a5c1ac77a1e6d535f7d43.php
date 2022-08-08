<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Genetischer Algorithmus</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
        crossorigin="anonymous">


        <link rel="stylesheet" href="css/tabs.css">
    </head>
    <body>
        
        <ul class="tabs">
            <li class="tab">
                <a href="/start" class="active tab">Konfiguration</a>
            </li>
            <li class="tab">
                <a href="<?php echo e(route('eingabe')); ?>" class="tab">Auftragserstellung</a>
            </li>
            <li class="tab">
                <a href="<?php echo e(route('ausgabe')); ?>" class="tab">Produktionsplan</a>
            </li>
        </ul>

        <script src="js/safeAuftrag.js"></script>
        <script src="js/zurück.js"></script>
        <script src="js/storage.js"></script>
        <script src="js/addRow.js"></script>
        <script src="js/tabs.js"></script>
        <script src="js/tablesort.js"></script>
        <script src="js/selectAll.js"></script>
        <script src="js/showAuftrag.js"></script>

        
        <?php echo $__env->yieldContent("content"); ?>
    </body>
</html><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Prototyp3/resources/views/layouts/app.blade.php ENDPATH**/ ?>