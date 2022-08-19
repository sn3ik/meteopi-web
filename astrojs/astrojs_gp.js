//********************************************************************************************************
//********************************************************************************************************
//                                                                                                      //
//                                ASTROJS_Graphics versione 1.0                                         //
//                               *******************************                                        //
//                                                                                                      //
//                             Copyright by  SALVATORE RUIU (Italy)                                     //
//                                    http://www.suchelu.it                                             //
//                                  email: salruiu2008@gmail.com                                        //
//                            EFFETTI GRAFICI REALIZZATI CON ASTROJS                                    //
//                                                                                                      //
//********************************************************************************************************
//********************************************************************************************************
// Ultima modifica: 31-gennaio-2013 - LAST UPDATED.

// *******************************************************************************************************
// *****                FUNZIONE PRINCIPALE PER IL DISEGNO DELLA FASE LUNARE                       *******
// *******************************************************************************************************


function fasi(njd,rpx_luna,emisfero){
          // by Salvatore Ruiu Irgoli-Sardegna (Italy) gennaio 2010
         // funzione per il calcolo e il disegno della fase lunare.
        // njd= numero dei giorni giuliani per il T.U. di Greenwich.
       // rpx_luna= raggio in pixel dell'immagine della luna.
      // emisfero="N" O "S" emisfero terreste di riferimento.
     // data di riferimento per gli elementi orbitali 0.0 gennaio 1980.
    // ***** richiamare la funzione [function testo_fase(njd,emisfero)] per inserire il testo della fase lunare
   //  predisporre (nella pagina web i div "div_luna" e "luna" e utilizzare il file [astrocss.css]

 var Dati_luna=pos_luna(njd);   // recupero fase/elongazione (1)

 var Fase_luna =Dati_luna[3];   // fase lunare.
 var Elogazione=Dati_luna[4];   // elongazione in gradi sessadecimali.

 // DISEGNO DELLA FASE LUNARE     - INIZIO   (2)

 disegno_fase(Elogazione,rpx_luna,emisfero);

 // DISEGNO DELLA FASE LUNARE     - FINE

}

// *******************************************************************************************************
// *****                FUNZIONE PRINCIPALE PER IL DISEGNO DELLA FASE DI UN PIANETA                *******
// *******************************************************************************************************


function fasi_pianeti(njd,np,rpx_luna){

          // by Salvatore Ruiu Irgoli-Sardegna (Italy) gennaio 2012
          // funzione per il calcolo delle fasi lunari.
          // njd= numero dei giorni giuliani per il T.U. di Greenwich.
          // rpx_luna= raggio in pixel dell'immagine della luna.
          // predisporre (nella pagina web i div "div_luna" e "luna" e utilizzare il file [astrocss.css]

 var Dati_pianeta=pos_pianeti(njd,np);      // recupero dati del pianeta.

 var          fase= Dati_pianeta[2];        // elongazione in gradi sessadecimali.
 var   elongazione= Dati_pianeta[6]*1;      // elongazione in gradi sessadecimali.
 var   angolo_fase= Dati_pianeta[12]*1;     // angolo di fase del pianeta.

 if (elongazione<0) {angolo_fase=-angolo_fase; }

 disegno_fasep(angolo_fase,rpx_luna);      // disegno della fase del pianeta.

}

// ----------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------

function disegno_fase_lunare(njd,rpx_luna,emisfero) {

  // by Salvatore Ruiu Irgoli-Sardegna (Italy) gennaio 2012
  // disegna la fase lunare e la sovrappone all'immagine.
  // script per la distribuzione.

 var immagini =new Array;
 var immgineid=new Array;

 var angolo_fase=afase_luna(njd);                           // angolo di fase

 var raggio_luna=rpx_luna/2;                                // raggio della luna in pixel.
 var coseno_fase=Math.cos(Rad(angolo_fase));                //  coseno dell'angolo di fase.

 var originey=1;                   // origine delle linee di costruzione nell'asse y.
 var originex=0;
 var lunghezza_linea=0;            // lunghezza della linea di costruzione.
 var lunghezza_ombra=0;

 var c=-1;                         // numero riferimento array immagini.
 var x=0;

 // disegno della fase lunare per angoli compresi tra 0-180 gradi.

 for (x=raggio_luna; x>-raggio_luna; x--){

     c++;
     originey++;

     lunghezza_linea=raggio_luna+coseno_fase*Math.sqrt(raggio_luna*raggio_luna-x*x);
     lunghezza_linea=Math.ceil(lunghezza_linea);

     // emisfero nord

     if (angolo_fase>0   && emisfero=="N"){ originex=0;                lunghezza_ombra=2*raggio_luna-lunghezza_linea;}

else if (angolo_fase<0   && emisfero=="N"){ originex=lunghezza_linea;  lunghezza_ombra=2*raggio_luna-lunghezza_linea; }

     // emisfero sud

else if (angolo_fase>0   && emisfero=="S"){ originex=lunghezza_linea;  lunghezza_ombra=2*raggio_luna-lunghezza_linea; }

else if (angolo_fase<0   && emisfero=="S"){ originex=0;                lunghezza_ombra=2*raggio_luna-lunghezza_linea; }


  immagini[c]='<img id="idluna'+c+'" src="http://www.suchelu.it/astrojs/linea.png" width="'+lunghezza_ombra+'" height="1" alt="luna"/>';
  document.write(immagini[c]);
  immgineid[c]=document.getElementById('idluna'+c);
  immgineid[c].style.marginTop =originey+"px";
  immgineid[c].style.marginLeft=originex+"px";
 }

 }   // fine funzione

// ---------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------------

