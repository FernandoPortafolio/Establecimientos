import { mapState } from 'vuex';
<template>
  <div class="container my-5" v-if="establecimiento">
    <h2 class="text-center mb-5">{{establecimiento.nombre}}</h2>
    <div class="row align-items-start justify-content-between">
      <div class="col-md-8 order-2">
        <img
          :src="`../storage/${establecimiento.imagen_principal}`"
          alt="Imagen del establecimiento"
          class="m-auto"
        />
        <p class="mt-5">{{establecimiento.descripcion}}</p>
        <galeria />
      </div>
      <aside class="col-md-4 order-1">
        <div>
          <mapa-ubicacion></mapa-ubicacion>
        </div>
        <div class="p-4 mt-2 bg-primary">
          <h3 class="text-center text-white mt-2 mb-4">Más Información</h3>
          <p class="text-white mt-1">
            <span class="font-weight-bold">Ubicación:</span>
            {{establecimiento.direccion}}
          </p>
          <p class="text-white mt-1">
            <span class="font-weight-bold">Colonia:</span>
            {{establecimiento.colonia}}
          </p>
          <p class="text-white mt-1">
            <span class="font-weight-bold">Horario:</span>
            {{establecimiento.apertura}} - {{establecimiento.cierre}}
          </p>
          <p class="text-white mt-1">
            <span class="font-weight-bold">Teléfono:</span>
            {{establecimiento.telefono}}
          </p>
        </div>
      </aside>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import MapaUbicacion from '../components/MapaUbicacion.vue'
  import Galeria from '../components/Galeria.vue'
  export default {
    components: { MapaUbicacion, Galeria },
    async mounted() {
      const resp = await axios.get(`/api/establecimientos/${this.$route.params.id}`)
      this.$store.commit('AGREGAR_ESTABLECIMIENTO', resp.data)
    },
    computed: {
      ...mapState(['establecimiento']),
    },
  }
</script>

<style>
</style>