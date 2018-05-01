<template>
  <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <register v-if="sw === 1"></register>
      <empresa v-if="sw === 2"></empresa>
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
        data(){
          return{
            sw: 0,
          }
        }
    }
</script>