function disegno_fase(Elogazione,rpx_luna,emisfero) {
  // by Salvatore Ruiu Irgoli-Sardegna (Italy) gennaio 2012
 //  disegna la fase lunare e la sovrappone all'immagine.

 var immagini =new Array;
 var immgineid=new Array;

 var angolo_fase=Elogazione;                                       // angolo di elogazione o et� della luna.

 if (angolo_fase<0){angolo_fase=angolo_fase+360;}               // intervallo 0-360 gradi.

 var raggio_luna=rpx_luna;                                   // raggio della luna in pixel.
 var coseno_fase=Math.cos(angolo_fase/180*Math.PI);         //  coseno dell'angolo di fase.

 var originey=-1;                           // origine delle linee di costruzione nell'asse y.
 var originex=0;
 var lunghezza_linea=0;                     // lunghezza della linea di costruzione.
 var lunghezza_ombra=0;

 var c=-1;                                  // numero riferimento array immagini.
 var x=0;

 // disegno della fase lunare per angoli compresi tra 0-180 gradi.

 for (x=raggio_luna; x>-raggio_luna; x--){

     c++;
     originey++;

     lunghezza_linea=raggio_luna+coseno_fase*Math.sqrt(raggio_luna*raggio_luna-x*x);
     lunghezza_linea=Math.ceil(lunghezza_linea);

     // emisfero nord

     if (angolo_fase>=0  && angolo_fase<=180 && emisfero=="N"){ originex=0; lunghezza_ombra=lunghezza_linea;}                                 // angoli compresi tra 0-180 gradi.

else if (angolo_fase>180 && angolo_fase<360  && emisfero=="N"){ originex=2*raggio_luna-lunghezza_linea;  lunghezza_ombra=lunghezza_linea;  } // angoli compresi tra 180-360 gradi.

     // emisfero sud

else if (angolo_fase>=0  && angolo_fase<=180 && emisfero=="S"){ originex=2*raggio_luna-lunghezza_linea;  lunghezza_ombra=lunghezza_linea; }  // angoli compresi tra 0-180 gradi.

else if (angolo_fase>180 && angolo_fase<360  && emisfero=="S"){ originex=0;  lunghezza_ombra=lunghezza_linea;  }                             // angoli compresi tra 180-360 gradi.


  immagini[c]='<img id="idluna'+c+'" src="http://www.suchelu.it/astrojs/linea.png" width="'+lunghezza_ombra+'" height="1" alt="luna"/>';
  document.write(immagini[c]);
  immgineid[c]=document.getElementById('idluna'+c);
  immgineid[c].style.marginTop =originey+"px";
  immgineid[c].style.marginLeft=originex+"px";


 }


 }   // fine funzione



// funzione per il calcolo delle fasi lunari - fine

// ---------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------------

function disegno_fasep(angolo_fase,rpx_luna) {

    // by Salvatore Ruiu Irgoli-Sardegna (Italy) gennaio 2012
    // disegna la fase per i pianeti.

 var immagini =new Array;
 var immgineid=new Array;

 var raggio_luna=rpx_luna;                               // raggio della luna in pixel.
 var coseno_fase=Math.cos(Rad(Math.abs(angolo_fase)));   //  coseno dell'angolo di fase.

 var originey=-1;            // origine delle linee di costruzione nell'asse y.
 var originex=0;
 var lunghezza_linea=0;      // lunghezza della linea di costruzione.
 var lunghezza_ombra=0;

 var c=-1;                   // numero riferimento array immagini.
 var x=0;

 // disegno della fase lunare per angoli compresi tra 0-180 gradi.

 for (x=raggio_luna; x>-raggio_luna; x--){

     c++;
     originey++;

     lunghezza_linea=raggio_luna+coseno_fase*Math.sqrt(raggio_luna*raggio_luna-x*x);
     lunghezza_linea=Math.ceil(lunghezza_linea);

     if (angolo_fase>=0){ originex=0;   lunghezza_ombra=2*raggio_luna-lunghezza_linea; }   // angoli compresi tra 0-180 gradi.

else if (angolo_fase<0 ){ originex=lunghezza_linea; lunghezza_ombra=2*raggio_luna-lunghezza_linea; }   // angoli compresi tra 180-360 gradi.

  immagini[c]='<img id="idluna'+c+'" src="linea.png" width="'+lunghezza_ombra+'" height="1" alt="luna"/>';
  document.write(immagini[c]);
  immgineid[c]=document.getElementById('idluna'+c);
  immgineid[c].style.marginTop =originey+"px";
  immgineid[c].style.marginLeft=originex+"px";

 }

 }

// ---------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------------


function testo_fase(njd,emisfero){
  // testo da inserire nel box della fase lunare.
 //  versione con il testo in inglese;
//   emisfero "N" o "S"

 var Dati_luna=pos_luna(njd);        // recupero fase e elongazione
 var Fase_luna =Dati_luna[3]*100;    // percentuale fase lunare.
 var Elogazione=Dati_luna[4];        // elongazione in gradi sessadecimali.
 var E_luna= Elogazione   ;          // et� della luna in giorni.

 if (E_luna<0){E_luna=E_luna+360;}

     E_luna=E_luna/13;

     E_luna=E_luna.toFixed(0)+" Days";
     Fase_luna=Fase_luna.toFixed(0)+"%";

     if (emisfero=="S"){emisfero=" South ";}
   else  emisfero=" North ";

  var nome_fase=name_phase(Dati_luna[4],"ENG");  // nome della fase lunare.

     var dt_day=calcola_datan("ING");

         document.write('<div id="testi_luna">');
         document.write('<h3>MOON PHASES 1.0</h3>');
         document.write('<p><b>'+nome_fase+'</b></p>');
         document.write('<p>'+Fase_luna+' of Full  |  '+emisfero+'  |  Age:'+E_luna+'</p>');
         document.write('<p>Elong:'+Elogazione.toFixed(2)+' Deg. |  '+dt_day+'</p>');
         document.write('<p align="left"> by www.suchelu.it</p>');
         document.write('</div>');



}

// ----------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------

function testo_faseit(njd,emisfero){
  // testo da inserire nel box della fase lunare.
 //  versione con il testo in inglese;

 var Dati_luna=pos_luna(njd);        // recupero fase/elogazione
 var Fase_luna =Dati_luna[3]*100;    // percentuale fase lunare.
 var Elogazione=Dati_luna[4];        // elongazione in gradi sessadecimali.
 var E_luna= Elogazione   ;          // et� della luna in giorni.

 if (E_luna<0){E_luna=E_luna+360;}

     E_luna=E_luna/13;

     E_luna=E_luna.toFixed(0)+" Giorni";
     Fase_luna=Fase_luna.toFixed(0)+"%";

     if (emisfero=="S"){emisfero=" Sud ";}
   else emisfero=" Nord ";

   var nome_fase=name_phase(Dati_luna[4],"ITA");  // nome della fase lunare.

       var dt_day=calcola_datan("ITA");

         document.write('<div id="testi_luna">');
         document.write('<h3>MOON PHASES 1.0</h3>');
         document.write('<p><b>'+nome_fase+'</b></p>');
         document.write('<p>'+Fase_luna+'F.Illuminata  | '+emisfero+'  |  Et&agrave; :'+E_luna+'</p>');
         document.write('<p>Elong:'+Elogazione.toFixed(2)+' Gradi. |  '+dt_day+'</p>');
         document.write('<p align="left"> by www.suchelu.it</p>');
         document.write('</div>');


}

// ----------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------

//      FUNZIONE PER IL CALCOLO DELLA POSIZIONE DELLA POLARE IN UN GRAFICO  (POLARP)                             - INIZIO

