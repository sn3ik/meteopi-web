<?php
require("weather.php");
require("graph_mini.php");
//require("metno/METno.php");
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $name_station; ?></title>
<link rel="icon" type="image/png" href="icone/meteopi_web.png" />
<script type="text/javascript" src="astrojs/astrojs.js"></script>
<script src="js/tween-min.js"></script>
<script src="js/steelseries-min.js"></script>
<script src="js/main.js"></script>
<script src="js/gauge.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://raw.githubusercontent.com/Mikhus/canvas-gauges/master/gauge.min.js"></script>

<script type="text/javascript" src="js/jquery-gauge.min.js"></script>
<script src='https://unpkg.com/dailychart/dist/dailychart.min.js'></script>


<script>
const popupCenter = ({url, title, w, h}) => {
    // Fixes dual-screen position                             Most browsers      Firefox
    const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
    const dualScreenTop = window.screenTop !==  undefined   ? window.screenTop  : window.screenY;

    const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    const systemZoom = width / window.screen.availWidth;
    const left = (width - w) / 2 / systemZoom + dualScreenLeft
    const top = (height - h) / 2 / systemZoom + dualScreenTop
    const newWindow = window.open(url, title,
      `
      toolbar=no,scrollbars=no,location=no,resizable =yes,menubar=no,
      width=${w / systemZoom},
      height=${h / systemZoom},
      top=${top},
      left=${left}
      `
    )

    if (window.focus) newWindow.focus();
}
</script>


<meta property="og:title" content="Observatory Weather Station"/>
<meta property="og:description" content="Temp: <?php echo $temp_out;?>°C - Hum: <?php echo $umidity;?>% - Press: <?php echo $pressure; ?> hPa - <?php echo $wind_nome ." ". $wind_ave; ?> km/h"  />
<meta property="og:url" content="http://francescocangiani.com/meteo/"/>
<meta property="og:image" content="https://www.meteo60.fr/satellites/animation-satellite-ir-france.gif"/>

<link rel="stylesheet" href="css/meteopi.css">

</head>
<body onload="start()" >

  <nav class="navbar">
      <span class="open-side">
          <a href="#" onclick="openSideMenu()">
              <svg width="30" height="30">
                  <path d="M0,5 30,5" stroke="#fff" stroke-width="3"/>
                  <path d="M0,14 30,14" stroke="#fff" stroke-width="3"/>
                  <path d="M0,23 30,23" stroke="#fff" stroke-width="3"/>
              </svg>
          </a>
      </span>

      <?php
        date_default_timezone_set('Europe/Rome');

        $date1=date_create(date("H:i:s"));
        $date2=date_create(date('H:i:s',strtotime($last_measure_time)));
        $diff=date_diff($date2,$date1);
        $hours   = $diff->format('%h');
        $minutes = $diff->format('%i');
        $seconds = $diff->format('%s');

        ?> <span class="light_blu"> <?php echo $city.': '; ?> </span>
        <?php setlocale(LC_TIME, 'ita', 'it_IT');
        echo utf8_encode (strftime("%A, %d %B %Y"));

        ?> <span class="light_orange"> <?php echo '<br>'.'Ultimo aggiornamento: ';?> </span>
        <?php echo date('H:i:s',strtotime($last_measure_time)) ?> -
        <?php
        //echo date_format($date1,"h:i:s");
        //echo date_format($date2,"h:i:s");

        echo ($hours*60)+$minutes.' minuti '.$seconds.' secondi fa';
      ?></span>
  </nav>

      <div id="side-menu" class="side-nav">
          <a href="#" class="btn-close" onclick="closeSideMenu()">&times;</a>
          <a href="#">Home</a>
          <a href="#" onclick="popupCenter({url: 'graphics.php', title: 'xtf', w: 700, h: 500}); closeSideMenu();">Andamento Oggi</a>
          <a href="#" onclick="popupCenter({url: 'graphics.php?ORE=3', title: 'xtf', w: 700, h: 500}); closeSideMenu();">Andamento Ore</a>
          <a href="#" onclick="popupCenter({url: 'minmax.php', title: 'xtf', w: 300, h: 500}); closeSideMenu();">Min & Max</a>

      </div>

<div class="header">
  <script type="text/javascript">
  function start(){
      display_ct();
      init();
  }

  function display_ct(){
  }

  </script>
</div>

<div style="overflow:auto">

