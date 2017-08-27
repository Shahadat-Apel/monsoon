<?php
include("header.php");
?>
<script LANGUAGE="JavaScript">
modImages = new Array();
    modImages[0] = "image/06102016-old/WRFDay_1.jpg";
    modImages[1] = "image/06102016-old/WRFDay_2.jpg";
    modImages[2] = "image/06102016-old/WRFDay_3.jpg";
    modImages[3] = "image/06102016-old/WRFDay_4.jpg";
    modImages[4] = "image/06102016-old/WRFDay_5.jpg";
    modImages[5] = "image/06102016-old/WRFDay_6.jpg";
first_image = 0;
last_image = 5;
theImages = new Array();      //holds the images
imageNum = new Array();       //keeps track of which images to omit from loop
normal_delay = 300;
delay = normal_delay;         //delay between frames in 1/100 seconds
delay_step = 150;
delay_max = 6000;
delay_min = 50;
dwell_multipler = 3;
dwell_step = 1;
end_dwell_multipler   = dwell_multipler;
start_dwell_multipler = dwell_multipler;
current_image = first_image;     //number of the current image
timeID = null;
status = 0;                      // 0-stopped, 1-playing
play_mode = 0;                   // 0-normal, 1-loop, 2-sweep
size_valid = 0;
if (first_image > last_image)
{
   var help = last_image;
   last_image = first_image;
   first_image = help;
}
//===> Preload the first image (while page is downloading)
   theImages[0] = new Image();
   theImages[0].src = modImages[0];
   imageNum[0] = true;
function stop()
{
   //== cancel animation (timeID holds the expression which calls the fwd or bkwd function) ==
   if (status == 1)
      clearTimeout (timeID);
   status = 0;
}
//===> Display animation in fwd direction in either loop or sweep mode
function animate_fwd()
{
   current_image++;                      //increment image number
   //== check if current image has exceeded loop bound ==
   if (current_image > last_image) {
      if (play_mode == 1) {              //fwd loop mode - skip to first image
         current_image = first_image;
      }
      if (play_mode == 2) {              //sweep mode - change directions (go bkwd)
         current_image = last_image;
         animate_rev();
         return;
      }
   }
   //== check to ensure that current image has not been deselected from the loop ==
   //== if it has, then find the next image that hasn't been ==
   while (imageNum[current_image-first_image] == false) {
         current_image++;
         if (current_image > last_image) {
            if (play_mode == 1)
               current_image = first_image;
            if (play_mode == 2) {
               current_image = last_image;
               animate_rev();
               return;
            }
         }
   }
   document.animation.src = theImages[current_image-first_image].src;   //display image onto screen
   document.control_form.frame_nr.value = current_image;                //display image number
   delay_time = delay;
   if ( current_image == first_image) delay_time = start_dwell_multipler*delay;
   if (current_image == last_image)   delay_time = end_dwell_multipler*delay;
   //== call "animate_fwd()" again after a set time (delay_time) has elapsed ==
   timeID = setTimeout("animate_fwd()", delay_time);
}
//===> Display animation in reverse direction
function animate_rev()
{
   current_image--;                      //decrement image number
   //== check if image number is before lower loop bound ==
   if (current_image < first_image) {
     if (play_mode == 1) {               //rev loop mode - skip to last image
        current_image = last_image;
     }
     if (play_mode == 2) {
        current_image = first_image;     //sweep mode - change directions (go fwd)
        animate_fwd();
        return;
     }
   }
   //== check to ensure that current image has not been deselected from the loop ==
   //== if it has, then find the next image that hasn't been ==
   while (imageNum[current_image-first_image] == false) {
         current_image--;
         if (current_image < first_image) {
            if (play_mode == 1)
               current_image = last_image;
            if (play_mode == 2) {
               current_image = first_image;
               animate_fwd();
               return;
            }
         }
   }
   document.animation.src = theImages[current_image-first_image].src;   //display image onto screen
   document.control_form.frame_nr.value = current_image;                //display image number
   delay_time = delay;
   if ( current_image == first_image) delay_time = start_dwell_multipler*delay;
   if (current_image == last_image)   delay_time = end_dwell_multipler*delay;
   //== call "animate_rev()" again after a set amount of time (delay_time) has elapsed ==
   timeID = setTimeout("animate_rev()", delay_time);
}
//===> Changes playing speed by adding to or substracting from the delay between frames
function change_speed(dv)
{
   delay+=dv;
   //== check to ensure max and min delay constraints have not been crossed ==
   if(delay > delay_max) delay = delay_max;
   if(delay < delay_min) delay = delay_min;
}
//===> functions that changed the dwell rates.
function change_end_dwell(dv) {
   end_dwell_multipler+=dv;
   if ( end_dwell_multipler < 1 ) end_dwell_multipler = 0;
   }
function change_start_dwell(dv) {
   start_dwell_multipler+=dv;
   if ( start_dwell_multipler < 1 ) start_dwell_multipler = 0;
   }