function star_polar(long,raggiost,posx,posy){
         // funzione per il calcolo della posizione della stella polare
        //  by Salvatore Ruiu Irgoli-Sardegna (Italy). dicembre 2009
       //   il fuso orario della localit� � calcolato da calcola_jd()
      //    long: longitudine della localit� in gradi sessadecimali.
     //     raggiost: raggio in pixel del cerchio polare.
    //      posx,posy: coordinate in pixel del cerchio polare.

var pos_polare= 2.5301944;                                         // A.R. della stella polare in ore decimali.

var njd=calcola_jd();                                            // numero dei giorni giuliani della data in U.T.
var tempo_siderale_greenwich=temposid (njd);                    // tempo siderale di Greenwich.
var tempo_siderale_locale=TSL(tempo_siderale_greenwich,long);  // tempo siderale locale.

var angolo_orario=tempo_siderale_locale-pos_polare;          // angolo orario della polare.

if (angolo_orario>24){	 angolo_orario=angolo_orario-24;	 }
if (angolo_orario<0 ){	 angolo_orario=angolo_orario+24;	 }

    angolo_orario=(angolo_orario*15)/180*Math.PI;                         // angolo orario in radianti;
    origine_angolo_orario=angolo_orario;                                 // origine dell'angolo orario;

var raggio_px=raggiost;

var x=raggio_px*Math.cos(origine_angolo_orario)+posx;
var y=raggio_px*Math.sin(origine_angolo_orario)+posy;

var coordinate=new Array(x,y);

return   coordinate;  // restituisce i valori x,y in pixel della posizione.

}
// disegno PolarP

function f_polarex(Longitudine){

var stella=document.getElementById('star_polar22');

var coor=star_polar(Longitudine,40,92,93) ;

stella.style.marginTop= coor[0]+"px";
stella.style.marginLeft=coor[1]+"px";

document.write('<p><b><i><u>PolarP  1.0-2010</u></i></b></p>');


}

//      FUNZIONE PER IL CALCOLO DELLA POSIZIONE DELLA POLARE IN UN GRAFICO                                                  - FINE

// -------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------------------------------

//                            funzione per disegnare le fasi lunari del mese corrente             inizio

function draw_phases (fase,data){

        // by Salvatore Ruiu Irgoli-Sardegna (Italy) settembre 2010
        // funzione per disegnare le fasi lunari del mese corrente.

       if (fase==0)    {document.write("<div id='luna_fase1'><p class='testo_fasi'> <b>Luna Nuova:</b><br>"+data+"</p></div>");    }

  else if (fase==0.25) {document.write("<div id='luna_fase2'><p class='testo_fasi'> <b>Primo Quarto:</b><br>"+data+"</p></div>");  }

  else if (fase==0.50) {document.write("<div id='luna_fase3'><p class='testo_fasi'> <b>Luna Piena:</b><br>"+data+"</p></div>");    }

  else if (fase==0.75) {document.write("<div id='luna_fase4'><p class='testo_fasi'> <b>Ultimo Quarto:</b><br>"+data+"</p></div>");}

}


//                            funzione per disegnare le fasi lunari del mese corrente               fine




// ---------------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------------


function testo_fase_pianeti(njd,np){
  // testo da inserire nel box della fase lunare.
 //  versione con il testo in inglese;


 var dati_pianeta=pos_pianeti(njd,np);              // recupero fase e elongazione

 var   ar=sc_ore(dati_pianeta[0]);                  // ascensione retta.
 var   de=sc_angolo(dati_pianeta[1]);               // declinazione.
 var fase=dati_pianeta[2];                          // fase.
 var magn=dati_pianeta[3];                          // magnitudine.
 var dist=dati_pianeta[4];                          // distanza pianeta dalla terra
 var diam=dati_pianeta[5];                          // diametro apparente.

 var Elon=sc_angolo(dati_pianeta[6]);               // elongazione.
 var pos_el=" Est";

 var a_fase=dati_pianeta[12].toFixed(2);            // angolo di fase del pianeta.

 if (dati_pianeta[6]<0) {pos_el=" West"; }


 var costellazione=costell2(dati_pianeta[0]);

   if      (np==0){  nome_pianeta="Mercury"; }
   else if (np==1){  nome_pianeta="Venus";   }
   else if (np==3){  nome_pianeta="Mars";    }
   else if (np==4){  nome_pianeta="Jupiter";    }
   else if (np==5){  nome_pianeta="Saturn";    }
   else if (np==6){  nome_pianeta="Uranus";    }
   else if (np==7){  nome_pianeta="Neptune";    }


   // nome fase lunare   - fine


         document.write('<div id="testi_luna">');
         document.write('<h3><b>'+nome_pianeta+'</b></h3>');
         document.write("<p id='data_planet'>Date : </p>");
         document.write("<p>R. Ascension : "+ar+"<br>");
         document.write(" Declination.: "+de+"<br>");
         document.write(" Elongation: "+Elon+pos_el+"<br>");
         document.write(" Illuminated Fraction: "+fase+"<br>");
         document.write(" Phase angle: "+a_fase+"&deg; <br>");
         document.write(" Magnitude.: "+magn+"<br>");
         document.write(" Distance: "+dist.toFixed(5)+" A.U. <br>");
         document.write(" Diameter: "+diam.toFixed(2)+" arcsec. <br>");
         document.write(" Constellation.: "+costellazione+"</p>");

         document.write("<div id='div_chelu'> ");
         document.write("<a target='_blank' href='http://www.suchelu.it'>by www.suchelu.it</a>");
         document.write('</div>');
         document.write('</div>');

}

// ---------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------

function data_planet(){     var data=calcola_datan2("ING");     document.getElementById("data_planet").innerHTML=("Date: "+data);   }

// ---------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------


function disegno_eqt(yy) {

    // by Salvatore Ruiu Irgoli-Sardegna (Italy) gennaio 2012
    // disegna il grafico dell'equazione del tempo.

 var immagini =new Array;
 var immgineid=new Array;

 //var raggio_luna=rpx_luna;                               // raggio della luna in pixel.
 //var coseno_fase=Math.cos(Rad(Math.abs(angolo_fase)));   //  coseno dell'angolo di fase.

 var originey=0;            // origine delle linee di costruzione nell'asse y.
 var originex=0;
 var lunghezza_linea=0;      // lunghezza della linea di costruzione.
 var lunghezza_ombra=0;

 var c=-1;                   // numero riferimento array immagini.
 var x=0;

    var njd=calcola_jddata(1,1,yy,12,0,0);
        njd=njd-1;

    var njd_att=calcola_jdUT0()+0.5;  // mezzogiorno di oggi.


 // disegno della fase lunare per angoli compresi tra 0-180 gradi.

 for (x=0; x<366; x++){

     njd=njd+1; v_eqtempo=eq_tempo_data(yy,njd); v_eqtempo=v_eqtempo;

     c++;
     originex++;
     originey=191-v_eqtempo*10;
     lunghezza_ombra=353-originey;


  immagini[c]='<img id="idluna'+c+'" src="http://www.suchelu.it/astrojs/lineaeqt.png" width="1" height="'+lunghezza_ombra+'" alt="luna"/>';

  if(njd==njd_att)  { immagini[c]='<img id="idluna'+c+'" src="http://www.suchelu.it/astrojs/linear_eqt.png" width="1" height="'+lunghezza_ombra+'" alt="luna"/>';
                    }
  document.write(immagini[c]);
  immgineid[c]=document.getElementById('idluna'+c);
  immgineid[c].style.marginTop =originey+"px";
  immgineid[c].style.marginLeft=originex+"px";

 }

 }   // fine funzione

