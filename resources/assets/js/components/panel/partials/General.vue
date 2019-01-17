<template>
  <div class="row mt-5">
    <div class="col-lg-6">
      <ul class="list-group">
        <li class="list-group-item active">
          <div class="row">
            <div class="col-lg-2">
              <h5>
                Paises
              </h5>
            </div>
            <div class="col-lg-10">
              <transition-group name="fade">
                <div :key="1" v-if="!createP" class="input-group">
                  <input @keyup="searchCountry()" type="text" class="form-control" id="validationCustomUsername" placeholder="Busca un país" aria-describedby="inputGroupPrepend" v-model="searchPais">
                  <div class="input-group-prepend">
                    <button class="btn btn-default"><i class="fas fa-search"></i></button>
                  </div>
                  <div class="input-group-prepend">
                    <button class="btn btn-default" @click="createP = true"><i class="fas fa-plus success"></i></button>
                  </div>
                </div>
                <div :key="2" v-else class="input-group">
                  <input v-model="newPais" type="text" class="form-control" id="validationCustomUsername" placeholder="Nombre" aria-describedby="inputGroupPrepend">
                  <select class="form-control" v-model="newZona">
                    <option v-for="zona in zonas" :value="zona.id">{{zona.nombre}}</option>
                  </select>
                  <div class="input-group-prepend">
                    <button class="btn btn-danger" @click="createP = false"><i class="fas fa-times"></i></button>
                  </div>
                  <div class="input-group-prepend">
                    <button class="btn btn-success" @click="addP"><i class="fas fa-check"></i></button>
                  </div>
                </div>
              </transition-group>
            </div>
          </div>
        </li>
      <div style="overflow-y: scroll; height: 70vh;" id="flux">
        <li v-for="(pais, index) in paises" class="list-group-item list-group-item-action">
          <div class="row" style="display: flex; align-items: center;">
            <div @click="editPais(1, index, 1)" class="col">

                <span :id="'spais_'+index">{{pais.nombre}}</span>

                <div class="input-group wedit" :id="'pais_'+index">
                    <input type="text" class="form-control" :value="pais.nombre" :id="'inputPais_'+index">
                  <div class="input-group-prepend">
                    <button @click="editPais(1, index, 0)" class="btn btn-danger"><i class="fas fa-times"></i></button>
                    <button @click="updatePais(pais.id, index)" class="btn btn-default"><i class="fas fa-check success"></i></button>
                  </div>
                </div>
            </div>
            <div @click="editPais(2, index, 1)" class="col">
                <span :id="'zpais_'+index">{{pais.zona.nombre}}</span>

                <div class="input-group wedit" :id="'zona_'+index">
                  <select @change="zona = pais.zona.id" :id="'inputZona_'+index" class="form-control" style="padding: 0;">
                    <option v-for="zona in zonas" :value="zona.id">{{zona.nombre}}</option>
                  </select>
                  <div class="input-group-prepend">
                    <button @click="editPais(2, index, 0)" class="btn btn-danger"><i class="fas fa-times"></i></button>
                    <button @click="updatePais(pais.id, index)" class="btn btn-default"><i class="fas fa-check success"></i></button>
                  </div>
                </div>
            </div>
            <div class="col text-right">
              <img :id="'flagImg_'+pais.id" @click="setPic(index, pais.id, 1)" onError="this.onerror=null;this.src='/media/img/flags/default.png';"  width="25%" :src="'/storage/flags/'+pais.id+'.png'" alt="">
              <input @change="fileChange($event, index, pais.id)" type="file" class="wedit" accept="image/x-png" :id="'flag_'+pais.id">
              <button :id="'flagBtn_'+pais.id" class="btn btn-link wedit" style="float:right;" @click="setPic(index, pais.id, 0)"><i class="fas fa-times danger"></i></button>
              <button :id="'sflagBtn_'+pais.id" class="btn btn-link wedit" style="float:right;" @click="updatePais(pais.id, index)"><i class="fas fa-check success"></i></button>
            </div>
            <div class="col text-center">
              <button @click="deletePais(pais.id, index)" class="btn btn-link"><i class="fas fa-trash danger"></i></button>
            </div>
          </div>
        </li>
      </div>
      </ul>
    </div>
    <div class="col-lg-3">
      <ul class="list-group">
        <li class="list-group-item active">
          <div class="row">
            <div class="col-lg-2">
              <h5>
                Idiomas
              </h5>
            </div>
            <div class="col-lg-10">
              <div class="input-group">
                <input @keyup="searchIdioma" type="text" class="form-control" placeholder="Busca un idioma" v-model="idioma">
                <div class="input-group-prepend">
                  <button class="btn btn-default"><i class="fas fa-search"></i></button>
                </div>
                <div class="input-group-prepend">
                  <button @click="addI" class="btn btn-success"><i class="fas fa-plus"></i></button>
                </div>
              </div>
            </div>
          </div>
        </li>
        <div style="overflow-y: scroll; height: 70vh;">
          <li v-for="(idioma, index) in idiomas" class="list-group-item list-group-item-action">
            <div class="row">
              <div @click="editIdioma(index, 1)" class="col">
              <span :id="'sidioma_'+index">{{idioma.nombre}}</span>
              <div class="input-group wedit" :id="'idioma_'+index">
                  <input type="text" class="form-control" :value="idioma.nombre" :id="'inputIdioma_'+index">
                <div class="input-group-prepend">
                  <button @click="editIdioma(index, 0)" class="btn btn-danger"><i class="fas fa-times"></i></button>
                  <button @click="updateIdioma(idioma.id, index)" class="btn btn-default"><i class="fas fa-check success"></i></button>
                </div>
              </div>
              </div>
              <button @click="deleteIdioma(idioma.id, index)" class="btn btn-link"><i class="fas fa-trash danger"></i></button>
            </div>
          </li>
        </div>
      </ul>
    </div>
    <div class="col-lg-3">
      <ul class="list-group">
        <li class="list-group-item active">
          <div class="row">
            <div class="col-lg-3">
              <h5>
                Categorías
              </h5>
            </div>
            <div class="col-lg-9">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Busca una categoría" aria-describedby="inputGroupPrepend" v-model="categoria">
                <div class="input-group-prepend">
                    <button class="btn btn-default"><i class="fas fa-search"></i></button>
                </div>
                <div class="input-group-prepend">
                  <button @click="addC" class="btn btn-success"><i class="fas fa-plus"></i></button>
                </div>
              </div>
            </div>
          </div>
        </li>
        <div style="overflow-y: scroll; height: 70vh;">
          <li v-for="(categoria, index) in categorias" class="list-group-item list-group-item-action">
            <div class="row">
              <div @click="editCat(index, 1)" class="col">
                  <span :id="'scategoria_'+index">{{categoria.nombre}}</span>
                  <div class="input-group wedit" :id="'categoria_'+index">
                      <input type="text" class="form-control" :value="categoria.nombre" :id="'inputCategoria_'+index">
                    <div class="input-group-prepend">
                      <button @click="editCat(index, 0)" class="btn btn-danger"><i class="fas fa-times"></i></button>
                      <button @click="updateCat(categoria.id, index)" class="btn btn-default"><i class="fas fa-check success"></i></button>
                    </div>
                  </div>
              </div>
              <button @click="deleteCat(categoria.id, index)" class="btn btn-link"><i class="fas fa-trash danger"></i></button>
            </div>
          </li>
        </div>
      </ul>
    </div>
  </div>
