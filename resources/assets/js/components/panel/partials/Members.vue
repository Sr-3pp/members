<template>
  <div class="row mt-5">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-sm-6">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button @click="empresa = false" type="button" style="border-bottom-left-radius: 0 ;" class="btn" :class="{'btn-primary' : !empresa, 'btn-dark': empresa}">Miembros</button>
            <button @click="empresa = true" type="button" style="border-bottom-right-radius: 0;" class="btn" :class="{'btn-primary' : empresa, 'btn-dark': !empresa}">Empresas</button>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="input-group">
            <input @keyup="searchMember()" type="text" class="form-control" id="validationCustomUsername" placeholder="Busca un usuario" aria-describedby="inputGroupPrepend" v-model="search">
            <div class="input-group-prepend">
              <button class="btn btn-default" ><i class="fas fa-search"></i></button>
              <button @click="$bus.$emit('registerModal', {sw: 1, admin: 1})" class="btn btn-success" ><i class="fas fa-plus"></i></button>
            </div>
          </div>
        </div>
      </div>
      <ul v-if="!empresa" class="list-group panel-list">
        <li class="list-group-item active">

        </li>
        <li class="list-group-item">
          <div class="row">

              <div v-for="(user, index) in users" class="col-xl-4" style="padding:30px; text-align: center;">
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
                            <div v-for="(valoracion, index2) in user.user.valoracion" class="row editvalorations">
                              <div class="col-3">
                                <span @click="editVal(index, valoracion.id, 1)" v-if="valoration !== 'val_'+index+'_'+valoracion.id" :id="'val_'+index+'_'+magic">{{valoracion.area}}</span>
                                <div v-if="valoration === 'val_'+index+'_'+valoracion.id" class="input-group">
                                  <input :id="'valInput_'+valoracion.id" maxlength="10" style="margin-bottom: 10px" type="text" class="form-control" :value="valoracion.area">
                                  <div class="input-group-prepend" style="padding-top: 5px;">
                                    <button class="btn btn-danger" style="height:40px;" @click="editVal(index, valoracion.id, 0)"><i class="fas fa-times"></i></button>
                                  </div>
                                  <div class="input-group-prepend" style="padding-top: 5px;">
                                    <button class="btn btn-success" style="height:40px;" @click="updateVal(valoracion.id, 'name', index, index2)"><i class="fas fa-check"></i></button>
                                  </div>
                                </div>
                              </div>
                              <div class="col-9 text-left">
                                <span @click="editStars = 'stars_'+index+'_'+valoracion.id" v-if="editStars !== 'stars_'+index+'_'+valoracion.id" class="reg-stars">
                                    <span v-for="val in parseInt(valoracion.porcentaje)"><i class="fas fa-star active"></i>&nbsp;&nbsp;</span>
                                </span>
                                <span v-if="editStars === 'stars_'+index+'_'+valoracion.id" class="reg-stars">
                                  <span @click="level('a', index2, valoracion.id, index, index3)" :id="'staram_'+index3+'_'+valoracion.id" @mouseover="setlevel('a', index3, 1, valoracion.id)"  @mouseout="setlevel('a', index3, 0, valoracion.id)" v-for="(star, index3) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
                                </span>
                                <button @click="deleteVal(valoracion.id, index2, index)" class="btn btn-link right-30 danger">
                                  <i class="fas fa-minus-square"></i>
                                </button>
                              </div>
                            </div>
                            <div v-if="newVal !== 'newVal_'+index" class="text-center" style="width:100%;">
                              <button @click="newVal = 'newVal_'+index" v-if="user.user.valoracion.length < 5" class="btn btn-link"><i class="fas fa-plus"></i></button>
                            </div>
                            <div class="container">
                              <div v-if="newVal === 'newVal_'+index" class="row">
                                <div class="col-3">
                                  <div class="input-group">
                                    <input :id="'newValInput_'+index" maxlength="10" style="margin-bottom: 10px" type="text" class="form-control" placeholder="Nombre">
                                  </div>
                                </div>
                                <div class="col-9">
                                  <br>
                                  <span class="reg-stars">
                                    <span @click="newStars = indexs" :id="'newStaram_'+indexs" @mouseover="setleveln('a', indexs, 1)"  @mouseout="setleveln('a', indexs, 0)" v-for="(star, indexs) in 10"><i class="fas fa-star"></i>&nbsp;&nbsp;</span>
                                  </span>
                                  <div class="right-30" style="margin-top: -30px;">
                                    <button class="btn btn-link"><i class="fas fa-times danger"></i></button>
                                    <button @click="saveVal(index, user.user_id)" class="btn btn-link"><i class="fas fa-check success"></i></button>
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
                            <div @click="changePic(index)" :id="'previewM_'+index" :style="'background: url(/storage/'+user.foto+') center no-repeat; background-size: cover; height:100%;'">
                            </div>
                            <div v-if="editPic === magic+'_'+index " style="position: absolute; right: 0; bottom: 0; height: auto;">
                              <button @click="editUser(index, 0 , 'pic')" class="btn btn-light"><i class="fas fa-times danger"></i></button>
                              <button @click="updateUser(user.user_id, index, 'pic')" class="btn btn-light"><i class="fas fa-check success"></i></button>
                            </div>
                            <input @change="fileChange($event, index)" :id="'fileInput_'+index" type="file" class="hidden">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div @click="editUser(index, 1, 'name')" class="col">
                          <span :id="'spanMname_'+index">
                            <b>Nombre: </b><br>{{user.name}}
                          </span>

                          <div class="wedit" :id="'inputMname_'+index">
                            <input :value="user.name" type="text" class="form-control">
                            <div class="edit-btns">
                              <button @click="editUser(index, 0, 'name')" class="btn btn-link" ><i class="fas fa-times danger"></i></button>
                              <button @click="updateUser(user.user_id, index, 'name')" class="btn btn-link" ><i class="fas fa-check success"></i></button>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="col-9">
                      <div v-if="editMemb !== magic+'_'+index && editCat !== magic+'_'+index" class="row">
                        <div class="col">
                          <b>Status:</b><br>
                          <button @click="setStatus(user.user.id, index)" class="btn btn-link" :class="{success : user.status, danger: !user.status}">
                            <i class="fas fa-circle"></i>
                          </button>
                        </div>
                        <div @click="editUser(index, 1, 'folio')" class="col">
                          <span :id="'spanMfolio_'+index"><b>Folio: </b> <br>{{user.user.folio}}</span>

                          <div class="wedit" :id="'inputMfolio_'+index">
                            <input :value="user.user.folio" type="text" class="form-control">
                            <div class="edit-btns">
                              <button @click="editUser(index, 0, 'folio')" class="btn btn-link" ><i class="fas fa-times danger"></i></button>
                              <button @click="updateUser(user.user_id, index, 'folio')" class="btn btn-link" ><i class="fas fa-check success"></i></button>
                            </div>
                          </div>
                        </div>
                        <div @click="editUser(index, 1, 'rango')" class="col text-center">
                          <img width="40%" :src="'/media/img/medallas/'+user.rango+'.png'" alt="membresia icon">
                        </div>
                        <div @click="editUser(index, 1, 'cat')" class="col text-center">

                              <img  v-for="categoria in user.user.categorias" width="30%" v-if="categoria.categoria_id !== 5" :src="'/media/img/categorias/'+categoria.categoria.nombre+'.png'" alt="user cat">
                        </div>
                      </div>
                      <div v-if="editMemb === magic+'_'+index" class="row">
                        <div class="col text-center membresias">
                          <img @click="updateUser(user.user_id, index, 'rango', 'afiliado')" :class="{selected : user.rango ==='afiliado'}" width="15%" src="/media/img/medallas/afiliado.png" alt="membresia icon">&nbsp;&nbsp;&nbsp;
                          <img @click="updateUser(user.user_id, index, 'rango', 'especialista')" :class="{selected : user.rango ==='especialista'}" width="15%" src="/media/img/medallas/especialista.png" alt="membresia icon">&nbsp;&nbsp;&nbsp;
                          <img @click="updateUser(user.user_id, index, 'rango', 'experto')" :class="{selected : user.rango ==='experto'}" width="15%" src="/media/img/medallas/experto.png" alt="membresia icon">&nbsp;&nbsp;&nbsp;
                          <img @click="updateUser(user.user_id, index, 'rango', 'profesional')" :class="{selected : user.rango ==='profesional'}" width="15%" src="/media/img/medallas/profesional.png" alt="membresia icon">&nbsp;&nbsp;&nbsp;
                          <span style="float: right; padding: 10px;" @click="editMemb = false"><i class="fas fa-times danger"></i></span>
                        </div>
                      </div>
                      <div v-if="editCat === magic+'_'+index" class="row">
                        <div class="col text-center membresias">
                          <span v-for="(categoria, index) in userCats">
                            <img @click="setCat({categoria_id: 1}, 0)" class="selected" v-if="categoria.categoria_id === 1" width="15%" src="/media/img/categorias/consultor.png" alt="membresia icon">&nbsp;&nbsp;&nbsp;
                            <img @click="setCat({categoria_id: 2}, 0)" class="selected" v-if="categoria.categoria_id === 2" width="15%" src="/media/img/categorias/coach.png" alt="membresia icon">&nbsp;&nbsp;&nbsp;
                            <img @click="setCat({categoria_id: 3}, 0)" class="selected" v-if="categoria.categoria_id === 3" width="15%" src="/media/img/categorias/capacitador.png" alt="membresia icon">&nbsp;&nbsp;&nbsp;
                          </span>

                            <span v-for="cat in categorias">
                              <img v-if="cat.categoria_id === 1 || cat === 1" @click="setCat({categoria_id: 1}, 1)" width="15%" src="/media/img/categorias/consultor.png" alt="membresia icon">&nbsp;&nbsp;&nbsp;
                              <img v-if="cat.categoria_id === 2 || cat === 2" @click="setCat({categoria_id: 2}, 1)" width="15%" src="/media/img/categorias/coach.png" alt="membresia icon">&nbsp;&nbsp;&nbsp;
                              <img v-if="cat.categoria_id === 3 || cat === 3" @click="setCat({categoria_id: 3}, 1)" width="15%" src="/media/img/categorias/capacitador.png" alt="membresia icon">&nbsp;&nbsp;&nbsp;
                            </span>




                          <span style="float: right; padding: 10px;" @click="editCat = false"><i class="fas fa-times danger"></i></span>
                          <span style="float: right; padding: 10px;" @click="updateUser(user.user_id, index, 'cat')"><i class="fas fa-check success"></i></span>
                        </div>
                      </div>
                      <div v-if="editAp !== magic+'_'+index" class="row">
                        <div  @click="editUser(index, 1, 'apellidos')" class="col">
                          <span :id="'spanMapellidos_'+index">
                            <b>Apellidos: </b><br>{{user.apellido_p+' '+user.apellido_m}}
                          </span>
                        </div>
                        <div @click="editUser(index, 1, 'tel')" class="col">
                          <span :id="'spanMtel_'+index">
                            <b>Teléfono: </b><br>{{user.telefono}}
                          </span>
                          <div class="wedit" :id="'inputMtel_'+index">
                            <input :value="user.telefono" type="text" class="form-control">
                            <div class="edit-btns">
                              <button @click="editUser(index, 0, 'tel')" class="btn btn-link" ><i class="fas fa-times danger"></i></button>
                              <button @click="updateUser(user.user_id, index, 'tel')" class="btn btn-link" ><i class="fas fa-check success"></i></button>
                            </div>
                          </div>
                        </div>
                        <div @click="editUser(index, 1, 'cel')" class="col">
                          <span :id="'spanMcel_'+index">
                            <b>Celular: </b><br>{{user.celular}}
                          </span>
                          <div class="wedit" :id="'inputMcel_'+index">
                            <input :value="user.celular" type="text" class="form-control">
                            <div class="edit-btns">
                              <button @click="editUser(index, 0, 'cel')" class="btn btn-link" ><i class="fas fa-times danger"></i></button>
                              <button @click="updateUser(user.user_id, index, 'cel')" class="btn btn-link" ><i class="fas fa-check success"></i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div v-if="editAp === magic+'_'+index" class="row">
                        <div class="col">
                          <div class="input-group" :id="'inputM'+magic+'_'+index">
                            <input :id="'input_ap_'+index" type="text" class="form-control" :value="user.apellido_p">
                            <input :id="'input_am_'+index" type="text" class="form-control" :value="user.apellido_m">
                            <div class="input-group-prepend">
                              <button @click="editUser(index, 0, magic)" class="btn btn-danger" ><i class="fas fa-times"></i></button>
                            </div>
                            <div class="input-group-prepend">
                              <button @click="updateUser(user.user_id, index, magic)" class="btn btn-success" ><i class="fas fa-check"></i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div v-if="editsocial !== magic+'_'+index" class="row">
                        <div @click="editUser(index, 1, 'fb')" class="col">
                          <span :id="'spanMfb_'+index"><b>Facebook: </b><br>{{user.fb ? user.fb : '-'}}</span>
                        </div>
                        <div  @click="editUser(index, 1, 'tw')" class="col">
                          <span :id="'spanMtw_'+index"><b>Twitter: </b><br>{{user.tw ? user.tw : '-'}}</span>
                        </div>
                        <div  @click="editUser(index, 1, 'in')" class="col">
                          <span :id="'spanMin_'+index"><b>Linkedin: </b><br>{{user.in ? user.in : '-'}}</span>
                        </div>
                      </div>
                      <div v-if="editsocial === magic+'_'+index" class="row">
                        <div class="col social-input">
                          <span v-if="magic === 'fb'">www.facebook.com/</span>
                          <span v-if="magic === 'tw'">www.twitter.com/</span>
                          <span v-if="magic === 'in'">www.linkedin.com/</span>
                          <div class="input-group" :id="'inputM'+magic+'_'+index">
                            <input v-if="magic === 'fb'" id="socialInput" type="text" class="form-control" :value="user.fb">
                            <input v-if="magic === 'tw'" id="socialInput" type="text" class="form-control" :value="user.tw">
                            <input v-if="magic === 'in'" id="socialInput" type="text" class="form-control" :value="user.in">
                            <div class="input-group-prepend">
                              <button @click="editUser(index, 0, magic)" class="btn btn-danger" ><i class="fas fa-times"></i></button>
                            </div>
                            <div class="input-group-prepend">
                              <button @click="updateUser(user.user_id, index, magic)" class="btn btn-success" ><i class="fas fa-check"></i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div v-if="editI !== magic+'_'+index" @click="editUser(index, 1, 'web')" class="col">
                      <span :id="'spanMweb_'+index">
                        <b>Website: </b><br>{{user.website}}
                      </span>

                      <div class="wedit" :id="'inputMweb_'+index">
                        <input :value="user.website" type="text" class="form-control">
                        <div class="edit-btns">
                          <button @click="editUser(index, 0, 'web')" class="btn btn-link" ><i class="fas fa-times danger"></i></button>
                          <button @click="updateUser(user.user_id, index, 'web')" class="btn btn-link" ><i class="fas fa-check success"></i></button>
                        </div>
                      </div>
                    </div>
                    <div v-if="editI !== magic+'_'+index" @click="editUser(index, 1, 'pais')" class="col">
                      <span :id="'spanMpais_'+index">
                        <b>País: </b><br>{{user.pais.nombre}}
                      </span>
                      <div class="wedit" :id="'inputMpais_'+index">
                        <select class="form-control">
                          <option selected v-if="pais.id === user.pais_id" :value="pais.id" v-for="pais in paises">{{pais.nombre}}</option>
                          <option v-if="pais.id !== user.pais_id" :value="pais.id" v-for="pais in paises">{{pais.nombre}}</option>
                        </select>
                        <div class="edit-btns">
                          <button @click="editUser(index, 0, 'pais')" class="btn btn-link" ><i class="fas fa-times danger"></i></button>
                          <button @click="updateUser(user.user_id, index, 'pais')" class="btn btn-link" ><i class="fas fa-check success"></i></button>
                        </div>
                      </div>
                    </div>
                    <div v-if="editI !== magic+'_'+index" @click="editUser(index, 1, 'cd')" class="col">
                      <span :id="'spanMcd_'+index">
                        <b>Ciudad: </b><br>{{user.ciudad}}
                      </span>
                      <div class="wedit" :id="'inputMcd_'+index">
                        <input :value="user.ciudad" type="text" class="form-control">
                        <div class="edit-btns">
                          <button @click="editUser(index, 0, 'cd')" class="btn btn-link" ><i class="fas fa-times danger"></i></button>
                          <button @click="updateUser(user.user_id, index, 'cd')" class="btn btn-link" ><i class="fas fa-check success"></i></button>
                        </div>
                      </div>
                    </div>
                    <div class="col" :class="{overflowv: idiomasResults}">

                      <div v-if="editI === magic+'_'+index">
                        <span @click="setLang(index, idioma.nombre, 0)" class="user-lang del-idioma" v-for="(idioma, index) in idiomas"><b><i class="fas fa-times"></i></b> {{idioma}}</span>
                        <div class="input-group">
                          <input @keyup="searchIdioma" type="text" class="form-control" placeholder="Agregar idioma" v-model="idioma">
                          <div class="input-group-prepend">
                            <button @click="editI = false" class="btn btn-danger" ><i class="fas fa-times"></i></button>
                          </div>
                          <div class="input-group-prepend">
                            <button @click="updateUser(user.user_id, index, 'idiomas')" class="btn btn-success" ><i class="fas fa-check"></i></button>
                          </div>
                        </div>
                        <transition name="fade">
                          <ul v-if="idiomasResults.length !== 0 && idioma !== ''" class="list-group input-results">
                            <a @click="setLang(index, idioma.nombre, 1)" href="#" role="button" class="list-group-item list-group-item-action" v-for="idioma in idiomasResults">{{idioma.nombre}}</a>
                          </ul>
                        </transition>
                      </div>

                      <span @click="editUser(index, 1, 'idiomas')" v-if="editI !== 'idiomas_'+index">
                        <b>Idiomas: </b><br>{{JSON.parse(user.idiomas)}}
                      </span>

                    </div>
                  </div>
                  <div v-if="editinfo !== magic+'_'+index" class="row">
                    <div @click="editUser(index, 1, 'cv')" class="col">
                      <span :id="'spanMcv_'+index">
                        <b>Cv: </b><br>{{user.resumen}}
                      </span>
                    </div>
                    <div @click="editUser(index, 1, 'ed')" class="col">
                      <span :id="'spanMed_'+index">
                        <b>Educacion: </b><br>{{user.educacion}}
                      </span>
                    </div>
                  </div>
                  <div v-if="editinfo === magic+'_'+index" class="row">
                    <div class="col">
                      <div :id="'inputM'+magic+'_'+index">
                        <textarea v-if="magic === 'ed'" :value="user.educacion" type="text" class="form-control"></textarea>
                        <textarea v-if="magic === 'cv'" :value="user.resumen" type="text" class="form-control"></textarea>
                        <div style="float: right">
                          <button @click="editUser(index, 0, magic)" class="btn btn-link" ><i class="fas fa-times danger"></i></button>
                          <button @click="updateUser(user.user_id, index, magic)" class="btn btn-link" ><i class="fas fa-check success"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <button @click="editskills(index)" class="btn btn-default btn-sm" style="margin: 0 auto;">Areas de expertise.</button>
              </div>

          </div>
        </li>
      </ul>
      <ul v-else class="list-group panel-list">
        <li class="list-group-item active">

        </li>
        <li class="list-group-item">
          <div class="row">

            <div  v-for="(user, index) in empresas" class="col-xl-4" style="padding:30px;">
              <div class="user-card">
                <div class="row" style="border-bottom: none">
                  <div class="col-3">
                    <div class="row">
                      <div class="col" style="height: 151px;">
                        <div class="panel-member-pic">
                          <div @click="changePicm(index)" :id="'previewE_'+index" :style="'background: url(/storage/'+user.foto+') center no-repeat; background-size: cover; height:100%;'">
                          </div>
                          <div v-if="editPic === magic+'_'+index " style="position: absolute; right: 0; bottom: 0; height: auto;">
                            <button @click="editEmpresa(index, 0 , 'pic')" class="btn btn-light"><i class="fas fa-times danger"></i></button>
                            <button @click="updateEmpresa(user.user_id, index, 'pic')" class="btn btn-light"><i class="fas fa-check success"></i></button>
                          </div>
                          <input @change="fileChangem($event, index)" :id="'fileInput_'+index" type="file" class="hidden">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div @click="editEmpresa(index, 1, 'folio')" class="col">
                        <span :id="'spanEfolio_'+index"><b>Folio: </b> <br>{{user.user.folio}}</span>

                        <div class="wedit" :id="'inputEfolio_'+index">
                          <input maxLength="6" :value="user.user.folio" type="text" class="form-control">
                          <div class="edit-btns">
                            <button @click="editEmpresa(index, 0, 'folio')" class="btn btn-link" ><i class="fas fa-times danger"></i></button>
                            <button @click="updateEmpresa(user.user_id, index, 'folio')" class="btn btn-link" ><i class="fas fa-check success"></i></button>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="col-9">
                    <div v-if="editMemb !== magic+'_'+index" class="row">
                      <div class="col">
                        <b>Status:</b><br>
                        <button @click="setStatus(user.user.id, index)" class="btn btn-link" :class="{success : user.status, danger: !user.status}">
                          <i class="fas fa-circle"></i>
                        </button>
                      </div>

                      <div @click="editEmpresa(index, 1, 'rango')" class="col text-center">
                        <img width="40%" :src="'/media/img/medallas/'+user.rango+'.png'" alt="membresia icon">
                      </div>
                      <div @click="editEmpresa(index, 1, 'cat')" class="col text-center">

                            <img width="40%" src="/media/img/categorias/empresa.png" alt="user cat">

                      </div>
                    </div>
                    <div v-if="editMemb === magic+'_'+index" class="row">
                      <div class="col text-center membresias">
                        <img @click="updateEmpresa(user.user_id, index, 'rango', 'afiliado')" :class="{selected : user.rango ==='afiliado'}" width="15%" src="/media/img/medallas/afiliado.png" alt="membresia icon">&nbsp;&nbsp;&nbsp;
                        <img @click="updateEmpresa(user.user_id, index, 'rango', 'especialista')" :class="{selected : user.rango ==='especialista'}" width="15%" src="/media/img/medallas/especialista.png" alt="membresia icon">&nbsp;&nbsp;&nbsp;
                        <img @click="updateEmpresa(user.user_id, index, 'rango', 'experto')" :class="{selected : user.rango ==='experto'}" width="15%" src="/media/img/medallas/experto.png" alt="membresia icon">&nbsp;&nbsp;&nbsp;
                        <img @click="updateEmpresa(user.user_id, index, 'rango', 'profesional')" :class="{selected : user.rango ==='profesional'}" width="15%" src="/media/img/medallas/profesional.png" alt="membresia icon">&nbsp;&nbsp;&nbsp;
                        <span style="float: right; padding: 10px;" @click="editMemb = false"><i class="fas fa-times danger"></i></span>
                      </div>
                    </div>
                    <div class="row">
                      <div @click="editEmpresa(index, 1, 'name')" class="col">
                        <span :id="'spanEname_'+index">
                          <b>Nombre: </b><br>{{user.name}}
                        </span>

                        <div class="wedit" :id="'inputEname_'+index">
                          <input :value="user.name" type="text" class="form-control">
                          <div class="edit-btns">
                            <button @click="editEmpresa(index, 0, 'name')" class="btn btn-link" ><i class="fas fa-times danger"></i></button>
                            <button @click="updateEmpresa(user.user_id, index, 'name')" class="btn btn-link" ><i class="fas fa-check success"></i></button>
                          </div>
                        </div>

                      </div>
                      <div @click="editEmpresa(index, 1, 'tel')" class="col">
                        <span :id="'spanEtel_'+index">
                          <b>Telefono: </b><br>{{user.telefono}}
                        </span>

                        <div class="wedit" :id="'inputEtel_'+index">
                          <input :value="user.telefono" type="text" class="form-control">
                          <div class="edit-btns">
                            <button @click="editEmpresa(index, 0, 'tel')" class="btn btn-link" ><i class="fas fa-times danger"></i></button>
                            <button @click="updateEmpresa(user.user_id, index, 'tel')" class="btn btn-link" ><i class="fas fa-check success"></i></button>
                          </div>
                        </div>

                      </div>
                      <div @click="editEmpresa(index, 1, 'web')" class="col">
                        <span :id="'spanEweb_'+index">
                          <b>Website: </b><br>{{user.website}}
                        </span>

                        <div class="wedit" :id="'inputEweb_'+index">
                          <input :value="user.website" type="text" class="form-control">
                          <div class="edit-btns">
                            <button @click="editEmpresa(index, 0, 'web')" class="btn btn-link" ><i class="fas fa-times danger"></i></button>
                            <button @click="updateEmpresa(user.user_id, index, 'web')" class="btn btn-link" ><i class="fas fa-check success"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div v-if="editsocial !== magic+'_'+index" class="row">
                      <div @click="editEmpresa(index, 1, 'fb')" class="col">
                        <span :id="'spanEfb_'+index"><b>Facebook: </b><br>{{user.fb}}</span>
                      </div>
                      <div  @click="editEmpresa(index, 1, 'tw')" class="col">
                        <span :id="'spanEtw_'+index"><b>Twitter: </b><br>{{user.tw}}</span>
                      </div>
                      <div  @click="editEmpresa(index, 1, 'in')" class="col">
                        <span :id="'spanEin_'+index"><b>Linkedin: </b><br>{{user.in}}</span>
                      </div>
                    </div>
                    <div v-if="editsocial === magic+'_'+index" class="row">
                      <div class="col social-input">
                        <span v-if="magic === 'fb'">www.facebook.com/</span>
                        <span v-if="magic === 'tw'">www.twitter.com/</span>
                        <span v-if="magic === 'in'">www.linkedin.com/</span>
                        <div class="input-group" :id="'inputE'+magic+'_'+index">
                          <input v-if="magic === 'fb'" id="socialInput" type="text" class="form-control" :value="user.fb">
                          <input v-if="magic === 'tw'" id="socialInput" type="text" class="form-control" :value="user.tw">
                          <input v-if="magic === 'in'" id="socialInput" type="text" class="form-control" :value="user.in">
                          <div class="input-group-prepend">
                            <button @click="editEmpresa(index, 0, magic)" class="btn btn-danger" ><i class="fas fa-times"></i></button>
                          </div>
                          <div class="input-group-prepend">
                            <button @click="updateEmpresa(user.user_id, index, magic)" class="btn btn-success" ><i class="fas fa-check"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">

                  <div v-if="editI !== magic+'_'+index" @click="editEmpresa(index, 1, 'pais')" class="col">
                    <span :id="'spanEpais_'+index">
                      <b>País: </b><br>{{user.pais.nombre}}
                    </span>
                    <div class="wedit" :id="'inputEpais_'+index">
                      <select class="form-control">
                        <option selected v-if="pais.id === user.pais_id" :value="pais.id" v-for="pais in paises">{{pais.nombre}}</option>
                        <option v-if="pais.id !== user.pais_id" :value="pais.id" v-for="pais in paises">{{pais.nombre}}</option>
                      </select>
                      <div class="edit-btns">
                        <button @click="editEmpresa(index, 0, 'pais')" class="btn btn-link" ><i class="fas fa-times danger"></i></button>
                        <button @click="updateEmpresa(user.user_id, index, 'pais')" class="btn btn-link" ><i class="fas fa-check success"></i></button>
                      </div>
                    </div>
                  </div>
                  <div v-if="editI !== magic+'_'+index" @click="editEmpresa(index, 1, 'cd')" class="col">
                    <span :id="'spanEcd_'+index">
                      <b>Ciudad: </b><br>{{user.ciudad}}
                    </span>
                    <div class="wedit" :id="'inputEcd_'+index">
                      <input :value="user.ciudad" type="text" class="form-control">
                      <div class="edit-btns">
                        <button @click="editEmpresa(index, 0, 'cd')" class="btn btn-link" ><i class="fas fa-times danger"></i></button>
                        <button @click="updateEmpresa(user.user_id, index, 'cd')" class="btn btn-link" ><i class="fas fa-check success"></i></button>
                      </div>
                    </div>
                  </div>
                  <div class="col" :class="{overflowv: idiomasResults}">

                    <div v-if="editI === magic+'_'+index">
                      <span @click="setLang(index, idioma.nombre, 0)" class="user-lang del-idioma" v-for="(idioma, index) in idiomas"><b><i class="fas fa-times"></i></b> {{idioma}}</span>
                      <div class="input-group">
                        <input @keyup="searchIdioma" type="text" class="form-control" placeholder="Agregar idioma" v-model="idioma">
                        <div class="input-group-prepend">
                          <button @click="editI = false" class="btn btn-danger" ><i class="fas fa-times"></i></button>
                        </div>
                        <div class="input-group-prepend">
                          <button @click="updateEmpresa(user.user_id, index, 'idiomas')" class="btn btn-success" ><i class="fas fa-check"></i></button>
                        </div>
                      </div>
                      <transition name="fade">
                        <ul v-if="idiomasResults.length !== 0 && idioma !== ''" class="list-group input-results">
                          <a @click="setLang(index, idioma.nombre, 1)" href="#" role="button" class="list-group-item list-group-item-action" v-for="idioma in idiomasResults">{{idioma.nombre}}</a>
                        </ul>
                      </transition>
                    </div>

                    <span @click="editEmpresa(index, 1, 'idiomas')" v-if="editI !== 'idiomas_'+index">
                      <b>Idiomas: </b><br>{{JSON.parse(user.idiomas)}}
                    </span>

                  </div>
                </div>
                <div v-if="editinfo !== magic+'_'+index" class="row">
                  <div @click="editEmpresa(index, 1, 'cv')" class="col">
                    <span :id="'spanEcv_'+index">
                      <b>Cv: </b><br>{{user.descripcion}}
                    </span>
                  </div>
                  <div @click="editEmpresa(index, 1, 'ed')" class="col">
                    <span :id="'spanEed_'+index">
                      <b>Educacion: </b><br>{{user.cv}}
                    </span>
                  </div>
                </div>
                <div v-if="editinfo === magic+'_'+index" class="row">
                  <div class="col">
                    <div :id="'inputE'+magic+'_'+index">
                      <textarea v-if="magic === 'ed'" :value="user.cv" type="text" class="form-control"></textarea>
                      <textarea v-if="magic === 'cv'" :value="user.descripcion" type="text" class="form-control"></textarea>
                      <div style="float: right">
                        <button @click="editEmpresa(index, 0, magic)" class="btn btn-link" ><i class="fas fa-times danger"></i></button>
                        <button @click="updateEmpresa(user.user_id, index, magic)" class="btn btn-link" ><i class="fas fa-check success"></i></button>
                      </div>
                    </div>
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
            axios.get('/panel/get-users').then(function(users){
              este.users = users.data
            });
            axios.get('/panel/get-empresas').then(function(empresas){
              este.empresas = empresas.data
            });

            axios.get('/get-paises').then(function(paises){
              este.paises = paises.data
            });
            this.$bus.$on('createdUser', ($event) => {
              este.users.push($event.user);
            });
        },
        data(){
          return {
            users: [],
            empresas: [],
            paises: [],
            idiomas: [],
            categorias: [1,2,3],
            userCats:[],
            empresa: false,
            search: '',
            picture: null,
            rango: '',

            editI: false,
            editMemb: false,
            editCat: false,
            editAp: false,
            editinfo: false,
            editsocial: false,
            editPic: false,
            bkpic: '',

            idioma: '',
            idiomasResults: [],
            magic: '',
            expertise: false,
            valoration: null,
            editStars: null,
            newVal: null,
            newStars: null
          }
        },
        methods: {
          deleteUser(id, key){
            var este = this;
            if (confirm('Seguro?') === true) {
              axios.get('/delete-user/'+id).then(function(){
                este.users.splice(key, 1);
              })
            }
          },
          setStatus(id, key){
            var este = this;
            axios.get('/status-user/'+id).then(function(user){
              if (este.empresa) {
                este.empresas.splice(key, 1);
                este.empresas.splice(key, 0, user.data);
              }else {
                este.users.splice(key, 1);
                este.users.splice(key, 0, user.data);
              }
            });
          },
          searchMember(){
            var este = this;
            if (this.search !== '') {
              if (!this.empresa) {
                this.users = []
                axios.post('/search-members', {nombre: this.search, magic: '2'}).then(function(users){

                  este.users = users.data
                });
              }else{
                this.empresas = []
                axios.post('/search-empresas', {nombre: this.search}).then(function(empresas){
                  este.empresas = empresas.data
                });
              }
            }else{
              if (!this.empresa) {
                axios.get('/panel/get-users').then(function(users){
                  este.users = users.data
                });
              }else{
                axios.get('/panel/get-empresas').then(function(empresas){
                  este.empresas = empresas.data
                });
              }
            }
          },
          setCat(cat, sw){
            var este = this;
            if (sw === 1) {
              var key = this.categorias.indexOf(cat.categoria_id)
              this.categorias.splice(key, 1)

              this.userCats.push(cat)
            }else{
              this.userCats.forEach(function(cate, key){

                if (cate.categoria_id === cat.categoria_id) {
                  este.userCats.splice(key, 1)
                }
              });
              this.categorias.push(cat)
            }
          },
          editUser(index, sw, magic){
            var este = this;

            var group = $("#inputM"+magic+"_"+index)
            var input = $("#inputM"+magic+"_"+index+">input")
            var span = $("#spanM"+magic+"_"+index)
            this.magic = magic


            if (sw === 1) {
              if (magic === 'idiomas') {
                this.idiomas = []
                this.editI = magic+'_'+index
                var idiomas = JSON.parse(this.users[index].idiomas).split(',')

                for(var x in idiomas){
                  this.idiomas.push(idiomas[x]);
                }
              }

              if (magic === 'fb' || magic === 'tw' || magic === 'in') {
                this.editsocial= magic+'_'+index
              }

              if (magic === 'apellidos') {
                this.editAp = magic+'_'+index
              }
              if (magic === 'rango') {
                this.editMemb = magic+'_'+index
              }
              if (magic === 'cat') {
                this.categorias = [1,2,3]
                this.userCats = []
                this.editCat = magic+'_'+index

                this.users[index].user.categorias.forEach(function(cat){
                  var key = este.categorias.indexOf(cat.categoria_id)
                  if (key > -1) {
                    este.categorias.splice(key, 1);
                  }
                  este.userCats.push(cat)

                })

              }

              if (magic === 'cv' || magic === 'ed') {
                this.editinfo = magic+'_'+index
              }

              group.removeClass('wedit')
              span.addClass('wedit')
            }else{
              if (magic === 'idiomas') {
                this.idiomasResults = []
                this.editI = false
              }

              if (magic === 'fb' || magic === 'tw' || magic === 'in') {
                this.editsocial = false
              }

              if (magic === 'apellidos') {
                this.editAp = false
              }
              if (magic === 'rango') {
                this.editMemb = false
              }
              if (magic === 'cat') {
                this.editCat = false;
              }
              if (magic === 'cv' || magic === 'ed') {
                this.editinfo = false
              }
              if (magic === 'pic') {
                this.editPic = false
                $("#previewM_"+index).css('background', 'url(/storage/'+this.bkpic+')center no-repeat')
                this.picture = null
              }
              setTimeout(function(){
                span.removeClass('wedit')
                group.addClass('wedit')
              }, 150);
            }
          },
          updateUser(id, index, magic, rango){
            var este = this;
            var group = $("#inputM"+magic+"_"+index)
            var span = $("#spanM"+magic+"_"+index)

            if (magic === 'pais') {
              var input = $("#inputM"+magic+"_"+index+">select")
            }else if (magic === 'cv' || magic === 'ed'){

              var input = $("#inputM"+magic+"_"+index+">textarea")
            }else{
              var input = $("#inputM"+magic+"_"+index+">input")
            }

            if (input.val() !== '') {
              if(magic === 'idiomas') {
                var formData = new FormData();
                formData.append('id', id)
                formData.append('magic', magic)
                formData.append('idiomas', this.idiomas)
                axios.post('/panel/update-user', formData).then(function(user){
                  este.users.splice(index, 1);
                  este.users.splice(index, 0, user.data);
                  este.editUser(index, 0, magic)
                });
              }else if(magic === 'apellidos'){
                var ap = $("#input_ap_"+index)
                var am = $("#input_am_"+index)
                axios.post('/panel/update-user', {id: id, value_p: ap.val(), value_m: am.val(), magic: magic}).then(function(user){
                  este.users.splice(index, 1);
                  este.users.splice(index, 0, user.data);
                  este.editUser(index, 0, magic)
                });
              }else if(magic === 'rango'){
                  this.rango = rango

                axios.post('/panel/update-user', {id: id, value: this.rango, magic: magic}).then(function(user){
                  este.users.splice(index, 1);
                  este.users.splice(index, 0, user.data);
                  este.editUser(index, 0, magic)
                });
              }else if(magic === 'cat'){
                var formData = new FormData();
                formData.append('id', id)
                formData.append('magic', magic)
                formData.append('categorias', JSON.stringify(this.userCats))

                axios.post('/panel/update-user', formData).then(function(user){
                  este.users.splice(index, 1);
                  este.users.splice(index, 0, user.data);
                  este.editUser(index, 0, magic)
                });
              }else if (!this.picture){
                axios.post('/panel/update-user', {id: id, value: input.val(), magic: magic}).then(function(user){
                  este.users.splice(index, 1);
                  este.users.splice(index, 0, user.data);
                  este.editUser(index, 0, magic)
                });
              }else{
                var formData = new FormData();
                formData.append('id', id)
                formData.append('magic', magic)
                formData.append('value', input.val())
                formData.append('file', this.picture)
                axios.post('/panel/update-user', formData).then(function(user){
                  este.users.splice(index, 1);
                  este.users.splice(index, 0, user.data);
                  este.editUser(index, 0, magic)
                });
              }
            }
          },
          searchIdioma(){
            var este = this;
            this.idiomasResults = []
            if (this.idioma !== '') {
              axios.post('/search-idioma', {idioma: this.idioma}).then(function(idiomas){
                este.idiomasResults = idiomas.data.data
              });
            }else{
              axios.get('/get-idiomas').then(function(idiomas){
                este.idiomasResults = idiomas.data
              });
            }
          },
          setLang(index, nombre, sw){
            if (sw === 1) {
              this.idiomas.push(nombre)
              this.idiomasResults = []
              this.idioma = ''
            }else{
              this.idiomas.splice(index, 1);
            }
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

          editEmpresa(index, sw, magic){
            var este = this;

            var group = $("#inputE"+magic+"_"+index)
            var input = $("#inputE"+magic+"_"+index+">input")
            var span = $("#spanE"+magic+"_"+index)
            this.magic = magic

            if (sw === 1) {
              if (magic === 'idiomas') {
                this.idiomas = []
                this.editI = magic+'_'+index
                var idiomas = JSON.parse(this.users[index].idiomas).split(',')

                for(var x in idiomas){
                  this.idiomas.push(idiomas[x]);
                }
              }

              if (magic === 'fb' || magic === 'tw' || magic === 'in') {
                this.editsocial= magic+'_'+index
              }

              if (magic === 'apellidos') {
                this.editAp = magic+'_'+index
              }
              if (magic === 'rango') {
                this.editMemb = magic+'_'+index
              }
              if (magic === 'cat') {
                this.categorias = [1,2,3]
                this.userCats = []
                this.editCat = magic+'_'+index

                this.users[index].user.categorias.forEach(function(cat){
                  var key = este.categorias.indexOf(cat.categoria_id)
                  if (key > -1) {
                    este.categorias.splice(key, 1);
                  }
                  este.userCats.push(cat)

                })

              }

              if (magic === 'cv' || magic === 'ed') {
                this.editinfo = magic+'_'+index
              }

              group.removeClass('wedit')
              span.addClass('wedit')
            }else{
              if (magic === 'idiomas') {
                this.idiomasResults = []
                this.editI = false
              }

              if (magic === 'fb' || magic === 'tw' || magic === 'in') {
                this.editsocial = false
              }

              if (magic === 'apellidos') {
                this.editAp = false
              }
              if (magic === 'rango') {
                this.editMemb = false
              }
              if (magic === 'cat') {
                this.editCat = false;
              }
              if (magic === 'cv' || magic === 'ed') {
                this.editinfo = false
              }
              if (magic === 'pic') {
                this.editPic = false
                $("#previewE_"+index).css('background', 'url(/storage/'+this.bkpic+')center no-repeat')
                this.picture = null
              }
              setTimeout(function(){
                span.removeClass('wedit')
                group.addClass('wedit')
              }, 150);
            }
          },
          updateEmpresa(id, index, magic, rango){
            var este = this;
            var group = $("#inputE"+magic+"_"+index)
            var span = $("#spanE"+magic+"_"+index)

            if (magic === 'pais') {
              var input = $("#inputE"+magic+"_"+index+">select")
            }else if (magic === 'cv' || magic === 'ed'){

              var input = $("#inputE"+magic+"_"+index+">textarea")
            }else{
              var input = $("#inputE"+magic+"_"+index+">input")
            }

            if (input.val() !== '') {
              if(magic === 'idiomas') {
                var formData = new FormData();
                formData.append('id', id)
                formData.append('magic', magic)
                formData.append('idiomas', this.idiomas)
                axios.post('/panel/update-empresa', formData).then(function(user){
                  este.empresas.splice(index, 1);
                  este.empresas.splice(index, 0, user.data);
                  este.editEmpresa(index, 0, magic)
                });
              }else if(magic === 'rango'){
                  this.rango = rango

                axios.post('/panel/update-empresa', {id: id, value: this.rango, magic: magic}).then(function(user){
                  este.empresas.splice(index, 1);
                  este.empresas.splice(index, 0, user.data);
                  este.editEmpresa(index, 0, magic)
                });
              }else if (!this.picture){
                axios.post('/panel/update-empresa', {id: id, value: input.val(), magic: magic}).then(function(user){
                  este.empresas.splice(index, 1);
                  este.empresas.splice(index, 0, user.data);
                  este.editEmpresa(index, 0, magic)
                });
              }else{
                var formData = new FormData();
                formData.append('id', id)
                formData.append('magic', magic)
                formData.append('value', input.val())
                formData.append('file', this.picture)
                axios.post('/panel/update-empresa', formData).then(function(user){
                  este.empresas.splice(index, 1);
                  este.empresas.splice(index, 0, user.data);
                  este.editEmpresa(index, 0, magic)
                });
              }
            }
          },
          changePicm(index){
            $("#fileInput_"+index).click()
            this.magic = 'pic'
            this.editPic = this.magic+'_'+index
            this.bkpic = this.empresas[index].foto
          },
          fileChangem(e, index){
            let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.previewm(files[0], index);
          },
          previewm(file, index){
            this.picture = file

            let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                  //  vm.foto = e.target.result;
                    $("#previewE_"+index).css('background', 'url('+e.target.result+')center no-repeat')
                };
                reader.readAsDataURL(file);
          },
          editskills(id){
            this.expertise = this.magic+'_exp_'+id
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
              este.users[user].user.valoracion[index] = response.data
              este.editStars = null
            })
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
              este.users[user].user.valoracion[index] = response.data
              este.valoration = null
            })
          },
          deleteVal(id, index, user){
            var este = this;
            if (confirm("Borrar valoración?") == true) {
              axios.get('/panel/delete-val/'+id).then(function(response){
                if (response.data === 1) {
                  este.users[user].user.valoracion.splice(index, 1)
                }
              });
            }
          },
          saveVal(index, id){
            var area = $('#newValInput_'+index).val()
            var percent = parseInt(this.newStars+1);
            var este = this;
            axios.post('/panel/add-valoration/'+id, {area: area, percent: percent}).then(function(response){
              este.users[index].user.valoracion.push(response.data)
              este.newVal = null
            });
          },
          setleveln(key, index, sw){
            if (sw === 1) {
              for (var i = 0; i < index+1 ; i++) {
                if (key === 'a') {
                  if (this.newStars === null) {
                    $('#newStar'+key+'m_'+i).addClass('active')
                  }
                }
              }
            }else{
                for (var i = 0; i < index+1 ; i++) {
                  if (key === 'a') {
                    if (this.newStars === null) {
                      $('#newStar'+key+'m_'+i).removeClass('active')
                    }
                  }
                }
            }
          },
        }
    }
</script>