// ----------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------

function testo_eqt(yy){
  // testo da inserire nel box della fase lunare.
 //  versione con il testo in inglese;
//   emisfero "N" o "S"

   v_eqtempo=eq_tempo();

         document.write('<div id="testi_luna">');
         document.write('<h3>The Equation of Time '+yy+'</h3>');
         //document.write("<img src='images/ajs35.png' width='25' height='25' alt='astrojs'>");
         document.write("<a target='_blank' href='http://www.suchelu.it'>by www.suchelu.it - Astrojs 01: 2012</a>");
         document.write('</div>');

}


// ----------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------


function testo_fase_luna(njd,LG){

  //  testo da inserire nel box della fase lunare.
  //  versione con il testo in inglese;
  //  Gennaio 2012.

 var dati_pianeta=pos_luna(njd);                    // recupero fase e elongazione

 var   ar=   sc_ore(dati_pianeta[0]);               // ascensione retta.
 var   de=sc_angolo(dati_pianeta[1]);               // declinazione.
 var fase=dati_pianeta[3];                          // fase.
 var Elon=sc_angolo(dati_pianeta[4]);               // elongazione.
 var diam=dati_pianeta[6];                          // diametro apparente.
 var dist=dati_pianeta[7];                          // distanza pianeta dalla terra

 var a_fase=afase_luna(njd).toFixed(2);             // angolo di fase
 var pos_el=" Est";

 if (dati_pianeta[4]<0) {pos_el=" West"; }

 var costellazione=costell2(dati_pianeta[0]);

     fase=(fase*100).toFixed(1);
     fase=fase+"%";

 var nome_fase=name_phase(dati_pianeta[4],LG);  // nome della fase lunare.

         document.write('<div id="testi_luna">');
         document.write('<h3><b>'+nome_fase+'</b></h3>');
         //document.write("<p id='data_planet'>Date : </p>");
         document.write("<p>Right Ascension : "+ar+" : ");
         document.write(" Declination.: "+de+" : ");
         document.write(" Elongation: "+Elon+pos_el+"<br>");
         document.write(" Illuminated Fraction: "+fase+" : ");
         document.write(" Phase Angle: "+a_fase+"&deg; <br>");
         document.write(" Distance: "+dist+" Km. <br>");
         document.write(" Diameter: "+diam+" arcsec. <br>");
         document.write(" Constellation.: "+costellazione+"</p>");

         document.write('</div>');

}

// ---------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------


function lembo_b(ar1,de1,ar2,de2){

    var delta_ar=(ar1-ar2)*15;

    var y=Math.cos(Rad(de1))*Math.sin(Rad(delta_ar));
    var x=Math.cos(Rad(de2))*Math.sin(Rad(de1))-Math.sin(Rad(de2))*Math.cos(Rad(de1))*Math.cos(Rad(delta_ar));

    var a_lembo=quadrante(y,x);

    return a_lembo;

}

// ---------------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------


function lattea(njd,LAT,TSLoc) {

    // by Salvatore Ruiu Irgoli-Sardegna (Italy) gennaio 2012
    // disegna il grafico della via lattea
    // NODO=180
    // da verificare

 var immagini =new Array;
 var immgineid=new Array;

 var originey=0;            // origine delle linee di costruzione nell'asse y.
 var originex=0;
 var lunghezza_linea=0;      // lunghezza della linea di costruzione.
 var lunghezza_ombra=0;

 var c=-1;                   // numero riferimento array immagini.
 var x=0;
 var angolo=0;
 var lnodo=0;;

 if (LAT==0) {LAT=0.001; }   // per la latitudine uguale a zero.

 for (x=0; x<1000; x++){

      angolo=x*0.36; c++; originex=1000-x;

 if(LAT>0) {   lnodo=180-(TSLoc*15);
               originey=Math.atan(Math.cos(Rad(lnodo+angolo))/Math.tan(Rad(LAT)));
               originey=Rda(originey);
               originey=(90-originey)*2.77778;
               lunghezza_ombra=500-originey;
            }

 if(LAT<0) {   lnodo=180-ore_24(TSLoc+12)*15;
               origine=0;
               origine=Math.atan(Math.cos(Rad(lnodo+angolo))/Math.tan(Rad(LAT)));
               origine=Rda(origine);
               originey=0;
               lunghezza_ombra=500-(90-origine)*2.77778;
 }

  // disegna l'orizzonte locale.

  //immagini[c]='<img id="idluna'+c+'" src="http://www.suchelu.it/astrojs/lineaeqt.png" width="1" height="'+lunghezza_ombra+'" alt="luna"/>';
  //document.write(immagini[c]);
  //immgineid[c]=document.getElementById('idluna'+c);
  //immgineid[c].style.marginTop =originey+"px";
  //immgineid[c].style.marginLeft=originex+"px";

   immagini='<div id="linea'+c+'"></div>';
   document.write(immagini);
   immgineid=document.getElementById("linea"+c);
   immgineid.style.marginTop =originey+"px";
   immgineid.style.marginLeft=originex+"px";

   $("#linea"+c).css("width","1px").css("height",lunghezza_ombra+"px").css("background","black").css("position","absolute").css("opacity","0.40");

 }

 // inserire la linea verticale per indicare il Tempo Siderale Locale.

  //immagine_ts='<img id="tsl" src="http://www.suchelu.it/astrojs/linear_eqt.png" width="1" height="500" alt="luna"/>';

  originex=1000-(TSLoc*15)*2.77778;
  //document.write(immagine_ts);
  //immagineid_tsl=document.getElementById('tsl');
  //immagineid_tsl.style.marginTop ="0px";
  //immagineid_tsl.style.marginLeft=originex+"px";

   immagini='<div id="tsl"></div>';
   document.write(immagini);
   immgineid=document.getElementById("tsl");
   immgineid.style.marginTop ="0px";
   immgineid.style.marginLeft=originex+"px";

   $("#tsl").css("width","1px").css("height","500px").css("background","red").css("position","absolute").css("opacity","1.00");

  // inserire il simbolo e il testo per lo zenit.

  //immagine_zenit='<img id="zenit" src="http://www.suchelu.it/astrojs/zenit.png" width="4" height="4" alt="luna"/>';

  originex=1000-(TSLoc*15)*2.77778;
  // document.write(immagine_zenit);
  // immagineid_zenit=document.getElementById('zenit');
  // immagineid_zenit.style.marginTop =(90-LAT)*2.77778+"0px";
  // immagineid_zenit.style.marginLeft=originex-2+"px";

   immagini='<div id="zenit"></div>';
   document.write(immagini);
   immgineid=document.getElementById("zenit");
   immgineid.style.marginTop =(90-LAT)*2.77778-3+"px";
   immgineid.style.marginLeft=originex-2+"px";

   $("#zenit").css("width","4px").css("height","4px").css("background","red").css("position","absolute").css("opacity","0.60");

   immagini='<div id="zenit_text"></div>';
   document.write(immagini);
   immgineid=document.getElementById("zenit_text");
   immgineid.style.marginTop =(90-LAT)*2.77778-12+"px";
   immgineid.style.marginLeft=originex+5+"px";

   $("#zenit_text").css("color","red").css("position","absolute").text("(Zenit)").css("font-size","70%");


  //  posizione del sole

  pianeti_grafico(njd,c);

 }   // fine funzione

