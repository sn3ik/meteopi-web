<?php // content="text/plain; charset=utf-8"
require_once("settings.php");

if(empty($_GET['DATE'])){
    $data = date("Y-m-d");
}else{
   $data = $_GET['DATE'];
}

if(empty($_GET['ORE'])){
  $sql = "SELECT * FROM `METEO` WHERE date( `TIMESTAMP_LOCAL` ) = STR_TO_DATE('".$data."', '%Y-%m-%d') ORDER BY `METEO`.`TIMESTAMP_LOCAL` ASC";
}else{
   $ore = $_GET['ORE'];
   $sql = "SELECT * FROM  `METEO` WHERE  `TIMESTAMP_LOCAL` > NOW( ) - INTERVAL ".$ore." HOUR ORDER BY  `METEO`.`TIMESTAMP_LOCAL` ASC ";
}

$con = new mysqli($server,$user,$pwd,$db);

if (!$con){
  die('Could not connect: ' . mysql_error());
}

$result = $con->query($sql);

$ymin_c = 1000000;
$ymax_c = 0;
$temp_tmin = 1000;
$temp_tmax = 0;
$temp_tamin = 1000;
$temp_tamax = 0;
$ymin_u = 1000;
$ymax_u = 0;
$ymin_p = 10000;
$ymax_p = 0;
$ymin_v = 1000;
$ymax_v = 0;
$ymin_rv = 1000;
$ymax_rv = 0;
$rainmax = 0;

$i = 0;
while ( $row = $result->fetch_row() )
{
	$i = $i + 1;
  $hms = date('h:m:s', strtotime($row[0]));

  $chart_temperatura .= "{ timestamp:'".$row[0]."', hms:'".$hms."', temperatura:".$row[6].", percepita:".$row[16]."}, ";
  $graph_temperatura .= $row[6].",";

  if($row[25]>$temp_tmax)
    $temp_tmax = $row[25];

  if($row[24]<$temp_tmin)
    $temp_tmin = $row[24];

  if($row[16]>$temp_tamax)
    $temp_tamax = $row[16];

  if($row[16]<$temp_tamin)
    $temp_tamin = $row[16];

  if($temp_tmax>$temp_tamax){
    $range_maxt = $temp_tmax;
  }else {
    $range_maxt = $temp_tamax;
  }

  if($temp_tmin<$temp_tamin){
    $range_mint = $temp_tmin;
  }else {
    $range_mint = $temp_tamin;
  }

  $chart_umidita .= "{ timestamp:'".$row[0]."', umidita:".$row[8]."}, ";
  if ($row[28]<$ymin_u)
    $ymin_u = $row[28];

  if ($row[29]>$ymax_u)
    $ymax_u = $row[29];

  $chart_pressure .= "{ timestamp:'".$row[0]."', pressure:".$row[7]."}, ";
  if ($row[32]<$ymin_p)
    $ymin_p = $row[32];

  if ($row[33]>$ymax_p)
    $ymax_p = $row[33];

  $cloud = ((((  ($row[6]-$row[17]) *1.8/4.5 ) * 1000 ) + ($alt * 3.2808) ) / 3.2808);
  $chart_cloud .= "{ timestamp:'".$row[0]."', cloud:".round($cloud,1)."}, ";
  if ($cloud<$ymin_c)
    $ymin_c = round($cloud,1);

  if ($cloud>$ymax_c)
    $ymax_c = round($cloud,1);

  $chart_vento .= "{ timestamp:'".$row[0]."', vento:".$row[4].", raffica:".$row[5]."}, ";
  if ($row[20]<$ymin_v)
    $ymin_v = $row[20];

  if ($row[21]>$ymax_v)
    $ymax_v = $row[21];

  if ($row[22]<$ymin_rv)
    $ymin_rv = $row[22];

  if ($row[23]>$ymax_rv)
    $ymax_rv = $row[23];

  $chart_vento_dir .= "{ timestamp:'".$row[0]."', vento_dir:".$row[3]."}, ";

  $rain1h .= "{ timestamp:'".$row[0]."', rain1h:".$row[10]."}, ";

  //$luce .= "{ timestamp:'".$row[0]."', lux:".$row[35].", full:".$row[36].", ir:".$row[37]."}, ";
  $luce .= "{ timestamp:'".$row[0]."', lux:".$row[19]."}, ";
  $uvi .= "{ timestamp:'".$row[0]."', uvi:".$row[18]."}, ";

  if($row[10]>$rainmax)
    $rainmax = $row[10];
}

