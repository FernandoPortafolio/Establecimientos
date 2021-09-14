const API_KEY = 'AAPK13615a04577342e9955bf3fdb55034d5Ucp38U_xu1YGYveI7Ahkis2afd2pImmDmlaJoTS0SVwhBaXh2L7Tb9a-COB8g26e'
const lat = document.querySelector('#lat')?.value || 20.666332695977
const lng = document.querySelector('#lng')?.value || -103.392177745699

document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('#mapa')) {
        const mapa = L.map('mapa').setView([lat, lng], 16)

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(mapa)

        // agregar el pin
        let marker = new L.marker([lat, lng], {
            draggable: true,
            autoPan: true,
        }).addTo(mapa)

        //Geocode service
        const geocodeService = L.esri.Geocoding.geocodeService({
            apikey: API_KEY,
        })

        //detectar movimiento del marker
        marker.on('moveend', function(e) {
            const target = e.target
            const position = target.getLatLng()

            //centrar automaticamente
            mapa.panTo(new L.LatLng(position.lat, position.lng))

            //Reverse geocoding
            geocodeService
                .reverse()
                .latlng(position, 16)
                .run(function(error, result) {
                    if (error) return
                    const lngLatString = `${result.latlng.lng.toFixed(5)}, ${result.latlng.lat.toFixed(5)}`
                    marker.bindPopup(`<b>${lngLatString}</b><p>${result.address.Match_addr}</p>`).openPopup()

                    llenarInputs(result)
                })
        })

        //Crear caja de busqueda dentro del mapa
        const searchControl = L.esri.Geocoding.geosearch({
            position: 'topright',
            placeholder: 'Ingresa una dirección e.g. 1 York St',
            useMapBounds: false,
            providers: [
                L.esri.Geocoding.arcgisOnlineProvider({
                    apikey: API_KEY,
                }),
            ],
        }).addTo(mapa)

        searchControl.on('results', function(data) {
            marker.setLatLng(data.latlng)
            document.querySelector('#direccion').value = data.results[0].properties.LongLabel
            document.querySelector('#formBuscador').value = data.results[0].properties.LongLabel
            document.querySelector('#colonia').value = data.results[0].properties.Nbrhd
            document.querySelector('#lat').value = data.results[0].latlng.lat
            document.querySelector('#lng').value = data.results[0].latlng.lng
        })
    }
})

function llenarInputs(result) {
    document.querySelector('#direccion').value = result.address.Address
    document.querySelector('#formBuscador').value = result.address.LongLabel
    document.querySelector('#colonia').value = result.address.Neighborhood
    document.querySelector('#lat').value = result.latlng.lat
    document.querySelector('#lng').value = result.latlng.lng
}
