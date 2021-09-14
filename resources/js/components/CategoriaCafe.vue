<template>
  <div class="container my-5">
    <h2>Cafés</h2>
    <lista-establecimientos :establecimientos="cafes" />
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import ListaEstablecimientos from './ListaEstablecimientos.vue'

  export default {
    components: { ListaEstablecimientos },
    async mounted() {
      const resp = await axios.get('/api/categorias/cafe')
      this.$store.commit('AGREGAR_CAFES', resp.data.establecimientos)
    },
    computed: {
      ...mapState(['cafes']),
    },
  }
</script>

<style>
</style>