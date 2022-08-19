<?php
require("settings.php");

$con = new mysqli($server,$user,$pwd,$db);
//mysqli_select_db($con, $db) or die(mysqli_error($con));

$sql = "SELECT * FROM METEO ORDER BY `TIMESTAMP_LOCAL` DESC LIMIT 1";
$rainnow = "SELECT RAIN FROM METEO ORDER BY `TIMESTAMP_LOCAL` DESC LIMIT 1 OFFSET 1";


$result = $con->query($sql);
$row = $result->fetch_row();

$result2 = $con->query($rainnow);
$row2 = $result2->fetch_row();

$data = date("d-m-Y");

$press_trend_3_6 = "SELECT `TIMESTAMP_LOCAL`,`PRESSURE` FROM  `METEO` WHERE  `TIMESTAMP_LOCAL` BETWEEN timestamp(DATE_SUB(NOW(), INTERVAL 6 HOUR)) AND timestamp(DATE_SUB(NOW(),INTERVAL 3 HOUR)) ORDER BY  `METEO`.`TIMESTAMP_LOCAL` DESC ";

$press_trend = "SELECT `TIMESTAMP_LOCAL`,`PRESSURE` FROM  `METEO` WHERE  `TIMESTAMP_LOCAL` > NOW( ) - INTERVAL 3 HOUR ORDER BY  `METEO`.`TIMESTAMP_LOCAL` DESC ";
$result_press = $con->query($press_trend);


$i = 0;
while ( $row_press = $result_press->fetch_row() )
{
  if($i==0){
    $press_3h = $row_press[1];
    $press_max_3h = $row_press[1];
    $press_min_3h = $row_press[1];
  }
  if($row_press[1]>$press_max_3h)
    $press_max_3h = $row_press[1];

  if($row_press[1]<$press_min_3h)
    $press_min_3h = $row_press[1];

  $i = $i + 1;
}



//$result = mysqli_query($con,"SELECT * FROM METEO ORDER BY `TIMESTAMP_LOCAL` DESC LIMIT 1") ;
//$row = mysqli_fetch_array($result);

//$result2 = mysql_query($con,"SELECT RAIN_RATE FROM METEO ORDER BY `TIMESTAMP_LOCAL` DESC LIMIT 1 OFFSET 1") ;
//$row2 = mysqli_fetch_array($result2);


$last_measure_time = $row[0];
$wind_dir_code = $row[2]; //vento direzione punti cardinali
$wind_dir = $row[3];      //vento direzione gradi
$wind_ave = $row[4];      //vento velocità
$wind_gust = $row[5];     //vento raffica
$temp_out = $row[6];      //temperatura esterna
$pressure = $row[7];      //pressione
$umidity = $row[8];       //umidità
$rain = $row[9];         //pioggia totale
$rain1 = $row[10];       //pioggia 1h
$rain24 = $row[11];      //pioggia 24h

$rain_now = $row[9]-$row2[0];      //pioggia in questo momento
$rain_rate = $row[12]-$row[12];    //pioggia %
$temp_in = $row[13];      //temperatura interna
$hum_in = $row[14];       //umidità interna
$wind_chill = $row[15];   //temperatura del vento
$temp_apparent = $row[16];//temperatura percepita
$dew_point = $row[17];    //punto di ruggiada
$uv = $row[18];           //uv del sole
$illuminance = $row[19];  //luminosità
$winDayMin = $row[20];    //vento h24 min
$winDayMax = $row[21];    //vento h24 max
$winDayGustMin = $row[22];//vento raffica min
$winDayGustMax = $row[23];//vento raffica max
$TempOutMin = $row[24];   //temperatura esterna min
$TempOutMax = $row[25];   //temperatura esterna max
$TempInMin = $row[26];    //temperatura interna min
$TempInMax = $row[27];    //temperatura interna max
$UmOutMin = $row[28];     //umidità esterna min
$UmOutMax = $row[29];     //umidità esterna max
$UmInMin = $row[30];      //umidità interna min
$UmInMax = $row[31];      //umidità interna max
$PressureMin = $row[32];  //pressione min
$PressureMax = $row[33];  //pressione max
$wind_dir_ave = $row[34]; //direzione media del vento
$Lux = $row[35];          //luce
$LuxFull = $row[36];      //luce + ir
$Ir = $row[37];           //ir
$cloud = ((((  ($row[6]-$row[17]) *1.8/4.5 ) * 1000 ) + ($alt * 3.2808) ) / 3.2808);




?>
