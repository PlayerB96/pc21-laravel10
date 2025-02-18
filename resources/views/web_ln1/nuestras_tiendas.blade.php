<!DOCTYPE html>
<html>

<head>
  <title>Redes de Tiendas</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="icon" type="image/png" href="{{ asset('web_ln1/img/favicon.png') }}" sizes="16x16">
  <link href="{{ asset('web_ln1/assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('web_ln1/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('web_ln1/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('web_ln1/assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
</head>

<style>
  @font-face {
    font-family: Poppins;
    src: url("{{ asset('web_ln1/POPPINS.TTF') }}");
  }

  html,
  body {
    height: 100%;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
    font-family: Poppins;
  }

  .home {
    display: flex;
    flex-wrap: wrap;
  }

  .in-flex {
    flex: 1;
    padding: 25px;
    min-width: 250px;
  }

  #map {
    height: 500px;
    width: 64%;
    float: right;
    margin-right: 6px;
    margin-left: 6px;
    margin-top: 50px;
  }

  #cabecera {
    text-align: center;
    color: #084254;
    font-weight: bold;
    font-size: 35px;
    font-family: Poppins;
  }

  .popup-bubble {
    position: absolute;
    top: 20;
    left: 0;
    transform: translate(-25%, -100%);
    background-color: white;
    padding: 5px;
    border-radius: 5px;
    overflow-y: auto;
    max-height: 60px;
  }

  .popup-bubble-anchor {
    background-image: url("{{ asset('web_ln1/img/ubicacion.png') }}");
    position: absolute;
    width: 100%;
    bottom: 8px;
    left: 0;
  }

  .popup-bubble-anchor::after {
    position: absolute;
    top: 0;
    left: 0;
    transform: translate(-50%, 0);
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 8px solid white;
  }

  .popup-container {
    cursor: auto;
    height: 0;
    position: absolute;
    width: 200px;
  }

  #content1,
  #content2,
  #content3,
  #content4,
  #content5,
  #content6,
  #content7,
  #content8,
  #content9,
  #content10,
  #content11,
  #content12,
  #content13 {
    align-items: center;
    display: flex;
    justify-content: center;
    color: #7a7a7a;
    font-size: 1.2rem;
    background: #ffffff00;
    overflow-x: hidden;
    overflow-y: auto;
    letter-spacing: 0.0312rem;
    font-weight: bold;
    cursor: pointer;
    font-family: Poppins;
  }

  table {
    padding: inherit;
  }

  table tbody tr td {
    border-radius: 20px;
    font-family: Poppins;
    background-color: #00afef;
    border: #f1f2f3 5px solid;
    padding: 4px;
    cursor: pointer;
  }
</style>