if ( $i == 0 )
{
	echo "No data avalaible for the selected date :".$data."<br>";
	exit();
}

?>

<!DOCTYPE html>
<html>
 <head>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>

  <style type="text/css">

  body {
    background-color: #1f2326;
    color: #F5F5F5 !important;
    font: normal 13px Verdana, Arial, sans-serif;
  }
  * {
    box-sizing: border-box;
  }

  .l {
    border-radius:3px;
    background-color:#2d3236;
    float:left;
    width:33%;
    height: 220px;
    padding:0px;
    margin-top:20px;
    margin-right:3px;
    position: relative;
    display: inline-block;
  }

  .m {
    border-radius:3px;
    background-color:#2d3236;
    float:left;
    width:33%;
    height: 220px;
    margin-top:20px;
    position: relative;
    display: inline-block;
  }

  .r {
    border-radius:3px;
    background-color:#2d3236;
    float:left;
    width:33%;
    height: 220px;
    margin-top:20px;
    margin-left:3px;
    position: relative;
    display: inline-block;
  }

  .red {
    color: red;
  }
  .blu {
    color: lightblue;
  }
  .yellow {
    color: yellow;
  }
  .green {
    color: green;
  }
  .gray {
    color: gray;
  }
  .h1 {
    background-color: #24292c;
    color: white;
    font-size: 12px;
    padding:1px;
    display: inline-block;
    width:100%;
    text-align: center;

  }

  .chart {
    padding:1px;
    height: 50px;
    width:100%;
    background: #1f2326;
  }
  .lg {
    border-radius:3px;
    background-color:#2d3236;
    float:left;
    width:33%;
    height: 50px;
    padding:1px;
    margin-top:1px;
    margin-right:3px;
    position: relative;
    display: inline-block;
  }

  @media only screen and (max-width:620px) {
    /* For mobile phones: */
    .navbar, .l, .m, .r {
      width:100%;
      margin-left:0%;
      margin-right:0%;
    }
  }

  </style>

 </head>
 <body>
   <div data-role="page" data-theme="a">
     <div data-role="content">

    <div id="temp" class="l">
      <span class="h1">TMin: <?php echo $temp_tmin; ?> C° TMax: <?php echo $temp_tmax; ?> C°
      PMin: <?php echo $temp_tamin; ?> C° PMax: <?php echo $temp_tamax; ?> C°</span>
    </div>


   <div id="umid" class="m">
     <span class="h1">Umidità Min: <?php echo $ymin_u; ?> % Max: <?php echo $ymax_u; ?> %
     </span>
   </div>

   <div id="press" class="r">
     <span class="h1">Pressione Min: <?php echo $ymin_p; ?> hPa Max: <?php echo $ymax_p; ?> hPa

     </span>
   </div>

   <div id="nuvole" class="l">
     <span class="h1">Altezza Nuvole Min: <?php echo $ymin_c; ?> m Max: <?php echo $ymax_c; ?> m
     </span>
   </div>


   <div id="vento" class="m">
     <span class="h1">Vento - Min: <?php echo $ymin_v; ?> Km/h Max: <?php echo $ymax_v; ?> Km/h
        RMin: <?php echo $ymin_rv; ?> Km/h RMax: <?php echo $ymax_rv; ?> Km/h
     </span>
   </div>

   <div id="vento_dir" class="r">
     <span class="h1">Direzione del Vento
     </span>
   </div>

   <div id="rain1h" class="l">
     <span class="h1">Pioggia Max: <?php echo round($rainmax,1); ?> mm
     </span>
   </div>

   <div id="lux" class="m">
     <span class="h1">Luce
     </span>
   </div>

   <div id="uvi" class="r">
     <span class="h1">UV-Index
     </span>
   </div>

 </body>
