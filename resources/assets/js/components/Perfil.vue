<template>
  <div class="container blanco">
    <div class="row">
      <div class="col-md-3">
        <div class="profile-pic profile-cons">
          <div :style="'background: url('+perfil.foto+')center no-repeat'"></div>
        </div>
        <div>
          <ul class="country-list">
            <li>
              <div>
                <img width="60" :src="'/media/img/flags/'+pais+'.png'" alt="pais flag">
              </div>
            </li>
            <li>
              <h3 style="margin-bottom: 0;">{{pais}}</h3>
              <span>{{perfil.ciudad}}</span><br>
              <span>({{zonaa.nombre}})</span>
            </li>
          </ul>
          <ul class="country-list">
            <li>
              <div>
                <img width="60" :src="'/media/img/medallas/'+usuario.rango+'.png'" alt="pais flag">
              </div>
            </li>
            <li>
              <h4 style="margin-bottom: 0; margin-top: 15px; text-transform: capitalize">{{usuario.rango}}</h4>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-9">
        <div style="width: 90%; margin: 0 auto;">
          <div>
            <h1>{{usuario.name}} {{usuario.apellido_p}} {{usuario.apellido_m}}</h1>
            <img width="40" :src="'/media/img/categorias/'+categoria+'.png'" alt="categoria icon">
            {{categoria}}
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
          console.log(this.categoria);
        },
        props: ['user', 'profile', 'pais', 'categoria', 'zona'],
        data(){
          return {
            usuario: JSON.parse(this.user),
            perfil: JSON.parse(this.profile),
            zonaa: JSON.parse(this.zona),
          }
        }
    }
</script>
