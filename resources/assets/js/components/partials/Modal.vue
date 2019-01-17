<template>
  <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <register v-if="!sw" :admin="admin"></register>
      <empresa v-else></empresa>
    </div>
  </div>
</template>

<script>
    export default {
        mounted() {
          var este = this;
            this.$bus.$on('registerModal', ($event) => {
              este.sw = $event.sw
              $("#registerModal").modal();
            });
        },
        props: ['admin'],
        data(){
          return{
            sw: 0,
          }
        }
    }
</script>
