<template>
  <div>
    <listado-categorias></listado-categorias>
    <mapa-establecimientos></mapa-establecimientos>
    <categoria-cafe></categoria-cafe>
    <categoria-restaurant></categoria-restaurant>
    <categoria-hotel></categoria-hotel>
  </div>
</template>

<script>
  import ListadoCategorias from '../components/ListadoCategorias.vue'
  import CategoriaCafe from '../components/CategoriaCafe.vue'
  import CategoriaRestaurant from '../components/CategoriaRestaurant.vue'
  import CategoriaHotel from '../components/CategoriaHotel.vue'
  import MapaEstablecimientos from '../components/MapaEstablecimientos.vue'
  export default {
    components: { CategoriaCafe, CategoriaRestaurant, CategoriaHotel, MapaEstablecimientos, ListadoCategorias },
  }
</script>

<style>
</style>