<!-- ************************
*
*         Temperatura
*
************************** -->
  <div class="l1">
    <span class="h1">Temperatura</span>
    <table width="100%" border="0">
      <tr>
        <td width="2%">
        </td>
        <td valign="top"><br>
          <font size="5"><?php echo $temp_out; ?> °C</font><br>
          <br>Percepita: <?php echo round($temp_apparent, 1); ?>°C
          <br>Punto di Rugiada: <?php echo round($dew_point, 1); ?>°C
          <br>System Temp.: <?php echo round($temp_in); ?>°C
         </td>
         <td align="center">
           <canvas data-type="linear-gauge"
                   data-width="100%"
                   data-height="160dp"
                   data-border-radius="0"
                   data-borders="false"
                   data-bar-stroke-width="5"
                   data-minor-ticks="10"
                   data-major-ticks="-10,0,10,20,30,40,50"
                   data-color-numbers="#0000FF,#6495ED,#87CEFA,#DAA520,#D2691E,#FF0000,#800000"
                   data-color-major-ticks="red,red,transparent,transparent,transparent,transparent,transparent"
                   data-color-bar-stroke="#444"
                   data-value=<?php echo ($temp_out*2)+10; ?>
                   data-units=""
                   data-color-value-box-shadow="false"
                   data-tick-side="left"
                   data-number-side="left"
                   data-needle-side="right"
                   data-animate-on-init="false"
                   data-color-plate="transparent"
                   data-font-value-size=""
           ></canvas>
         </td>
     </tr>
    </table>
   <span class="h2">
   <image src='image/down.png' width=10><span class="min"> <?php echo $TempOutMin; ?>°</span> | <image src='image/up.png' width=10> <span class="max"><?php echo $TempOutMax; ?>°
     <div class="graph"
        id="chart-default" data-dailychart-values=<?php echo (substr($graph_temperatura,0, -1)); ?>
        data-dailychart-close=<?php echo ($temp_tmin); ?>
        data-dailychart-length=<?php echo ($i); ?>>
      </div>
   </span>
  </div>

  <!-- ************************
  *
  *    Umidità e condizioni
  *
  ************************** -->
  <div class="m1">
    <span class="h1">Umidità | Condizioni attuali</span>
    <table width="100%" height="170px" border="0">
      <tr>
        <td width="2%">
        </td>
        <td valign="top"><br>
        <font size="5"><?php echo round($umidity); ?> %</font><br>
        <br>Altezza nuvole: <?php echo round($cloud,1); ?> metri
        <br> Stato: <span class="light_blu"> <?php echo $txt_meteo ; ?>
         </td>
         <td align="center">
           <image src=<?php echo $ico_meteo;?> width=70%></font>
         </td>
     </tr>
    </table>
    <br>
    <span class="h2">
      <image src='image/down.png' width=10><span class="min"> <?php echo $UmOutMin; ?>%</span> | <image src='image/up.png' width=10> <span class="max"><?php echo $UmOutMax; ?>%
        <div class="graph"
           id="chart-default" data-dailychart-values=<?php echo (substr($graph_umidita,0, -1)); ?>
           data-dailychart-close=<?php echo ($ymin_u); ?>
           data-dailychart-length=<?php echo ($i); ?>>
         </div>
    </span>
  </div>

  <!-- ************************
  *
  *            Vento
  *
  ************************** -->
  <div class="r1">
    <span class="h1">Vento</span>
    <table width="100%" height="70px" border="0">
      <tr>
        <td width="2%">
        </td>
        <td valign="top"><br>
          <font size="5"><?php echo $wind_ave; ?> km/h </font> <br>
          <br>Raffica <?php echo $wind_gust; ?> km/h
          <br>T. del vento <?php echo round($wind_chill, 1); ?>°C
          <br><?php echo $wind_dir_code; ?> <span class="light_blu"><?php echo $wind_nome ." - ". $wind_vel_tipo; ?></span>
        </td>
        <td style="background:url(http://francescocangiani.com/meteo/image/rv.png); background-repeat:no-repeat; background-position:center; background-size:150px 150px;" width="150px" height="150px">
          <div class="gauge3 wind" width="50%"></div>
        </td>
      </tr>
    </table>
    <script>
    $('.gauge3').gauge({
        values: {
          0: "N",
          12.5: "NE",
          25: "E",
          37.5: "SE",
          50: "S",
          62.5: "SW",
          75: "W",
          87.5: "NW",
          100: ""
        },
        colors: {
          0: "#00008B",     //Tramontana
          6.25: "#1E90FF",  //Grecale
          18.75: "#FF4500", //Levante
          31.25: "#FFA500", //Scirocco
          43.75: "#D2691E", //Ostro - Mezzogiorno
          56.25: "#FFA500", //Libeccio
          68.75: "#FF4500", //Ponente
          81.25: "#1E90FF", //Maestrale
          93.75: "#00008B", //Tramontana
        },
        angles: [
            270,
            630
        ],
        lineWidth: 8,
        arrowWidth: 6,
        arrowColor: '#ccc',
        inset:0,

        value: (<?php echo $wind_dir; ?>*100)/360,
        valueAve: (<?php echo 180+(180+$wind_dir_ave); ?>*100)/360,
    });

  </script>
    <span class="h2">
      Vmax <span class="light_orange"><?php echo $winDayMax; ?></span> km/h | Rmax <span class="max"> <?php echo $winDayGustMax; ?></span> km/h
        <div class="graph"
           id="chart-default" data-dailychart-values=<?php echo (substr($graph_wind,0, -1)); ?>
           data-dailychart-close=<?php echo $ymin_v; ?>
           data-dailychart-length=<?php echo ($i); ?>>
         </div>
    </span>
  </div>

  <!-- ************************
  *
  *           Pioggia
  *
  ************************** -->
  <div class="l1">
    <span class="h1">Pioggia</span>

    <table width="100%" border="0">
      <tr>
        <td width="2%">
        </td>
        <td valign="top"><br>
        <font size="5"><?php echo round($rain1,1); ?> mm</font><br>
        <!--<br><?php echo round($rain_now ,1); ?> mm 15min-->
        <br><?php echo round($rain24 ,1); ?> mm 24H
        <br><?php echo $rain_rate; ?>% Rate
         </td>
         <td align="center">
           <canvas data-type="linear-gauge"
                   data-width="100dp"
                   data-height="170dp"
                   data-border-radius="0"
                   data-borders="false"
                   data-bar-begin-circle="false"
                   data-color-units="transparent"
                   data-minor-ticks="10"
                   data-value=<?php echo (round($rain1,1)*100)/10;?>
                   data-major-ticks="0,10"
                   data-tick-side="right"
                   data-number-side="right"
                   data-needle-side="right"
                   data-animation-rule="bounce"
                   data-animation-duration="750"
                   data-bar-stroke-width="5"
                   data-value-box-border-radius="0"
                   data-value-text-shadow="false"
                   data-color-plate="transparent"
                   data-color-bar-stroke="#1E90FF"
                   data-color-numbers="#6495ED,#6495ED,#6495ED,#6495ED,#6495ED,#6495ED,#6495ED,#6495ED,#6495ED,#6495ED"
                   data-color-value-box-shadow="false"
                   data-animate-on-init="false"
                   data-font-value-size=""
           ></canvas>
         </td>
     </tr>
    </table>

    <span class="h2">
      Totale <span class="max"><?php echo round ($rain); ?></span> mm
        <div class="graph"
           id="chart-default" data-dailychart-values=<?php echo (substr($graph_rain,0, -1)); ?>
           data-dailychart-close=-1.0
           data-dailychart-length=<?php echo ($i); ?>>
         </div>
    </span>
  </div>

  <!-- ************************
  *
  *         Pressione
  *
  ************************** -->
  <div class="m1">
    <span class="h1">Pressione</span>
    <table width="100%" border="0">
      <tr>
        <td width="2%">
        </td>
        <td valign="top"><font size="5"><?php echo $pressure; ?> hPa</font><image src=<?php echo $ico_tendenza;?> width=15>
          <br>
          <br>Trend (3h): <?php echo round($trend,1);?>
          <br><span class="light_blu"><?php echo $txt_tendenza;?>
        </td>
        <td>
          <div class="gauge2 pressure" </div>
          <script>
              $('.gauge2').gauge({
                  values: {
                    0: "960",
                    10: "970",
                    20: "980",
                    30: "990",
                    40: "1000",
                    50: "1010",
                    60: "1020",
                    70: "1030",
                    80: "1040",
                    90: "1050",
                    100: "1060"
                  },
                  colors: {
                    0: "#666",
                    <?php if ($PressureMin > 960) {
                      echo (($PressureMin-960)*100)/(1060-960);
                    } else {
                      echo 0;
                    }?>: "#029baa",
                    <?php echo (($PressureMax-960)*100)/(1060-960); ?>: "#666",
                  },
                  angles: [
                      150,
                      390
                  ],
                  lineWidth: 8,
                  arrowWidth: 6,
                  arrowColor: '#ccc',
                  inset:!1,

                  value: ((<?php echo $pressure; ?>-960)*100)/(1060-960),
                  valueAve:!1
              });
          </script>
        </td>
      </tr>
    </table>
    <span class="h2">
      <image src='image/down.png' width=10><span class="min"> <?php echo $PressureMin; ?></span> hPa | <image src='image/up.png' width=10> <span class="max"><?php echo $PressureMax; ?></span> hPa
        <div class="graph"
                 id="chart-default" data-dailychart-values=<?php echo (substr($graph_pressure,0, -1)); ?>
                 data-dailychart-close=<?php echo (($PressureMin+$PressureMax)/2); ?>
                 data-dailychart-length=<?php echo ($i); ?>>
        </div>
    </span>
  </div>

  <!-- ************************
  *
  *         Luminosità
  *
  ************************** -->
  <div class="r1">
    <span class="h1">Luminosità</span>

    <table width="100%" height="150px" border="0">
      <tr>
        <td width="2%">
        </td>
        <td valign="top" width="58%"><br>
        <font size="5"><?php echo round($illuminance*0.0079); ?> W/m</font><br>
        <!--<br>Lux: <?php echo $illuminance; ?>
        <br>UVI: <?php
          if($uv < 3 ){
            echo "<span style='color:#00cc00'>Leggero". "</span>";
          }else if($uv < 6 ){
            echo "<span style='color:#ffcc00'>Moderato". "</span>";
          }else if($uv < 8 ){
            echo "<span style='color:#ff9900'>Alto". "</span>";
          }else if($uv < 11 ){
            echo "<span style='color:#ff3300'>Molto alto". "</span>";
          }else{
            echo "<span style='color:#cc0099'>Estremo". "</span>";
          } ?>-->

          <br><span class="light_orange"><?php echo $inizio_crep;?></span> Inizio del crepuscolo
          <br><span class="light_orange"><?php echo $fine_crep;?></span>  Fine del crepuscolo
          <br><span class="light_orange"><?php echo $leng_day;?></span>  Ore di luce
          <br>

         </td>
           <?php if($uv < 3 ){
             echo "<td align='center' style='background-color:#00cc00; border-radius:25px'><br>";
           }else if($uv < 6 ){
             echo "<td align='center' style='background-color:#ffcc00; border-radius:25px'><br>";
           }else if($uv < 8 ){
             echo "<td align='center' style='background-color:#ff9900; border-radius:25px'><br>";
           }else if($uv < 11 ){
             echo "<td align='center' style='background-color:#ff3300; border-radius:25px'><br>";
           }else{
             echo "<td align='center' style='background-color:#cc0099; border-radius:25px'><br>";
           }
           echo "<font size='10'>" .$uv. "</font><br><font size='4'>INDEX</font>";
           ?>
         </td>
     </tr>
    </table>
    <span class="h2">
      Giorno: <span class="min"> <?php echo $leng_cpr; ?></span> | Notte: <span class="max"> <?php echo $le_night; ?></span>
      <div class="graph"
               id="chart-default" data-dailychart-values=<?php echo (substr($graph_lux,0, -1)); ?>
               data-dailychart-close=-1.0
               data-dailychart-length=<?php echo ($i); ?>>
      </div>
    </span>
  </div>

  <!-- ************************
  *
  *         Satellite
  *
  ************************** -->
  <div class="l1">
    <span class="h1">Immagini dal Satellite</span>
    <table width="100%" border="0">
      <tr>
        <td style="background:url(https://sat24.mobi/Image/satir/europa/it); background-repeat:no-repeat; background-position:center;" width="100%" height="190px"></td>
        </tr>
     </table>
     <span class="h2">Sat24 - IR</span>

  </div>

  <!-- ************************
  *
  *         Effemeridi
  *
  ************************** -->
  <div class="m1">
    <span class="h1">Effemeridi Sole e Luna</span><br>
    <table width='100%' border='0'><br>
       <tr><td align='center' width='100'><image src='image/sunrise.png'></td><td align='center' width='100'><image src='image/suntop.png'></td><td align='center' width='100'><image src='image/sunset.png'></td></tr>
       <tr><td align='center'>Sorge</td><td align='center'>Culmine</td><td align='center'>Tramonta</td></tr>
       <tr><td align='center'><?php echo $sole_sorge;?></td><td align='center'><?php echo $sole_transita;?></td><td align='center'><?php echo $sole_tramonta;?></td></tr>
     </table>
      <table width='100%' border='0'>
         <tr><td align='center' width='100'><image src='image/moonrise.png'></td><td align='center' width='100'><image src='image/moontop.png'></td><td align='center' width='100'><image src='image/moonset.png'></td></tr>
         <tr><td align='center'>Levata</td><td align='center'>Culmine</td><td align='center'>Calata</td></tr>
         <tr><td align='center'><?php echo $luna_sorge;?></td><td align='center'><?php echo $luna_transita;?></td><td align='center'><?php echo $luna_tramonta;?></td></tr>
       </table>
       <span class="h2">Fase lunare <span class="max"><?php echo $luna_fase;?> %</span></span>
  </div>

  <!-- ************************
  *
  *       Allerta meteo
  *
  ************************** -->
  <div class="r1">
    <span class="h1">Allerta meteo</span>
    <table width="100%" border="0">
      <tr>
        <td style="background:url(http://www.unwetterzentrale.de/images/map/europe_index.png); background-repeat:no-repeat; background-position:bottom;;" width="100%" height="190px"></td>
        </tr>
     </table>
     <span class="h2"><a href="http://allarmi.meteo-allerta.it/campania-index.html" target="_blank">meteo-allerta.it</a></span>
  </div>


  <!-- ************************
  *
  *             Cam
  *
  ************************** -->
  <div class="l1">
    <span class="h1">Cam</span>
    <table width="100%" border="0">
      <tr>
          <td onClick="popupCenter({url: '<?php if($img_valid){echo $img_cam_path;}else{echo $img_no_available;}  ?>', title: 'xtf', w: 700, h: 547});"   style="background:url(<?php if($img_valid){echo $img_cam_path;}else{echo $img_no_available;}  ?>);  background-position:bottom;  background-size: 400px;" width="100%" height="190px"></td>
        </tr>
     </table>
     <span class="h2">W - NW - N</span>
  </div>

  <!-- ************************
  *
  *         Previsioni
  *
  ************************** -->
  <div class="m1">
    <span class="h1">Previsioni</span>
    <table width="100%" border="0">
      <tr>
        <td align="center" >
        <img width="100%" src="http://www.foreca.it/meteogram.php?loc_id=103166350&amp;mglang=it&amp;units=metrickmh&amp;tf=24h">
        </td>
      </tr>
     </table>
     <span class="h2">Lat <?php echo $lat;?> - Lon <?php echo $lon;?></span>
  </div>

  <!-- ************************
  *
  *            Windy
  *
  ************************** -->
  <div class="r1">
    <span class="h1">Windy</span>
    <table width="100%" border="0">
      <tr>
        <td> <iframe width="100%" height="190" src="https://embed.windy.com/embed2.html?lat=40.571&lon=14.413&detailLat=40.585&detailLon=14.442&width=650&height=180&zoom=9&level=surface&overlay=waves&product=ecmwf&menu=&message=true&marker=&calendar=now&pressure=&type=map&location=coordinates&detail=&metricWind=km%2Fh&metricTemp=%C2%B0C&radarRange=-1" frameborder="0"></iframe></td>
        </tr>
     </table>
     <span class="h2">Mari</span>
  </div>

  <div>
    <table width="50%" border="0">
      <tr><td>
        <!--<image src='https://sat24.mobi/Image/satir/europa/it' width=100% >
        <image src='https://www.meteo60.fr/satellites/animation-satellite-ir-france.gif' width=100% >
       <image src='https://api.sat24.com/animated/IT/infraPolair/3/Central%20European%20Standard%20Time/4231854' width=100% >

     </br>Nuvole
     </br><image src='https://api.sat24.com/animated/IT/visual/1/Central%20European%20Standard%20Time/4455529' width=330 height=220>
     </br>Infrarosso
     </br><image src='https://api.sat24.com/animated/IT/infraPolair/1/Central%20European%20Standard%20Time/3219839' width=330 height=220>
     </br>Pioggia
     </br><image src='https://api.sat24.com/animated/IT/rainTMC/1/Central%20European%20Standard%20Time/8414767' width=330 height=220>
     </br>Neve
    </br><image src='https://api.sat24.com/animated/IT/snow/1/Central%20European%20Standard%20Time/6855405' width=330 height=220>-->
     </td></tr>
     </table>

</body>
</html>

<script>
  Dailychart.create('#chart-default', {
    lineWidth: 1,
    closeColor: ''
  });

  Dailychart.create('#chart-line', {
    lineWidth: 2
  });

  Dailychart.create('#chart-color', {
    lineWidth: 2,
    colorPositive: '#3d3d3d',
    colorNegative: '#3d3d3d'
  });

  Dailychart.create('#chart-close', {
    lineWidth: 2,
    colorPositive: '#3d3d3d',
    colorNegative: '#3d3d3d',
    closeColor: ''
  });

  Dailychart.create('#chart-fill', {
    fillPositive: '#d6efda',
    fillNegative: '#fbdddd',
    closeColor: ''
  });

  Dailychart.create('#chart-intraday', {
    fillPositive: '#d6efda',
    fillNegative: '#fbdddd'
  });
</script>
