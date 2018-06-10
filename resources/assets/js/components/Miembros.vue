<template>
    <div id="memberSection" class="container center-content" style="min-height:600px; position: relativo" :class="{activated : selected}">
        <div class="row" style="height:100%; margin: 0 auto;" :class="{plusWidth : selected}">
          <div v-if="selected" class="col-md-12 text-right">
            <button class="btn-back btn" @click="selected = false">< Regresar</button>
          </div>
            <div class="col-md-12">
              <div>
                <h2 class="text-center">Conoce a nuestros miembros ICCN</h2>
                <h3 v-if="!selected" class="text-center">Selecciona el área de tu interes</h3>
                <form v-else style="width: 80%; margin: 0 auto;">
                  <br>
                  <div class="row">
                    <div class="col text-right">
                      <h4>Busca un miembro:</h4>
                    </div>
                    <div class="col">
                      <input v-model="nombre" @keyup="search()" type="text" class="form-control" placeholder="Nombre">
                    </div>
                    <div class="col" style="position: relative">
                      <input v-model="pais" type="text" class="form-control" placeholder="País" @keyup="searchPais()">
                      <transition name="fade">
                        <ul v-if="searchCountry" class="input-results list-group">
                           <a @click="setPais(pais.id, pais.nombre)" v-for="pais in paises" role="button" class="list-group-item list-group-item-action">{{pais.nombre}}</a>
                        </ul>
                      </transition>
                    </div>
                  </div>
                  <hr>
                </form>
              </div>
              <transition-group name="fade">
                <div v-if="selected && selected !== 5" :key="0" id="memberCards" class="row" :style="active">
                  <div v-if="member.perfil && member.perfil.status === 1 || member.empresa && member.empresa.status === 1" class="col-lg-6" v-for="member in members">
                    <div class="card" :class="{conscard: consultor, coachcard: coach, capacard: capacitador, empresacard: empresa, programcard: programa}">
                      <div class="card-header">
                        <div class="row">
                          <div class="col-3">
                            <div v-if="member.perfil" class="member">
                              <div class="member-picture" :style="'background: url(/storage/'+member.perfil.foto+') center no-repeat'"></div>
                              <div class="member-flag" :style="'background: url(/storage/flags/'+member.perfil.pais.id+'.png) center no-repeat'"></div>
                            </div>
                            <div v-else class="member">
                              <div class="member-picture" :style="'background: url(/storage/'+member.empresa.foto+') center no-repeat'"></div>
                              <div class="member-flag" :style="'background: url(/storage/flags/'+member.empresa.pais.id+'.png) center no-repeat'"></div>
                            </div>
                          </div>
                          <div class="col-9 text-right">
                            <div class="row">
                              <div class="col-md-10" style="padding-top:3px;">
                                <h3 v-if="member.perfil">{{member.perfil.name+' '+member.perfil.apellido_p+' '+member.perfil.apellido_m}}</h3>
                                <h3 v-else>{{member.empresa.name}}</h3>
                              </div>
                              <div class="col-md-2">
                                <img v-if="selected === 1" width="40" src="/media/img/categorias/consultor.png" alt="categoria_icon">
                                <img v-if="selected === 2" width="40" src="/media/img/categorias/coach.png" alt="categoria_icon">
                                <img v-if="selected === 3" width="40" src="/media/img/categorias/capacitador.png" alt="categoria_icon">
                                <img v-if="selected === 4" width="40" src="/media/img/categorias/empresa.png" alt="categoria_icon">
                                <img v-if="selected === 5" width="40" src="/media/img/categorias/programas.png" alt="categoria_icon">
                              </div>
                            </div>
                            <span v-if="selected === 1">Consultor</span>
                            <span v-if="selected === 2">Coach</span>
                            <span v-if="selected === 3">Capacitador</span>
                            <span v-if="selected === 4">Empresa</span>
                            <span v-if="selected === 5">Programa</span> <br>
                            <a :href="member.perfil ? member.perfil.fb : member.empresa.fb"><img width="30" src="/media/img/recursos/fb-logo.png" alt="facebook logo"></a>


                            <a :href="member.perfil ? member.perfil.tw : member.empresa.tw"><img width="30" src="/media/img/recursos/tw-logo.png" alt="facebook logo"></a>


                            <a :href="member.perfil ? member.perfil.in : member.empresa.in"><img width="30" src="/media/img/recursos/in-logo.png" alt="facebook logo"></a>

                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="card-text text-center">
                          <table class="table">
                            <tr>
                              <th class="text-right">Folio</th>
                              <td class="text-left">{{member.folio}}</td>
                            </tr>
                            <tr>
                              <th class="text-right">Tipo de Miembro</th>
                              <td class="text-left" style="text-transform: capitalize">{{member.perfil ? member.perfil.rango : member.empresa.rango}}</td>
                            </tr>
                            <tr>
                              <th class="text-right">Correo electrónico</th>
                              <td class="text-left">{{member.email}}</td>
                            </tr>
                            <tr>
                              <th class="text-right">Sitio Web</th>
                              <td class="text-left">{{member.perfil ? member.perfil.website : member.empresa.website}}</td>
                            </tr>
                          </table>
                          <a v-if="selected !== 4" class="btn btn-primary" :href="'/perfil/'+member.folio">Más información</a>
                          <a v-else class="btn btn-primary" :href="'/empresa/'+member.folio">Más información</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-else-if="selected && selected === 5" :key="1" id="memberCards" class="row" :style="active">
                  <div v-if="program.status === 1" class="col-md-6" v-for="program in programs">
                    <div class="card programcard">
                      <div class="card-header">
                        <div class="row">
                          <div class="col-sm-3">
                            <div class="member">
                              <div class="member-picture" :style="'background: url(/storage/'+program.foto+') center no-repeat'"></div>
                              <div class="member-flag" :style="'background: url(/storage/flags/'+program.empresa.pais.id+'.png) center no-repeat'"></div>
                            </div>
                          </div>
                          <div class="col-sm-9 text-right">
                            <div class="row">
                              <div class="col-md-10" style="padding-top:3px;">
                                <h3>{{program.nombre}}</h3>
                              </div>
                              <div class="col-md-2">
                                <img width="40" src="/media/img/categorias/programas.png" alt="categoria_icon">
                              </div>
                            </div>
                            <span>Programa</span> <br>
                            <a v-if="program.empresa.fb" :href="program.empresa.fb"><img width="30" src="/media/img/recursos/fb-logo.png" alt="facebook logo"></a>
                            <a v-if="program.empresa.tw" :href="program.empresa.tw"><img width="30" src="/media/img/recursos/tw-logo.png" alt="facebook logo"></a>
                            <a v-if="program.empresa.in" :href="program.empresa.in"><img width="30" src="/media/img/recursos/in-logo.png" alt="facebook logo"></a>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="card-text text-center">
                          <table class="table">
                            <tr>
                              <th class="text-right">Folio</th>
                              <td class="text-left">{{program.empresa.user.folio}}</td>
                            </tr>
                            <tr>
                              <th class="text-right">Tipo de Miembro</th>
                              <td class="text-left">{{program.empresa.rango}}</td>
                            </tr>
                            <tr>
                              <th class="text-right">Correo electrónico</th>
                              <td class="text-left">{{program.empresa.user.email}}</td>
                            </tr>
                            <tr>
                              <th class="text-right">Sitio Web</th>
                              <td class="text-left">{{program.empresa.website}}</td>
                            </tr>
                          </table>
                          <a class="btn btn-primary" :href="'/programa/'+program.id">Más información</a>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </transition-group>
                <ul class="category-list" :class="{fixedCat : selected}">
                  <li @click="setSelection(1)">
                    <img name="cat" src="/media/img/categorias/consultor.png" alt="consultores_icon"> <br>
                    Consultores
                  </li>
                  <li @click="setSelection(2)">
                    <img name="cat" src="/media/img/categorias/coach.png" alt="coaches_icon"> <br>
                    Coaches
                  </li>
                  <li @click="setSelection(3)">
                    <img name="cat" src="/media/img/categorias/capacitador.png" alt="capacitador_icon"> <br>
                    Capacitadores
                  </li>
                  <li @click="setSelection(4)">
                    <img name="cat" src="/media/img/categorias/empresa.png" alt="empresa_icon"> <br>
                    Empresas
                  </li>
                  <li @click="setSelection(5)">
                    <img name="cat" src="/media/img/categorias/programas.png" alt="programa_icon"> <br>
                    Programas
                  </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {

        },
        data(){
          return {
            selected: false,
            active: {
              height: '0px',
              overflowY: 'scroll',
              overflowX: 'hidden',
            },
            members:[],
            programs:[],
            consultor: false,
            coach: false,
            capacitador: false,
            empresa: false,
            programa: false,
            pais: '',
            nombre: '',
            paisid: 0,
            resultados: [],
            paises: [],
            searchCountry: false

          }
        },
        methods:{
          setSelection(sw){
            var este = this;
            this.selected = sw
            window.location = "#memberSection"
            this.active= {
              height: 'auto',
              maxHeight: '550px',
              minHeight: '480px',
              overflowY: 'scroll',
              overflowX: 'hidden',
              marginBottom: '140px',
              marginTop: '50px',
              margin: '0px auto 149px auto',
              paddingTop: '60px'
            }

            if (sw === 1) {
              this.consultor = true
              this.coach = false
              this.capacitador = false
              this.empresa = false
              this.programa = false
            }
            if (sw === 2) {
              this.consultor = false
              this.coach = true
              this.capacitador = false
              this.empresa = false
              this.programa = false
            }
            if (sw === 3) {
              this.consultor = false
              this.coach = false
              this.capacitador = true
              this.empresa = false
              this.programa = false
            }
            if (sw === 4) {
              this.consultor = false
              this.coach = false
              this.capacitador = false
              this.empresa = true
              this.programa = false
            }
            if (sw === 5) {
              axios.get('/get-programas').then(function(programas){
                este.programs = programas.data
              }).then(function(){
                este.consultor = false
                este.coach = false
                este.capacitador = false
                este.empresa = false
                este.programa = true
              });
            }else{
              axios.get('/get-members/'+sw).then(function(members){
                este.members = members.data
                console.log(este.members);
              });
            }
          },
          search(){
            var este = this;
            this.members = [];
            if (this.nombre !== '') {
              axios.post('/search-members', {nombre: this.nombre, pais: this.paisid, categoria: this.selected}).then(function(results){
                este.members = results.data
              });
            }else{
              axios.get('/get-members/'+this.selected).then(function(members){
                este.members = members.data
              });
            }

          },
          searchPais(){
            var este = this;
            this.searchCountry = true
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
            this.searchCountry = false
          }
        }
    }
</script>