</div>
</div>
</html>

<script>

Morris.Line({
 element : 'temp',
 data:[<?php echo $chart_temperatura; ?>],
 xkey:'timestamp',
 ykeys:['temperatura','percepita'],
 ymax: <?php echo round($range_maxt)+$range_t; ?>,
 ymin: <?php echo round($range_mint)-$range_t; ?>,
 labels:['Temperatura','Percepita'],
 resize: true
});

Morris.Bar({
 element : 'umid',
 data:[<?php echo $chart_umidita; ?>],
 xkey:'timestamp',
 ykeys:['umidita'],
 ymax: <?php echo round($ymax_u)+$range_u; ?>,
 ymin: <?php echo round($ymin_u)-$range_u; ?>,
 labels:['Umidità'],
 barColors: ['#b30000'],
 barOpacity: 0.5,
 resize: true
});

Morris.Bar({
 element : 'press',
 data:[<?php echo $chart_pressure; ?>],
 xkey:'timestamp',
 ykeys:['pressure'],
 //ymax: 1045,
 //ymin: 995,
 //ymax: <!?php echo (round($ymax_p)+round($ymin_p))/2+$range_p; ?>,
 //ymin: <!?php echo (round($ymax_p)+round($ymin_p))/2-$range_p; ?>,
 ymax: <?php echo (round($ymax_p)+1); ?>,
 ymin: <?php echo (round($ymin_p)); ?>,
 labels:['Pressione'],
 barColors: ['#1fbba6', '#f8aa33', '#4da74d', '#afd8f8', '#edc240', '#cb4b4b', '#9440ed'],
 barOpacity: 0.5,
 resize: true

});

Morris.Bar({
 element : 'nuvole',
 data:[<?php echo $chart_cloud; ?>],
 xkey:'timestamp',
 ykeys:['cloud'],
 ymax: <?php echo round($ymax_c)+$range_n; ?>,
 ymin: <?php echo round($ymin_c)-$range_n; ?>,
 labels:['Nuvole'],
 barColors: ['#cccccc'],
 barOpacity: 0.5,
 resize: true
});

Morris.Line({
 element : 'vento',
 data:[<?php echo $chart_vento; ?>],
 xkey:'timestamp',
 ykeys:['vento','raffica'],
 ymax: <?php echo round($ymax_rv)+$range_v; ?>,
 ymin: 0,
 labels:['Vento','Raffica'],
 lineColors: ['#660066','#000000'],
 pointFillColors: ['#660066','#000000'],
 resize: true
});

Morris.Line({
 element : 'vento_dir',
 data:[<?php echo $chart_vento_dir; ?>],
 xkey:'timestamp',
 ykeys:['vento_dir'],
 ymax: 360,
 ymin: 0,
 labels:['Vento'],
 lineColors: ['#009900'],
 pointFillColors: ['#009900'],
 resize: true,
});

Morris.Bar({
  element : 'rain1h',
  data:[<?php echo $rain1h; ?>],
  xkey:'timestamp',
  ykeys:['rain1h'],
  ymax: <?php echo round($rainmax); ?>,
  ymin: 0,
  labels:['Pioggia'],
  resize: true,
  barColors: ['#99ccff'],
  barOpacity: 0.5
});

Morris.Bar({
  element : 'lux',
  data:[<?php echo $luce; ?>],
  xkey:'timestamp',
  ykeys:['lux'],
  ymax: 250000,
  ymin: 0,
  labels:['Lux'],
  resize: true,
  barColors: ['#ffe066'],
  barOpacity: 0.5
});

Morris.Bar({
  element : 'uvi',
  data:[<?php echo $uvi; ?>],
  xkey:'timestamp',
  ykeys:['uvi'],
  ymax: 14,
  ymin: 0,
  labels:['UVI'],
  resize: true,
  barColors: ['#ff9933'],
  barOpacity: 0.5
}).on('click', function(i, row){
  console.log(i, row);
});

</script>
