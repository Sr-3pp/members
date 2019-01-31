<template>
<div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Registrar Programa
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>Los campos marcados con * son obligatorios</h5>
        <hr>
        <form>
          <div class="row">
            <div class="col">
              <transition name="fade">
                <span v-if="alertName" class="must">Este campo es obligatorio</span>
              </transition>
              <input maxlength="250" v-model="nombre" type="text" class="form-control" placeholder="Programa*">
            </div>
            <div class="col">
              <transition name="fade">
                <span v-if="alertMail" class="must">{{alertMailText}}</span>
              </transition>
              <input maxlength="100" v-model="duracion" type="text" class="form-control" placeholder="Duración*">
            </div>
            <div v-if="empresaid === 0" class="col">
              <div class="input-group">
                <transition name="fade">
                  <span v-if="alertTel" class="must">Este campo es obligatorio</span>
                </transition>
                <input @keyup="searchEmpresa" v-model="empresa" type="text" class="form-control" placeholder="Empresa que lo imparte">
                <div class="input-group-prepend">
                  <button type="button" @click="listEmpresas" class="btn btn-default"><i class="fas fa-chevron-down"></i></button>
                </div>
              </div>
              <transition name="fade">
                <ul v-if="searchEmpresa" class="input-results list-group">
                   <a @click="setEmpresa(empresa.id, empresa.name)" v-for="empresa in empresas" role="button" class="list-group-item list-group-item-action">{{empresa.name}}</a>
                </ul>
              </transition>
            </div>
            <div v-else class="col text-center">
                <span>{{empresa}}</span> <button type="button" class="btn btn-link danger" @click="empresaid = 0"><i class="fas fa-times"></i></button>
            </div>
          </div>
        </form>
        <hr>
        <div class="row">
          <div class="col text-center">
            <br>
            <h4>Áreas de expertise</h4>
          </div>
          <div class="col text-center">
            <input maxlength="10" @keyup="validateVal(1)" v-model="area1" style="margin-bottom: 10px" type="text" class="form-control" placeholder="Área 1">
            <span class="reg-stars">
              <span @click="level('a', index)" :id="'stara_'+index" @mouseover="setlevel('a', index, 1)"  @mouseout="setlevel('a', index, 0)" v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
          </div>
          <div class="col">
            <input maxlength="10" @keyup="validateVal(2)" :disabled="area1 === '' || area1v === 0" v-model="area2" style="margin-bottom: 10px" type="twxt" class="form-control" placeholder="Área 2">
            <span class="reg-stars" v-if="area1 !== '' && area1v !== 0">
              <span @click="level('b', index)" :id="'starb_'+index"  @mouseover="setlevel('b', index, 1)"  @mouseout="setlevel('b', index, 0)" v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
            <span class="reg-stars" v-else>
              <span  v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col">
            <input maxlength="10" @keyup="validateVal(3)"  :disabled="area1 === '' || area1v === 0 || area2 === '' || area2v === 0" v-model="area3" style="margin-bottom: 10px" type="text" class="form-control" placeholder="Área 3">
            <span class="reg-stars" v-if="area1 !== '' && area1v !== 0 && area2 !== '' && area2v !== 0">
              <span @click="level('c', index)" :id="'starc_'+index" @mouseover="setlevel('c', index, 1)"  @mouseout="setlevel('c', index, 0)" v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
            <span class="reg-stars" v-else>
              <span  v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
          </div>
          <div class="col">
            <input maxlength="10" @keyup="validateVal(4)" :disabled="area1 === '' || area1v === 0 || area2 === '' || area2v === 0 || area3 === '' || area3v === 0" v-model="area4" style="margin-bottom: 10px" type="text" class="form-control" placeholder="Área 4">
            <span class="reg-stars" v-if="area1 !== '' && area1v !== 0 && area2 !== '' && area2v !== 0 && area3 !== '' && area3v !== 0">
              <span @click="level('d', index)" :id="'stard_'+index"  @mouseover="setlevel('d', index, 1)"  @mouseout="setlevel('d', index, 0)" v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
            <span class="reg-stars" v-else>
              <span  v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
          </div>
          <div class="col">
            <input maxlength="10" :disabled="area1 === '' || area1v === 0 || area2 === '' || area2v === 0 || area3 === '' || area3v === 0 || area4=== '' || area4v === 0" v-model="area5" style="margin-bottom: 10px" type="text" class="form-control" placeholder="Área 5">
            <span class="reg-stars" v-if="area1 !== '' && area1v !== 0 && area2 !== '' && area2v !== 0 && area3 !== '' && area3v !== 0 && area4 !== '' && area4v !== 0">
              <span @click="level('e', index)" :id="'stare_'+index" @mouseover="setlevel('e', index, 1)"  @mouseout="setlevel('e', index, 0)" v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
            <span class="reg-stars" v-else>
              <span  v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col">
            <transition name="fade">
              <span v-if="alertCv" class="must">Este campo es obligatorio</span>
            </transition>
            <label>Alcance *</label>
            <textarea style="height: 200px!important" v-model="cv" cols="30" rows="10" class="form-control"></textarea>
          </div>
          <div class="col">
            <preview></preview>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" @click="register">Registrar</button>
      </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            var este = this;
            this.csrf = $('meta[name="csrf-token"]').attr('content')
            this.$bus.$on('file', ($event) => {
              este.picture = $event.file              
            });

        },
        data(){
          return {
            csrf: '',
            levelsetted: false,
            nombre: '',
            duracion: '',
            empresa: '',
            empresas: [],
            pais: '',
            paises: [],
            area1: '',
            area2: '',
            area3: '',
            area4: '',
            area5: '',
            area1v: 0,
            area2v: 0,
            area3v: 0,
            area4v: 0,
            area5v: 0,
            cv: '',
            foto: '/media/img/defaults/profile_1.png',
            picture: null,

            alertName: false,
            alertMail: false,
            alertMailText: 'Este campo es Obligatorio',
            alertTel: false,
            alertPais: false,
            alertCv: false,



            searchCountry: false,
            searchEmpresas: false,
            empresaid: 0,
            paisid: 0
          }
        },
        methods: {
          reset(){
            this.levelsetted =  false
            this.nombre =  ''
            this.duracion =  ''
            this.empresa =  ''
            this.empresas =  []
            this.pais =  ''
            this.paises =  []
            this.area1 =  ''
            this.area2 =  ''
            this.area3 =  ''
            this.area4 =  ''
            this.area5 =  ''
            this.area1v =  0
            this.area2v =  0
            this.area3v =  0
            this.area4v =  0
            this.area5v =  0
            this.cv =  ''
            this.foto =  '/media/img/defaults/profile_1.png'
            this.picture =  null

            this.alertName =  false
            this.alertMail =  false
            this.alertMailText =  'Este campo es Obligatorio'
            this.alertTel =  false
            this.alertPais =  false
            this.alertCv =  false

            this.searchCountry =  false
            this.searchEmpresas =  false
            this.empresaid =  0
            this.paisid =  0
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
          },
          searchEmpresa(){
            var este = this;
            this.searchEmpresas = true
            if (this.empresa !== '') {
              axios.post('/search-empresas', {empresa: this.empresa}).then(function(empresas){
                este.empresas = empresas.data;
              });
            }else{
              este.empresas = []
            }
          },
          listEmpresas(){
            var este = this;
            axios.get('/panel/get-empresas').then(function(empresas){
              este.empresas = empresas.data;
            });
          },
          setEmpresa(id, nombre){
            this.empresaid = id
            this.empresa = nombre
            this.searchEmpresas = false
          },
          validateVal(key){
            if (key === 1) {
              if (this.area1 === '' || this.area1v === 0) {

                this.area2 = ''
                this.area2v = 0
                this.area3 = ''
                this.area3v = 0
                this.area4 = ''
                this.area4v = 0
                this.area5 = ''
                this.area5v = 0
              }
            }
            if (key === 2) {
              if (this.area1 === '' || this.area1v === 0 && this.area2 === ''|| this.area2v === 0) {
                this.area3 = ''
                this.area3v = 0
                this.area4 = ''
                this.area4v = 0
                this.area5 = ''
                this.area5v = 0
              }
            }
            if (key === 3) {
              if (this.area1 === '' || this.area1v === 0 || this.area2 === '' || this.area2v === 0 || this.area3 === '' || this.area3v === 0) {
                this.area4 = ''
                this.area4v = 0
                this.area5 = ''
                this.area5v = 0
              }
            }
            if (key === 4) {
              if (this.area1 === '' || this.area1v === 0 || this.area2 === '' || this.area2v === 0 || this.area3 === '' || this.area3v === 0 || this.area4 === '' || this.area4v === 0) {
                this.area5 = ''
                this.area5v = 0
              }
            }
          },
          setlevel(key, index, sw){
            if (sw === 1) {
              for (var i = 0; i < index+1 ; i++) {
                if (key === 'a') {
                  if (this.area1v === 0) {
                    $('#star'+key+'_'+i).addClass('active')
                  }
                }
                if (key === 'b') {
                  if (this.area2v === 0) {
                    $('#star'+key+'_'+i).addClass('active')
                  }
                }
                if (key === 'c') {
                  if (this.area3v === 0) {
                    $('#star'+key+'_'+i).addClass('active')
                  }
                }
                if (key === 'd') {
                  if (this.area4v === 0) {
                    $('#star'+key+'_'+i).addClass('active')
                  }
                }
                if (key === 'e') {
                  if (this.area5v === 0) {
                    $('#star'+key+'_'+i).addClass('active')
                  }
                }
              }
            }else{
                for (var i = 0; i < index+1 ; i++) {
                  if (key === 'a') {
                    if (this.area1v === 0) {
                      $('#star'+key+'_'+i).removeClass('active')
                    }
                  }
                  if (key === 'b') {
                    if (this.area2v === 0) {
                      $('#star'+key+'_'+i).removeClass('active')
                    }
                  }
                  if (key === 'c') {
                    if (this.area3v === 0) {
                      $('#star'+key+'_'+i).removeClass('active')
                    }
                  }
                  if (key === 'd') {
                    if (this.area4v === 0) {
                      $('#star'+key+'_'+i).removeClass('active')
                    }
                  }
                  if (key === 'e') {
                    if (this.area5v === 0) {
                      $('#star'+key+'_'+i).removeClass('active')
                    }
                  }
                }
            }
          },
          selectPic(){
            $('#registerPic').click()
          },
          level(key, index){
            if (key === 'a') {
              if (this.area1v === 0) {
                this.area1v = index+1
              }else{
                this.area1v = 0
                this.validateVal(1)
              }
            }
            if (key === 'b') {
              if (this.area2v === 0) {
                this.area2v = index+1
              }else{
                this.area2v = 0
                this.validateVal(2)
              }
            }
            if (key === 'c') {
              if (this.area3v === 0) {
                this.area3v = index+1
              }else{
                this.area3v = 0
                this.validateVal(3)
              }
            }
            if (key === 'd') {
              if (this.area4v === 0) {
                this.area4v = index+1
              }else{
                this.area4v = 0
                this.validateVal(4)
              }
            }
            if (key === 'e') {
              if (this.area5v === 0) {
                this.area5v = index+1
              }else{
                this.area5v = 0
                this.validateVal(5)
              }
            }
            for (var i = 0; i < index+1 ; i++) {
              $('#star'+key+'_'+i).addClass('active')
            }
          },
          register(){
            if (this.nombre === '' || this.duracion === '' || this.empresaid === 0 || this.pais === '' || this.cv === '') {
              if (this.nombre === '') {
                this.alertName = true
              }else{
                this.alertName = false
              }
              if (this.duracion === '') {
                this.alertMail = true
              }else{
                this.alertMail = false
              }
              if (this.empresaid === 0) {
                this.alertTel = true
              }else{
                this.alertTel = false
              }

              if (this.pais === '') {
                this.alertPais = true
              }else{
                this.alertPais = false
              }
              if (this.cv === '') {
                this.alertCv = true
              }else{
                this.alertCv = false
              }

            }else{
              this.alertName = false
              this.alertMail = false
              this.alertPais = false
              this.alertCv = false

              var este = this;
              var formData = new FormData();
              formData.append('nombre' , this.nombre);
              formData.append('duracion' , this.duracion);
              formData.append('empresa' , this.empresaid);
              formData.append('pais' , this.pais);
              formData.append('area1' , this.area1);
              formData.append('area2v' , this.area2v);
              formData.append('area2' , this.area2);
              formData.append('area3v' , this.area3v);
              formData.append('area3' , this.area3);
              formData.append('area1v' , this.area1v);
              formData.append('area4' , this.area4);
              formData.append('area4v' , this.area4v);
              formData.append('area5' , this.area5);
              formData.append('area5v' , this.area5v);
              formData.append('cv' , this.cv);
              formData.append('picture', this.picture);

              axios.post('/new-programa', formData).then(function(program){
                este.$bus.$emit('newProg', {program: program.data});
              }).then(function(){
                $('#registerModal').modal('hide');
                este.reset();
              });
            }
          }
        }
    }
</script>
