<template>
  <div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Nama Pemesan" v-on:input="pesanan.nama_pemesan = $event.target.value">
      </div>
      <div class="form-group">
        <input type="text" v-on:input="pesanan.alamat = $event.target.value" class="form-control" placeholder="Alamat">
      </div>
      <div class="form-group">
        <selectize-component :settings="select_provinsi" ref="provinsi" v-on:input="pilihWilayah('kabupaten')">
          <option v-for="provinsi, index in provinsi" v-bind:value="provinsi.id">{{ provinsi.name }} </option> 
        </selectize-component>
      </div>
      <div class="form-group">
        <md-progress-bar md-mode="indeterminate" v-if="lokasi.load_kabupaten"></md-progress-bar>
        <p class="waiting" v-if="lokasi.load_kabupaten">Mohon tunggu ...</p>
        <selectize-component :settings="select_kabupaten" ref="kabupaten" v-on:input="pilihWilayah('kecamatan')">
          <option v-for="kabupaten, index in kabupaten" v-bind:value="kabupaten.id">{{ kabupaten.name }} </option> 
        </selectize-component>
      </div>
      <div class="form-group">
        <md-progress-bar md-mode="indeterminate" v-if="lokasi.load_kecamatan"></md-progress-bar>
        <p class="waiting" v-if="lokasi.load_kecamatan">Mohon tunggu ...</p>
        <selectize-component :settings="select_kecamatan" ref="kecamatan" v-on:input="pilihWilayah('kelurahan')">
          <option v-for="kecamatan, index in kecamatan" v-bind:value="kecamatan.id">{{ kecamatan.name }} </option> 
        </selectize-component>
      </div>
      <div class="form-group">
        <md-progress-bar md-mode="indeterminate" v-if="lokasi.load_kelurahan"></md-progress-bar>
        <p class="waiting" v-if="lokasi.load_kelurahan">Mohon tunggu ...</p>
        <selectize-component :settings="select_kelurahan" ref="kelurahan" v-on:input="changeKelurahan()">
          <option v-for="kelurahan, index in kelurahan" v-bind:value="kelurahan.id">{{ kelurahan.name }} </option> 
        </selectize-component>
      </div>
      <div class="form-group">
        <input type="text" v-on:input="pesanan.handphone = $event.target.value" class="form-control" placeholder="Handphone">
      </div>
      <div class="form-group">
        <input type="email" v-on:input="pesanan.email = $event.target.value" class="form-control" placeholder="Email">
      </div>
      <div class="form-group">
        <selectize-component :settings="selectsumberInformasi" v-on:input="changeSumberInformasi()" ref="sumber_informasi">
          <option v-for="sumberinformasi, index in sumber_informasi" v-bind:value="sumberinformasi">{{ sumberinformasi }} </option> 
        </selectize-component>
      </div>
      <div class="form-group">
        <textarea v-on:input="pesanan.notes = $event.target.value" class="form-control" placeholder="Catatan"></textarea>
      </div>
    </div>
</template>

<script>

  import { LOAD_DATA } from '../../store/lokasi/mutations'

  export default {
      props : ["pesanan" ,"lokasi" ,"select_provinsi" ,"select_kabupaten"
                  ,"select_kecamatan" ,"select_kelurahan" ,"selectsumberInformasi",
                  "sumber_informasi" ,"provinsi" ,"kabupaten" ,"kecamatan" ,"kelurahan"],
      mounted() {
        this.$refs.kabupaten.$el.selectize.disable()
        this.$refs.kelurahan.$el.selectize.disable()
        this.$refs.kecamatan.$el.selectize.disable()
      },
      methods: {
        changeKelurahan () {
            this.pesanan.kelurahan = this.$refs.kelurahan.$el.selectize.getValue()
        },
        changeSumberInformasi () {
            this.pesanan.sumber_informasi = this.$refs.sumber_informasi.$el.selectize.getValue()
        },
        pilihWilayah(type) {
          const app = this
          var selectize
          var id_wilayah 
            switch (type) {
                case "kabupaten":
                  id_wilayah = app.$refs.provinsi.$el.selectize.getValue()
                  if(id_wilayah){
                      app.pesanan.provinsi = id_wilayah
                      selectize = app.$refs.kabupaten.$el.selectize
                      app.$refs.kecamatan.$el.selectize.disable()
                      app.$refs.kelurahan.$el.selectize.disable()
                  }
                    break;
                case "kecamatan":
                  id_wilayah = app.$refs.kabupaten.$el.selectize.getValue()
                  if(id_wilayah){
                      app.pesanan.kabupaten = id_wilayah
                      selectize = app.$refs.kecamatan.$el.selectize
                      selectize.clearOptions()
                      app.$refs.kelurahan.$el.selectize.clearOptions()
                      app.$refs.kelurahan.$el.selectize.disable()
                  }
                    break;
                case "kelurahan":
                  id_wilayah = app.$refs.kecamatan.$el.selectize.getValue()
                  if(id_wilayah){
                      app.pesanan.kecamatan = id_wilayah
                      selectize = app.$refs.kelurahan.$el.selectize
                      selectize.clearOptions()
                  }
                    break;
            }

          if(id_wilayah){
              app.$store.commit(`lokasi/${LOAD_DATA}`,type)
              app.$store.dispatch('lokasi/LOAD_WILAYAH',{
                type : type,
                id : id_wilayah
              })
              selectize.enable()
              selectize.focus()
          }
        }
      }
  }

</script>

<style lang="scss" scoped>
  .waiting {
    font-style: italic;
  }
</style>
