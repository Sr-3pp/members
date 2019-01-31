<template>
  <div class="row mt-5">
    <div class="col-lg-12">
      <div class="input-group">
        <input @keyup="searchProgram()" type="text" class="form-control" id="validationCustomUsername" placeholder="Busca un Programa" aria-describedby="inputGroupPrepend" v-model="programs">
        <div class="input-group-prepend">
          <button type="button" class="btn btn-default"><i class="fas fa-search"></i></button>
        </div>
        <div class="input-group-prepend">
          <button @click="$bus.$emit('registerModal', {sw: 2, admin: 1})" class="btn btn-link" ><i class="fas fa-plus"></i></button>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <ul class="list-group">
        <li class="list-group-item">
          <div class="row">
            <div  v-for="(programa, index) in programas" class="col-xl-4" style="padding:30px;">
              <div class="user-card">
                <div class="row" style="border-bottom: none">
                  <div class="col-3">
                    <div class="row">
                      <div class="col" style="height: 151px;">
                        <div class="panel-member-pic">
                          <div :style="'background: url(/storage/'+programa.foto+') center no-repeat; background-size: cover; height:100%;'"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-9">
                    <div class="row"  v-if="editEmpresa !== magic+'_'+index">
                      <div class="col">
                        <b>Status:</b><br>
                        <button @click="setStatus(programa.id, index)" class="btn btn-link" :class="{success : programa.status, danger: !programa.status}">
                          <i class="fas fa-circle"></i>
                        </button>
                      </div>
                      <div @click="edit(index, 1, 'duracion')" class="col">
                        <span :id="'spanduracion_'+index">
                          <b>Duración: </b><br>{{programa.duracion}}
                        </span>
                      </div>
                      <div @click="edit(index, 1, 'empresa')" class="col">
                        <span :id="'spanempresa_'+index">
                          <b>Empresa: </b><br>{{programa.empresa.name}}
                        </span>
                      </div>
                    </div>
                    <div  v-if="editEmpresa === magic+'_'+index" class="row">
                      <div v-if="magic === 'empresa'" class="col">
                        <b>Empresa:</b>
                        <div  style="margin-top: -8px;" class="input-group" :id="magic+'_'+index">
                          <input @keyup="searchEmpresas" type="text" class="form-control" placeholder="Escribe el nombre de la empresa" aria-describedby="inputGroupPrepend" v-model="empresa">
                          <div class="input-group-prepend">
                            <button @click="edit(index, 0, 'empresa')" type="button" class="btn btn-danger"><i class="fas fa-times"></i></button>
                          </div>
                          <div class="input-group-prepend">
                            <button type="button" class="btn btn-success" data-toggle="modal" @click="update(programa.id, index)"><i class="fas fa-check"></i></button>
                          </div>
                          <transition name="fade">
                            <ul style="margin-top: 45px;" v-if="empresas.length !== 0 && empresa !== ''" class="list-group input-results">
                              <a @click="setEmpresa(index, empresa.name, 1)" href="#" role="button" class="list-group-item list-group-item-action" v-for="(empresa, index) in empresas">{{empresa.name}}</a>
                            </ul>
                          </transition>
                        </div>
                      </div>
                      <div v-if="magic === 'duracion'" class="col">
                        <b>Duración:</b>
                        <div  style="margin-top: -8px;" class="input-group" :id="magic+'_'+index">
                          <input type="text" class="form-control" placeholder="xx meses" :value="programa.duracion">
                          <div class="input-group-prepend">
                            <button @click="edit(index, 0, magic)" type="button" class="btn btn-danger"><i class="fas fa-times"></i></button>
                          </div>
                          <div class="input-group-prepend">
                            <button type="button" class="btn btn-success" data-toggle="modal" @click="update(programa.id, index)"><i class="fas fa-check"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div v-if="editNombre !== magic+'_'+index" @click="edit(index, 1, 'name')" class="col">
                        <span>
                          <b>Nombre: </b><br>{{programa.nombre}}
                        </span>
                      </div>
                      <div v-if="editNombre === magic+'_'+index" class="col">
                        <div style="margin-top: -8px;" class="input-group" :id="magic+'_'+index">
                          <input type="text" class="form-control" :value="programa.nombre" aria-describedby="inputGroupPrepend">
                          <div class="input-group-prepend">
                            <button @click="edit(index, 0, magic)" type="button" class="btn btn-danger"><i class="fas fa-times"></i></button>
                          </div>
                          <div class="input-group-prepend">
                            <button type="button" class="btn btn-success" data-toggle="modal" @click="update(programa.id, index)"><i class="fas fa-check"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div v-if="editAlcance !== magic+'_'+index" @click="edit(index, 1, 'alcance')" class="col">
                    <span><b>Alcance: </b><br>{{programa.alcance}}</span>
                  </div>
                  <div v-if="editAlcance === magic+'_'+index" class="col">
                    <div style="margin-top: -8px;" class="input-group" :id="magic+'_'+index">
                      <textarea type="text" :value="programa.alcance" class="form-control" aria-describedby="inputGroupPrepend"></textarea>
                      <div class="input-group-prepend">
                        <button @click="edit(index, 0, magic)" type="button" class="btn btn-danger"><i class="fas fa-times"></i></button>
                      </div>
                      <div class="input-group-prepend">
                        <button type="button" class="btn btn-success" data-toggle="modal" @click="update(programa.id, index)"><i class="fas fa-check"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <span>
                      <b>Participanes: </b> <span class="badge badge-primary">{{programa.participantes.length}} </span><button style="float: right" class="btn btn-success" @click="addPart(programa.id, index)"><i class="fas fa-plus"></i></button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
    export default {
        mounted() {
          var este = this;
            axios.get('/panel/get-programas').then(function(programas){
              este.programas = programas.data

            });

            this.$bus.$on('newProg', ($event) => {
              este.programas.unshift($event.program)
            })
            this.$bus.$on('pushPart', ($event) => {
              este.programas[$event.index].participantes.push($event.participant)
              $("#participantsModal").modal('hide')
            })
        },
        data(){
          return {
            programas: [],
            programs: '',
            programa: '',
            empresa: '',
            empresas: [],
            editEmpresa: false,
            editNombre: false,
            editAlcance: false,
            magic: '',
            newEmpresa: '',
            duracion: ''
          }
        },
        methods: {
          deleteProgram(id, key){
            var este = this;
            if (confirm('Seguro?') === true) {
              axios.get('/delete-program/'+id).then(function(){
                este.programas.splice(key, 1);
              });
            }
          },
          setStatus(id, key){
            var este = this;
            axios.get('/status-programa/'+id).then(function(program){
              este.programas.splice(key, 1);
              este.programas.splice(key, 0, program.data);
            });
          },
          searchProgram(){
            var este = this;
            this.programas = []
            if (this.programs !== '') {
              axios.post('/search-programa', {programa: this.programs}).then(function(programas){
                este.programas = programas.data
              });
            }else{
              axios.get('/get-programas').then(function(programas){
                este.programas = programas.data
              });
            }
          },
          searchEmpresas(){
            var este = this;
            this.empresas = []
            if (this.programa !== '') {
              axios.post('/search-empresa', {empresa: this.empresa}).then(function(empresa){
                este.empresas = empresas.data
              });
            }else{
              axios.get('/panel/get-empresas').then(function(empresas){
                este.empresas = empresas.data
              });
            }
          },
          edit(index, sw, magic){
            var este = this;
            var group = $("#"+this.magic+"_"+index)
            var span = $("#span"+this.magic+"_"+index)
            this.magic = magic

            if (sw === 1) {

              if (magic === 'empresa' || magic === 'duracion') {
                this.editEmpresa = magic+'_'+index
              }
              if (magic === 'name') {
                this.editNombre = magic+'_'+index
              }
              if (magic === 'alcance') {
                this.editAlcance = magic+'_'+index
              }


            }else{
              if (magic === 'empresa' || magic === 'duracion') {
                this.editEmpresa = false
              }
              if (magic === 'name') {
                this.editNombre = false
              }
              if (magic === 'alcance') {
                this.editAlcance = false
              }
            }
          },
          setEmpresa(index, id, sw ){
            this.newEmpresa = this.empresas[index]
            this.empresa = this.empresas[index].name
            this.empresas = []
          },
          update(id, index){
            var este = this;
            var group = $("#"+this.magic+"_"+index)
            var span = $("#span"+this.magic+"_"+index)

            if (this.magic === 'alcance') {
              var input = $("#"+this.magic+"_"+index+">textarea")
            }else{
              var input = $("#"+this.magic+"_"+index+">input")
            }

            if (this.magic === 'empresa') {
              axios.post('/panel/update-programa', {id: id, value: this.newEmpresa.id, magic: this.magic}).then(function(empresa){
                este.programas.splice(index, 1);
                este.programas.splice(index, 0, empresa.data);
                este.empresas = []
                este.edit(index, 0, este.magic)
              });
            }
            if (this.magic === 'duracion' || this.magic === 'alcance') {
              axios.post('/panel/update-programa', {id: id, value: input.val(), magic: this.magic}).then(function(empresa){
                este.programas.splice(index, 1);
                este.programas.splice(index, 0, empresa.data);
                este.empresas = []
                este.edit(index, 0, este.magic)
              });
            }
            if (this.magic === 'name') {
              axios.post('/panel/update-programa', {id: id, value: input.val(), magic: this.magic}).then(function(empresa){
                este.programas.splice(index, 1);
                este.programas.splice(index, 0, empresa.data);
                este.edit(index, 0, este.magic)
              });
            }
          },
          addPart(id, index){
            $("#participantsModal").modal()
            this.$bus.$emit('addPart',  {id: id, index: index});
          }
        }
    }
</script>
