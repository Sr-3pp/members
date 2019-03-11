<template>
  <div class="container blanco">
    <div class="row">
      <div class="col-md-4">
        <div class="profile-pic profile-cons">
          <div :style="'background: url(/storage/'+programa.foto+')center no-repeat'"></div>
        </div>
        <div>
          <ul class="country-list">
            <li>
              <div class="row">
                <div class="col" style="max-width:35%;">
                  <img width="60" :src="'/storage/flags/'+empresa.pais_id+'.png'" :alt="empresa.pais.nombre+' flag'" onError="this.onerror=null;this.src='/media/img/flags/default.png';" >
                </div>
                <div class="col">
                  <h3 style="margin-bottom: 0;">{{empresa.pais.nombre}}</h3>
                  <span>{{empresa.ciudad}}</span><br>
                  <span>({{empresa.pais.zona.nombre}})</span>
                </div>
              </div>
            </li>
            <li>
              <div class="row">
                <div class="col">
                  <img v-if="empresa.rango === 'afiliado'" width="60" :src="'/media/img/medallas/afiliado.png'" alt="afiliado icon">
                  <img v-if="empresa.rango === 'especialista'" width="60" :src="'/media/img/medallas/especialista.png'" alt="especialista icon">
                  <img v-if="empresa.rango === 'experto'" width="60" :src="'/media/img/medallas/experto.png'" alt="experto icon">
                  <img v-if="empresa.rango === 'profesional'" width="60" :src="'/media/img/medallas/profesional.png'" alt="profesional icon">
                </div>
                <div class="col">
                  <h4 style="margin-bottom: 0; margin-top: 15px; text-transform: capitalize">
                    <span v-if="empresa.rango === 'afiliado'">Afiliado</span>
                    <span v-if="empresa.rango === 'especialista'">Especialista</span>
                    <span v-if="empresa.rango === 'experto'">Experto</span>
                    <span v-if="empresa.rango === 'profesional'">Profesional</span>
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
            <h1>{{programa.nombre}}</h1>
            <span>
              <img width="40" :src="'/media/img/categorias/programas.png'" alt="categoria icon">
              <span>Programa</span>
            </span>
          </div>
          <hr style="border-top: 1px solid #FFF;">
          <br>
          <img width="100%" :src="'/media/img/mapas/'+empresa.pais.zona.id+'.png'" alt="mapa de zona">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        mounted() {
          var este =this;
          axios.get('/get-programa/'+this.id).then(function(programa){
            este.programa = programa.data
            este.empresa = programa.data.empresa
          })
        },
        props: ['id'],
        data(){
          return {
            programa: [],
            empresa: []
          }
        }
    }
</script>