//===> Increment to next image
function incrementImage(number)
{
   stop();
   //== if image is last in loop, increment to first image ==
   if (number > last_image) number = first_image;
   //== check to ensure that image has not been deselected from loop ==
   while (imageNum[number-first_image] == false) {
         number++;
         if (number > last_image) number = first_image;
   }
   current_image = number;
   document.animation.src = theImages[current_image-first_image].src;   //display image
   document.control_form.frame_nr.value = current_image;                //display image number
}
//===> Decrement to next image
function decrementImage(number)
{
   stop();
   //== if image is first in loop, decrement to last image ==
   if (number < first_image) number = last_image;
   //== check to ensure that image has not been deselected from loop ==
   while (imageNum[number-first_image] == false) {
         number--;
         if (number < first_image) number = last_image;
   }
   current_image = number;
   document.animation.src = theImages[current_image-first_image].src;   //display image
   document.control_form.frame_nr.value = current_image;                //display image number
}
//===> "Play forward"
function fwd()
{
   stop();
   status = 1;
   play_mode = 1;
   animate_fwd();
}
//===> "Play reverse"
function rev()
{
   stop();
   status = 1;
   play_mode = 1;
   animate_rev();
}
//===> "play sweep"
function sweep() {
   stop();
   status = 1;
   play_mode = 2;
   animate_fwd();
   }
//===> Change play mode (normal, loop, swing)
function change_mode(mode)
{
   play_mode = mode;
}
//===> Load and initialize everything once page is downloaded (called from 'onLoad' in <BODY>)
function launch()
{
   for (var i = first_image + 1; i <= last_image; i++)
   {
      theImages[i-first_image] = new Image();
      theImages[i-first_image].src = modImages[i-first_image];
      imageNum[i-first_image] = true;
      document.animation.src = theImages[i-first_image].src;
      document.control_form.frame_nr.value = i;
   }
   // this needs to be done to set the right mode when the page is manually reloaded
   change_mode (1);
   fwd();
}
//===> Check selection status of image in animation loop
function checkImage(status,i)
{
   if (status == true)
      imageNum[i] = false;
   else imageNum[i] = true;
}
//==> Empty function - used to deal with image buttons rather than HTML buttons
function func()
{
}
//===> Sets up interface - this is the one function called from the HTML body
function animation()
{
  count = first_image;
}
// -->
//-->
    </script>


</head>
<?php include("header1.php");?>


<body bgcolor="#ffffff" onLoad="launch()">
<br/>
    <div class="row">
        <div class="container">
            <div class="col-sm-12">
                <h3>WRF Predicted Rainfall</h3>
                <br />
            </div>

            <div class="col-sm-5">
                <div class="btn-group" data-toggle="buttons">
                    <a data-toggle="tooltip" data-placement="top" title="Pause" style="font-size:25px;" class="btn btn-danger" role="button" href="JavaScript: func()" onClick="stop()"><i class="fa fa-pause-circle"></i></a>
                    <a data-toggle="tooltip" data-placement="top" title="Play"style="font-size:25px;" class="btn btn-primary" role="button" href="JavaScript: func()" onClick="change_mode(1);fwd()"><i style="font-size:25px;" class="fa fa-play-circle"></i></a>
                    <a data-toggle="tooltip" data-placement="top" title="Speed Down" style="font-size:25px;" class="btn btn-success" role="button" href="JavaScript: func()" onClick="change_speed(delay_step)"><i class="fa fa-chevron-circle-down"></i></a>
                    <a data-toggle="tooltip" data-placement="top" title="Speed Up" style="font-size:25px;" class="btn btn-success" role="button" href="JavaScript: func()" onClick="change_speed(-delay_step)"><i color yellowgreen" class="fa fa-chevron-circle-up"></i></a>
                    <a data-toggle="tooltip" data-placement="top" title="Previous" style="font-size:25px;" class="btn btn-info" role="button" href="JavaScript: func()" onClick="decrementImage(--current_image)"><i class="fa fa-arrow-circle-o-left"></i></a>
                    <a data-toggle="tooltip" data-placement="top" title="Next" style="font-size:25px;" class="btn btn-info" role="button" href="JavaScript: func()" onClick="incrementImage(++current_image)"><i class="fa fa-arrow-circle-o-right"></i></a>
                </div>
            </div>
            <div class="col-sm-2">
                <FORM METHOD="POST" NAME="control_form">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-secondary" type="button">Frame No:</button>
                        </span>
                        <input class="form-control" type="text" name="frame_nr" value=9 size="3" onFocus="this.select()" onChange="go2image(this.value)">
                    </div>

                </FORM>
            </div>
            <div class="col-sm-5">
                <div class="btn-group" >
                    <label data-toggle="tooltip" data-placement="top" title="Realtime Gauge Observed Rainfall" class="btn btn-secondary">
                        <a href="RealtimeRainfall.php">Observed Rainfall</a>
                    </label>
                    <label data-toggle="tooltip" data-placement="top" title="Realtime Satellite Estimated Rainfall" class="btn btn-secondary">
                        <a href="StellitePredictedRainfall.php">Satellite Estimated Rainfall</a>
                    </label>
                </div>
            </div>
            <p><IMG style="width:100%" name="animation" BORDER="0" src="image/06102016-old/WRFDay_1.jpg"></p>
        </div>
    </div>
    <script type="text/javascript">

        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

    </script>

    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-31343808-1']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>


    <?php include("Footer.php");?>

