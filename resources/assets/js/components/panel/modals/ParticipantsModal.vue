<template>
  <div class="modal fade" id="participantsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Participantes:
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <transition name="fade">
              <span class="must" v-if="alertNombre">Campo obligatorio</span>
            </transition>
            <input type="text" class="form-control" placeholder="Nombre" v-model="nombre">
          </div>
          <div v-if="paisid === 0" class="col" style="position: relative">
            <div class="input-group">
                  <input :disabled="paises.length === 0" @keyup="searchPais" v-model="pais" type="text" class="form-control" :placeholder="$t('form.placeholder.Country')">
                  <div class="input-group-prepend">
                    <button @click="listCountry" type="button" class="btn btn-default"><i class="fas fa-chevron-down"></i></button>
                  </div>
                </div>
                <transition name="fade">
                  <ul v-if="paises.length !== 0" class="input-results list-group">
                     <a @click="setPais(pais.id, pais.nombre)" v-for="pais in paises" role="button" class="list-group-item list-group-item-action">{{pais.nombre}}</a>
                  </ul>
                </transition>
          </div>
          <div v-else class="col text-center">
              <span>{{pais}}</span> <button class="btn btn-link danger" @click="paisid = 0"><i class="fas fa-times"></i></button>
          </div>
          <div class="col">
            <transition name="fade">
              <span class="must" v-if="alertFolio">Campo obligatorio</span>
            </transition>
            <input type="text" class="form-control" placeholder="Folio" v-model="folio">
          </div>
        </div>
        <hr>
        <div class="row text-center">
          <div class="col"><b>Nombre</b></div>
          <div class="col"><b>País</b></div>
          <div class="col"><b>Folio</b></div>
        </div>
        <hr>
        <div class="row text-center" v-for="(participante, index) in participantes">
          <div class="col">{{participante.nombre}}</div>
          <div class="col">{{participante.pais.nombre}}</div>
          <div class="col">{{participante.folio}}</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" @click="add()">Registrar</button>
      </div>
    </div>
  </div>
</div>
</template>

<script>
    export default {
        mounted() {
            var este = this;
            this.$bus.$on('addPart', ($event) => {
              this.programaid = $event.id
              this.index = $event.index
              axios.get('/panel/get-participantes/'+this.programaid).then(function(participantes){
                este.participantes = participantes.data
              });
            });
        },
        data(){
          return {
            paisid: 0,
            pais: '',
            searchCountry: false,
            paises: [],
            nombre: '',
            folio: '',
            index: null,
            programaid: 0,
            alertNombre: false,
            alertFolio: false,
            participantes: []
          }
        },
        methods: {
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
          setPais(id, nombre){
            this.paisid = id
            this.pais = nombre
            this.searchCountry = false
          },
          add(){
            var este = this;
            if (this.nombre !== '' && this.folio !== '') {
              axios.post('/panel/add-participant', {nombre: this.nombre, folio: this.folio, pais: this.paisid, programa: this.programaid}).then(function(participante){
                este.participantes.push(participante.data)
                este.$bus.$emit('pushPart', {participant: participante.data, index: este.index});
              });
            }else{
              if (this.nombre === '') {
                this.alertNombre = true
              }
              if (this.folio === '') {
                this.alertFolio = true
              }
            }
          }
        }
    }
</script>
