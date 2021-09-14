<template>
  <div class="container my-5">
    <h2>Restaurantes</h2>
    <lista-establecimientos :establecimientos="restaurants" />
  </div>
</template>

<script>
import { mapState } from 'vuex'
  import ListaEstablecimientos from './ListaEstablecimientos.vue'

  export default {
    components: { ListaEstablecimientos },
    async mounted() {
      const resp = await axios.get('/api/categorias/restaurant')
      this.$store.commit('AGREGAR_RESTAURANTS', resp.data.establecimientos)
    },
    computed: {
      ...mapState(['restaurants'])
    }
  }
</script>

<style>
</style>