<?php
require("query.php");
?>


<!DOCTYPE html>
<html>
<head>
  <link rel="icon" type="image/png" href="icone/meteopi_web.png" />
  <script type="text/javascript" src="astrojs/astrojs.js"></script>
  <script language="JavaScript" type="text/javascript">

      var LAT=<?php echo $lat; ?>;    // latitudine  del luogo di osservazione in gradi sessadecimali.
      var LON=<?php echo $lon; ?>;    // longitudine del luogo di osservazione in gradi sessadecimali.
      var ALT=<?php echo $alt; ?>;       // altitudine in metri sul livello del mare del luogo di osservazione.

      var njd=calcola_jd();
      //var njd=calcola_jddata(dd,mm,yy,hh,mi,se);  // calcola  il G.G. della data.
      var crep=crepuscolo_UT(njd,LON,LAT,ALT);    // calcola  il crepuscolo.
      var t_locale=hh_loc(1,njd);  //calcola le ore da aggiungere al T.U. per avere il tempo locale.

      var inizio_crep=crep[0]+t_locale; // inizio del crepuscolo in ore decimali (Tempo Locale).
      var   fine_crep=crep[1]+t_locale; // fine del crepuscolo in ore decimali (Tempo Locale).
      var    leng_day=crep[2];          // durata del giorno in ore decimali.
      var    leng_cpr=crep[3];          // durata crepuscolo+giorno in ore decimali.
      var    le_night=crep[4];          // durata della notte astronomica in ore decimali.

      //SOLE
      var dati_ast=ST_SOLE(njd,LON,LAT,ALT); // I tempi e gli azimut.

      var  sole_azimut_s=sc_angolo_gm(dati_ast[0],1); // Azimut del sorgere con 1 decimali.
      var  sole_azimut_t=sc_angolo_gm(dati_ast[1],1); // Azimut del tramontare con 1 decimali.
      var     sole_sorge=sc_ore_hm(dati_ast[2]+t_locale);   // Sorge in hh|mm.
      var  sole_transita=sc_ore_hm(dati_ast[3]+t_locale);   // Transita in hh|mm.
      var  sole_tramonta=sc_ore_hm(dati_ast[4]+t_locale);   // Tramonta in hh|mm.
      //nightday(sole_sorge, sole_tramonta)

      //Luna
      var dati_ast=ST_LUNA(njd,LON,LAT,ALT); // I tempi e gli azimut.
      var effemeridi=pos_luna(njd);
      // Recupero dei dati dall'array dati_ast[] e formattazione.

      var  azimut_s=sc_angolo_gm(dati_ast[0],1); // Azimut del sorgere con 1 decimali.
      var  azimut_t=sc_angolo_gm(dati_ast[1],1); // Azimut del tramontare con 1 decimali.
      var     sorge=sc_ore_hm(dati_ast[2]+t_locale);   // Sorge in hh|mm.
      var  transita=sc_ore_hm(dati_ast[3]+t_locale);   // Transita in hh|mm.
      var  tramonta=sc_ore_hm(dati_ast[4]+t_locale);   // Tramonta in hh|mm.

      <?php $i_crep = "<script>document.write(oremin(inizio_crep))</script>"?>
      <?php $f_crep = "<script>document.write(oremin(fine_crep))</script>"?>


      <?php $inizio_crep = "<script>document.write(sc_ore_hm(inizio_crep))</script>"?>
      <?php $fine_crep = "<script>document.write(sc_ore_hm(fine_crep))</script>"?>
      <?php $leng_day = "<script>document.write(sc_ore_hm(leng_day))</script>"?>
      <?php $leng_cpr = "<script>document.write(sc_ore_hm(leng_cpr))</script>"?>
      <?php $le_night = "<script>document.write(sc_ore_hm(le_night))</script>"?>
      <?php $sole_sorge = "<script>document.write(sole_sorge)</script>"?>
      <?php $sole_transita = "<script>document.write(sole_transita)</script>"?>
      <?php $sole_tramonta = "<script>document.write(sole_tramonta)</script>"?>
      <?php $luna_fase = "<script>document.write((effemeridi[3].toFixed(2))*100)</script>"?>
      <?php $luna_sorge = "<script>document.write(sorge)</script>"?>
      <?php $luna_transita = "<script>document.write(transita)</script>"?>
      <?php $luna_tramonta = "<script>document.write(tramonta)</script>"?>

  </script>
