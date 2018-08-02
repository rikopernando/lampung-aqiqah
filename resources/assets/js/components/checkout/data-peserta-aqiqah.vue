<template>
   <div>
      <div class="form-group">
        <input type="text" v-on:input="pesanan.nama_peserta = $event.target.value" class="form-control form-checkout" placeholder="Nama Peserta">
      </div>
      <div class="form-group">
        <input type="text" v-on:input="pesanan.ttl_peserta = $event.target.value" class="form-control form-checkout" placeholder="Tempat & Tanggal Lahir">
      </div>
      <div class="form-group">
        <selectize-component :settings="jenisKelamin" v-on:input="changeJenisKelamin()" ref="jenis_kelamin_peserta">
          <option v-bind:value="1">Laki-laki</option>
          <option v-bind:value="2">Perempuan</option>
        </selectize-component>
      </div>
      <div class="form-group">
        <input type="text" v-on:input="pesanan.nama_ayah = $event.target.value" class="form-control form-checkout" placeholder="Nama Ayah">
      </div>
      <div class="form-group">
        <input type="text" v-on:input="pesanan.nama_ibu = $event.target.value" class="form-control form-checkout" placeholder="Nama Ibu">
      </div>
      <div class="form-group">
        <input type="text" v-on:input="pesanan.tempat_lahir = $event.target.value" class="form-control form-checkout" placeholder="Lahir Di(Nama RSB/Bidan)">
      </div>
   </div>
</template>

<script>
  export default {
    props : ['pesanan'],
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
</style>
