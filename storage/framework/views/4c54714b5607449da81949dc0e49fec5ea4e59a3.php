<?php $__env->startSection("content"); ?>
<h1> Produktionspläne </h1>



<link rel="stylesheet" href="css/ausgabe.css">

<div class="w-100 p-3">
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
           
        <script type="text/javascript">
            google.charts.load("current", {packages:["timeline"]});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
            
                var container = document.getElementById('example3.1');
                var chart = new google.visualization.Timeline(container);
                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn({ type: 'string', id: 'Position' });
                dataTable.addColumn({ type: 'string', id: 'Name' });
                dataTable.addColumn({ type: 'date',  id: 'Start' });
                dataTable.addColumn({ type: 'date', id: 'End' });
            
                dataTable.addRows([
            
                [ 'Walze 1', '#2002' , new Date('December 17, 2020, 03:24:00'), new Date('December 17, 2020, 04:25:00') ],
                ['Walze 2', '#2001', new Date('December 17, 2020, 03:24:00'), new Date('December 17, 2020, 04:28:00')],
                ['Walze 3', '#2000', new Date('December 17, 2020, 03:24:00'), new Date('December 17, 2020, 04:46:00')],
            
                ['Drehen 1', '#2002', new Date('December 17, 2020, 04:25:00'), new Date('December 17, 2020, 05:40:00')],
                ['Drehen 1', '#2000', new Date('December 17, 2020, 05:40:00'), new Date('December 17, 2020, 06:40:00')],
                ['Drehen 2', '#2001', new Date('December 17, 2020, 04:28:00'), new Date('December 17, 2020, 05:58:00')],
            
                ['Pesse Kopf 1', '#2002', new Date('December 17, 2020, 03:24:00'), new Date('December 17, 2020, 04:46:00')],
                ['Presse Kopf 2', '#2001', new Date('December 17, 2020, 03:24:00'), new Date('December 17, 2020, 04:18:00')],
                ['Presse Kopf 2', '#2000', new Date('December 17, 2020, 04:18:00'), new Date('December 17, 2020, 05:08:00')],
            
                ['Presse Gewinde 1', '#2001', new Date('December 17, 2020, 04:18:00'), new Date('December 17, 2020, 05:38:00')],
                ['Presse Gewinde 2', '#2000', new Date('December 17, 2020, 05:08:00'), new Date('December 17, 2020, 05:28:00')],
                ['Presse Gewinde 2', '#2002', new Date('December 17, 2020, 05:28:00'), new Date('December 17, 2020, 6:16:00')],
            
                ['Schweißen 1', '#2001', new Date('December 17, 2020, 05:58:00'), new Date('December 17, 2020, 6:36:00')],
                ['Schweißen 1', '#2002', new Date('December 17, 2020, 06:36:00'), new Date('December 17, 2020, 7:09:00')],
                ['Schweißen 1', '#2000', new Date('December 17, 2020, 07:09:00'), new Date('December 17, 2020, 7:34:00')],
            
                ['Beschichten 1', '#2001', new Date('December 17, 2020, 06:36:00'), new Date('December 17, 2020, 7:34:00')],
                ['Beschichten 1', '#2000', new Date('December 17, 2020, 07:34:00'), new Date('December 17, 2020, 8:06:00')],
                ['Beschichten 2', '#2002', new Date('December 17, 2020, 07:09:00'), new Date('December 17, 2020, 8:06:00')],
            
                ['Lackieren 1', '#2001', new Date('December 17, 2020, 07:24:00'), new Date('December 17, 2020, 8:30:00')],
                ['Lackieren 1', '#2002', new Date('December 17, 2020, 08:30:00'), new Date('December 17, 2020, 9:00:00')],
                ['Lackieren 2', '#2000', new Date('December 17, 2020, 08:06:00'), new Date('December 17, 2020, 9:00:00')],
            
                ]);
            
                chart.draw(dataTable);
            
                var options = {
                    height: 800
                    }
            }
        </script>

    <script>
        <div id="example3.1" style="height: 630px;"></div>
    </script>


    <div class="d-flex align-items-center justify-content-between bd-highlight mb-3">
        <div class="p-2 bd-highlight"><a href="/start" class="btn btn-primary">zurück</a>  </div>
        <div class="p-2 bd-highlight">
            <div class="pagination">
                <a class="active" href="#">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/Prototyp3/resources/views/ausgabe/ausgabe.blade.php ENDPATH**/ ?>