// ----------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------

function testo_lattea(TSLoc){
  // testo da inserire nel box della fase lunare.
 //  versione con il testo in inglese;

 document.write('<div id="azimut_testo1"><p>N<small>0&deg;</small></p></div>');
 document.write('<div id="azimut_testo2"><p>E<small>90&deg;</small></p></div>');
 document.write('<div id="azimut_testo3"><p>S<small>180&deg;</small></p></div>');
 document.write('<div id="azimut_testo4"><p>W<small>270&deg;</small></p></div>');

 var offset=-3;

 var p_nord=(1-ore_24(TSLoc+12)/24)*1000;
 var p_est= (1-ore_24(TSLoc+6 )/24)*1000;
 var p_sud= (1-ore_24(TSLoc   )/24)*1000;
 var p_west=(1-ore_24(TSLoc-6 )/24)*1000;

 document.write('<div id="testi_luna">');

document.write('<div id="azimut">');

    // posizione del Nord

    immgineid1=document.getElementById('azimut_testo1');
    immgineid1.style.marginTop ="495px";
    immgineid1.style.marginLeft=offset+p_nord+"px";

    // posizione del Est

    immgineid2=document.getElementById('azimut_testo2');
    immgineid2.style.marginTop ="495px";
    immgineid2.style.marginLeft=offset+p_est+"px";

    // posizione del Sud

    immgineid3=document.getElementById('azimut_testo3');
    immgineid3.style.marginTop ="495px";
    immgineid3.style.marginLeft=offset+p_sud+"px";

    // posizione del West

    immgineid4=document.getElementById('azimut_testo4');
    immgineid4.style.marginTop ="495px";
    immgineid4.style.marginLeft=offset+p_west+"px";

document.write('</div>');

        rif_topografici(TSLoc);

         //document.write("<p>Mappa della sfera celeste presa da Wikipedia</p>");
         document.write('<h3>La Sfera Celeste in questo istante</h3>');
         document.write("<img src='http://www.suchelu.it/images/ajs35.png' width='25' height='25' alt='astrojs'>");
         document.write("<a target='_blank' href='http://www.suchelu.it'>by Salvatore Ruiu - www.suchelu.it - Astrojs 01: 2012</a>");
         document.write('</div>');
}

// ----------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------

function rif_topografici(TSLoc){



 document.write('<div id="azimut_cime_testo1"><p><small>M. Senes</small></p></div>');
 document.write('<div id="azimut_cime_testo2"><p><small>M. Oddie</small></p></div>');
 document.write('<div id="azimut_cime_testo3"><p><small>Sa Fraigada</small></p></div>');
 document.write('<div id="azimut_cime_testo4"><p><small>M. Tuttavista</small></p></div>');
 document.write('<div id="azimut_cime_testo5"><p><small>Pontesu</small></p></div>');


 document.write('<div id="azimut_cime">');

 // azimut dei riferimenti topografici in ore decimali.

 var rif1=  11/15;
 var rif2=  50/15;
 var rif3= 138/15;
 var rif4= 179/15;
 var rif5= 337/15;

 var offset=-3;

 //var origine=(1-ore_24(TSLoc+12)/24)*1000;

 var p1=(1-ore_24(TSLoc+12-rif1)/24)*1000;
 var p2=(1-ore_24(TSLoc+12-rif2)/24)*1000;
 var p3=(1-ore_24(TSLoc+12-rif3)/24)*1000;
 var p4=(1-ore_24(TSLoc+12-rif4)/24)*1000;
 var p5=(1-ore_24(TSLoc+12-rif5)/24)*1000;

// posizione del Nord

    immgineid1=document.getElementById('azimut_cime_testo1');
    immgineid1.style.marginTop ="-15px";
    immgineid1.style.marginLeft=offset+p1+"px";

// posizione del Nord

    immgineid2=document.getElementById('azimut_cime_testo2');
    immgineid2.style.marginTop ="-15px";
    immgineid2.style.marginLeft=offset+p2+"px";

// posizione del Nord

    immgineid3=document.getElementById('azimut_cime_testo3');
    immgineid3.style.marginTop ="-15px";
    immgineid3.style.marginLeft=offset+p3+"px";

// posizione del Nord

    immgineid4=document.getElementById('azimut_cime_testo4');
    immgineid4.style.marginTop ="-15px";
    immgineid4.style.marginLeft=offset+p4+"px";

    immgineid5=document.getElementById('azimut_cime_testo5');
    immgineid5.style.marginTop ="-15px";
    immgineid5.style.marginLeft=offset+p5+"px";

document.write('</div>');

}



