<template>
  <div class="row">
    <div class="col text-center">
      <h6>Selecciona una foto de perfil</h6>
      <hr>
      <div  @click="selectPic" class="uploadPicPrev" :style="'background: url('+foto+')center no-repeat'"></div>
      <br><br>
      <input accept="image/x-png,image/gif,image/jpeg"  @change="fileChange" id="registerPic" type="file" style="display: none">
    </div>
  </div>
</template>

<script>
    export default {
        mounted() {
            console.log(this.sw)
        },
        data(){
          return {
            foto: '/media/img/defaults/profile_1.png',
            foto2: '/media/img/defaults/profile_1.png',
            picture: null,
          }
        },
        methods: {
          fileChange(e){
            let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.preview(files[0]);
          },
          preview(file){
            this.picture = file
            this.$bus.$emit('file', {file: this.picture});
            let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.foto = e.target.result;
                };
                reader.readAsDataURL(file);
          },
          selectPic(){
            $('#registerPic').click()
          },
        }
    }
</script>
