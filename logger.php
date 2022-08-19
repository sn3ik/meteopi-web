<?php

require("settings.php");

$con_p = new mysqli($server,$user,$pwd,$db);
//mysqli_select_db($con, $db) or die(mysqli_error($con));
$sql_p = "SELECT `TIMESTAMP_LOCAL`,`PRESSURE_DAY_MIN` FROM METEO ORDER BY `TIMESTAMP_LOCAL` DESC LIMIT 1";
$result_p = $con_p->query($sql_p);
$row_p = $result_p->fetch_row();
while ( $row_p = $result_p->fetch_row() )
{
  //$press_min_old = $row_press[1];
}

//$content =$_POST;
$ipstation = get_client_ip();
//$file = "text.txt";
$file2 = "ip.txt";

//$Saved_File = fopen($file, 'w');
$Saved_File2 = fopen($file2, 'w');

//fwrite($Saved_File, serialize($content));
fwrite($Saved_File2, $ipstation);

//fclose($Saved_File);
fclose($Saved_File2);


$swpipwd1 = $_POST['pwd'];

if ($swpipwd1 != $swpipwd)
{
  die('Wrong password ');
}

$last_measure_time = $_POST['last_measure_time'];
$idx = $_POST['idx'];
$wind_dir_code = $_POST['wind_dir_code'];
$wind_dir = $_POST['wind_dir'];
$wind_ave = $_POST['wind_ave'];
$wind_gust = $_POST['wind_gust'];
$temp_out = $_POST['temp_out'];
$hum_out = $_POST['hum_out'];
$rel_pressure = $_POST['rel_pressure'];
$rain = $_POST['rain'];
$rain24 = $_POST['rain_rate_24h'];
$rain1 = $_POST['rain_rate_1h'];
$rain_rate = $_POST['rain_rate'];
$temp_in = $_POST['temp_in'];
$hum_in = $_POST['hum_in'];
$wind_chill = $_POST['wind_chill'];
$temp_apparent = $_POST['temp_apparent'];
$dew_point = $_POST['dew_point'];
$uv = $_POST['uv'];
$illuminance = $_POST['illuminance'];
$winDayMin = $_POST['winDayMin'];
$winDayMax = $_POST['winDayMax'];

$winDayGustMin  = $_POST['winDayGustMin'];
$winDayGustMax = $_POST['winDayGustMax'];
$TempOutMin = $_POST['TempOutMin'];
$TempOutMax = $_POST['TempOutMax'];
$TempInMin = $_POST['TempInMin'];
$TempInMax = $_POST['TempInMax'];
$UmOutMin = $_POST['UmOutMin'];
$UmOutMax = $_POST['UmOutMax'];
$UmInMin = $_POST['UmInMin'];
$UmInMax = $_POST['UmInMax'];
//if($_POST['PressureMin'] > 960){
$PressureMin = $_POST['PressureMin'];
//}else{
//  $PressureMin = 960;
//}
$PressureMax = $_POST['PressureMax'];
$wind_dir_ave = $_POST['wind_dir_ave'];
$lux = $_POST['lux'];
$luxfull = $_POST['luxfull'];
$ir = $_POST['ir'];

$con = mysql_connect($server,$user,$pwd);
mysql_select_db($db);

if (!$con){
  die('Could not connect: ' . mysql_error());
}

$sql = "INSERT INTO METEO (TIMESTAMP_LOCAL, TIMESTAMP_IDX, WINDIR_CODE, WIND_DIR, WIND_AVE, WIND_GUST, TEMP, PRESSURE, HUM, RAIN, RAIN1, RAIN24, RAIN_RATE, TEMPINT, HUMINT, WIND_CHILL, TEMP_APPARENT, DEW_POINT, UV_INDEX, SOLAR_RAD, WIND_DAY_MIN, WIND_DAY_MAX,WIND_DAY_GUST_MIN ,WIND_DAY_GUST_MAX ,TEMP_OUT_DAY_MIN ,TEMP_OUT_DAY_MAX,TEMP_IN_DAY_MIN ,TEMP_IN_DAY_MAX ,HUM_OUT_DAY_MIN ,HUM_OUT_DAY_MAX ,HUM_IN_DAY_MIN ,HUM_IN_DAY_MAX ,PRESSURE_DAY_MIN ,PRESSURE_DAY_MAX,WIND_DIR_AVE, LUX, LUXFULL, IR) VALUES ('".$last_measure_time."','".$idx."','".$wind_dir_code."',".$wind_dir.",".$wind_ave.",".$wind_gust.",".$temp_out.",".$rel_pressure.",".$hum_out.",".$rain.",".$rain1.",".$rain24.",".$rain_rate.",".$temp_in.",".$hum_in.",".$wind_chill.",".$temp_apparent.",".$dew_point.",".$uv.",".$illuminance.",".$winDayMin.",".$winDayMax.",".$winDayGustMin.",".$winDayGustMax.",".$TempOutMin.",".$TempOutMax.",".$TempInMin.",".$TempInMax.",".$UmOutMin.",".$UmOutMax.",".$UmInMin.",".$UmInMax.",".$PressureMin.",".$PressureMax.",".$wind_dir_ave.",".$lux.",".$luxfull.",".$ir." )";

$file = "sql.txt";
$Saved_File = fopen($file, 'w');
fwrite($Saved_File, $sql);
fclose($Saved_File);

$result = mysql_query($sql) ;

if (!$result) {
	die("Errore nella query $sql: " . mysql_error());
	//die("Errore nella query $query: " . $sql);
}else{
    echo 'OK';
}

mysql_close($con);



// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

?>
