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
            <div  v-for="(programa, index) in programas" class="col-xl-4" style="padding:30px; text-align: center">
              <div class="user-card">
                <transition name="fade">
                  <div v-if="expertise === magic+'_exp_'+index" class="skillsEdit">
                    <div class="row">
                      <div class="col">
                        <h1>Areas de expertise
                          <button @click="expertise = null" class="close right-30 white"><i class="fas fa-window-close"></i></button>
                        </h1>
                        <hr>
                        <div>
                          <div v-if="newVal !== 'newVal_'+index" v-for="(valoracion, index2) in programa.valoracion" class="row editvalorations">
                            <div class="col-4">
                              <span @click="editVal(index, valoracion.id, 1)" v-if="valoration !== 'val_'+index+'_'+valoracion.id" :id="'val_'+index+'_'+magic">{{valoracion.area}}</span>
                              <div v-if="valoration === 'val_'+index+'_'+valoracion.id" class="input-group">
                                <input ref="valoration" @keyup.esc="editVal(index, valoracion.id, 0)" @keyup.enter="updateVal(valoracion.id, 'name', index, index2)" :id="'valInput_'+valoracion.id" maxlength="30" style="margin-bottom: 10px" type="text" class="form-control" :value="valoracion.area">
                              </div>
                            </div>
                            <div class="col-8 text-left">
                              <span @click="editStars = 'stars_'+index+'_'+valoracion.id" v-if="editStars !== 'stars_'+index+'_'+valoracion.id" class="reg-stars">
                                  <span v-for="val in parseInt(valoracion.porcentaje)"><i class="fas fa-star active"></i>&nbsp;&nbsp;</span>
                              </span>
                              <span v-if="editStars === 'stars_'+index+'_'+valoracion.id" class="reg-stars">
                                <span @click="level('a', index2, valoracion.id, index, index3)" :id="'staram_'+index3+'_'+valoracion.id" @mouseover="setlevel('a', index3, 1, valoracion.id)"  @mouseout="setlevel('a', index3, 0, valoracion.id)" v-for="(star, index3) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
                              </span>
                              <button @click="deleteVal(valoracion.id, index2, index)" class="btn btn-link right danger">
                                <i class="fas fa-minus-square"></i>
                              </button>
                            </div>
                          </div>
                          <div v-if="newVal !== 'newVal_'+index" class="text-center" style="width:100%;">
                            <button @click="newVal = 'newVal_'+index" v-if="programa.valoracion.length < 5" class="btn btn-link"><i class="fas fa-plus"></i></button>
                          </div>
                          <div class="container">
                            <div v-if="newVal === 'newVal_'+index" class="row">
                              <div class="col-12">
                                <div class="input-group">
                                  <input @keyup.enter="saveVal(index, programa.id)" @keyup.esc="newVal = ''" :id="'newValInput_'+index" maxlength="40" style="margin-bottom: 10px" type="text" class="form-control" placeholder="Nombre">
                                </div>
                              </div>
                              <div class="col-12">
                                <br>
                                <span class="reg-stars">
                                  <span @click="newStars = indexs" :id="'newStarpam_'+indexs" @mouseover="setleveln('a', indexs, 1)"  @mouseout="setleveln('a', indexs, 0)" v-for="(star, indexs) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
                                </span> <br>
                                <div>
                                  <button class="btn btn-link" @click="newVal = ''"><i class="fas fa-times danger"></i></button>
                                  <button @click="saveVal(index, programa.id)" class="btn btn-link"><i class="fas fa-check success success"></i></button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </transition>
                <div class="row" style="border-bottom: none">
                  <div class="col-3">
                    <div class="row">
                      <div class="col" style="height: 151px;">
                        <div class="panel-member-pic">
                          <div  @click="changePic(index)" :id="'previewM_'+index" :style="'background: url(/storage/'+programa.foto+') center no-repeat; background-size: cover; height:100%;'"></div>
                          <div v-if="editPic === magic+'_'+index " style="position: absolute; right: 0; bottom: 0; height: auto;">
                            <button @click="editPic = false" class="btn btn-light"><i class="fas fa-times danger"></i></button>
                            <button @click="update(programa.id, index, 'pic')" class="btn btn-light"><i class="fas fa-check success success"></i></button>
                          </div>
                          <input @change="fileChange($event, index)" :id="'fileInput_'+index" type="file" class="hidden">
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
              <button @click="editskills(index)" class="btn btn-default btn-sm" style="margin: 0 auto;">Areas de expertise.</button>
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
            duracion: '',
            bkpic: null,
            picture: null,
            editPic: false,
            expertise: false,
            valoration: null,
            newVal: false,
            editStars: null,
            newStars: null
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
            if (this.magic === 'pic') {
              var formData = new FormData;
                formData.append('pic', this.picture);
                formData.append('id', id);
                formData.append('magic', this.magic);
              axios.post('/panel/update-programa', formData).then(function(empresa){
                este.programas.splice(index, 1);
                este.programas.splice(index, 0, empresa.data);
                este.edit(index, 0, este.magic)
                este.editPic = false;
              });
            }
          },
          addPart(id, index){
            $("#participantsModal").modal()
            this.$bus.$emit('addPart',  {id: id, index: index});
          },
          changePic(index){
            $("#fileInput_"+index).click()
            this.magic = 'pic'
            this.editPic = this.magic+'_'+index
            this.bkpic = this.users[index].foto
          },
          fileChange(e, index){
            let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.preview(files[0], index);
          },
          preview(file, index){
            this.picture = file

            let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                  //  vm.foto = e.target.result;
                    $("#previewM_"+index).css('background', 'url('+e.target.result+')center no-repeat')
                };
                reader.readAsDataURL(file);
          },
          editskills(id){
            this.expertise = this.magic+'_exp_'+id
          },
          editVal(index, id, sw){
            if (sw === 1) {
              this.valoration = 'val_'+index+'_'+id
            }else{
              this.valoration = null
            }
          },
          updateVal(id, magic, user, index){
            var nombre = $('#valInput_'+id).val()
            var este = this;
            axios.post('/panel/update-val', {id: id, name: nombre, magic: magic}).then(function(response){
                este.programas[user].valoracion[index] = response.data
              este.valoration = null
            })
          },
          deleteVal(id, index, user){
            var este = this;
            if (confirm("Borrar valoración?") == true) {
              axios.get('/panel/delete-val/'+id).then(function(response){
                if (response.data === 1) {
                  este.programas[index].valoracion.splice(index, 1)
                }
              });
            }
          },
          saveVal(index, id){
            var area = $('#newValInput_'+index).val()
            var percent = parseInt(this.newStars+1);
            var este = this;
            axios.post('/panel/add-valoration/'+id, {area: area, percent: percent}).then(function(response){
              este.programas[index].valoracion.push(response.data)
              este.newVal = null
            });
          },
          setlevel(key, index, sw, user){
            if (sw === 1) {
              for (var i = 0; i < index+1 ; i++) {
                if (key === 'a') {

                  $('#star'+key+'m_'+i+'_'+user).addClass('active')
                }
              }
            }else{
                for (var i = 0; i < index+1 ; i++) {
                  if (key === 'a') {
                    $('#star'+key+'m_'+i+'_'+user).removeClass('active')
                  }
                }
            }
          },
          level(key, index, valoracion, user, percent){
            for (var i = 0; i < index+1 ; i++) {
              $('#star'+key+'m_'+i+'_'+valoracion).addClass('active')
            }
            var este = this;
            var porcentaje = parseInt(percent+1);
            axios.post('/panel/update-val', {id: valoracion, percent: porcentaje, magic: 'star'}).then(function(response){
              este.programas[user].valoracion[index] = response.data
              este.editStars = null
            })
          },
          setleveln(key, index, sw){
            if (sw === 1) {
              for (var i = 0; i < index+1 ; i++) {
                if (key === 'a') {
                  if (this.newStars === null) {
                    $('#newStarp'+key+'m_'+i).addClass('active')
                  }
                }
              }
            }else{
                for (var i = 0; i < index+1 ; i++) {
                  if (key === 'a') {
                    if (this.newStars === null) {
                      $('#newStarp'+key+'m_'+i).removeClass('active')
                    }
                  }
                }
            }
          },
        }
    }
</script>