</head>
<body>
</body>
</html>

<?php

####################################
#                                  #
#    Riconoscimento icona meteo    #
#                                  #
####################################

# delete from `METEO` where `TIMESTAMP_LOCAL` < '2017-12-10';

$cloud = ((((  ($row[6]-$row[17]) *1.8/4.5 ) * 1000 ) + ($alt * 3.2808) ) / 3.2808);

$sunrise = date_sunrise(time(), SUNFUNCS_RET_DOUBLE, $lat, $lon, 96, 1);
$sunset = date_sunset(time(), SUNFUNCS_RET_DOUBLE, $lat, $lon, 96, 1);
$now = date("H") + date("i") / 60 + date("s") / 3600;
//$test = date_sunset(time(), SUNFUNCS_RET_STRING, $lat, $lon, $alt, 1). " > ". date('Hi') ." && ". date('Hi') ." > ". $i_crep;


if($cloud < 600 && $rain1 != 0.0){
  $ico_meteo = 'icone/pioggia_nuvole_giorno.png';
  $txt_meteo = "Pioggia";
}else if($cloud < 600){
  $ico_meteo = 'icone/nuvole_molte_giorno.png';
  $txt_meteo = "Molto nuvoloso";
}else if($cloud > 600 && $cloud < 900){
  $ico_meteo = 'icone/nuvole_poche.png';
  $txt_meteo = "Leggermente nuvoloso";
}else if($cloud > 900 && $cloud < 1100){

  //if($f_crep > date('Hi') && date('Hi') > $i_crep){
  if (($now > $sunrise) && ($now < $sunset)) {

    $ico_meteo = 'icone/sole_nuvole.png';
    $txt_meteo = "Variabile";
  }else{
    $ico_meteo = 'icone/luna_nuvole.png';
    $txt_meteo = "Variabile";
  }

    //$ico_meteo = 'icone/sole_nuvole.png';
  //}else{
    //$ico_meteo = 'icone/luna_nuvole.png';

  //}
}else{
  //if(intval($f_crep) > intval(date('Hi')) && intval(date('Hi')) > intval($i_crep)){

  if (($now > $sunrise) && ($now < $sunset)) {

    $ico_meteo = 'icone/sole.png';
    $txt_meteo = "Soleggiato - ";
  }else{
    $ico_meteo = 'icone/luna.png';
    $txt_meteo = "Cielo limpido - ";
  }
    //$ico_meteo = 'icone/sole.png';

  //}else{
    //$ico_meteo = 'icone/luna.png';
  //}

}


####################################
#                                  #
#      Riconoscimento tendenza     #
#                                  #
####################################


if(($PressureMax - $PressureMin)>1.6){
  $diminuzione = ($PressureMax-$pressure);
  $aumento = ($pressure-$PressureMin);
  $tendency = ($diminuzione+$aumento);

  if($diminuzione > $aumento){
    $tendency = 0-$diminuzione;
  }else{
    $tendency = $aumento;
  }

}else{
  //pressione stabile
  $tendency = 1;
}

if($tendency>4){
    // |
    $ico_tendenza = 'icone/1.png';
    $txt_tendenza = "Tempo in forte miglioramento";
}else if($tendency<4 && $tendency>2){
    // /
    $ico_tendenza = 'icone/2.png';
    $txt_tendenza = "Tempo in miglioramento";

}else if($tendency<2 && $tendency>1.5){
    // /-
    $ico_tendenza = 'icone/3.png';
    $txt_tendenza = "Tempo in lieve miglioramento";

}else if($tendency<-1.5 && $tendency>-2){
    // \-
    $ico_tendenza = 'icone/5.png';
    $txt_tendenza = "Tempo in lieve peggioramento";

}else if($tendency<-2 && $tendency>-4){
    // \
    $ico_tendenza = 'icone/6.png';
    $txt_tendenza = "Tempo in peggioramento";

}else if($tendency<-4){
    // |
    $ico_tendenza = 'icone/7.png';
    $txt_tendenza = "Tempo in forte peggioramento";

}else {
    // -
    $ico_tendenza = 'icone/4.png';
    $txt_tendenza = "Tempo stabile";
    }


