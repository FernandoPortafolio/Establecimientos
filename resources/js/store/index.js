import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        cafes: [],
        restaurants: [],
        hoteles: [],
        establecimientos: [],
        categorias: [],
        establecimiento: null,
        categoria: null,
    },
    mutations: {
        AGREGAR_CAFES(state, cafes) {
            state.cafes = cafes
        },
        AGREGAR_RESTAURANTS(state, restaurants) {
            state.restaurants = restaurants
        },
        AGREGAR_HOTELES(state, hoteles) {
            state.hoteles = hoteles
        },
        AGREGAR_ESTABLECIMIENTO(state, establecimiento) {
            state.establecimiento = establecimiento
        },
        AGREGAR_ESTABLECIMIENTOS(state, establecimientos) {
            state.establecimientos = establecimientos
        },
        AGREGAR_CATEGORIAS(state, categorias) {
            state.categorias = categorias
        },
        SELECCIONAR_CATEGORIA(state, categoria) {
            state.categoria = categoria
        },
    },
})
