<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Genetischer Algorithmus</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Neueste Bootstrap-Version: -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
        crossorigin="anonymous">
        <!--Folgender Link und das script in Zeile 14 & 15 sind für den Selectpicker multiple dropdown fuer Maschinenauswahl im Falle eines Defekts.-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <!-- Importieren aller Stylesheets -->
        <link rel="stylesheet" href="css/ausgabe.css">
        <link rel="stylesheet" href="css/tabs.css">
        <link rel="stylesheet" href="css/stylesheet.css">
    </head>
    <body>
        
        <!-- Navigationsleiste -->
        <div class="header">
            <img src="<?php echo e(asset('image/logo-gut.png')); ?>" alt="description of myimage" width="55" height="50">
            <div class="header-right"> 
                <a href="/public">Konfiguration</a>
                <a href="./eingabe">Auftragserstellung</a>
                <a href="./ausgabe">Produktionsplan</a>
            </div>
        </div>

        <!-- Importieren aller Java-Skripte -->
        <script src="js/sort.js"></script>
        <script src="js/search.js"></script>
        <script src="js/selectAll.js"></script>
        <script src="js/showAuftrag.js"></script>

        <!-- Zeig hier den Content an -->
        <?php echo $__env->yieldContent("content"); ?>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
            <!--Beide Skripte hier sind für den Selectpicker multiple dropdown bei der Maschinenauswahl im Falle eines oder mehreren Defekts.-->
    </body>
</html><?php /**PATH /var/www/phpvhosts/mob224/htdocs/resources/views/layouts/app.blade.php ENDPATH**/ ?>