function pianeti_grafico(njd,c){

    //

    var  immagini=new Array;
    var immgineid=new Array;
    var  eff_sole=new Array;

  c=c+1; immagini[c]='<img id="idluna'+c+'" src="sol.png" width="10" height="10" />'; eff_sole=pos_sole(njd);  draw_planet(eff_sole[0],eff_sole[1],immagini[c],c);
  c=c+1; immagini[c]='<img id="idluna'+c+'" src="lun.png" width="10" height="10" />'; eff_sole=pos_luna(njd);  draw_planet(eff_sole[0],eff_sole[1],immagini[c],c);

  c=c+1; immagini[c]='<img id="idluna'+c+'" src="mer.png" width="10" height="10" />'; eff_sole=pos_pianeti(njd,0);  draw_planet(eff_sole[0],eff_sole[1],immagini[c],c);
  c=c+1; immagini[c]='<img id="idluna'+c+'" src="ver.png" width="10" height="10" />'; eff_sole=pos_pianeti(njd,1);  draw_planet(eff_sole[0],eff_sole[1],immagini[c],c);
  c=c+1; immagini[c]='<img id="idluna'+c+'" src="mar.png" width="10" height="10" />'; eff_sole=pos_pianeti(njd,3);  draw_planet(eff_sole[0],eff_sole[1],immagini[c],c);
  c=c+1; immagini[c]='<img id="idluna'+c+'" src="jup.png" width="10" height="10" />'; eff_sole=pos_pianeti(njd,4);  draw_planet(eff_sole[0],eff_sole[1],immagini[c],c);
  c=c+1; immagini[c]='<img id="idluna'+c+'" src="sat.png" width="10" height="10" />'; eff_sole=pos_pianeti(njd,5);  draw_planet(eff_sole[0],eff_sole[1],immagini[c],c);
  c=c+1; immagini[c]='<img id="idluna'+c+'" src="ura.png" width="10" height="10" />'; eff_sole=pos_pianeti(njd,6);  draw_planet(eff_sole[0],eff_sole[1],immagini[c],c);
  c=c+1; immagini[c]='<img id="idluna'+c+'" src="net.png" width="10" height="10" />'; eff_sole=pos_pianeti(njd,7);  draw_planet(eff_sole[0],eff_sole[1],immagini[c],c);

  c=c+1; immagini[c]='<img id="idluna'+c+'" src="plu.png" width="10" height="10" />'; draw_planet(18.43,-19.34,immagini[c],c);
  //c=c+1; immagini[c]='<img id="idluna'+c+'" src="com.png" width="10" height="10" />'; draw_planet(8.43,59.34,immagini[c],c);




function draw_planet(ar,de,immagine){

  var originex=1000-ar*15*2.77778;
  var originey= 247-de*2.77778;
  document.write(immagine);
  immgineid=document.getElementById('idluna'+c);
  immgineid.style.marginTop =(originey-2)+"px";
  immgineid.style.marginLeft=(originex-5)+"px";}
}

// ***************************************************************************************************************************************************************
// ***************************************************************************************************************************************************************
// ***************************************************************************************************************************************************************
// ***************************************************************************************************************************************************************


function I_flat(dimx,dimy,colore,trasparenza){

    //var   bboard='<div id="blackboard"></div>';

    var assex='<div id="assex"></div>';
    var assey='<div id="assey"></div>';

    //document.write(bboard);
    document.write( assex);
    document.write( assey);

    //$("#blackboard").css("width",dimx+"px").css("height",dimy+"px").css("background",colore+"").css("opacity",trasparenza+"").css("position","absolute");

    var Lx=dimx/2;
    var Ly=dimy/2;

    $("#assex").css("top",  Ly+"px").css("width",dimx+"px").css("height","1px"    ).css("background","red").css("position","absolute").css("opacity",trasparenza+"");
    $("#assey").css("left", Lx+"px").css("width","1px"    ).css("height",dimy+"px").css("background","red").css("position","absolute").css("opacity",trasparenza+"");


}

function I_axy(colore){

    // by Salvatore Ruiu Irgoli-Sardegna (Italy) settembre 2012
    // disegna gli assi coordinati x e y.

    var assex='<div id="assex"></div>';    document.write( assex);
    var assey='<div id="assey"></div>';    document.write( assey);

    var dimx=parseInt($("#blackboard").css("width"));      // recupera la larghezza del div #blackboard.
    var dimy=parseInt($("#blackboard").css("height"));     // recupera l'altezza    del div #blackboard.

    var Lx=dimx/2;
    var Ly=dimy/2;

    $("#assex").css("top",  Ly+"px").css("width",dimx+"px").css("height","1px"    ).css("background",colore).css("position","absolute");
    $("#assey").css("left", Lx+"px").css("width","1px"    ).css("height",dimy+"px").css("background",colore).css("position","absolute");

}

function I_ax(y,colore){

    // by Salvatore Ruiu Irgoli-Sardegna (Italy) settembre 2012
    // disegna una linea di costruzione (x).

    var dimx=parseInt($("#blackboard").css("width"));      // recupera la larghezza del div #blackboard.
    var dimy=parseInt($("#blackboard").css("height"));     // recupera l'altezza    del div #blackboard.

    var assex='<div id="assexx"></div>';  document.write( assex);

    var Ly=(dimy/2)-y;

    $("#assexx").css("top",  Ly+"px").css("width",dimx+"px").css("height","1px"    ).css("background",colore).css("position","absolute");
}

function I_ay(x,colore){

    // by Salvatore Ruiu Irgoli-Sardegna (Italy) settembre 2012
    // disegna una linea di costruzione (y).

    var dimx=parseInt($("#blackboard").css("width"));      // recupera la larghezza del div #blackboard.
    var dimy=parseInt($("#blackboard").css("height"));     // recupera l'altezza    del div #blackboard.

    var assex='<div id="asseyy"></div>';  document.write( assex);

    var Lx=x+dimx/2;

    $("#asseyy").css("left", Lx+"px").css("width","1px"    ).css("height",dimy+"px").css("background",colore).css("position","absolute");
}

// ************************************************************************ INSERIMENTO DI UN PUNTO ( inizio )

function I_point(x,y,colore,nid){

     // by Salvatore Ruiu Irgoli-Sardegna (Italy) settembre 2012
     // funzione per l'inserimento di un punto all'interno del grafico.
     // x , y  : coordinate in pixel, con origine al centro.
     // colore : colore del punto.
     // nid    : riferimento id.
     // ultima verifica: 07:01:2013

     var dimx=parseInt($("#blackboard").css("width"));      // recupera la larghezza del div #blackboard.
     var dimy=parseInt($("#blackboard").css("height"));     // recupera l'altezza    del div #blackboard.

     var originex=(dimx/2)+x;
     var originey=(dimy/2)-y;

     var immaginid='<div id="'+nid+'"></div>';   document.write(immaginid);

     immgineid=document.getElementById(""+nid);
     immgineid.style.marginLeft=originex+"px";
     immgineid.style.marginTop =originey+"px";

     $("#"+nid).css("width","1px").css("height","1px").css("background",colore+"").css("position","absolute");

}

// **************************************************************************** INSERIMENTO DI UN PUNTO ( fine )

// ************************************************************************ INSERIMENTO DI UN POLIGONO REGOLARE ( inizio )