</template>

<script>
    export default {
        mounted() {
          var este = this;

          $('#flux').on('scroll', function() {
              if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                  axios.get(este.more).then(function(nexts){
                    este.more = nexts.data.next_page_url
                    nexts.data.data.forEach(function(item){
                      este.paises.push(item)
                    })
                  });
              }
          })

            axios.get('/panel/get-paises').then(function(paises){
              este.paises = paises.data.data
              este.more = paises.data.next_page_url
            });
            axios.get('/get-idiomas').then(function(idiomas){
              este.idiomas = idiomas.data
            });
            axios.get('/get-categorias').then(function(categorias){
              este.categorias = categorias.data
            });
            axios.get('/get-zonas').then(function(zonas){
              este.zonas = zonas.data
            });
        },
        data(){
          return {
            paises: [],
            idiomas: [],
            categorias: [],
            zonas: [],
            pais: '',
            zona: '',
            idioma: '',
            categoria: '',
            picture: null,
            picBckp: '',
            searchPais: '',
            more: '',
            createP: false,
            createI: false,
            createC: false,
            newPais: '',
            newZona: 1,
            newIdioma: '',
            newCat: ''


          }
        },
        methods: {
          editPais(key, index, sw){
            var este = this;
            if (sw === 1) {
              if (key === 1) {
                $('#inputZona_'+index).val(this.paises[index].zona_id)
                $('#inputPais_'+index).val(this.paises[index].nombre)

                $('#spais_'+index).addClass('wedit');
                $('#pais_'+index).removeClass('wedit');
              }else{

                $('#zpais_'+index).addClass('wedit');
                $('#zona_'+index).removeClass('wedit');
              }
            }else{
              if (key === 1) {
                setTimeout(function(){

                  $('#spais_'+index).removeClass('wedit');
                  $('#pais_'+index).addClass('wedit');
                }, 100)
              }else{
                setTimeout(function(){

                  $('#zona_'+index).addClass('wedit');
                  $('#zpais_'+index).removeClass('wedit');
                }, 100);
              }
            }
          },
          editIdioma(index, sw){
            var este = this;
            if (sw === 1) {

                $('#sidioma_'+index).addClass('wedit');
                $('#idioma_'+index).removeClass('wedit');

            }else{

                setTimeout(function(){

                  $('#sidioma_'+index).removeClass('wedit');
                  $('#idioma_'+index).addClass('wedit');
                }, 100)

            }
          },
          editCat(index, sw){
            var este = this;
            if (sw === 1) {

                $('#scategoria_'+index).addClass('wedit');
                $('#categoria_'+index).removeClass('wedit');

            }else{

                setTimeout(function(){

                  $('#scategoria_'+index).removeClass('wedit');
                  $('#categoria_'+index).addClass('wedit');
                }, 100)

            }
          },
          updatePais(id, index){
            var este = this;
            this.pais = $('#inputPais_'+index).val()
            this.zona = $('#inputZona_'+index).val()
            var formData = new FormData();
            formData.append('id', id);
            formData.append('pais', this.pais);
            formData.append('zona', this.zona);
            formData.append('flag', this.picture);

            axios.post('/panel/update-pais', formData).then(function(pais){
              este.paises.splice(index, 1);
              este.paises.splice(index, 0, pais.data);
              este.editPais(2, index, 0)
              este.editPais(1, index, 0)
              $('#flagBtn_'+id).addClass('wedit')
              $('#sflagBtn_'+id).addClass('wedit')
            });
          },
          updateIdioma(id, index){
            var este = this;
            var idioma = $('#inputIdioma_'+index).val()
            axios.post('/panel/update-idioma', {id: id, nombre: idioma}).then(function(idioma){
              este.idiomas.splice(index, 1);
              este.idiomas.splice(index, 0, idioma.data);
              este.editIdioma(index, 0)
            });
          },
          updateCat(id, index){
            var este = this;
            var categoria = $('#inputCategoria_'+index).val()
            axios.post('/panel/update-categoria', {id: id, nombre: categoria}).then(function(categoria){
              este.categorias.splice(index, 1);
              este.categorias.splice(index, 0, categoria.data);
              este.editCat(index, 0)
            });
          },
          searchCountry(){
            var este = this;
            this.paises = []
            if (this.searchPais !== '') {
              axios.post('/search-pais', {pais: this.searchPais}).then(function(paises){
                este.paises = paises.data.data
              });
            }else{
              axios.get('/get-paises').then(function(paises){
                este.paises = paises.data.data
              });
            }
          },
          searchIdioma(){
            var este = this;
            this.idiomas = []
            if (this.idioma !== '') {
              axios.post('/search-idioma', {idioma: this.idioma}).then(function(idiomas){
                este.idiomas = idiomas.data.data
              });
            }else{
              axios.get('/get-idiomas').then(function(idiomas){
                este.idiomas = idiomas.data
              });
            }
          },
          searchCat(){

          },
          setPic(index, id, sw){
            if (sw === 1) {
              $('#inputZona_'+index).val(this.paises[index].zona_id)
              $('#inputPais_'+index).val(this.paises[index].nombre)
              $('#flag_'+id).click();
            }else{

              $('#flagImg_'+id).attr('src', this.picBckp)
              $('#flagBtn_'+id).addClass('wedit')
              $('#sflagBtn_'+id).addClass('wedit')
            }
          },
          fileChange(e, index, id){
            console.log(e);
            let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.preview(files[0], id);
          },
          preview(file, id){
            this.picture = file
            this.picBckp =   $('#flagImg_'+id).attr('src')
            $('#flagBtn_'+id).removeClass('wedit')
            $('#sflagBtn_'+id).removeClass('wedit')
            let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    $('#flagImg_'+id).attr('src', e.target.result) ;
                };
                reader.readAsDataURL(file);
          },
          addP(){
            var este = this;
            axios.post('/panel/new-pais', {nombre: this.newPais, zona: this.newZona}).then(function(pais){
              este.paises.unshift(pais.data)
              este.createP = false
            })
          },
          addI(){
            var este = this;
            if (this.idioma !== '') {
              axios.post('/panel/new-idioma', {nombre: this.idioma}).then(function(idioma){
                este.idiomas.unshift(idioma.data)
                este.idioma = ''
              })
            }
          },
          addC(){
            var este = this;
            if (this.categoria !== '') {
              axios.post('/panel/new-categoria', {nombre: this.categoria}).then(function(categoria){
                este.categorias.unshift(categoria.data)
                este.categoria = ''
              })
            }
          },
          deletePais(id, index){
            var este = this;
            if (confirm('Seguro?') === true) {
              axios.get('/panel/delete-pais/'+id).then(function(){
                este.paises.splice(index, 1)
              })
            }
          },
          deleteIdioma(id, index){
            var este = this;
            if (confirm('Seguro?') === true) {
              axios.get('/panel/delete-idioma/'+id).then(function(){
                este.idiomas.splice(index, 1)
              })
            }
          },
          deleteCat(id, index){
            var este = this;
            if (confirm('Seguro?') === true) {
              axios.get('/panel/delete-cat/'+id).then(function(){
                este.categorias.splice(index, 1)
              })
            }
          }

        }
    }
</script>
