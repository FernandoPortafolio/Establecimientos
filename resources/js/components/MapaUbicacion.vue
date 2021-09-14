<template>
  <div style="height: 350px;" class="mt-3">
    <l-map
      :zoom="zoom"
      :center="center"
      :options="mapOptions"
      @update:zoom="zoomUpdated"
      @update:center="centerUpdated"
    >
      <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>

      <l-marker :lat-lng="{lat, lng}">
        <l-tooltip>
          <div>{{establecimiento.nombre}}</div>
        </l-tooltip>
      </l-marker>
    </l-map>
  </div>
</template>

<script>
  import { latLng } from 'leaflet'
  import { LMap, LTileLayer, LMarker, LTooltip } from 'vue2-leaflet'
  import { mapState } from 'vuex'
  export default {
    components: {
      LMap,
      LTileLayer,
      LMarker,
      LTooltip,
    },
    data() {
      return {
        zoom: 16,
        center: latLng(20.666332695977, -103.392177745699),
        url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        currentZoom: 11.5,
        mapOptions: {
          zoomSnap: 0.5,
        },
        showMap: true,
        lat: '',
        lng: '',
      }
    },
    computed: {
      ...mapState(['establecimiento']),
    },
    created() {
      setTimeout(() => {
        this.lat = this.establecimiento.lat
        this.lng = this.establecimiento.lng
        this.center = latLng(this.lat, this.lng)
      }, 300)
    },
    methods: {
      zoomUpdated(zoom) {
        this.zoom = zoom
      },
      centerUpdated(center) {
        this.center = center
      },
    },
  }
</script>

<style scoped>
  .mapa {
    height: 300px;
    width: 300px;
  }
</style>