function I_polig(x,y,lx,ly,nid){

     // by Salvatore Ruiu Irgoli-Sardegna (Italy) gennaio 2013
     // funzione per l'inserimento di un punto all'interno del grafico.
     // x , y    : coordinate in pixel, con origine al centro.
     // lx , ly  : dimensioni in pixel dei lati del poligono
     // nid    : riferimento id.
     // ultima verifica: 07:01:2013

     var dimx=parseInt($("#blackboard").css("width"));      // recupera la larghezza del div #blackboard.
     var dimy=parseInt($("#blackboard").css("height"));     // recupera l'altezza    del div #blackboard.

     var originex=(dimx/2)+x;
     var originey=(dimy/2)-y;

     var immaginid='<div id="'+nid+'"></div>';   document.write(immaginid);

     immgineid=document.getElementById(""+nid);
     immgineid.style.marginLeft=originex+"px";
     immgineid.style.marginTop =originey+"px";

     $("#"+nid).css("width",lx+"px").css("height",ly+"px").css("background","red").css("position","absolute");

}

// **************************************************************************** INSERIMENTO DI UN POLIGONO REGOLARE ( fine )


function I_text(testo,x,y,colore,text_nid){

     // funzione per l'inserimento di un testo all'interno del grafico.
     // testo: stringa di testo da inserire.
     // x,y: coordinate in pixel, con origine al centro.
     // text_nid: riferimento id del tag testo.

     var dimx=parseInt($("#blackboard").css("width"));      // recupera la larghezza del div #blackboard.
     var dimy=parseInt($("#blackboard").css("height"));     // recupera l'altezza    del div #blackboard.

     var originex=(dimx/2)+x*1;
     var originey=(dimy/2)-y*1;

     var immaginid='<p id="'+text_nid+'">'+testo+'</p>';   document.write(immaginid);

     immgineid=document.getElementById(text_nid);
     immgineid.style.marginLeft=originex+"px";
     immgineid.style.marginTop =originey+"px";

     $("#"+text_nid).css("position","absolute").css("color",colore+"");

}

// ************************************************************************ INSERIMENTO DI UNA IMMAGINE ( inizio )

function I_images(pos,x,y,nid){

     // funzione per l'inserimento di un'immagine all'interno del grafico.
     // pos: posizione e nome del file immagine.
     // x,y: coordinate in pixel, con origine al centro di #blackboard.
     // nid: riferimento id del tag immagine.
     // ultima verifica: 07:01:2013

     var dimx=parseInt($("#blackboard").css("width"));      // recupera la larghezza del div #blackboard.
     var dimy=parseInt($("#blackboard").css("height"));     // recupera l'altezza    del div #blackboard.

     var originex=(dimx/2)+x*1;
     var originey=(dimy/2)-y*1;

         immagine='<img id="'+nid+'" src="'+pos+'" alt="immagine"/>';
         document.write(immagine);
         immgineid=document.getElementById(''+nid);
         immgineid.style.marginTop =originey+"px";
         immgineid.style.marginLeft=originex+"px";

    $("#"+nid).css("position","absolute");

}

// ************************************************************************ INSERIMENTO DI UNA IMMAGINE ( fine )

// ************************************************************************ INSERIMENTO DI UNA IMMAGINE ( inizio )

function I_imagesc(pos,x,y,dx,dy,nid){

     // funzione per l'inserimento di un'immagine all'interno del grafico.
     // pos: posizione e nome del file immagine.
     // x,y: coordinate in pixel, con origine delle coordinate al centro di #blackboard.
     // dx,dy: dimensioni in pixel dell'immagine.
     // nid: riferimento id del tag immagine.
     // fa coincidere il centro dell'immagine sul punto x,y.
     // ultima verifica: 20:01:2013

     var dimx=parseInt($("#blackboard").css("width"));      // recupera la larghezza del div #blackboard.
     var dimy=parseInt($("#blackboard").css("height"));     // recupera l'altezza    del div #blackboard.

     var originex=((dimx/2)+x*1)-(dx/2);
     var originey=((dimy/2)-y*1)-(dy/2);

         immagine='<img id="'+nid+'" src="'+pos+'" width="'+dx+'" height="'+dy+'" alt="immagine"/>';
         document.write(immagine);
         immgineid=document.getElementById(''+nid);
         immgineid.style.marginTop =originey+"px";
         immgineid.style.marginLeft=originex+"px";

    $("#"+nid).css("position","absolute");

}

// ************************************************************************ INSERIMENTO DI UNA IMMAGINE ( fine )


function I_move(nid,x,y){

     // funzione per spostare un elemento presente nel grafico.

     var dimx=parseInt($("#blackboard").css("width"));      // recupera la larghezza del div #blackboard.
     var dimy=parseInt($("#blackboard").css("height"));     // recupera l'altezza    del div #blackboard.

     var originex=(dimx/2)+x*1;
     var originey=(dimy/2)-y*1;

         immgineid=document.getElementById(''+nid);
         immgineid.style.marginTop =originey+"px";
         immgineid.style.marginLeft=originex+"px";

    $("#"+nid).css("position","absolute");

}

// *************************************************************************************************** cerchio

function I_circle(x,y,r,colore,nid){

     // funzione per l'inserimento di un cerchio all'interno del grafico.

 for(an=0; an<360; an++){

      x1=x+r*Math.cos(Rad(an));
      y1=y+r*Math.sin(Rad(an));

      I_point(x1,y1,colore,nid+an);
}
}

// *************************************************************************************************** cerchio

function I_ellipse(x,y,r1,r2,colore,nid){

     // funzione per l'inserimento di un cerchio all'interno del grafico.

 var scalay=r2/r1;

 for(an=0; an<360; an++){

      x1=x+r1*Math.cos(Rad(an));
      y1=y+r1*Math.sin(Rad(an))*scalay;

      I_point(x1,y1,colore,nid+an);
}
}


// *************************************************************************************************** disco

function I_line(x1,y1,x2,y2,colore,nid,step){

     // funzione per l'inserimento di una linea all'interno del grafico.

 var m=(y2-y1)/(x2-x1);
 var q=y1-m*x1;

 var an=1;

 if(step==0 || step==undefined) {step=1;}

 //if(Math.abs(x1-x2)<30) {step=0.1; }
 //if(Math.abs(x1-x2)<10) {step=0.01; }

 if(x1<x2) { for(x=x1; x<x2; x=x+step){  an=an+1; y=m*x+q;    I_point(x,y,colore,nid+an);} }

 if(x1>x2) { for(x=x2; x<x1; x=x+step){  an=an+1; y=m*x+q;    I_point(x,y,colore,nid+an);} }

}

// *************************************************************************************************** disco

