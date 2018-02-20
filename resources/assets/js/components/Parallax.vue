<template>
<div class="parallax">
  <parallax :parallax="true">
    <img src="/media/img/recursos/parallax-bg.png" alt="very cool bg">
  </parallax>
  <div class="content">
    <div class="text-center">
      <h3 class="futura-light blanco">Ingresa los datos del miembro ICCN para iniciar la busqueda</h3><br>
      <img src="https://static.wixstatic.com/media/b258fc_524e497a8fd94c96bc704c826cfd9a9f~mv2.png/v1/fill/w_673,h_264,al_c,usm_0.66_1.00_0.01/b258fc_524e497a8fd94c96bc704c826cfd9a9f~mv2.png" alt="iccn_map">
      <div style="width:50%; margin: 40px auto;">
        <div class="form-row">
          <div class="col">
            <input v-model="nombre" type="text" class="form-control" placeholder="Nombre">
          </div>
          <div class="col">
            <input v-model="pais" type="text" class="form-control" placeholder="País*">
          </div>
          <div class="col">
            <select class="form-control" style="height: inherit" v-model="categoria">
              <option value="">Selecciona una categoría</option>
              <option v-for="categoria in categorias" :value="categoria.id">{{categoria.nombre}}</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import Parallax from 'vue-parallaxy'
    export default {
      components: {
        Parallax
      },
        mounted() {
          var este = this;
            axios.get('/get-categorias').then(function(categorias){
              este.categorias = categorias.data
            })
        },
        data() {
          return {
            categorias: [],
            categoria: '',
            pais: '',
            nombre: ''
          }
        }
    }
</script>
