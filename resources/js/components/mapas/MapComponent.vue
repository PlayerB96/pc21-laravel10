<template>
    <div>
        <!-- Input para buscar la dirección -->
        <input v-model="address" type="text" placeholder="Buscar dirección" />
        <!-- Botón para buscar la dirección -->
        <button @click="geocodeAddress">Buscar</button>
        <div id="map"></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            address: '', // Dirección ingresada por el usuario
            map: null, // Instancia del mapa
            marker: null, // Instancia del marcador
            geocoder: null, // Instancia del geocodificador
        };
    },
    mounted() {
        // Crear el script de la API de Google Maps y cargarlo dinámicamente
        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyBoLwjzhsozI9zhHo6Y_y47y_fhIDHlicg&callback=initMap&libraries=places`;
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);

        // Función que se llama cuando la API está completamente cargada
        window.initMap = this.initMap;
    },
    methods: {
        initMap() {
            // Crear el mapa y establecer sus opciones
            const options = {
                zoom: 12,
                center: { lat: -12.0464, lng: -77.0428 }, // Lima, Perú
            };

            this.map = new google.maps.Map(document.getElementById('map'), options);
            this.geocoder = new google.maps.Geocoder(); // Crear el geocodificador
        },
        geocodeAddress() {
            if (this.address !== '') {
                // Usar el geocodificador para obtener la latitud y longitud de la dirección
                this.geocoder.geocode({ address: this.address }, (results, status) => {
                    if (status === google.maps.GeocoderStatus.OK) {
                        const location = results[0].geometry.location;

                        // Centrar el mapa en la nueva ubicación
                        this.map.setCenter(location);

                        // Crear un marcador en la ubicación encontrada
                        if (this.marker) {
                            this.marker.setMap(null); // Eliminar marcador anterior si existe
                        }
                        this.marker = new google.maps.Marker({
                            position: location,
                            map: this.map,
                            title: 'Ubicación encontrada',
                            icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png', // Punto rojo
                        });
                    } else {
                        alert('No se pudo encontrar la dirección: ' + status);
                    }
                });
            } else {
                alert('Por favor ingresa una dirección');
            }
        }
    }
};
</script>

<style>
#map {
    height: 400px;
    width: 100%;
}

input {
    margin-bottom: 10px;
    padding: 5px;
    width: 80%;
}

button {
    padding: 5px 10px;
    margin-top: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}
</style>
