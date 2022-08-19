<?php // content="text/plain; charset=utf-8"

require_once("settings.php");

$con = new mysqli($server,$user,$pwd,$db);

$sql_temp_max_total = "SELECT `TIMESTAMP_LOCAL`,`TEMP` FROM `METEO` WHERE `TEMP` < 40 AND `TEMP` IS NOT NULL order by `TEMP` desc limit 1";
$result = $con->query($sql_temp_max_total);
$row = $result->fetch_row();

$sql_temp_min_total = "SELECT `TIMESTAMP_LOCAL`,`TEMP` FROM `METEO` WHERE `TEMP` IS NOT NULL order by `TEMP` asc limit 1";
$result1 = $con->query($sql_temp_min_total);
$row1 = $result1->fetch_row();

$sql_temp_app_max_total = "SELECT `TIMESTAMP_LOCAL`,`TEMP_APPARENT` FROM `METEO` WHERE `TEMP_APPARENT` IS NOT NULL AND `TEMP_APPARENT` < 50 order by `TEMP_APPARENT` desc limit 1";
$result11 = $con->query($sql_temp_app_max_total);
$row11 = $result11->fetch_row();

$sql_temp_app_min_total = "SELECT `TIMESTAMP_LOCAL`,`TEMP_APPARENT` FROM `METEO` WHERE `TEMP_APPARENT` IS NOT NULL AND `TEMP_APPARENT` < 50 order by `TEMP_APPARENT` asc limit 1";
$result12 = $con->query($sql_temp_app_min_total);
$row12 = $result12->fetch_row();

$sql_hum_max_total = "SELECT `TIMESTAMP_LOCAL`,`HUM` FROM `METEO` order by `HUM` desc limit 1";
$result2 = $con->query($sql_hum_max_total);
$row2 = $result2->fetch_row();

$sql_hum_min_total = "SELECT `TIMESTAMP_LOCAL`,`HUM` FROM `METEO` order by `HUM` asc limit 1";
$result3 = $con->query($sql_hum_min_total);
$row3 = $result3->fetch_row();

$sql_wind_ave_max_total = "SELECT `TIMESTAMP_LOCAL`,`WIND_DAY_MAX` FROM `METEO` order by `WIND_DAY_MAX` desc limit 1";
$result4 = $con->query($sql_wind_ave_max_total);
$row4 = $result4->fetch_row();

$sql_wind_gust_max_total = "SELECT `TIMESTAMP_LOCAL`,`WIND_DAY_GUST_MAX` FROM `METEO` order by `WIND_DAY_GUST_MAX` desc limit 1";
$result5 = $con->query($sql_wind_gust_max_total);
$row5 = $result5->fetch_row();

$sql_pressure_max_total = "SELECT `TIMESTAMP_LOCAL`,`PRESSURE_DAY_MAX` FROM `METEO` WHERE `PRESSURE_DAY_MAX` < 1200 AND `PRESSURE_DAY_MAX` IS NOT NULL order by `PRESSURE_DAY_MAX` desc limit 1";
$result6 = $con->query($sql_pressure_max_total);
$row6 = $result6->fetch_row();

$sql_pressure_min_total = "SELECT `TIMESTAMP_LOCAL`,`PRESSURE_DAY_MIN` FROM `METEO` WHERE `PRESSURE_DAY_MIN` > 900 AND `PRESSURE_DAY_MIN` IS NOT NULL order by `PRESSURE_DAY_MIN` asc limit 1";
$result7 = $con->query($sql_pressure_min_total);
$row7 = $result7->fetch_row();

$sql_rain1_max_total = "SELECT `TIMESTAMP_LOCAL`,`RAIN1` FROM `METEO` WHERE `RAIN1` < 200 order by `RAIN1` desc limit 1";
$result8 = $con->query($sql_rain1_max_total);
$row8 = $result8->fetch_row();

$sql_rain24_max_total = "SELECT `TIMESTAMP_LOCAL`,`RAIN24` FROM `METEO` WHERE `RAIN24` < 500 order by `RAIN24` desc limit 1";
$result9 = $con->query($sql_rain24_max_total);
$row9 = $result9->fetch_row();

?>
<!DOCTYPE html>
<html>
<head>

<style type="text/css">

