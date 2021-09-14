<template>
  <div class="row">
    <div
      class="col-md-4 mt-4"
      v-for="establecimiento in establecimientos"
      :key="establecimiento.id"
    >
      <div class="card">
        <img :src="`storage/${establecimiento.imagen_principal}`" alt="Card del restaurant" />
        <div class="card-body">
          <h3 class="card-title text-primary font-weight-bold">{{establecimiento.nombre}}</h3>
          <p class="card-text">{{establecimiento.direccion}}</p>
          <p class="card-text">
            <span class="font-weight-bold">Horario:</span>
            {{establecimiento.apertura}} - {{establecimiento.cierre}}
          </p>
          <router-link
            :to="{name: 'establecimiento', params: {id: establecimiento.id}}"
            class="btn btn-primary d-block"
          >Ver lugar</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['establecimientos'],
  }
</script>

<style>
</style>