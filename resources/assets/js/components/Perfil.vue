<template>
  <div class="container blanco">
    <div class="row">
      <div class="col-md-4">
        <div class="profile-pic profile-cons">
          <div :style="'background: url(/storage/'+perfil.foto+')center no-repeat'"></div>
        </div>
        <div>
          <ul class="country-list">
            <li>
              <div class="row">
                <div class="col" style="max-width:35%;">
                  <img width="60" :src="'/storage/flags/'+perfil.pais_id+'.png'" :alt="pais+' flag'" onError="this.onerror=null;this.src='/media/img/flags/default.png';" >
                </div>
                <div class="col">
                  <h3 style="margin-bottom: 0;">{{pais}}</h3>
                  <span>{{perfil.ciudad}}</span><br>
                  <span>({{zonaa.nombre}})</span>
                </div>
              </div>
            </li>
            <li>
              <div class="row">
                <div v-if="usuario.empresa" class="col">
                  <img v-if="usuario.empresa.rango === '1'" width="60" :src="'/media/img/medallas/afiliado.png'" alt="afiliado icon">
                  <img v-if="usuario.empresa.rango === '2'" width="60" :src="'/media/img/medallas/especialista.png'" alt="especialista icon">
                  <img v-if="usuario.empresa.rango === '3'" width="60" :src="'/media/img/medallas/experto.png'" alt="experto icon">
                  <img v-if="usuario.empresa.rango === '4'" width="60" :src="'/media/img/medallas/profesional.png'" alt="profesional icon">
                </div>
                <div v-else class="col">
                  <img v-if="profile.rango === '1'" width="60" :src="'/media/img/medallas/afiliado.png'" alt="afiliado icon">
                  <img v-if="profile.rango === '2'" width="60" :src="'/media/img/medallas/especialista.png'" alt="especialista icon">
                  <img v-if="profile.rango === '3'" width="60" :src="'/media/img/medallas/experto.png'" alt="experto icon">
                  <img v-if="profile.rango === '4'" width="60" :src="'/media/img/medallas/profesional.png'" alt="profesional icon">
                </div>
                <div class="col">
                  <h4 style="margin-bottom: 0; margin-top: 15px; text-transform: capitalize">
                    <span v-if="profile.rango === '1'">Afiliado</span>
                    <span v-if="profile.rango === '2'">Especialista</span>
                    <span v-if="profile.rango === '3'">Experto</span>
                    <span v-if="profile.rango === '4'">Profesional</span>
                  </h4>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-8">
        <div>
          <div>
            <h1 v-if="perfil.apellido_p">{{perfil.name}} {{perfil.apellido_p}} {{perfil.apellido_m}}</h1>
            <h1 v-else>{{perfil.name}}</h1>
            <span  v-for="categoria in categoriass">
              <img v-if="categoria.categoria_id === 1" width="40" :src="'/media/img/categorias/consultor.png'" alt="categoria icon">
              <span v-if="categoria.categoria_id === 1">Consultor</span>
              <img v-if="categoria.categoria_id === 2" width="40" :src="'/media/img/categorias/coach.png'" alt="categoria icon">
              <span v-if="categoria.categoria_id === 2">Coach</span>
              <img v-if="categoria.categoria_id === 3" width="40" :src="'/media/img/categorias/capacitador.png'" alt="categoria icon">
              <span v-if="categoria.categoria_id === 3">Capacitador</span>
              <img v-if="categoria.categoria_id === 4" width="40" :src="'/media/img/categorias/empresa.png'" alt="categoria icon">
              <span v-if="categoria.categoria_id === 4">Empresa</span>
              <img v-if="categoria.categoria_id === 5" width="40" :src="'/media/img/categorias/programas.png'" alt="categoria icon">
              <span v-if="categoria.categoria_id === 5">Programa</span>
            </span>
          </div>
          <hr style="border-top: 1px solid #FFF;">
          <br>
          <img width="100%" :src="'/media/img/mapas/'+zonaa.id+'.png'" alt="mapa de zona">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        mounted() {

        },
        props: ['user', 'profile', 'pais', 'categorias', 'zona'],
        data(){
          return {
            usuario: JSON.parse(this.user),
            perfil: JSON.parse(this.profile),
            zonaa: JSON.parse(this.zona),
            categoriass: JSON.parse(this.categorias),
          }
        }
    }
</script>
