<?php
require_once("header.php");
?>

<script src="tooltip/tooltip.js"></script>
<link href="tooltip/tooltip.css" rel="stylesheet" />
<script src="Scripts/canvasjs.min.js"></script>

<style>
    .baseMap {
        position: relative;
        background-color: white;
        text-align: center;
    }

    .positionMarker {
        position: absolute;
        display: inline-block;
    }

    .clear {
        clear: both;
    }

    .column {
        float: left;
        padding: 0 20px;
    }
</style>
<style>
    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        position: relative;
    }

    /* The Close Button */
    .btn-danger {
        position: absolute;
        float: left;
        z-index: 1;
    }

    /*.close:hover,
            .close:focus {
                color: #000;
                text-decoration: none;
                cursor: pointer;
            }*/
</style>

</head>
<?php require_once("header1.php");?>

<div class="clear"></div>
<div class="container">
    <!-- Content here -->
    <div class="baseMap" id="sht">
    </div>
    
    <!-- Model -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <button type="button" class="btn btn-danger btn-sm" id="closeButton">X</button>
            <div id="chartContainer" style="height: 600px; width: 100%;"></div>
        </div>

    </div>
    <!--Tooltip-->
    <div id="tooltipsht" style="display:none;">
    </div>

</div>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="C:\Users\FMG\Downloads\jQuery-rwdImageMaps-master\jquery.rwdImageMaps.min.js"></script>-->

<script>

        window.onload = function () {
            var text = '<img src="image\\Fontpage\\MoonsoonFlood.png" class="img-fluid mapBase" alt="Responsive image">';
            $.get("textFile/stationPositionMonsoon.txt", function (data) {
                var stationPositionLine = data.split('\n');
                for (var i = 0; i < stationPositionLine.length ; i++) {
                    var stationName = stationPositionLine[i].split(',');
                    //text += '<a href="#" id="' + stationName[0] + '"' + 'class="demo">' + '<img src="image\\Fontpage\\google-placeGreen.png" class="positionMarker img-fluid" value="' + stationName[0] + '" alt="Responsive image" style="left:' + stationName[1] + '%;top:' + stationName[2] + '%; width:3%;"></a>';
					if (stationName[3]>= .5){
						text += '<a href="#" onmouseover="tooltip.pop(this,' + "'#" + stationName[0] + "'" + ', {position:3, offsetY:-1, offsetX:20, effect:\'slide\'})">  <img src="image\\Fontpage\\google-placeGreen.png" class="positionMarker img-fluid" value="' + stationName[0] + '" alt="Responsive image" style="left:' + stationName[1] + '%;top:' + stationName[2] + '%; width:3%;"></a>';
					}
                    else if (stationName[3]<= .5 && stationName[3]>= 0){
						text += '<a href="#" onmouseover="tooltip.pop(this,' + "'#" + stationName[0] + "'" + ', {position:3, offsetY:-1, offsetX:20, effect:\'slide\'})">  <img src="image\\Fontpage\\google-placeYellow.png" class="positionMarker img-fluid" value="' + stationName[0] + '" alt="Responsive image" style="left:' + stationName[1] + '%;top:' + stationName[2] + '%; width:3%;"></a>';
					}
					else if (stationName[3]<= 0 && stationName[3]>= -1){
						text += '<a href="#" onmouseover="tooltip.pop(this,' + "'#" + stationName[0] + "'" + ', {position:3, offsetY:-1, offsetX:20, effect:\'slide\'})">  <img src="image\\Fontpage\\google-placeping.png" class="positionMarker img-fluid" value="' + stationName[0] + '" alt="Responsive image" style="left:' + stationName[1] + '%;top:' + stationName[2] + '%; width:3%;"></a>';
					}
					else if (stationName[3]< -1){
						text += '<a href="#" onmouseover="tooltip.pop(this,' + "'#" + stationName[0] + "'" + ', {position:3, offsetY:-1, offsetX:20, effect:\'slide\'})">  <img src="image\\Fontpage\\google-place.png" class="positionMarker img-fluid" value="' + stationName[0] + '" alt="Responsive image" style="left:' + stationName[1] + '%;top:' + stationName[2] + '%; width:3%;"></a>';
					}
                    //text += '<img src="image\\Fontpage\\google-place.png" class="positionMarker img-fluid" alt="Responsive image" style="left:' + stationName[1] + '%;top:' + stationName[2] + '%; width:3%;">';
                    //text += '<p>' + stationName[1] + '_' + stationName[2] + '</p>';
                }
                document.getElementById("sht").innerHTML = text;
            }
            );

            $.get("textFile/tooltip-BD.txt", function (data2) {

                document.getElementById("tooltipsht").innerHTML = data2;
            }
            );


        }


        //var i = 45;
        //var len = 46;
        //var text = '<img src="image\\Fontpage\\NERM_Flash.png" class="img-fluid mapBase" alt="Responsive image">';
        //for (; i < len;) {
        //    if (i%2==0) {
        //        text += '<img src="image\\Fontpage\\google-place.png" class="positionMarker img-fluid" alt="Responsive image" style="left:' + i + '%;top:' + i + '%; width:3%;">';
        //    }
        //    else if (i%3==0){
        //        text += '<img src="image\\Fontpage\\google-placeYellow.png" class="positionMarker img-fluid" alt="Responsive image" style="left:' + i + '%;top:' + i + '%; width:3%;">';
        //    }
        //    else if (i % 5 == 0) {
        //        text += '<img src="image\\Fontpage\\google-placeping.png" class="positionMarker img-fluid" alt="Responsive image" style="left:' + i + '%;top:' + i + '%; width:3%;">';
        //    }
        //    else {
        //        text += '<a href="#" onmouseover="tooltip.pop(this, \'#sub2\', {position:1, offsetX:-20, effect:\'slide\', sticky: true})">  <img src="image\\Fontpage\\google-placeGreen.png" class="positionMarker img-fluid" alt="Responsive image" style="left:' + i + '%;top:' + i + '%; width:3%;"></a>';
        //    }
        //    i++;
        //}
        //document.getElementById("sht").innerHTML = text;
