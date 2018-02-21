<template>
  <nav class="navbar navbar-default" style="height:200px!important; background:url('/media/img/recursos/nav_bg.jpg'); border:none!important;">
              <div class="container">
                <ul class="top-links">
                  <li>
                    <a v-if="userid !== '0'" :href="'/perfil/'+user.id">Perfil</a>
                  </li>
                  <li>
                     <a v-if="userid !== '0' && user.tipo === 3" href="#" class="btn btn-warning"><i class="glyphicon glyphicon-list-alt"></i> &nbsp;Dashboard</a>
                  </li>
                  <li>
                    <a v-if="userid === '0'" href="#">Registrar Empresa</a>
                  </li>
                  <li>
                    <a v-if="userid === '0'" href="#">Crear Perfil</a>
                  </li>
                  <li>
                    <a v-if="userid === '0'" href="#">Acceder</a>
                  </li>
                </ul>
                  <div class="navbar-header">

                      <!-- Collapsed Hamburger -->
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                          <span class="sr-only">Toggle Navigation</span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                      </button>

                      <!-- Branding Image -->
                      <a class="navbar-brand" href="/">
                         <img width="150" src="https://static.wixstatic.com/media/b258fc_1804aea6d7ff4188905eda7f86d65487.png/v1/fill/w_171,h_96,al_c,usm_0.66_1.00_0.01/b258fc_1804aea6d7ff4188905eda7f86d65487.png" alt="">
                      </a>
                  </div>

                  <div class="navigation" id="app-navbar-collapse">
                    <ul>
                      <li>
                        <a href="https://www.internationalccn.org/blank-ekhzj">¿Qué es la ICCN? &nbsp;</a>
                        <img src="/media/img/recursos/nav-separator.png" height="85" alt="">
                      </li>
                      <li>
                        <a href="https://www.internationalccn.org/blank-luchn">Membresías &nbsp;</a>
                        <img src="/media/img/recursos/nav-separator.png" height="85" alt="">
                      </li>
                      <li>
                        <a href="https://www.internationalccn.org/b">Programas &nbsp;</a>
                        <img src="/media/img/recursos/nav-separator.png" height="85" alt="">
                      </li>
                      <li>
                        <a href="http://miembros.internationalccn.org">Miembros &nbsp;</a>
                        <img src="/media/img/recursos/nav-separator.png" height="85" alt="">
                      </li>
                      <li>
                        <a href="https://www.internationalccn.org/blank-1">Blog &nbsp;</a>
                        <img src="/media/img/recursos/nav-separator.png" height="85" alt="" style="">
                      </li>
                      <li>
                        <a href="https://www.internationalccn.org/formulario">Contacto</a>
                         <img src="/media/img/recursos/nav-separator.png" height="85" alt="" style="visibility: hidden;">
                      </li>
                    </ul>
                  </div>
                  <div class="social-icons">
                    <ul>
                      <li>
                        <a href="https://www.facebook.com/internationalccn/?fref=ts"><img src="https://static.wixstatic.com/media/f61c7a3b4b4947b28511a25034973383.png/v1/fill/w_29,h_29,al_c,usm_0.66_1.00_0.01/f61c7a3b4b4947b28511a25034973383.png" alt=""></a>
                      </li>
                      <li>
                        <a href="https://www.facebook.com/internationalccn/?fref=ts"><img src="https://static.wixstatic.com/media/e0678ef25486466ba65ef6ad47b559e1.png/v1/fill/w_29,h_29,al_c,usm_0.66_1.00_0.01/e0678ef25486466ba65ef6ad47b559e1.png" alt=""></a>
                      </li>
                    </ul>
              </div>
              </div>
          </nav>
</template>

<script>
    export default {
        mounted() {
          console.log(this.userid);
            var este = this;
            axios.get('/get-user/'+this.userid).then(function(user){
              este.user = user.data
            });
        },
        props: ['userid'],
        data(){
          return {
            user: [],
          }
        },
        methods: {

        }
    }
</script>