function I_linepl(x1,y1,dist,angolo,colore,nid,step){

     // funzione per l'inserimento di una linea con coordinate polari all'interno del grafico.

 var x2=dist*Math.cos(Rad(angolo));
 var y2=dist*Math.sin(Rad(angolo));

 var m=(y2-y1)/(x2-x1);
 var q=y1-m*x1;

 var an=1;

 if(step==0 || step==undefined) {step=1;}

 //if(Math.abs(x1-x2)<30) {step=0.1; }
 //if(Math.abs(x1-x2)<10) {step=0.01; }

 if(x1<x2) { for(x=x1; x<x2; x=x+step){  an=an+1; y=m*x+q;    I_point(x,y,colore,nid+an);} }

 if(x1>x2) { for(x=x2; x<x1; x=x+step){  an=an+1; y=m*x+q;    I_point(x,y,colore,nid+an);} }

}

// *************************************************************************************************** disco

// ************************* CALCOLI DI POSIZIONE SEMPLIFICATI PER I PIANETI (da utilizzare nelle animazioni)

function eq_kepleroAN(M,ecc_orbita){

          // by Salvatore Ruiu Irgoli-Sardegna (Italy) gennaio 2013
         // funzione per il calcolo semplificato dell'equazione di Keplero.
        // M= anomalia media in gradi sessadecimali.
       // ecc_orbita= eccentricit� dell'orbita.
      // Math.abs  restituisce il valore assoluto.

    M=M/180*Math.PI;
var E=M;
var E1=M;
var delta_E=1;

while (delta_E>0.001){

 E=E1;
 E1=M+ecc_orbita*Math.sin(E);

 delta_E=Math.abs(E-E1);   // calcola il valore assoluto del numero.

}

 var anomalia_vera1= Math.sqrt((1+ecc_orbita)/(1-ecc_orbita));
 var anomalia_vera2= anomalia_vera1*Math.tan(E/2);
 var anomalia_vera = 2*Math.atan(anomalia_vera2);    // in radianti.

 var anomalie=new Array(E,anomalia_vera);            // in radianti.

return anomalie;

}

// funzione per il calcolo semplificato dell'equazione di Keplero  -  fine

// ----------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------

function p_planetgh(njd,np){

    // calcola la posizione dei pianeti per realizzare il grafico animato
    // la funzione restituisce la lunghezza del raggio vettore e la longitudine eliocentrica del pianeta.
    // realizzata: gennaio 2013

    // definizione variabili:

    var nplanet=new Array(  "Mercury",     "Venus",    "Earth",   "Mars"   ,   "Jupiter",    "Saturn",     "Uranus",    "Neptune",     "Pluto");
    var      PP=new Array(  0.2408500,   0.6152100,  1.0000400,   1.8808900,  11.8622400,  29.4577100,   84.0124700,  164.7955800,   250.90000);
    var      LE=new Array(231.2973000, 355.7335200, 98.8335400, 126.3078300, 146.9663650, 165.3222420,  228.0708551,  260.3578998,   209.43900);
    var       W=new Array( 77.1442128, 131.2895792, 102.596403, 335.6908166,  14.0095493,  92.6653974,  172.7363288,   47.8672148,   222.97200);
    var      ec=new Array(  0.2056306,   0.0067826,   0.016718,   0.0933865,   0.0484658,   0.0556155,    0.0463232,    0.0090021,     0.25387);
    var       A=new Array(  0.3870986,   0.7233316,    1.00000,   1.5236883,   5.2025610,   9.5547470,   19.2181400,   30.1095700,    39.78459);
    var       i=new Array(  7.0043579,   3.3944350,    0.00000,   1.8498011,   1.3041819,   2.4893741,    0.7729895,    1.7716017,    17.13700);
    var      NO=new Array( 48.0941733,  76.4997524,    0.00000,  49.4032001, 100.2520175, 113.4888341,   73.8768642,  131.5606494,   109.94100);


   var d=njd-2444238.5;                                                    // numeri di giorni trascorsi dallo 0.0 gennaio 1980.

   var M=(360/365.2422)*(d/PP[np])+LE[np]-W[np];                           // Anomalia media.
   var M= gradi_360(M);                                                    // anomalia all'interno dell'intervallo 0� - 360�

   var av=eq_kepleroAN(M,ec[np]);                   // anomalia vera in radianti EQUAZIONE DI KEPLERO ( calcolo semplificato).

   var rv=A[np]*(1-ec[np]*Math.cos(av[0]));         // raggio vettore del pianeta: av[0]=E � gi� in radianti.

   var  v=Rda(av[1]);                               // anomalia vera in gradi.

   var Le=v+W[np];                                  // longitudine eliocentrica del pianeta.

       Le=gradi_360(Le);                            // longitudine eliocentrica del pianeta all'interno dell'intervallo 0� - 360�.

   var datip=new Array (rv,Le);

 return datip;


}

//***********************************************************************************************************************************
//***********************************************************************************************************************************


// ----------------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------
//                                                           ORBITA ELLITTICA (per le animazioni)                            - INIZIO
// ----------------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------

function elliptic_orbitAN(njd,njp,W,LNOD,e,n,a){

    // funzione per il calcolo di un'orbita ellittica.
    // by Salvatore Ruiu Irgoli-Sardegna (Italy) maggio 2012.
    // parametri dell'orbita:
    //  njd=giorno giuliano della data.
    //  njp=giorno giuliano del passaggio del pianeta al perielio.
    //    W=argomento del perielio.
    // LNOD= longitudine del nodo ascendente.
    //    e=eccentricit�.
    //    n=velocit� giornaliera del pianeta in gradi.
    //    a=semiasse maggiore in UA.
    // note: Longitudine del perielio=W+LNOD.


    var M=(njd-njp)*n;          // anomalia media in gradi, per la data.
        M=gradi_360(M);         // anomalia all'interno dell'intervallo 0� - 360�

   // ****************************************************** EQUAZIONE DI KEPLERO

    var av=eq_kepleroAN(M,e);               // anomalia vera in radianti (calcolo semplificato).

    var rv=a*(1-e*Math.cos(av[0]));         // raggio vettore del pianeta: av[0]=E � gi� in radianti.

    var  v=Rda(av[1]);                      // anomalia vera in gradi.

    var U=v+W;                              // argomento di Latitudine.

    var LL=U+LNOD;                          // longitudine eliocentrica

    var dati=new Array (rv,LL);                        // risultati: angolo polare e separazione angolare in secondi d'arco.

    return dati;


}

// ----------------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------
//                                                           ORBITA ELLITTICA  (per le animazioni)                             - FINE
// ----------------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------



// ***************************************************************************************************************************************************************
// ***************************************************************************************************************************************************************
// ***************************************************************************************************************************************************************
// ***************************************************************************************************************************************************************