body {
  background-color: #1f2326;
  color: #F5F5F5 !important;
  font: normal 13px Verdana, Arial, sans-serif;
}
* {
  box-sizing: border-box;
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

</style></head>

<body onload="init()">
  <div data-role="page" data-theme="a">
    <div data-role="content">

        <span class='gray'>Minimi e Massimi</span>
          <table border="0">
            <tr align="left">
                <td>T° max: </td><td> <span class="red"> <?php echo $row[1] ?> </span>° </td></tr><tr align="left"><td> <?php echo date('H:i:s',strtotime($row[0])) ?> - <?php echo date('d/m/Y',strtotime($row[0]))?><br><br>
            </tr>
            <tr align="left">
                <td>T° min: </td><td> <span class="blu"> <?php echo $row1[1] ?> </span>° </td></tr><tr align="left"><td> <?php echo date('H:i:s',strtotime($row1[0])) ?> - <?php echo date('d/m/Y',strtotime($row1[0]))?><br><br>
            </tr>
            <tr align="left">
                <td>T° percepita max: </td><td> <span class="red"> <?php echo $row11[1] ?> </span>°</td></tr><tr align="left"><td> <?php echo date('H:i:s',strtotime($row11[0])) ?> - <?php echo date('d/m/Y',strtotime($row11[0]))?><br><br>
            </tr>
            <tr align="left">
                <td>T° percepita min: </td><td> <span class="blu"> <?php echo $row12[1] ?> </span>°</td></tr><tr align="left"><td> <?php echo date('H:i:s',strtotime($row12[0])) ?> - <?php echo date('d/m/Y',strtotime($row12[0]))?><br><br>
            </tr>
            <tr align="left">
                <td>Umidità max: </td><td> <span class="yellow"> <?php echo $row2[1] ?> </span>%</td></tr><tr align="left"><td> <?php echo date('H:i:s',strtotime($row2[0])) ?> - <?php echo date('d/m/Y',strtotime($row2[0]))?><br><br>
            </tr>
            <tr align="left">
                <td>Umidità min: </td><td> <span class="yellow"> <?php echo $row3[1] ?> </span>%</td></tr><tr align="left"><td> <?php echo date('H:i:s',strtotime($row3[0])) ?> - <?php echo date('d/m/Y',strtotime($row3[0]))?><br><br>
            </tr>
            <tr align="left">
                <td>Vento max: </td><td> <span class="green"> <?php echo $row4[1] ?> </span>km</td></tr><tr align="left"><td> <?php echo date('H:i:s',strtotime($row4[0])) ?> - <?php echo date('d/m/Y',strtotime($row4[0]))?><br><br>
            </tr>
            <tr align="left">
                <td>Raffica max: </td><td> <span class="green"> <?php echo $row5[1] ?> </span>km</td></tr><tr align="left"><td> <?php echo date('H:i:s',strtotime($row5[0])) ?> - <?php echo date('d/m/Y',strtotime($row5[0]))?><br><br>
            </tr>
            <tr align="left">
                <td>Pressione max: </td><td> <span class="gray"> <?php echo $row6[1] ?> </span>hPa</td></tr><tr align="left"><td> <?php echo date('H:i:s',strtotime($row6[0])) ?> - <?php echo date('d/m/Y',strtotime($row6[0]))?><br><br>
            </tr>
            <tr align="left">
                <td>Pressione min: </td><td> <span class="gray"> <?php echo $row7[1] ?> </span>hPa</td></tr><tr align="left"><td> <?php echo date('H:i:s',strtotime($row7[0])) ?> - <?php echo date('d/m/Y',strtotime($row7[0]))?><br><br>
            </tr>
            <tr align="left">
                <td>Pioggia 1 ora max: </td><td> <span class="blu"> <?php echo $row8[1] ?> </span>mm</td></tr><tr align="left"><td> <?php echo date('H:i:s',strtotime($row8[0])) ?> - <?php echo date('d/m/Y',strtotime($row8[0]))?><br><br>
            </tr>
            <tr align="left">
                <td>Pioggia 24 ore max: </td><td> <span class="blu"> <?php echo $row9[1] ?> </span>mm</td></tr><tr align="left"><td> <?php echo date('H:i:s',strtotime($row9[0])) ?> - <?php echo date('d/m/Y',strtotime($row9[0]))?><br><br>
            </tr>
        </table>
    <form action="andamento_day.php" target="_blank">
      <input type="date" name="DATE">
      <input type="submit" value="Andamento">
    </form>
  </div>
</div>
</body>
</html>
