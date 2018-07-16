<template>

    <div class="modal-content">
      <div class="modal-header">
        <h5 v-if="!admin" class="modal-title" id="exampleModalLabel">
          <span>Registrate</span><br>
          <small>(Recuerda que tu perfil estará en línea hasta realizar el pago de tu membresía.)</small>
        </h5>
        <h5 v-else class="modal-title" id="exampleModalLabel">
          <span>Agregar Usuario</span>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6">
            <h5>Los campos marcados con * son obligatorios</h5>
          </div>
          <div class="col-lg-6">
            <transition name="fade">
              <span v-if="alertFolio" class="must">{{textFolio}}</span>
            </transition>
            <input v-model="folio" type="text" class="form-control pull-right" placeholder="Folio:">
          </div>
        </div>
        <hr>
        <form>
          <div class="row">
            <div class="col">
              <transition name="fade">
                <span v-if="alertName" class="must">Este campo es obligatorio</span>
              </transition>
              <input maxlength="30" v-model="nombre" type="text" class="form-control" placeholder="Nombre*">
            </div>
            <div class="col">
              <transition name="fade">
                <span v-if="alertAp" class="must">Este campo es obligatorio</span>
              </transition>
              <input maxlength="30" v-model="apellido_p" type="text" class="form-control" placeholder="Apellido paterno *">
            </div>
            <div class="col">
              <input maxlength="30" v-model="apellido_m" type="text" class="form-control" placeholder="Apellido materno">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col">
              <transition name="fade">
                <span v-if="alertMail" class="must">{{alertMailText}}</span>
              </transition>
              <input maxlength="100" v-model="email" type="email" class="form-control" placeholder="E-mail*">
            </div>
            <div class="col">
              <transition name="fade">
                <span v-if="alertTel" class="must">Este campo es obligatorio</span>
              </transition>
              <input maxlength="10" v-model="telefono" type="text" class="form-control" placeholder="Telefono *">
            </div>
            <div class="col">
              <input maxlength="15" v-model="cel" type="text" class="form-control" placeholder="Cel.">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col">
              <transition name="fade">
                <span v-if="alertMemb" class="must">Este campo es obligatorio</span>
              </transition>
              <select v-model="membresia" class="form-control">
                <option value="">Membresia*</option>
                <option value="afiliado">Afiliado</option>
                <option value="especialista">Especialista</option>
                <option value="experto">Experto</option>
                <option value="profesional">Profesional</option>
              </select>
            </div>
            <div class="col">
              <transition name="fade">
                <span v-if="alertPais" class="must">Este campo es obligatorio</span>
              </transition>
              <select v-model="pais" class="form-control">
                <option value="">Pais*</option>
                <option v-for="pais in paises" :value="pais.id">{{pais.nombre}}</option>
              </select>
            </div>
            <div class="col">
              <input maxlength="25" v-model="ciudad" type="text" class="form-control" placeholder="Ciudad">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col">
              <transition name="fade">
                <span v-if="alertPaisr" class="must">Este campo es obligatorio</span>
              </transition>
              <select v-model="paisr" class="form-control">
                <option value="">Pais de residencia*</option>
                <option v-for="pais in paises" :value="pais.id">{{pais.nombre}}</option>
              </select>
            </div>
            <div class="col">
              <input maxlength="15" @keyup="searchLanguage" v-model="idioma" type="text" class="form-control" placeholder="Idiomas">
              <transition name="fade">
                <ul v-if="languajes.length !== 0" class="list-group input-results">
                  <a @click="setLang(languaje.nombre)" href="#" role="button" class="list-group-item list-group-item-action" v-for="languaje in languajes">{{languaje.nombre}}</a>
                </ul>
              </transition>
            </div>
          </div>
          <transition name="fade">
            <div v-if="idiomas.length !== 0" class="row">
              <br>
              <div class="col">
                  <ul class="languajes">
                    <li v-for="idioma in idiomas">
                      <span @click="delIdioma(idioma)" class="badge del-idioma"><i class="fas fa-times"></i></span>
                      <span class="languajes">{{idioma}}</span>
                    </li>
                  </ul>
              </div>
            </div>
          </transition>
          <br>
          <div class="row">
            <div class="col">
              <input maxlength="100" v-model="fb" type="text" class="form-control" placeholder="Facebook url">
            </div>
            <div class="col">
              <input maxlength="100" v-model="tw" type="text" class="form-control" placeholder="Twitter url">
            </div>
            <div class="col">
              <input maxlength="100" v-model="lin" type="text" class="form-control" placeholder="Linkedin url">
            </div>
          </div>
        </form>
        <hr>
        <h5>Selecciona 1 ó más categorias</h5>
        <br>
        <div class="row catSelector">
          <div class="col text-center">
            <transition name="fade">
              <span v-if="alertCats" class="must">Selecciona almenos una categoría</span>
            </transition>
            <img :class="{activeCat : consultor}" @click="consultor ? consultor = false : consultor = true " width="90" src="/media/img/categorias/consultor.png" alt="consultor icon">
            <h4>Consultor</h4>
          </div>
          <div class="col text-center">
            <img :class="{activeCat : coach}" @click="coach ? coach = false : coach = true " width="90" src="/media/img/categorias/coach.png" alt="coach icon">
            <h4>Coach</h4>
          </div>
          <div class="col text-center">
            <img :class="{activeCat : capacitador}" @click="capacitador ? capacitador = false : capacitador = true " width="90" src="/media/img/categorias/capacitador.png" alt="capacitador icon">
            <h4>Capacitador</h4>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col text-center">
            <br>
            <h4>Áreas de expertise</h4>
          </div>
          <div class="col text-center">
            <input maxlength="30" @keyup="validateVal(1)" v-model="area1" style="margin-bottom: 10px" type="text" class="form-control" placeholder="Área 1">
            <span class="reg-stars">
              <span @click="level('a', index)" :id="'staram_'+index" @mouseover="setlevel('a', index, 1)"  @mouseout="setlevel('a', index, 0)" v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
          </div>
          <div class="col">
            <input maxlength="30" @keyup="validateVal(2)" :disabled="area1 === '' || area1v === 0" v-model="area2" style="margin-bottom: 10px" type="twxt" class="form-control" placeholder="Área 2">
            <span class="reg-stars" v-if="area1 !== '' && area1v !== 0">
              <span @click="level('b', index)" :id="'starbm_'+index"  @mouseover="setlevel('b', index, 1)"  @mouseout="setlevel('b', index, 0)" v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
            <span class="reg-stars" v-else>
              <span  v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col">
            <input maxlength="30" @keyup="validateVal(3)"  :disabled="area1 === '' || area1v === 0 || area2 === '' || area2v === 0" v-model="area3" style="margin-bottom: 10px" type="text" class="form-control" placeholder="Área 3">
            <span class="reg-stars" v-if="area1 !== '' && area1v !== 0 && area2 !== '' && area2v !== 0">
              <span @click="level('c', index)" :id="'starcm_'+index" @mouseover="setlevel('c', index, 1)"  @mouseout="setlevel('c', index, 0)" v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
            <span class="reg-stars" v-else>
              <span  v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
          </div>
          <div class="col">
            <input maxlength="30" @keyup="validateVal(4)" :disabled="area1 === '' || area1v === 0 || area2 === '' || area2v === 0 || area3 === '' || area3v === 0" v-model="area4" style="margin-bottom: 10px" type="text" class="form-control" placeholder="Área 4">
            <span class="reg-stars" v-if="area1 !== '' && area1v !== 0 && area2 !== '' && area2v !== 0 && area3 !== '' && area3v !== 0">
              <span @click="level('d', index)" :id="'stardm_'+index"  @mouseover="setlevel('d', index, 1)"  @mouseout="setlevel('d', index, 0)" v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
            <span class="reg-stars" v-else>
              <span  v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
            </span>
          </div>
          <div class="col">
            <input maxlength="30" :disabled="area1 === '' || area1v === 0 || area2 === '' || area2v === 0 || area3 === '' || area3v === 0 || area4=== '' || area4v === 0" v-model="area5" style="margin-bottom: 10px" type="text" class="form-control" placeholder="Área 5">
            <span class="reg-stars" v-if="area1 !== '' && area1v !== 0 && area2 !== '' && area2v !== 0 && area3 !== '' && area3v !== 0 && area4 !== '' && area4v !== 0">
              <span @click="level('e', index)" :id="'starem_'+index" @mouseover="setlevel('e', index, 1)"  @mouseout="setlevel('e', index, 0)" v-for="(star, index) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
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
            <label>Resume tu CV *</label>
            <textarea style="height: 200px!important" v-model="cv" cols="30" rows="10" class="form-control"></textarea>
          </div>
          <div class="col">
            <label>Educación *</label>
            <transition name="fade">
              <span v-if="alertEd" class="must">Este campo es obligatorio</span>
            </transition>
            <textarea style="height: 200px!important" v-model="educacion" cols="30" rows="10" class="form-control"></textarea>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-8">
            <br>
            <div class="row">
              <div class="col">
                <input maxlength="50" v-model="website" type="text" class="form-control" placeholder="Website">
              </div>
            </div><br>
            <div class="row">
              <div class="col">
                <transition name="fade">
                  <span v-if="alertPass" class="must">{{alertPassText}}</span>
                </transition>
                <input v-model="password" type="password" class="form-control" placeholder="Password*">
              </div>
            </div><br>
            <div class="row">
              <div class="col">
                <transition name="fade">
                  <span v-if="alertConfirm" class="must">Este campo es obligatorio</span>
                </transition>
                <input v-model="confirm" type="password" class="form-control" placeholder="Confirm Password*">
              </div>
            </div>
          </div>
          <div class="col-md-4">
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

            axios.get('/get-paises').then(function(paises){
              este.paises = paises.data
            });

            this.$bus.$on('file', ($event) => {
              este.picture = $event.file
            });

        },
        props: ['admin'],
        data(){
          return {
            csrf: '',
            folio: '',
            levelsetted: false,
            nombre: '',
            apellido_p: '',
            apellido_m: '',
            email: '',
            telefono: '',
            cel: '',
            membresia: '',
            pais: '',
            paises: [],
            ciudad: '',
            paisr: '',
            idiomas: [],
            languajes: [],
            idioma: '',
            fb: '',
            tw: '',
            lin: '',
            consultor: false,
            coach: false,
            capacitador: false,
            categorias:[],
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
            educacion: '',
            website: '',
            password: '',
            confirm: '',
            picture: null,

            alertFolio: false,
            alertName: false,
            alertAp: false,
            alertMail: false,
            alertMailText: 'Este campo es Obligatorio',
            alertPassText: 'Este campo es Obligatorio',
            alertTel: false,
            alertMemb: false,
            alertPais: false,
            alertPaisr: false,
            alertCats: false,
            alertCv: false,
            alertEd: false,
            alertPass: false,
            alertConfirm: false,

            textFolio: 'Este campo es obligatorio'
          }
        },
        methods: {
          delIdioma(idioma){
            var index = this.idiomas.indexOf(idioma);
            if (index > -1) {
                this.idiomas.splice(index, 1);
            }
          },
          setLang(lang){
            this.idiomas.push(lang)
            this.languajes = []
            this.idioma = ''
          },
          searchLanguage(){
            var este = this;
            if (this.idioma !== '') {
              axios.get('/get-languages/'+this.idioma).then(function(languajes){
                este.languajes = languajes.data
              })
            }else{
              this.languajes = []
            }
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
                    $('#star'+key+'m_'+i).addClass('active')
                  }
                }
                if (key === 'b') {
                  if (this.area2v === 0) {
                    $('#star'+key+'m_'+i).addClass('active')
                  }
                }
                if (key === 'c') {
                  if (this.area3v === 0) {
                    $('#star'+key+'m_'+i).addClass('active')
                  }
                }
                if (key === 'd') {
                  if (this.area4v === 0) {
                    $('#star'+key+'m_'+i).addClass('active')
                  }
                }
                if (key === 'e') {
                  if (this.area5v === 0) {
                    $('#star'+key+'m_'+i).addClass('active')
                  }
                }
              }
            }else{
                for (var i = 0; i < index+1 ; i++) {
                  if (key === 'a') {
                    if (this.area1v === 0) {
                      $('#star'+key+'m_'+i).removeClass('active')
                    }
                  }
                  if (key === 'b') {
                    if (this.area2v === 0) {
                      $('#star'+key+'m_'+i).removeClass('active')
                    }
                  }
                  if (key === 'c') {
                    if (this.area3v === 0) {
                      $('#star'+key+'m_'+i).removeClass('active')
                    }
                  }
                  if (key === 'd') {
                    if (this.area4v === 0) {
                      $('#star'+key+'m_'+i).removeClass('active')
                    }
                  }
                  if (key === 'e') {
                    if (this.area5v === 0) {
                      $('#star'+key+'m_'+i).removeClass('active')
                    }
                  }
                }
            }
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
              $('#star'+key+'m_'+i).addClass('active')
            }
          },
          register(){
            this.categorias = []
            if (this.consultor) {
              this.categorias.push(1)
            }
            if (this.coach) {
              this.categorias.push(2)
            }
            if (this.capacitador) {
              this.categorias.push(3)
            }
            if (this.folio === ''  || this.nombre === '' || this.apellido_p === '' || this.email === '' || this.membresia === '' || this.pais === '' || this.paisr === '' || this.categorias.length === 0 || this.cv === '' || this.educacion === '' || this.password === '' || this.confirm === '') {
              if (this.folio === '') {
                this.alertFolio = true
              }else{
                this.alertFolio = false
              }
              if (this.nombre === '') {
                this.alertName = true
              }else{
                this.alertName = false
              }
              if (this.apellido_p === '') {
                this.alertAp = true
              }else{
                this.alertAp = false
              }
              if (this.email === '') {
                this.alertMail = true
              }else{
                this.alertMail = false
              }
              if (this.membresia === '') {
                this.alertMemb = true
              }else{
                this.alertMemb = false
              }
              if (this.pais === '') {
                this.alertPais = true
              }else{
                this.alertPais = false
              }
              if (this.paisr === '') {
                this.alertPaisr = true
              }else{
                this.alertPaisr = false
              }
              if (this.categorias.length === 0) {
                this.alertCats = true
              }else{
                this.alertCats = false
              }
              if (this.cv === '') {
                this.alertCv = true
              }else{
                this.alertCv = false
              }
              if (this.educacion === '') {
                this.alertEd = true
              }else{
                this.alertEd = false
              }
              if (this.password === '') {
                this.alertPass = true
              }else{
                this.alertPass = false
              }
              if (this.confirm === '') {
                this.alertConfirm = true
              }else{
                this.alertConfirm = false
              }
            }else{
              if (this.password === this.confirm) {
                this.alertFolio = false
                this.alertName = false
                this.alertAp = false
                this.alertMail = false
                this.alertPais = false
                this.alertPaisr = false
                this.alertCats = false
                this.alertCv = false
                this.alertEd = false
                this.alertPass = false
                this.alertConfirm = false
                this.alertMemb = false

                var este = this;

                if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email)) {

                  var formData = new FormData();
                  formData.append('folio' , this.folio);
                  formData.append('nombre' , this.nombre);
                  formData.append('apellido_p' , this.apellido_p);
                  formData.append('apellido_m' , this.apellido_m);
                  formData.append('email' , this.email);
                  formData.append('telefono' , this.telefono);
                  formData.append('cel' , this.cel);
                  formData.append('membresia' , this.membresia);
                  formData.append('pais' , this.pais);
                  formData.append('ciudad' , this.ciudad);
                  formData.append('paisr' , this.paisr);
                  formData.append('idiomas' , this.idiomas);
                  formData.append('fb' , this.fb);
                  formData.append('tw' , this.tw);
                  formData.append('in' , this.lin);
                  formData.append('categorias' , JSON.stringify(this.categorias));
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
                  formData.append('educacion' , this.educacion);
                  formData.append('website' , this.website);
                  formData.append('password' , this.password);
                  formData.append('confirm' , this.confirm);
                  formData.append('file', this.picture);

                  axios.post('/new-membrer', formData).then(function(member){
                    if (member.data !== 99) {
                      este.alertFolio = false
                      if (!este.admin) {
                        este.$bus.$emit('login', {email: este.email, password: este.password});
                      }else{
                        este.$bus.$emit('createdUser', {user: member.data});
                      }
                    }else{
                      este.textFolio = 'Este folio ya esta registrado'
                      este.alertFolio = true
                    }
                  }).then(function(){
                    if (!este.alertFolio) {
                      $('.modal-backdrop').css('display', 'none')
                      $('#registerModal').modal('hide');
                    }
                  });
                }else{
                  this.alertMail = true
                  this.alertMailText = 'Introduce un correo válido'
                }
              }else{
                this.alertPass = true
                this.alertPassText = 'Los passwords no coinciden'
              }
            }
          }
        }
    }
</script>
