<?php
include("header.php");
?>

</head>
<?php include("header1.php");?>


<body bgcolor="#ffffff" onLoad="launch()">
<br/>
    <div class="row">
        <div class="container">
            <div class="col-sm-12">
                <h3>Realtime Gauge Observed Rainfall</h3>
                
            </div>

            <div class="col-sm-4">
                
            </div>
            <div class="col-sm-3">
                
            </div>
            <div class="col-sm-5">
                <div class="btn-group" >
                    <label data-toggle="tooltip" data-placement="top" title="WRF Predicted Rainfall" class="btn btn-secondary">
                        <a href="ForecastRainfall(GBMBasin).php" >Forecasted Rainfall</a>
                    </label>
                    <label data-toggle="tooltip" data-placement="top" title="Realtime Satellite Estimated Rainfall" class="btn btn-secondary">
                        <a href="StellitePredictedRainfall.php" >Satellite Estimated Rainfall</a>
                    </label>
                </div>
            </div>
            <p><IMG style="width:100%" name="animation" BORDER="0" src="image/06102016-old\Ob_rainmap.jpg"></p>
        </div>
    </div>
    <script type="text/javascript">

        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

    </script>

   


    <?php include("Footer.php");?>

<?php

