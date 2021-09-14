<template>
  <div class="container my-5">
    <h2>Hoteles</h2>
    <lista-establecimientos :establecimientos="hoteles" />
  </div>
</template>

<script>
import { mapState } from 'vuex'
  import ListaEstablecimientos from './ListaEstablecimientos.vue'

  export default {
    components: { ListaEstablecimientos },
    async mounted() {
      const resp = await axios.get('/api/categorias/hoteles')
      this.$store.commit('AGREGAR_HOTELES', resp.data.establecimientos)
    },
    computed: {
      ...mapState(['hoteles'])
    }
  }
</script>

<style>
</style>