<template>
  <div class="mapa">
    <l-map :zoom="zoom" :center="center" :options="mapOptions">
      <l-tile-layer :url="url" :attribution="attribution" />

      <l-marker
        v-for="establecimiento in establecimientos"
        :key="establecimiento.id"
        :lat-lng="getCoordenadas(establecimiento)"
        :icon="getIcono(establecimiento)"
        @click="redireccionar(establecimiento)"
      >
        <l-tooltip>
          <div>{{establecimiento.nombre}} - {{establecimiento.categoria.nombre}}</div>
        </l-tooltip>
      </l-marker>
    </l-map>
  </div>
</template>

<script>
  import { latLng } from 'leaflet'
  import { LMap, LTileLayer, LMarker, LTooltip, LIcon } from 'vue2-leaflet'
  import { mapState } from 'vuex'
  export default {
    components: {
      LMap,
      LTileLayer,
      LMarker,
      LTooltip,
      LIcon,
    },
    data() {
      return {
        zoom: 13,
        center: latLng(20.666332695977, -103.392177745699),
        url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        currentZoom: 11.5,
        currentCenter: latLng(20.666332695977, -103.392177745699),
        showParagraph: false,
        mapOptions: {
          zoomSnap: 0.5,
        },
        showMap: true,
      }
    },
    computed: {
      ...mapState(['establecimientos', 'categoria']),
    },
    async created() {
      const resp = await axios.get('/api/establecimientos')
      this.$store.commit('AGREGAR_ESTABLECIMIENTOS', resp.data)
    },
    methods: {
      getCoordenadas(establecimiento) {
        return {
          lat: establecimiento.lat,
          lng: establecimiento.lng,
        }
      },
      getIcono(establecimiento) {
        const { slug } = establecimiento.categoria
        return L.icon({
          iconUrl: `images/iconos/${slug}.png`,
          iconSize: [40, 50],
        })
      },
      redireccionar(establecimiento) {
        this.$router.push({ name: 'establecimiento', params: { id: establecimiento.id } })
      },
    },
    watch: {
      categoria: async function () {
        if (this.categoria !== 'todos') {
          const resp = await axios.get(`/api/${this.categoria}`)
          this.$store.commit('AGREGAR_ESTABLECIMIENTOS', resp.data.establecimientos)
        } else {
          const resp = await axios.get('/api/establecimientos')
          this.$store.commit('AGREGAR_ESTABLECIMIENTOS', resp.data)
        }
      },
    },
  }
</script>

<style scoped>
  .mapa {
    height: 450px;
  }
</style>