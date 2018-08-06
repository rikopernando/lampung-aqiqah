<template>
   <div>
      <div class="form-group">
        <input type="text" v-on:input="pesanan.nama_peserta = $event.target.value" class="form-control form-checkout" placeholder="Nama Peserta">
        <span v-if="errors.nama_peserta" class="error-message"> {{ errors.nama_peserta[0] }}</span>
      </div>
      <div class="form-group">
        <input type="text" v-on:input="pesanan.tempat_tanggal_lahir = $event.target.value" class="form-control form-checkout" placeholder="Tempat & Tanggal Lahir">
        <span v-if="errors.tempat_tanggal_lahir" class="error-message"> {{ errors.tempat_tanggal_lahir[0] }}</span>
      </div>
      <div class="form-group">
        <selectize-component :settings="jenisKelamin" v-on:input="changeJenisKelamin()" ref="jenis_kelamin_peserta">
          <option v-bind:value="1">Laki-laki</option>
          <option v-bind:value="2">Perempuan</option>
        </selectize-component>
        <span v-if="errors.jenis_kelamin_peserta" class="error-message"> {{ errors.jenis_kelamin_peserta[0] }}</span>
      </div>
      <div class="form-group">
        <input type="text" v-on:input="pesanan.nama_ayah = $event.target.value" class="form-control form-checkout" placeholder="Nama Ayah">
        <span v-if="errors.nama_ayah" class="error-message"> {{ errors.nama_ayah[0] }}</span>
      </div>
      <div class="form-group">
        <input type="text" v-on:input="pesanan.nama_ibu = $event.target.value" class="form-control form-checkout" placeholder="Nama Ibu">
        <span v-if="errors.nama_ibu" class="error-message"> {{ errors.nama_ibu[0] }}</span>
      </div>
      <div class="form-group">
        <input type="text" v-on:input="pesanan.tempat_lahir = $event.target.value" class="form-control form-checkout" placeholder="Lahir Di(Nama RSB/Bidan)">
        <span v-if="errors.tempat_lahir" class="error-message"> {{ errors.tempat_lahir[0] }}</span>
      </div>
   </div>
</template>

<script>
  export default {
    props : ['pesanan','errors'],
    data : () => ({
      jenisKelamin : {
        placeholder : 'Jenis Kelamin'
      }
    }),
    methods : {
      changeJenisKelamin() {
        this.pesanan.jenis_kelamin_peserta = this.$refs.jenis_kelamin_peserta.$el.selectize.getValue()
      }
    }
  }
</script>

<style lang="scss" scoped>
  .form-checkout {
    font-size: 14px;
  }
  .error-message {
    background-color:  #ff4d4d;
    border-radius: 2px;
    font-weight: bold;
    color: white;
    padding : 4px;
  }
</style>
