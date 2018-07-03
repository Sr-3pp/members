<template>
  <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Login</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col">
                <div class="form-group pos-relative">
                  <transition name="fade">
                    <span style="top: 0;" class="must" v-if="alertMail">{{alertMailText}}</span>
                  </transition>
                  <label>E-mail:</label>
                  <input id="loginMail" @keyup.enter="login" v-model="email" type="text" class="form-control" placeholder="ejemplo@mail.com">
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col">
                <transition name="fade">
                  <span class="must" v-if="alertPass">Este campo es Obligatorio</span>
                </transition>
                <label>Password</label>
                <input @keyup.enter="login" v-model="password" type="password" class="form-control" placeholder="Password">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" @click="login">Login</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        mounted() {
          var este = this;
          this.$bus.$on('loginattempt', ($event) => {
            this.alertMail = true
            this.alertMailText = 'Verifica tus datos'
          })
        },
        data(){
          return {
            email: '',
            password: '',
            alertMail: false,
            alertPass: false,
            alertMailText: 'Este campo es obligatorio'
          }
        },
        methods: {
          login(){
            if (this.email !== '' || this.password !== '') {
              if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email)) {
                this.$bus.$emit('login', {email: this.email, password: this.password})
              }else{
                this.alertMail = true
                this.alertMailText = 'Introduce un correo válido'
              }
            }else{
              if (this.email === '') {
                this.alertPass = true
              }
              if (this.password === '') {
                this.alertMail = true
              }
            }
          }
        }
    }
</script>
