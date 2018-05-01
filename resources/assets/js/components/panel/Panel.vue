<template>
    <div class="container-fluid">
        <div class="row panel-nav">
          <div class="col text-center" onclick="window.location.href = '/'">
            <img width="50px" src="https://static.wixstatic.com/media/b258fc_1804aea6d7ff4188905eda7f86d65487.png/v1/fill/w_171,h_96,al_c,usm_0.66_1.00_0.01/b258fc_1804aea6d7ff4188905eda7f86d65487.png" alt="">
          </div>
          <div class="col text-center" @click="setSection(2)" :class="{active : members}">
            <button>
              <span class="badge badge-danger">2</span>  Miembros <i class="fas fa-users"></i>
            </button>
          </div>
          <div class="col text-center" @click="setSection(3)" :class="{active : programas}">
            <button>
              Programas <i class="fas fa-book"></i>
            </button>
          </div>
          <div class="col text-center" @click="setSection(4)" :class="{active : general}">
             <button>
               General <i class="fas fa-cog"></i>
             </button>
          </div>
        </div>
        <transition-group name="fade">


          <members :key="2" v-if="members"></members>

          <programs :key="3" v-if="programas"></programs>

          <general :key="4" v-if="general"></general>
        </transition-group>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data(){
          return {
            inbox: false,
            members: true,
            programas: false,
            general: false
          }
        },
        methods: {
          setSection(key){
            if (key === 1) {
              this.inbox = true,
              this.members = false,
              this.programas = false,
              this.general = false
            }
            if (key === 2) {
              this.inbox = false,
              this.members = true,
              this.programas = false,
              this.general = false
            }
            if (key === 3) {
              this.inbox = false,
              this.members = false,
              this.programas = true,
              this.general = false
            }
            if (key === 4) {
              this.inbox = false,
              this.members = false,
              this.programas = false,
              this.general = true
            }
          }
        }
    }
</script>