<body>
  <div id="load_screen">
    <div class="loader">
      <div class="loader-content">
        <div class="spinner-grow align-self-center">
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="ModalTiendas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      </div>
    </div>
  </div>
  <section class="home">
    <div id="mapr" class="in-flex">
      <div id="cabecera">
        <span><b>Nuestras Tiendas</b></span><br>
      </div>
      <table align="center" style="height: 90%;border-radius: 20px;">
        <tbody style="font-size:23px;color:white">
          <tr align="center" style="line-height: 27pt;">
            <td id="mtumbes" class="pintar_boton"
            onclick="Buscar_Tienda('-3.4817612073323354', '-80.24454171848888',1)">
              <span>
                <b>TUMBES</b>
              </span>
            </td>
            <td id="msullana" class="pintar_boton" 
            onclick="Buscar_Tienda('-4.892087716290082', '-80.68480635918314',2)">
              <span>
                <b>SULLANA</b>
              </span>
            </td>
          </tr>

          <tr align="center" style="line-height: 27pt;">
            <td id="mpiura" class="pintar_boton" 
            onclick="Buscar_Tienda('-5.195876724789404', '-80.6289884448477',3)">
              <span>
                <b>PIURA</b>
              </span>
            </td>
            <td id="mcajamarca" class="pintar_boton" 
            onclick="Buscar_Tienda('-7.154473850703116', '-78.51748933834115',4)">
              <span>
                <b>&nbsp;CAJAMARCA&nbsp;</b>
              </span>
            </td>
          </tr>

          <tr align="center" style="line-height: 27pt;">
            <td id="miquitos1" class="pintar_boton" 
            onclick="Buscar_Tienda('-3.757655959835168', '-73.24855506327688',5)">
              <span>
                <b>IQUITOS</b>
              </span>
            </td>
            <td id="mchiclayo" class="pintar_boton" 
            onclick="Buscar_Tienda('-6.767756900294341', '-79.83804701178121',6)">
              <span>
                <b>CHICLAYO</b>
              </span>
            </td>
          </tr>

          <tr align="center" style="line-height: 19pt;">
            <td id="mtrujilloz" class="pintar_boton" 
            onclick="Buscar_Tienda('-8.112362716258593', '-79.02216973912667',7)">
              <span>
                <b>TRUJILLO</b><br>
                <b style="font-size:14px">ZELA</b>
              </span>
            </td>
            <td id="mtrujillog" class="pintar_boton" 
            onclick="Buscar_Tienda('-8.112817626644446', '-79.02440561252065',8)">
              <a>
                <span>
                  <b>TRUJILLO</b><br>
                  <b style="font-size:14px">GAMARRA</b>
                </span></a>
            </td>
          </tr>

          <tr align="center" style="line-height: 27pt;">
            <td id="mchimbote" class="pintar_boton" 
            onclick="Buscar_Tienda('-9.074445152674972', '-78.59215076419024',9)">
              <span>
                <b>&nbsp;CHIMBOTE&nbsp;</b>
              </span>
            </td>
            <td id="mchincha" class="pintar_boton" 
            onclick="Buscar_Tienda('-13.417191766356806', '-76.13629598876966',10)">
              <span>
                <b>CHINCHA</b>
              </span>
            </td>
          </tr>

          <tr align="center" style="line-height: 19pt;">
            <td id="miquitos2" class="pintar_boton" 
            onclick="Buscar_Tienda('-3.7647522161689886', '-73.26746407674052',11)">
              <span>
                <b>IQUITOS</b><br>
                <b style="font-size:14px">MALL</b>
              </span>
            </td>
            <td id="mtacna" class="pintar_boton" 
            onclick="Buscar_Tienda('-18.010842485047586', '-70.24678646623904',12)">
              <span>
                <b>TACNA</b>
              </span>
            </td>
          </tr>

          <tr align="center" style="line-height: 27pt;">
            <td id="marequipa" class="pintar_boton" 
            onclick="Buscar_Tienda('-16.399505215267038', '-71.53343966324768',13)">
              <span>
                <b>AREQUIPA</b>
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div id="map" class="in-flex">
    </div>
  </section>
  <script src="{{ asset('web_ln1/docs/js/jquery-3.2.1.min.js') }}"></script>
  <script src="{{ asset('web_ln1/assets/js/loader.js') }}"></script>
  <script src="{{ asset('web_ln1/bootstrap/js/bootstrap.min.js') }}"></script>
  <script>
    $(document).ready(function() {
      $("#ModalTiendas").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("app_tiendas"));
      });
    });
  </script>
  <!--TUMBES-->
  <div id="content1" data-toggle="modal" data-target="#ModalTiendas" app_tiendas="{{ url('api/modal_nuestras_tiendas/1') }}">
    <img src="{{ asset('web_ln1/img/ubicacion.png') }}" width="50px">
  </div>
  <!--SULLANA-->
  <div id="content2" data-toggle="modal" data-target="#ModalTiendas" app_tiendas="{{ url('api/modal_nuestras_tiendas/2') }}">
    <img src="{{ asset('web_ln1/img/ubicacion.png') }}" width="50px">
  </div>
  <!--PIURA-->
  <div id="content3" data-toggle="modal" data-target="#ModalTiendas" app_tiendas="{{ url('api/modal_nuestras_tiendas/3') }}">
    <img src="{{ asset('web_ln1/img/ubicacion.png') }}" width="50px">
  </div>  
  <!--CAJAMARCA-->
  <div id="content4" data-toggle="modal" data-target="#ModalTiendas" app_tiendas="{{ url('api/modal_nuestras_tiendas/4') }}">
    <img src="{{ asset('web_ln1/img/ubicacion.png') }}" width="50px">
  </div>  
  <!--IQUITOS 1-->
  <div id="content5" data-toggle="modal" data-target="#ModalTiendas" app_tiendas="{{ url('api/modal_nuestras_tiendas/5') }}">
    <img src="{{ asset('web_ln1/img/ubicacion.png') }}" width="50px">
  </div>
  <!--CHICLAYO-->
  <div id="content6" data-toggle="modal" data-target="#ModalTiendas" app_tiendas="{{ url('api/modal_nuestras_tiendas/6') }}">
    <img src="{{ asset('web_ln1/img/ubicacion.png') }}" width="50px">
  </div>  
  <!--TRUJILLO ZELA-->
  <div id="content7" data-toggle="modal" data-target="#ModalTiendas" app_tiendas="{{ url('api/modal_nuestras_tiendas/7') }}">
    <img src="{{ asset('web_ln1/img/ubicacion.png') }}" width="50px">
  </div>  
  <!--TRUJILLO GAMARRA-->
  <div id="content8" data-toggle="modal" data-target="#ModalTiendas" app_tiendas="{{ url('api/modal_nuestras_tiendas/8') }}">
    <img src="{{ asset('web_ln1/img/ubicacion.png') }}" width="50px">
  </div>  
  <!--CHIMBOTE-->
  <div id="content9" data-toggle="modal" data-target="#ModalTiendas" app_tiendas="{{ url('api/modal_nuestras_tiendas/9') }}">
    <img src="{{ asset('web_ln1/img/ubicacion.png') }}" width="50px">
  </div>
  <!--CHINCHA-->
  <div id="content10" data-toggle="modal" data-target="#ModalTiendas" app_tiendas="{{ url('api/modal_nuestras_tiendas/10') }}">
    <img src="{{ asset('web_ln1/img/ubicacion.png') }}" width="50px">
  </div>  
  <!--IQUITOS 2-->
  <div id="content11" class="" data-toggle="modal" data-target="#ModalTiendas" app_tiendas="{{ url('api/modal_nuestras_tiendas/11') }}">
    <img src="{{ asset('web_ln1/img/ubicacion.png') }}" width="50px">
  </div>
  <!--TACNA-->
  <div id="content12" data-toggle="modal" data-target="#ModalTiendas" app_tiendas="{{ url('api/modal_nuestras_tiendas/12') }}">
    <img src="{{ asset('web_ln1/img/ubicacion.png') }}" width="50px">
  </div>
  <!--AREQUIPA-->
  <div id="content13" data-toggle="modal" data-target="#ModalTiendas" app_tiendas="{{ url('api/modal_nuestras_tiendas/13') }}">
    <img src="{{ asset('web_ln1/img/ubicacion.png') }}" width="50px">
  </div>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD71lAXSpu6pRw4rGk53QlvLLY6sGWReIE&callback=initMap&v=weekly&channel=2" async></script>
  <script>
    let map, popup, Popup;
  
    function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: {
          lat: -8.592849563966267,
          lng: -75.28372679960403
        },
        zoom: 6,
      });
  
      class Popup extends google.maps.OverlayView {
        position;
        containerDiv;
        constructor(position, content) {
          super();
          this.position = position;
          content.classList.add("popup-bubble");
  
          // This zero-height div is positioned at the bottom of the bubble.
          const bubbleAnchor = document.createElement("div");
  
          bubbleAnchor.classList.add("popup-bubble-anchor");
          bubbleAnchor.appendChild(content);
          // This zero-height div is positioned at the bottom of the tip.
          this.containerDiv = document.createElement("div");
          this.containerDiv.classList.add("popup-container");
          this.containerDiv.appendChild(bubbleAnchor);
          // Optionally stop clicks, etc., from bubbling up to the map.
          Popup.preventMapHitsAndGesturesFrom(this.containerDiv);
        }
  
        onAdd() {
          this.getPanes().floatPane.appendChild(this.containerDiv);
        }
  
        onRemove() {
          if (this.containerDiv.parentElement) {
            this.containerDiv.parentElement.removeChild(this.containerDiv);
          }
        }
  
        draw() {
          const divPosition = this.getProjection().fromLatLngToDivPixel(
            this.position
          );
          // Hide the popup when it is far out of view.
          const display =
            Math.abs(divPosition.x) < 4000 && Math.abs(divPosition.y) < 4000 ?
            "block" :
            "none";
  
          if (display === "block") {
            this.containerDiv.style.left = divPosition.x + "px";
            this.containerDiv.style.top = divPosition.y + "px";
          }
  
          if (this.containerDiv.style.display !== display) {
            this.containerDiv.style.display = display;
          }
        }
      }
      
      //TUMBES (B04)
      popup = new Popup(
        new google.maps.LatLng(-3.4817612073323354, -80.24454171848888),
        document.getElementById("content1")
      );
      popup.setMap(map);
  
      //SULLANA (B05)
      popup2 = new Popup(
        new google.maps.LatLng(-4.892087716290082, -80.68480635918314),
        document.getElementById("content2")
      );
      popup2.setMap(map);
  
      //PIURA (B12)
      popup3 = new Popup(
        new google.maps.LatLng(-5.195876724789404, -80.6289884448477),
        document.getElementById("content3")
      );
      popup3.setMap(map);
  
      //CAJAMARCA (B08)
      popup4 = new Popup(
        new google.maps.LatLng(-7.154473850703116, -78.51748933834115),
        document.getElementById("content4")
      );
      popup4.setMap(map);
  
      //IQUITOS (B09)
      popup5 = new Popup(
        new google.maps.LatLng(-3.757655959835168, -73.24855506327688),
        document.getElementById("content5")
      );
      popup5.setMap(map);
  
      //CHICLAYO (B07)
      popup6 = new Popup(
        new google.maps.LatLng(-6.767756900294341, -79.83804701178121),
        document.getElementById("content6")
      );
      popup6.setMap(map);
  
      //TRUJILLO ZELA (B10)
      popup7 = new Popup(
        new google.maps.LatLng(-8.112362716258593, -79.02216973912667),
        document.getElementById("content7")
      );
      popup7.setMap(map);
  
      //TRUJILLO GAMARRA (B15)
      popup8 = new Popup(
        new google.maps.LatLng(-8.112817626644446, -79.02440561252065),
        document.getElementById("content8")
      );
      popup8.setMap(map);
  
      //CHIMBOTE (B03)
      popup9 = new Popup(
        new google.maps.LatLng(-9.074445152674972, -78.59215076419024),
        document.getElementById("content9")
      );
      popup9.setMap(map);
  
      //CHINCHA (B11)
      popup10 = new Popup(
        new google.maps.LatLng(-13.417191766356806, -76.13629598876966),
        document.getElementById("content10")
      );
      popup10.setMap(map);
  
      //IQUITOS MALL (B19)
      popup11 = new Popup(
        new google.maps.LatLng(-3.7647522161689886, -73.26746407674052),
        document.getElementById("content11")
      );
      popup11.setMap(map);
  
      //TACNA (B16)
      popup12 = new Popup(
        new google.maps.LatLng(-18.010842485047586, -70.24678646623904),
        document.getElementById("content12")
      );
      popup12.setMap(map);
  
      //AREQUIPA (B06)
      popup13 = new Popup(
        new google.maps.LatLng(-16.399505215267038, -71.53343966324768),
        document.getElementById("content13")
      );
      popup13.setMap(map);
    }
  
    function Buscar_Tienda(a, b, m) {
      var Lat = a;
      var Lng = b;
      var myLatlng = new google.maps.LatLng(Lat, Lng);
      if (m == 7 || m == 8) {
        var myOptions = {
          zoom: 19,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
      } else {
        var myOptions = {
          zoom: 18,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
      }
  
      var map = new google.maps.Map(document.getElementById("map"), myOptions);
  
      class Popup extends google.maps.OverlayView {
        position;
        containerDiv;
        constructor(position, content) {
          super();
          this.position = position;
          content.classList.add("popup-bubble");
  
          // This zero-height div is positioned at the bottom of the bubble.
          const bubbleAnchor = document.createElement("div");
  
          bubbleAnchor.classList.add("popup-bubble-anchor");
          bubbleAnchor.appendChild(content);
          // This zero-height div is positioned at the bottom of the tip.
          this.containerDiv = document.createElement("div");
          this.containerDiv.classList.add("popup-container");
          this.containerDiv.appendChild(bubbleAnchor);
          // Optionally stop clicks, etc., from bubbling up to the map.
          Popup.preventMapHitsAndGesturesFrom(this.containerDiv);
        }
  
        onAdd() {
          this.getPanes().floatPane.appendChild(this.containerDiv);
        }
  
        onRemove() {
          if (this.containerDiv.parentElement) {
            this.containerDiv.parentElement.removeChild(this.containerDiv);
          }
        }
  
        draw() {
          const divPosition = this.getProjection().fromLatLngToDivPixel(
            this.position
          );
          // Hide the popup when it is far out of view.
          const display =
            Math.abs(divPosition.x) < 4000 && Math.abs(divPosition.y) < 4000 ?
            "block" :
            "none";
  
          if (display === "block") {
            this.containerDiv.style.left = divPosition.x + "px";
            this.containerDiv.style.top = divPosition.y + "px";
          }
  
          if (this.containerDiv.style.display !== display) {
            this.containerDiv.style.display = display;
          }
        }
      }
      popup.setMap(map);
      popup2.setMap(map);
      popup3.setMap(map);
      popup4.setMap(map);
      popup5.setMap(map);
      popup6.setMap(map);
      popup7.setMap(map);
      popup8.setMap(map);
      popup9.setMap(map);
      popup10.setMap(map);
      popup11.setMap(map);
      popup12.setMap(map);
      popup13.setMap(map);
  
      var tumbes = document.getElementById('mtumbes');
      var sullana = document.getElementById('msullana');
      var piura = document.getElementById('mpiura');
      var cajamarca = document.getElementById('mcajamarca');
      var iquitos1 = document.getElementById('miquitos1');
      var chiclayo = document.getElementById('mchiclayo');
      var trujilloz = document.getElementById('mtrujilloz');
      var trujillog = document.getElementById('mtrujillog');
      var chimbote = document.getElementById('mchimbote');
      var chincha = document.getElementById('mchincha');
      var iquitos2 = document.getElementById('miquitos2');
      var tacna = document.getElementById('mtacna');
      var arequipa = document.getElementById('marequipa');
  
      $(".pintar_boton").css("background-color", "#00afef");
  
      if (m == 1) {
        tumbes.style.backgroundColor = '#ff8628';
      } else if (m == 2) {
        sullana.style.backgroundColor = '#ff8628';
      } else if (m == 3) {
        piura.style.backgroundColor = '#ff8628';
      } else if (m == 4) {
        cajamarca.style.backgroundColor = '#ff8628';
      } else if (m == 5) {
        iquitos1.style.backgroundColor = '#ff8628';
      } else if (m == 6) {
        chiclayo.style.backgroundColor = '#ff8628';
      } else if (m == 7) {
        trujilloz.style.backgroundColor = '#ff8628';
      } else if (m == 8) {
        trujillog.style.backgroundColor = '#ff8628';
      } else if (m == 9) {
        chimbote.style.backgroundColor = '#ff8628';
      } else if (m == 10) {
        chincha.style.backgroundColor = '#ff8628';
      } else if (m == 11) {
        iquitos2.style.backgroundColor = '#ff8628';
      } else if (m == 12) {
        tacna.style.backgroundColor = '#ff8628';
      } else if (m == 13) {
        arequipa.style.backgroundColor = '#ff8628';
      }
    }
  </script>
</body>
</html>