# tendeza 3h

$dim = ($press_max_3h-$press_3h);
$au = ($press_3h-$press_min_3h);
if($dim>$au){
  $trend = "-".$dim;
}else{
  $trend = "+".$au;
}


####################################
#                                  #
#     Riconoscimento del Vento     #
#                                  #
####################################

if($wind_dir_ave>22 && $wind_dir_ave<68){
  $wind_nome = "Grecale";
}else if($wind_dir_ave>67 && $wind_dir_ave<113){
  $wind_nome = "Levante";
}else if($wind_dir_ave>112 && $wind_dir_ave<158){
  $wind_nome = "Scirocco";
}else if($wind_dir_ave>157 && $wind_dir_ave<180 || $wind_dir_ave < -157 && $wind_dir_ave > -180){
  $wind_nome = "Ostro";
}else if($wind_dir_ave > -158 && $wind_dir_ave < -112){
  $wind_nome = "Libeccio";
}else if($wind_dir_ave > -113 && $wind_dir_ave < -67){
  $wind_nome = "Ponente";
}else if($wind_dir_ave > -68 && $wind_dir_ave < -22){
  $wind_nome = "Maestrale";
}else{
  $wind_nome = "Tramontana";
}

if($wind_ave<0.9){
  $wind_vel_tipo = "Calmo";
}else if($wind_ave>0.8 && $wind_ave<5.6){
  $wind_vel_tipo = "Bava di vento";
}else if($wind_ave>5.5 && $wind_ave<12.2){
  $wind_vel_tipo = "Brezza leggera";
}else if($wind_ave>12.1 && $wind_ave<19.7){
  $wind_vel_tipo = "Brezza tesa";
}else if($wind_ave>19.6 && $wind_ave<28.6){
  $wind_vel_tipo = "Vento moderato";
}else if($wind_ave>28.5 && $wind_ave<38.9){
  $wind_vel_tipo = "Vento teso";
}else if($wind_ave>38.8 && $wind_ave<49.9){
  $wind_vel_tipo = "Vento fresco";
}else if($wind_ave>49.8 && $wind_ave<61.8){
  $wind_vel_tipo = "Vento forte";
}else if($wind_ave>61.7 && $wind_ave<74.7){
  $wind_vel_tipo = "Burrasca";
}else if($wind_ave>74.6 && $wind_ave<88.1){
  $wind_vel_tipo = "Burrasca forte";
}else if($wind_ave>88.0 && $wind_ave<102.5){
  $wind_vel_tipo = "Tempesta";
}else if($wind_ave>102.4 && $wind_ave<117.1){
  $wind_vel_tipo = "Tempesta violenta";
}else {
  $wind_vel_tipo = "Uragano";
}

####################################
#                                  #
#       EXIF DATA Image Cam        #
#                                  #
####################################
if (file_exists($img_cam_path)) {
  $img_valid = true;
  /*if(exif_imagetype($img_cam_path) != IMAGETYPE_JPEG){
    $exifTimestamp = "GIF File";
    $img_valid = true;

  }else{

    if(exif_imagetype($img_cam_path)) {

      $exif_data = exif_read_data ($img_cam_path);
      $exifString = $exif_data['DateTimeOriginal'];
      $exifPieces = explode(":", $exifString);
      $newExifString = $exifPieces[0] . "-" . $exifPieces[1] . "-" . $exifPieces[2] . ":" .$exifPieces[3] . ":" . $exifPieces[4];
      $exifTimestamp = strtotime($newExifString);
      $img_valid = true;
    }else{
      $img_valid = false;
    }

  }*/
}
?>
