<template>
  <div>
    <md-card>
      <md-card-content>
        <table class="table table-hover" id="tableAlamat">
          <thead>
            <th width="20%">Nama Lengkap</th>
            <th>Alamat</th>
            <th>No. Telepon</th>
          </thead>
          <tbody>
            <tr>
              <td>{{ userAddress.name }}</td>
              <td>
                {{ userAddress.alamat }}
              </td>
              <td>{{ userAddress.no_telp }}</td>
            </tr>
          </tbody>
        </table>

        <div id="inputAlamat" class="row" style="display: none">
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label>Nama Lengkap</label>
              <input 
                style="font-size: 17px;" 
                type="text" 
                class="form-control" 
                placeholder="Nama Lengkap" 
                v-model="userAddress.name" 
                v-on:input="userAddress.nama_pemesan = $event.target.value" />
            </div>
            <div class="form-group">
              <label>No. Telepon</label>
              <input 
                style="font-size: 17px;" 
                type="text" 
                class="form-control" 
                placeholder="No. Telepon" 
                v-model="userAddress.no_telp" 
                v-on:input="userAddress.nama_pemesan = $event.target.value">
            </div>
            <md-field>
              <label>Alamat</label>
              <md-textarea v-model="userAddress.alamat"></md-textarea>
            </md-field>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label>Provinsi</label>
              <selectize-component :settings="select_provinsi" ref="provinsi" v-on:input="pilihWilayah('kabupaten')">
                <option v-for="provinsi, index in provinsi" v-bind:value="provinsi.id">
                  {{ provinsi.name }}
                </option>
              </selectize-component>
            </div>
            <div class="form-group">
              <label>Kabupaten</label>
              <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kabupaten"></md-progress-bar>
              <p class="waiting" v-if="this.$store.state.lokasi.load_kabupaten">Mohon tunggu ...</p>
              <selectize-component :settings="select_kabupaten" v-model="userAddress.kabupaten" ref="kabupaten" v-on:input="pilihWilayah('kecamatan')">
                <option v-for="kabupaten, index in kabupaten" v-bind:value="kabupaten.id">
                  {{ kabupaten.name }}
                </option>
              </selectize-component>
            </div>
            <div class="form-group">
              <label>Kecamatan</label>
              <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kecamatan"></md-progress-bar>
              <p class="waiting" v-if="this.$store.state.lokasi.load_kecamatan">Mohon tunggu ...</p>
              <selectize-component :settings="select_kecamatan" v-model="userAddress.kecamatan" ref="kecamatan" v-on:input="pilihWilayah('kelurahan')">
                <option v-for="kecamatan, index in kecamatan" v-bind:value="kecamatan.id">
                  {{ kecamatan.name }}
                </option>
              </selectize-component>
            </div>
            <div class="form-group">
              <label>Kelurahan</label>
              <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kelurahan"></md-progress-bar>
              <p class="waiting" v-if="this.$store.state.lokasi.load_kelurahan">Mohon tunggu ...</p>
              <selectize-component :settings="select_kelurahan" v-model="userAddress.kelurahan" ref="kelurahan" v-on:input="changeKelurahan()">
                <option v-for="kelurahan, index in kelurahan" v-bind:value="kelurahan.id">
                  {{ kelurahan.name }}
                </option>
              </selectize-component>
            </div>
          </div>
        </div>
      </md-card-content>

      <md-card-actions>
        <md-button id="btnUbah" @click="ubahAlamat" class="md-dense md-raised" style="background-color: #d44723; color: white">
          Ubah Alamat
        </md-button>
        <md-button id="btnSimpan" @click="simpanAlamat" class="md-dense md-raised" style="display: none; background-color: #d44723; color: white">
          Simpan Alamat
        </md-button>
      </md-card-actions>
    </md-card>

    <!-- Snackbar for success alert -->
    <md-snackbar md-position="center" :md-duration="1500" :md-active.sync="notifSuccess" @md-closed="redirectTo">
      <span id="span-snackbar">{{notifMessage}}</span>
      <span><md-icon style="color: white">done_all</md-icon></span>
    </md-snackbar>
  </div>
</template>

<script type="text/javascript">

import { LOAD_DATA } from '../../store/lokasi/mutations'

export default {
  props: [
    "userAddress",
    "select_provinsi", "select_kabupaten", "select_kecamatan", "select_kelurahan",
    "provinsi" , "kabupaten" , "kecamatan" , "kelurahan"
 ],
 data : () => ({
   url: window.location.origin + (window.location.pathname + 'user'),
   notifMessage: '',
   notifSuccess: false
 }),
  mounted() {
    this.$refs.kabupaten.$el.selectize.disable()
    this.$refs.kelurahan.$el.selectize.disable()
    this.$refs.kecamatan.$el.selectize.disable()
  },
  methods: {
    changeKelurahan () {
      this.userAddress.kelurahan = this.$refs.kelurahan.$el.selectize.getValue()
    },
    pilihWilayah(type) {
      const app = this
      var selectize
      var id_wilayah

      switch (type) {
        case "kabupaten":
          id_wilayah = app.$refs.provinsi.$el.selectize.getValue()
          if(id_wilayah){
            app.userAddress.provinsi = id_wilayah
            app.userAddress.kabupaten = null
            app.userAddress.kecamatan = null
            app.userAddress.kelurahan = null
            selectize = app.$refs.kabupaten.$el.selectize
            app.$refs.kecamatan.$el.selectize.disable()
            app.$refs.kelurahan.$el.selectize.disable()
          }
        break;
        case "kecamatan":
          id_wilayah = app.$refs.kabupaten.$el.selectize.getValue()
          if(id_wilayah){
            app.userAddress.kabupaten = id_wilayah
            app.userAddress.kecamatan = null
            app.userAddress.kelurahan = null
            selectize = app.$refs.kecamatan.$el.selectize
            selectize.clearOptions()
            app.$refs.kelurahan.$el.selectize.clearOptions()
            app.$refs.kelurahan.$el.selectize.disable()
          }
        break;
        case "kelurahan":
          id_wilayah = app.$refs.kecamatan.$el.selectize.getValue()
          if(id_wilayah){
            app.userAddress.kecamatan = id_wilayah
            app.userAddress.kelurahan = null
            selectize = app.$refs.kelurahan.$el.selectize
            selectize.clearOptions()
          }
        break;
      }

      if(id_wilayah){
        app.$store.commit(`lokasi/${LOAD_DATA}`, {data : type, status : 1})
        app.$store.dispatch('lokasi/LOAD_WILAYAH', {
          type : type,
          id : id_wilayah,
          status : 1
        })
        selectize.enable()
        selectize.focus()
      }
    },
    ubahAlamat() {
      $("#tableAlamat").hide();
      $("#btnUbah").hide();

      $("#inputAlamat").show();
      $("#btnSimpan").show();
    },
    simpanAlamat() {
      const app = this;

      axios.put(app.url+'/simpan-alamat', app.userAddress)
			.then(function (resp) {
        app.notifMessage = `Berhasil Mengubah Alamat`
        app.notifSuccess = true;

        $("#tableAlamat").show();
        $("#btnUbah").show();

        $("#inputAlamat").hide();
        $("#btnSimpan").hide();
			})
			.catch(function (resp) {
        console.log(resp);
				app.errors = resp.response
			});
    },
    redirectTo() {
      window.location.replace(window.location.origin+(window.location.pathname)+"#/akun")
    },
  }
}

</script>
