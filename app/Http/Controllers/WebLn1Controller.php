<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebLn1Controller extends Controller
{
    public function nuestras_tiendas()
    {
        return view('web_ln1.nuestras_tiendas');
    }

    public function modal_nuestras_tiendas($parametro)
    {
        $ruta = "web_ln1/img/";
        if($parametro==1){
			$tienda = "TUMBES";
			$ubicacion = "Av. Republica del Perú 213-Aguas Verdes";
			$como_llegar = "https://maps.google.com/?q=-3.4814522876979037,-80.24452722627535";
			$horario = "Lunes a Domingos de 09:30 a 21:00";
			$email = "nicolas_de_pierola@cajahuancayo.com.pe";
			$img = $ruta."Aguas-Verdes.jpg";
		}if($parametro==2){
			$tienda = "SULLANA";
			$ubicacion = "Av. José de Lama 17 - 19";
			$como_llegar = "https://maps.google.com/?q=-4.891783942334922,-80.685014005136";
			$horario = "Lunes a Domingos de 09:30 a 21:00";
			$email = "nicolas_de_pierola@cajahuancayo.com.pe";
			$img = $ruta."Sullana.jpg";
		}if($parametro==3){
			$tienda = "PIURA";
			$ubicacion = "Av. Grau 373 Esq. con Junín (Ex local Elektra)";
			$como_llegar = "https://maps.google.com/?q=-5.194106439763042,-80.62873320513343";
			$horario = "Lunes a Domingos de 09:30 a 21:00";
			$email = "nicolas_de_pierola@cajahuancayo.com.pe";
			$img = $ruta."Piura.jpg";
		}if($parametro==4){
			$tienda = "CAJAMARCA";
			$ubicacion = "Jr. Apurimac 971";
			$como_llegar = "https://maps.google.com/?q=-7.153274339702458,-78.51743176041657";
			$horario = "Lunes a Domingos de 09:30 a 21:00";
			$email = "nicolas_de_pierola@cajahuancayo.com.pe";
			$img = $ruta."Cajamarca1.jpg";
		}if($parametro==5){
			$tienda = "IQUITOS";
			$ubicacion = "Jr. Próspero 1010";
			$como_llegar = "https://maps.google.com/?q=-8.022785116805583,-74.49137808896037";
			$horario = "Lunes a Domingos de 09:30 a 21:00";
			$email = "nicolas_de_pierola@cajahuancayo.com.pe";
			$img = $ruta."Iquitos1.jpg";
		}if($parametro==6){
			$tienda = "CHICLAYO";
			$ubicacion = "Av. José Balta 1315";
			$como_llegar = "https://maps.google.com/?q=-6.767595275762239,-79.8381557186127";
			$horario = "Lunes a Domingos de 09:30 a 21:00";
			$email = "nicolas_de_pierola@cajahuancayo.com.pe";
			$img = $ruta."Chiclayo1.jpg";
		}if($parametro==7){
			$tienda = "TRUJILLO ZELA";
			$ubicacion = "Jr. Zela 212";
			$como_llegar = "https://maps.google.com/?q=-8.112157864602402,-79.02225494743361";
			$horario = "Lunes a Domingos de 09:30 a 21:00";
			$email = "nicolas_de_pierola@cajahuancayo.com.pe";
			$img = $ruta."Trujillo-Sela1.jpg";
		}if($parametro==8){
			$tienda = "TRUJILLO GAMARRA";
			$ubicacion = "Calle Gamarra 784";
			$como_llegar = "https://maps.google.com/?q=-8.112384468538124,-79.02453496663877";
			$horario = "Lunes a Domingos de 09:30 a 21:00";
			$email = "nicolas_de_pierola@cajahuancayo.com.pe";
			$img = $ruta."Trujillo-Gamarra.jpg";
		}if($parametro==9){
			$tienda = "CHIMBOTE";
			$ubicacion = "Jr. Leoncio Prado 560";
			$como_llegar = "https://maps.google.com/?q=-9.074272485981101,-78.5922859762576";
			$horario = "Lunes a Domingos de 09:30 a 21:00";
			$email = "nicolas_de_pierola@cajahuancayo.com.pe";
			$img = $ruta."Chimbote.jpg";
		}if($parametro==10){
			$tienda = "CHINCHA";
			$ubicacion = "Av. Oscar R. Benavides 351-Chincha Alta";
			$como_llegar = "https://maps.google.com/?q=-13.417005578379781,-76.13632513201864";
			$horario = "Lunes a Domingos de 09:30 a 21:00";
			$email = "nicolas_de_pierola@cajahuancayo.com.pe";
			$img = $ruta."Chincha2.jpg";
		}if($parametro==11){
			$tienda = "IQUITOS MALL";
			$ubicacion = "Av. Capitan Jose Abelardo Quiñones 1050 (2do Piso del Mall Aventura - Iquitos)";
			$horario = "Lunes a Domingos de 09:30 a 21:00";
			$email = "nicolas_de_pierola@cajahuancayo.com.pe";
			$como_llegar = "https://maps.google.com/?q=-3.7645198654562066,-73.26748051873834";
			$img = $ruta."Iquitos_Mall.jpeg";
		}if($parametro==12){
			$tienda = "TACNA";
			$ubicacion = "Av. San Martín 817 (1 cuadra de Plaza Zela)";
			$como_llegar = "https://maps.google.com/?q=-11.978529679458592,-76.99117433143287";
			$horario = "Lunes a Domingos de 09:30 a 21:00";
			$email = "nicolas_de_pierola@cajahuancayo.com.pe";
			$img = $ruta."Tacna.jpeg";
		}if($parametro==13){
			$tienda = "AREQUIPA";
			$ubicacion = "C. Mercaderes 324, Arequipa 04001";
			$como_llegar = "https://maps.google.com/?q=-16.399618511262627,-71.53370046080106";
			$horario = "Lunes a Domingos de 09:30 a 21:00";
			$email = "nicolas_de_pierola@cajahuancayo.com.pe";
			$img = $ruta."Arequipa1.jpg";
		}
        return view('web_ln1.modal_nuestras_tiendas',compact(
            'tienda',
            'ubicacion',
            'como_llegar',
            'horario',
            'email',
            'img'
        ));
    }
}
