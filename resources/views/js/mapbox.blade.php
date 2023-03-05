<script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
<script>
    $(document).ready(() => {
        mapboxgl.accessToken = '{{ config('services.mapbox.token') }}';
        if (!mapboxgl.supported()) {
            alert('Your browser does not support Mapbox GL');
        } else {
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                cooperativeGestures: true,
                center: [117.8888, -2.44565],
                zoom: 4
            });

            const geocoder = new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                mapboxgl: mapboxgl,
                country: 'ID',
                language: 'id',
                marker: false
            });

            const marker = new mapboxgl.Marker({
                draggable: true
            })

            marker.on('dragend', function(e) {
                var coords = e.target.getLngLat();
                setLatitudeLongitude(coords['lng'], coords['lat'])
            })

            geocoder.on('result', e => {
                setLatitudeLongitude(e.result.center[0], e.result.center[1])
                marker.setLngLat(e.result.center)
                    .addTo(map)
            })

            const geolocate = new mapboxgl.GeolocateControl({
                positionOptions: {
                    enableHighAccuracy: true
                },
                trackUserLocation: true,
                showUserHeading: false,
                showUserLocation: false,
            });

            geolocate.on('geolocate', (e) => {
                setLatitudeLongitude(e.coords.longitude, e.coords.latitude)
                marker.setLngLat([
                        e.coords.longitude,
                        e.coords.latitude,
                    ])
                    .addTo(map)
            })

            map.addControl(geocoder);
            map.addControl(new mapboxgl.FullscreenControl());
            map.addControl(new mapboxgl.NavigationControl());
            map.addControl(geolocate);

            function setLatitudeLongitude(longitude, latitude) {
                $('#longitude').val(longitude)
                $('#latitude').val(latitude)
            }
        }
    })
</script>
