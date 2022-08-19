<?php
require("config.php");

$con = mysql_connect($server,$user,$pwd);
mysql_select_db($db);


if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

$sql = "SELECT * FROM METEO ORDER BY `TIMESTAMP_LOCAL` DESC LIMIT 1";

// $today = date("dmY");

$result = mysql_query($sql) ;
$row = mysql_fetch_array($result);

$wind_dir_code = $row[2];
$wind_dir = $row[3];
$wind_ave = $row[4];
$wind_gust = $row[5];
$temp_out = $row[6];
$pressure = $row[7];
$umidity = $row[8];
$rain = $row[9];
$rain_rate = $row[10];
$temp_in = $row[11];
$hum_in = $row[12];
$wind_chill = $row[13];
$temp_apparent = $row[14];
$dew_point = $row[15];
$uv = $row[16];
$illuminance = $row[17];
$winDayMin = $row[18];
$winDayMax = $row[19];
$winDayGustMin = $row[20];
$winDayGustMax = $row[21]     ;
$TempOutMin = $row[22];
$TempOutMax = $row[23];
$TempInMin = $row[24];
$TempInMax = $row[25];
$UmOutMin = $row[26];
$UmOutMax = $row[27];
$UmInMin = $row[28];
$UmInMax = $row[29];
$PressureMin = $row[30];
$PressureMax = $row[31];
$wind_dir_ave = $row[32];





// echo $wind_dir_code ; echo "<br>";
// echo $wind_dir ; echo "<br>";
// echo $wind_ave ; echo "<br>";
// echo $wind_gust ; echo "<br>";
// echo $temp_out ; echo "<br>";
// echo $pressure ; echo "<br>";
// echo $umidity ; echo "<br>";
// echo $rain ; echo "<br>";
// echo $rain_rate ; echo "<br>";
// echo $temp_in ; echo "<br>";
// echo $hum_in ; echo "<br>";
// echo $wind_chill ; echo "<br>";
// echo $temp_apparent ; echo "<br>";
// echo $dew_point ; echo "<br>";
// echo $uv ; echo "<br>";
// echo $illuminance ; echo "<br>";
// echo $winDayMin ; echo "<br>";
// echo $winDayMax ; echo "<br>";
// echo $winDayGustMin ; echo "<br>";
// echo $winDayGustMax      ; echo "<br>";
// echo $TempOutMin ; echo "<br>";
// echo $TempOutMax ; echo "<br>";
// echo $TempInMin ; echo "<br>";
// echo $TempInMax ; echo "<br>";
// echo $UmOutMin ; echo "<br>";
// echo $UmOutMax ; echo "<br>";
// echo $UmInMin ; echo "<br>";
// echo $UmInMax ; echo "<br>";
// echo $PressureMin ; echo "<br>";
// echo $PressureMax ; echo "<br>";



?>

<!DOCTYPE html>
<html manifest="demo.manifest"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Observatory Weather Station</title>
</head>
<body onload="init()" style="background-color:#dcdcdc">
    <table>
        <tbody>

        <tr valign="center">
             <td  width="100%">
				        <canvas id="canvasRadial1" width="210" height="210"></canvas>
                <canvas id="canvasRadial2" width="210" height="210"></canvas>
	              <canvas id="canvasRadial3" width="210" height="210"></canvas>
            </td>
        </tr>
        <tr valign="center">
            <td width="100%">
			          <canvas id="canvasRadial4" width="210" height="210"></canvas>
				        <canvas id="canvasLinear1" width="210" height="210"></canvas>
                <canvas id="canvasRadial5" width="210" height="210"></canvas>

            </td>
        </tr>

    </tbody></table>