</script>

<!-- Graph____Model -->



<script>
        // Get the modal

        $('#sht').delegate("a", "click", function () {
            var modal = document.getElementById('myModal');

            // Get the button that opens the modal
            $(".positionMarker").click(function () {
                var btn = ($(this).attr('value'));
                modal.style.display = "block";
                var dataPoints = [];
                var dataPointss = [];
                var dangerLevel = [];
                var HighestLevel = [];
                $.get("DataBaseBD/" + btn + ".csv", function (data) {
                    var allLines = data.split('\n');

                    if (allLines.length > 0) {
                        for (var i = 1; i <= allLines.length - 42; i++) {
                            var dataPoint = allLines[i].split(',');
                            dataPoints.push({ x: Date.parse(dataPoint[0]), y: parseFloat(dataPoint[1]) });
                        };
                        for (var i = allLines.length - 42; i < allLines.length; i++) {
                            var dataPoint = allLines[i].split(',');
                            dataPointss.push({ x: Date.parse(dataPoint[0]), y: parseFloat(dataPoint[1]) });
                        };
						for (var i = 0; i < 1; i++) {
                            var dataPoint = allLines[i].split(',');
                            var dataPointDanger = allLines[1].split(',');
                            dangerLevel.push({ x: Date.parse(dataPointDanger[0]), y: parseFloat(dataPoint[0]) });
                            HighestLevel.push({ x: Date.parse(dataPointDanger[0]), y: parseFloat(dataPoint[1]) });
                        };
                        for (var i = allLines.length - 2; i < allLines.length-1; i++) {
                            var dataPoint = allLines[i].split(',');
                            var dataPointHih = allLines[0].split(',');
                            dangerLevel.push({ x: Date.parse(dataPoint[0]), y: parseFloat(dataPointHih[0]) });
                            HighestLevel.push({ x: Date.parse(dataPoint[0]), y: parseFloat(dataPointHih[1]) });
                        };
                    }
					var ForecastDate = allLines[allLines.length - 42].split(',');
					var DateShow = ForecastDate[0].split('/');
					
					var m_names = new Array('SHT','Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
					var CuuMonth = DateShow[0];
					var GraphDate = DateShow[1] + "-" + m_names[CuuMonth] + "-" + DateShow[2].substr(0, 4)+ " 6:00 am";

                    var chart = new Highcharts.chart('chartContainer', {
                        chart: {
                            type: 'spline'
                        },
                        title: {
                            text: btn + ' Water Level (mPWD)'
                        },
                        subtitle: {
                            text: 'Forecast Date: ' + GraphDate
                        },
                        xAxis: {
                            type: 'datetime',
                            dateTimeLabelFormats: { // don't display the dummy year
                                month: '%e. %b',
                                year: '%b'
                            },
                            title: {
                                text: 'Date'
                            },

                        },
                        yAxis: {
                            title: {
                                text: 'Water Level (m PWD)'
                            },

                        },
                        tooltip: {
                            headerFormat: '<b>{series.name}</b><br>',
                            pointFormat: '{point.x:%e \%b \%Y %H:%M}: {point.y:.2f} m'
                        },

                        plotOptions: {
                            spline: {
                                marker: {
                                    enabled: true
                                }
                            }
                        },

                        series: [{
                            name: 'Hindecast',
                            color: 'blue',
                            data: dataPoints,
                        }, {
                            name: 'Forecast',
                            color: '#FF0000',
                            data: dataPointss,
                        }, {
                            name: 'Danger Level',
                            marker: {
                                enabled: false
                            },
                            data: dangerLevel,
                        },

                        {
                            name: 'Recorded Highest Water Level',
                            marker: {
                                enabled: false
                            },

                            data: HighestLevel,
                        }
                        ]
                    });
                    chart.render();
                });
            });
			

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("btn-danger")[0];

            // When the user clicks the button, open the modal


            // When the user clicks on <span> (x), close the modal
            span.onclick = function () {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
			
        });



</script>



<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<?php require_once("Footer.php");?>



    




















   