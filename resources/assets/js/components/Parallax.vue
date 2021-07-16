<template>
<div id="results" class="parallax">
  <parallax :parallax="true" :speedFactor="0.5">
    <img src="/media/img/recursos/parallax-bg.png" alt="very cool bg">
  </parallax>
  <div v-if="loading" class="content loader">
    <div>
      {{$t('Searching')}} &nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-spiner fa-spin"></i>
    </div>
  </div>
  <div v-else class="content" :class="{'overflow-y-scroll': search}">
    <div v-if="!search" class="text-center">
      <h3 class="futura-light blanco">{{$t('parallax-text')}}</h3><br>
      <img class="desk-disp" width="80%" style="max-width: 800px; margin:0 auto;" src="https://static.wixstatic.com/media/b258fc_524e497a8fd94c96bc704c826cfd9a9f~mv2.png/v1/fill/w_673,h_264,al_c,usm_0.66_1.00_0.01/b258fc_524e497a8fd94c96bc704c826cfd9a9f~mv2.png" alt="iccn_map">
      <hr>
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div class="container">
            <div class="row">
              <div class="col-md-3 form-group">
                  <input @keyup.enter="searchFor()" v-model="nombre" type="text" class="form-control" :placeholder="$t('form.placeholder.Search')">
              </div>
              <div class="col-md-3 form-group">
                <div class="input-group">
                  <input :disabled="paises.length === 0" @keyup="searchPais" v-model="pais" type="text" class="form-control" :placeholder="$t('form.placeholder.Country')">
                  <div class="input-group-prepend">
                    <button @click="listCountry" type="button" class="btn btn-primary"><i class="fas fa-chevron-down"></i></button>
                  </div>
                </div>
                <transition name="fade">
                  <ul v-if="paises.length !== 0" class="input-results list-group">
                     <a @click="setPais(pais.id, pais.nombre)" v-for="pais in paises" role="button" class="list-group-item list-group-item-action">{{pais.nombre}}</a>
                  </ul>
                </transition>
              </div>
              <div class="col-md-3 form-group">
                <select class="form-control" v-model="categoria">
                  <option :value="0">{{$t('form.select-categoria')}}</option>
                  <option v-for="categoria in categorias" :value="categoria.id">{{$t('categoria.'+categoria.nombre.replace(" ", ""))}}</option>
                </select>
              </div>
              <div class="col-md-3 form-group">
                <button @click="searchFor()" class="btn btn-primary">{{$t('form.button.Search')}}</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container" v-else>
      <div class="content loader" v-if="results.length === 0">
        <div>
          {{$t('no-results')}} <br><br>
          <button class="btn btn-primary" @click="home()">{{$t('form.button.Return')}}</button>
        </div>
      </div>
      <div v-else>
        <button @click="home()" style="float:right" class="search-member-btn btn btn-danger"><i class="fas fa-home"></i></button>
        <div class="row" style="height: -webkit-fill-available; padding-top: 30px;">
          <div v-if="categoria !== 5"  class="col-md-6 result-member" v-for="member in results">
            <div class="card" :class="{conscard: member.categoria_id === 1, coachcard: member.categoria_id === 2, capacard: member.categoria_id === 3, empresacard: member.categoria_id === 4, programcard: member.categoria_id === 5, especial: member.categoria_id === 6}">
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
                  <div class="col-sm-9">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="card-category">
                              <span v-if="member.categoria_id === 1">{{$t('categoria.Consultor')}}</span>
                              <span v-if="member.categoria_id === 2">{{$t('categoria.Coach')}}</span>
                              <span v-if="member.categoria_id === 3">{{$t('categoria.Capacitador')}}</span>
                              <span v-if="member.categoria_id === 4">{{$t('categoria.Empresa')}}</span>
                              <span v-if="member.categoria_id === 5">{{$t('categoria.Programa')}}</span>
                              <span v-if="member.categoria_id === 6">{{$t('categoria.CertificacionesEspecializadas')}}</span>
                              &nbsp;&nbsp;&nbsp;
                              <img v-if="member.categoria_id === 1" width="40" src="/media/img/categorias/consultor.png" alt="categoria_icon">
                              <img v-if="member.categoria_id === 2" width="40" src="/media/img/categorias/coach.png" alt="categoria_icon">
                              <img v-if="member.categoria_id === 3" width="40" src="/media/img/categorias/capacitador.png" alt="categoria_icon">
                              <img v-if="member.categoria_id === 4" width="40" src="/media/img/categorias/empresa.png" alt="categoria_icon">
                              <img v-if="member.categoria_id === 5" width="40" src="/media/img/categorias/programas.png" alt="categoria_icon">
                              <img v-if="member.categoria_id === 6" width="40" src="/media/img/categorias/certificaciones_especializadas.png" alt="categoria_icon">
                        </div>
                        <h3>{{member.name}} {{member.apellido_p ? member.apellido_p : '' +' '+member.apellido_m ? member.apellido_m : ''}}</h3>
                      </div>
                    </div>
                    <a v-if="member.fb" :href="'https://facebook.com/' + member.fb"><img width="30" src="/media/img/recursos/fb-logo.png" alt="facebook logo"></a>


                    <a v-if="member.tw" :href="'https://twitter.com/' + member.tw"><img width="30" src="/media/img/recursos/tw-logo.png" alt="facebook logo"></a>


                    <a v-if="member.in" :href="'https://linkedin.com/' + member.in"><img width="30" src="/media/img/recursos/in-logo.png" alt="facebook logo"></a>

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
                      <th class="text-right">{{$t('user.tipo-mimebro')}}</th>
                      <td class="text-left" style="text-transform: capitalize">{{member.rango}}</td>
                    </tr>
                    <tr>
                      <th class="text-right">{{$t('user.Email')}}</th>
                      <td class="text-left">{{member.user.email}}</td>
                    </tr>
                    <tr>
                      <th class="text-right">{{$t('user.site')}}</th>
                      <td class="text-left">{{member.website}}</td>
                    </tr>
                  </table>
                  <a v-if="member.categoria_id !== 4" class="btn btn-primary" :href="'/perfil/'+member.user.folio+'/'+member.slug">{{$t('form.button.more-info')}}</a>
                  <a v-else class="btn btn-primary" :href="'/empresa/'+member.user.folio+ '/' + member.name.toLowerCase().replace(/\s/g, '-')">{{$t('form.button.more-info')}}</a>
                </div>
              </div>
            </div>
          </div>
          <div v-if="categoria == 5"  class="col-md-6 result-member" v-for="program in results">
            <div class="card programcard">
              <div class="card-header">
                <div class="row">
                  <div class="col-sm-3">
                    <div class="member">
                      <div class="mobile-member">
                        <div class="member-picture" :style="'background: url(/storage/'+program.foto+') center no-repeat'"></div>
                        <div class="member-flag" :style="'background: url(/storage/flags/'+program.empresa.pais.id+'.png) center no-repeat'"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-9">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="card-category">
                              <span>{{$t('categoria.Programa')}}</span>
                              &nbsp;&nbsp;&nbsp;
                              <img width="40" src="/media/img/categorias/programas.png" alt="categoria_icon">
                        </div>
                        <h3>{{program.nombre}}</h3>
                      </div>
                    </div>
                    <a v-if="program.empresa.fb" :href="'https://facebook.com/' + program.empresa.fb"><img width="30" src="/media/img/recursos/fb-logo.png" alt="facebook logo"></a>


                    <a v-if="program.empresa.tw" :href="'https://twitter.com/' + program.empresa.tw"><img width="30" src="/media/img/recursos/tw-logo.png" alt="facebook logo"></a>


                    <a v-if="program.empresa.in" :href="'https://linkedin.com/' + program.empresa.in"><img width="30" src="/media/img/recursos/in-logo.png" alt="facebook logo"></a>

                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="card-text text-center table-responsive">
                  <table class="table">
                    <tr>
                      <th class="text-right">Folio</th>
                      <td class="text-left">{{program.empresa.user.folio}}</td>
                    </tr>
                    <tr>
                      <th class="text-right">{{$t('user.tipo-mimebro')}}</th>
                      <td class="text-left" style="text-transform: capitalize">{{program.empresa.rango}}</td>
                    </tr>
                    <tr>
                      <th class="text-right">{{$t('user.Email')}}</th>
                      <td class="text-left">{{program.empresa.user.email}}</td>
                    </tr>
                    <tr>
                      <th class="text-right">{{$t('user.site')}}</th>
                      <td class="text-left">{{program.empresa.website}}</td>
                    </tr>
                  </table>
                  <a class="btn btn-primary" :href="'/programa/'+program.id+'/'+program.nombre.toLowerCase().replace(/\s/g, '-')">{{$t('form.button.more-info')}}</a>
                </div>
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
            loading: false,
            noResults: false
          }
        },
        methods: {
          searchFor(){
            var este = this;
            this.loading = true
                axios.post('/search', {nombre: this.nombre, pais: this.paisid, categoria: this.categoria}).then(function(results){
                    este.results = results.data
                    console.log(este.results);
                    
                    for (var i = 0; i < este.results.length; i++) {
                      if (este.results[i].apellido_p) {
                        var apP = este.results[i].apellido_p
                      }else{
                        var apP = ''
                      }
                      if (este.results[i].apellido_m) {
                        var apM = este.results[i].apellido_m
                      }else{
                        var apM = ''
                      }
                      var cadena = este.results[i].name+'-'+apP+'-'+apM
                      cadena = cadena.toLowerCase();

                       cadena = cadena.replace(/ /g,"-");

                       cadena = cadena.replace(/á/gi,"a");
                       cadena = cadena.replace(/é/gi,"e");
                       cadena = cadena.replace(/í/gi,"i");
                       cadena = cadena.replace(/ó/gi,"o");
                       cadena = cadena.replace(/ú/gi,"u");
                       cadena = cadena.replace(/ñ/gi,"n");
                      este.results[i].slug = cadena
                    }
                }).then(function(){
                  $(".Masthead").addClass('full-height')
                  este.search = true
                  if (este.results.length === 0) {
                    este.noResults = true
                  }
                    este.loading = false
                  window.location.href = '#results'
                });


          },
          home(){
            this.search = false
            this.noResults = false
            $(".Masthead").removeClass('full-height')
          },
          listCountry(){
            var este = this;
            if (this.paises.length !== 0) {
              this.paises = []
            }else{
              axios.get('/get-paises').then(function(paises){
                este.paises = paises.data;
              });
            }
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