<script>

  var scroll = false;
  var winDirGauge;
	var windIntensityGustGauge;
	var windGustIntensityGauge;
	var tempGauge;
	var pressureGauge;
	var umidityGauge;


    function init() {
        // Initialzing gauge

		var sections = [steelseries.Section(0, 20, 'rgba(0, 0, 220, 0.3)'),
						steelseries.Section(20, 40, 'rgba(0, 220, 0, 0.3)'),
						steelseries.Section(40, 50, 'rgba(220, 220, 0, 0.3)'),
						steelseries.Section(50, 100, 'rgba(255, 0, 0, 0.3)')],
			// Define one area
			areas = [steelseries.Section(75, 100, 'rgba(220, 0, 0, 0.3)')],
			// Define value gradient for bargraph
			valGrad = new steelseries.gradientWrapper(  0,
														100,
														[ 0, 0.33, 0.66, 0.85, 1],
														[ new steelseries.rgbaColor(0, 0, 200, 1),
														  new steelseries.rgbaColor(0, 200, 0, 1),
														  new steelseries.rgbaColor(200, 200, 0, 1),
														  new steelseries.rgbaColor(200, 0, 0, 1),
														  new steelseries.rgbaColor(200, 0, 0, 1) ]);

		var sectionsPressute = [steelseries.Section(0, 800, 'rgba(0, 0, 220, 0.3)'),
								steelseries.Section(800, 850, 'rgba(0, 220, 0, 0.3)'),
								steelseries.Section(850, 900, 'rgba(220, 220, 0, 0.3)'),
								steelseries.Section(900, 1200, 'rgba(255, 0, 0, 0.3)')],
            // Define one area
            areas = [steelseries.Section(75, 100, 'rgba(220, 0, 0, 0.3)')],
            // Define value gradient for bargraph
            valGrad = new steelseries.gradientWrapper(  0,
                                                        100,
                                                        [ 0, 0.33, 0.66, 0.85, 1],
                                                        [ new steelseries.rgbaColor(0, 0, 200, 1),
                                                          new steelseries.rgbaColor(0, 200, 0, 1),
                                                          new steelseries.rgbaColor(200, 200, 0, 1),
                                                          new steelseries.rgbaColor(200, 0, 0, 1),
                                                          new steelseries.rgbaColor(200, 0, 0, 1) ]);



        winDirGauge = new steelseries.WindDirection('canvasRadial1', {
                            size: 210,
                            lcdVisible: true,
                            roseVisible: true
                            });

        windIntensityGauge = new steelseries.Radial('canvasRadial2', {
                            gaugeType: steelseries.GaugeType.TYPE3,
                            size: 210,
                            section: sections,
							minValue: 0,
							maxValue: 70,
                            useSectionColors: true,
							thresholdVisible: false,
							minMeasuredValueVisible: true,
							maxMeasuredValueVisible: true,
                            titleString: 'Wind Average',
                            unitString: 'km/h',
                            lcdVisible: true
                        });

		 windIntensityGustGauge = new steelseries.Radial('canvasRadial3', {
						gaugeType: steelseries.GaugeType.TYPE3,
						size: 210,
						section: sections,
						minValue: 0,
						maxValue: 70,
						useSectionColors: true,
						thresholdVisible: false,
						minMeasuredValueVisible: true,
						maxMeasuredValueVisible: true,
						titleString: 'Wind Gust',
						unitString: 'km/h',
						lcdVisible: true
					});

		 umidityGauge = new steelseries.Radial('canvasRadial4', {
                            gaugeType: steelseries.GaugeType.TYPE3,
                            size: 210,
							minMeasuredValueVisible: true,
							maxMeasuredValueVisible: true,
							thresholdVisible: false,
                            titleString: 'Umidity',
                            unitString: '%',
                            lcdVisible: true
                        });




       pressureGauge = new steelseries.Radial('canvasRadial5', {
                            gaugeType: steelseries.GaugeType.TYPE3,
                            size: 210,
							minValue: 800,
							maxValue: 1200,
							minMeasuredValueVisible: true,
							maxMeasuredValueVisible: true,
							thresholdVisible: false,
                            titleString: 'Pressure',
                            unitString: 'hpa',
                            lcdVisible: true
                        });

		tempGauge = new steelseries.Radial('canvasLinear1', {
                            size: 210,
							minValue: -30,
							maxValue: 50,
              useSectionColors: true,
              thresholdVisible: false,
                            gaugeType: steelseries.GaugeType.TYPE3,
							minMeasuredValueVisible: true,
							maxMeasuredValueVisible: true,
							thresholdVisible: false,
                            titleString: "Temperature",
                            unitString: "C",
                            lcdVisible: true
                            });


		winDirGauge.setFrameDesign(steelseries.FrameDesign.SHINY_METAL);
		windIntensityGauge.setFrameDesign(steelseries.FrameDesign.SHINY_METAL);
		tempGauge.setFrameDesign(steelseries.FrameDesign.SHINY_METAL);
		pressureGauge.setFrameDesign(steelseries.FrameDesign.SHINY_METAL);
		umidityGauge.setFrameDesign(steelseries.FrameDesign.SHINY_METAL);
		windIntensityGustGauge.setFrameDesign(steelseries.FrameDesign.SHINY_METAL);

		winDirGauge.setBackgroundColor(steelseries.BackgroundColor.BRUSHED_STAINLESS);
		windIntensityGauge.setBackgroundColor(steelseries.BackgroundColor.BRUSHED_STAINLESS);
		tempGauge.setBackgroundColor(steelseries.BackgroundColor.BRUSHED_STAINLESS);
		pressureGauge.setBackgroundColor(steelseries.BackgroundColor.BRUSHED_STAINLESS);
		umidityGauge.setBackgroundColor(steelseries.BackgroundColor.BRUSHED_STAINLESS);
		windIntensityGustGauge.setBackgroundColor(steelseries.BackgroundColor.BRUSHED_STAINLESS);



		winDirGauge.setValueAnimatedLatest(<?php echo $wind_dir; ?>);
    winDirGauge.setValueAnimatedAverage(<?php echo $wind_dir_ave; ?>);
    winDirGauge.setPointerType(steelseries.PointerType.TYPE16);
    winDirGauge.setLcdColor(steelseries.LcdColor.STANDARD);

		windIntensityGauge.setValueAnimated(<?php echo $wind_ave; ?>);
  	windIntensityGauge.setMinMeasuredValue(<?php echo $winDayMin; ?>);
  	windIntensityGauge.setMaxMeasuredValue(<?php echo $winDayMax; ?>);
    windIntensityGauge.setPointerType(steelseries.PointerType.TYPE16);

		windIntensityGustGauge.setValueAnimated(<?php echo $wind_gust; ?>);
 		windIntensityGustGauge.setMinMeasuredValue(<?php echo $winDayGustMin; ?>);
  	windIntensityGustGauge.setMaxMeasuredValue(<?php echo $winDayGustMax; ?>);
    windIntensityGustGauge.setPointerType(steelseries.PointerType.TYPE16);

		tempGauge.setValueAnimated(<?php echo $temp_out; ?>);
		tempGauge.setMinMeasuredValue(<?php echo $TempOutMin; ?>);
  	tempGauge.setMaxMeasuredValue(<?php echo $TempOutMax; ?>);
    tempGauge.setPointerType(steelseries.PointerType.TYPE16);

		pressureGauge.setValueAnimated(<?php echo $pressure; ?>);
		pressureGauge.setMinMeasuredValue(<?php echo $PressureMin; ?>);
  	pressureGauge.setMaxMeasuredValue(<?php echo $PressureMax; ?>);
    pressureGauge.setPointerType(steelseries.PointerType.TYPE16);

		umidityGauge.setValueAnimated(<?php echo $umidity; ?>);
		umidityGauge.setMinMeasuredValue(<?php echo $UmOutMin; ?>);
  	umidityGauge.setMaxMeasuredValue(<?php echo $UmOutMax; ?>);
    umidityGauge.setPointerType(steelseries.PointerType.TYPE16);

	}


</script>

<script src="js/tween-min.js"></script>
<script src="js/steelseries-min.js"></script>
</body></html>
