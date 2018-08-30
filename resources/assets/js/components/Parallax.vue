<template>
<div id="results" class="parallax">
  <parallax :parallax="true" :speedFactor="0.5">
    <img src="/media/img/recursos/parallax-bg.png" alt="very cool bg">
  </parallax>
  <div v-if="loading" class="content loader">
    <div>
      Buscando &nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-spiner fa-spin"></i>
    </div>
  </div>
  <div v-else class="content" :class="{'overflow-y-scroll': search}">
    <div v-if="!search" class="text-center">
      <h3 class="futura-light blanco">Ingresa los datos del miembro ICCN para iniciar la búsqueda</h3><br>
      <img class="desk-disp" width="80%" style="max-width: 800px;" src="https://static.wixstatic.com/media/b258fc_524e497a8fd94c96bc704c826cfd9a9f~mv2.png/v1/fill/w_673,h_264,al_c,usm_0.66_1.00_0.01/b258fc_524e497a8fd94c96bc704c826cfd9a9f~mv2.png" alt="iccn_map">
      <hr>
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div class="container">
            <div class="row">
              <div class="col-md-3 form-group">
                  <input v-model="nombre" type="text" class="form-control" placeholder="Nombre">
              </div>
              <div class="col-md-3 form-group">
                <input @keyup="searchPais" v-model="pais" type="text" class="form-control" placeholder="País*">
                <transition name="fade">
                  <ul v-if="paises.length !== 0" class="input-results list-group">
                     <a @click="setPais(pais.id, pais.nombre)" v-for="pais in paises" role="button" class="list-group-item list-group-item-action">{{pais.nombre}}</a>
                  </ul>
                </transition>
              </div>
              <div class="col-md-3 form-group">
                <select class="form-control" v-model="categoria">
                  <option :value="0">Selecciona una categoría</option>
                  <option v-for="categoria in categorias" :value="categoria.id">{{categoria.nombre}}</option>
                </select>
              </div>
              <div class="col-md-3 form-group">
                <button @click="searchFor()" class="btn btn-searchm">Buscar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container" v-else>
      <button @click="home()" style="float:right" class="search-member-btn btn btn-danger"><i class="fas fa-home"></i></button>
      <div class="row" style="height: -webkit-fill-available">
        <div  class="col-md-6 result-member" v-for="member in results">
          <div class="card" :class="{conscard: member.categoria_id === 1, coachcard: member.categoria_id === 2, capacard: member.categoria_id === 3, empresacard: member.categoria_id === 4, programcard: member.categoria_id === 5}">
            <div class="card-header">
              <div class="row">
                <div class="col-sm-3">
                  <div class="member">
                    <div class="mobile-member">
                      <div class="member-picture" :style="'background: url(/storage/'+member.foto+') center no-repeat'"></div>
                      <div class="member-flag" :style="'background: url(/storage/flags/'+member.pais.id+'.png) center no-repeat'"></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-9 text-right">
                  <div class="row">
                    <div class="col-md-10">
                      <h3 v-if="member.apellido_p">{{member.name+' '+member.apellido_p+' '+member.apellido_m}}</h3>
                      <h3 v-else>{{member.name}}</h3>
                    </div>
                    <div class="col-md-2">
                      <img v-if="member.categoria_id === 1" width="40" src="/media/img/categorias/consultor.png" alt="categoria_icon">
                      <img v-if="member.categoria_id === 2" width="40" src="/media/img/categorias/coach.png" alt="categoria_icon">
                      <img v-if="member.categoria_id === 3" width="40" src="/media/img/categorias/capacitador.png" alt="categoria_icon">
                      <img v-if="member.categoria_id === 4" width="40" src="/media/img/categorias/empresa.png" alt="categoria_icon">
                      <img v-if="member.categoria_id === 5" width="40" src="/media/img/categorias/programas.png" alt="categoria_icon">
                    </div>
                  </div>
                  <span v-if="member.categoria_id === 1">Consultor</span>
                  <span v-if="member.categoria_id === 2">Coach</span>
                  <span v-if="member.categoria_id === 3">Capacitador</span>
                  <span v-if="member.categoria_id === 4">Empresa</span>
                  <span v-if="member.categoria_id === 5">Programa</span> <br>
                  <a v-if="member.fb" :href="member.fb"><img width="30" src="/media/img/recursos/fb-logo.png" alt="facebook logo"></a>


                  <a v-if="member.tw" :href="member.tw"><img width="30" src="/media/img/recursos/tw-logo.png" alt="facebook logo"></a>


                  <a v-if="member.in" :href="member.in"><img width="30" src="/media/img/recursos/in-logo.png" alt="facebook logo"></a>

                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="card-text text-center table-responsive">
                <table class="table">
                  <tr>
                    <th class="text-right">Folio</th>
                    <td class="text-left">{{member.user.folio}}</td>
                  </tr>
                  <tr>
                    <th class="text-right">Tipo de Miembro</th>
                    <td class="text-left" style="text-transform: capitalize">{{member.rango}}</td>
                  </tr>
                  <tr>
                    <th class="text-right">Correo electrónico</th>
                    <td class="text-left">{{member.user.email}}</td>
                  </tr>
                  <tr>
                    <th class="text-right">Sitio Web</th>
                    <td class="text-left">{{member.website}}</td>
                  </tr>
                </table>
                <a v-if="member.categoria_id !== 4" class="btn btn-primary" :href="'/perfil/'+member.user.folio+'/'+member.perfil.nombre+'-'+member.perfil.apellido_p+'-'+member.perfil.apellido_m">Más información</a>
                <a v-else class="btn btn-primary" :href="'/empresa/'+member.user.folio">Más información</a>
              </div>
            </div>
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
            categoria: 0,
            paises: [],
            pais: '',
            paisid: 0,
            nombre: '',
            search: false,
            results: [],
            loading: false
          }
        },
        methods: {
          searchFor(){
            var este = this;
            this.loading = true
                axios.post('/search', {nombre: this.nombre, pais: this.paisid, categoria: this.categoria}).then(function(results){
                  este.results = results.data
                }).then(function(){
                  este.search = true
                  este.loading = false
                  window.location.href = '#results'
                  $(".Masthead").addClass('full-height')
                });


          },
          home(){
            this.search = false
            $(".Masthead").removeClass('full-height')
          },
          searchPais(){
            var este = this;
            if (this.pais !== '') {
              axios.post('/search-pais', {pais: this.pais}).then(function(paises){
                este.paises = paises.data.data;
              });
            }else{
              este.paises = []
            }
          },
          setPais(id, nombre){
            this.paisid = id
            this.pais = nombre
            this.paises = []
          },
        }
    }
</script>
