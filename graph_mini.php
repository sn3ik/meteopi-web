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

  $graph_umidita .=  $row[8].",";
  if ($row[28]<$ymin_u)
    $ymin_u = $row[28];

  if ($row[29]>$ymax_u)
    $ymax_u = $row[29];

  $graph_pressure .= $row[7].",";
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

  $graph_wind .= $row[4].",";
  if ($row[20]<$ymin_v)
    $ymin_v = $row[20];

  if ($row[21]>$ymax_v)
    $ymax_v = $row[21];

  if ($row[22]<$ymin_rv)
    $ymin_rv = $row[22];

  if ($row[23]>$ymax_rv)
    $ymax_rv = $row[23];

  $chart_vento_dir .= "{ timestamp:'".$row[0]."', vento_dir:".$row[3]."}, ";

  $graph_rain .= $row[10].",";

  //$luce .= "{ timestamp:'".$row[0]."', lux:".$row[35].", full:".$row[36].", ir:".$row[37]."}, ";
  $luce .= "{ timestamp:'".$row[0]."', lux:".$row[19]."}, ";
  $graph_lux .= $row[19].",";
  $uvi .= "{ timestamp:'".$row[0]."', uvi:".$row[18]."}, ";

  if($row[10]>$rainmax)
    $rainmax = $row[10];
}

//if ( $i == 0 )
//{
//	echo "No data avalaible for the selected date :".$data."<br>";
//	exit();
//}

?>
