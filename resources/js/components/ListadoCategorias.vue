<template>
  <div>
    <nav class="d-flex flex-column flex-md-row container justify-content-md-center">
      <a href="#" @click="seleccionarCategoria('todos')">Todos</a>
      <a
        v-for="categoria in categorias"
        :key="categoria.id"
        class="m-0"
        @click="seleccionarCategoria(categoria)"
      >{{categoria.nombre}}</a>
    </nav>
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  export default {
    async created() {
      const resp = await axios.get('/api/categorias')
      this.$store.commit('AGREGAR_CATEGORIAS', resp.data)
    },
    computed: {
      ...mapState(['categorias']),
    },
    methods: {
      seleccionarCategoria(categoria) {
        if (categoria === 'todos') {
          this.$store.commit('SELECCIONAR_CATEGORIA', 'todos')
        } else this.$store.commit('SELECCIONAR_CATEGORIA', categoria.slug)
      },
    },
  }
</script>



<style scoped>
  div {
    background-color: #6272d4;
  }
  nav a {
    color: white;
    font-weight: bold;
    text-transform: uppercase;
    padding: 0.5rem 2rem;
    text-align: center;
    flex: 1;
  }
  nav a:hover {
    color: white;
    cursor: pointer;
  }
  nav a:nth-child(1) {
    background-color: #a000b7;
  }
  nav a:nth-child(2) {
    background-color: #591d03;
  }
  nav a:nth-child(3) {
    background-color: #ea6a00;
  }
  nav a:nth-child(4) {
    background-color: #edb220;
  }
  nav a:nth-child(5) {
    background-color: #dd0e3f;
  }
  nav a:nth-child(6) {
    background-color: #0448b5;
  }
  nav a:nth-child(7) {
    background-color: #00a81c;
  }
  nav a:nth-child(8) {
    background-color: #a000b7;
  }
</style>