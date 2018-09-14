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
              <td> {{ userAddress.alamat }} </td>
              <td>{{ userAddress.no_telp }}</td>
            </tr>
          </tbody>
        </table>

        <div id="inputAlamat" class="row" style="display: none">
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label>Nama Lengkap</label>
              <input style="font-size: 17px;" type="text" class="form-control" placeholder="Nama Lengkap" v-model="userAddress.name" v-on:input="userAddress.nama_pemesan = $event.target.value">
            </div>
            <div class="form-group">
              <label>No. Telepon</label>
              <input style="font-size: 17px;" type="text" class="form-control" placeholder="No. Telepon" v-model="userAddress.no_telp" v-on:input="userAddress.nama_pemesan = $event.target.value">
            </div>
            <md-field>
              <label>Alamat</label>
              <md-textarea v-model="userAddress.alamat"></md-textarea>
            </md-field>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
              <label>Provinsi</label>
              <selectize-component :settings="select_provinsi" v-model="selected_provinsi" ref="provinsi" v-on:input="pilihWilayah('kabupaten')">
                <option v-for="provinsi, index in provinsi" v-bind:value="provinsi.id">{{ provinsi.name }} </option>
              </selectize-component>
            </div>
            <div class="form-group">
              <label>Kabupaten</label>
              <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kabupaten"></md-progress-bar>
              <p class="waiting" v-if="this.$store.state.lokasi.load_kabupaten">Mohon tunggu ...</p>
              <selectize-component :settings="select_kabupaten" v-model="userAddress.kabupaten" ref="kabupaten" v-on:input="pilihWilayah('kecamatan')">
                <option v-for="kabupaten, index in kabupaten" v-bind:value="kabupaten.id">{{ kabupaten.name }} </option>
              </selectize-component>
            </div>
            <div class="form-group">
              <label>Kecamatan</label>
              <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kecamatan"></md-progress-bar>
              <p class="waiting" v-if="this.$store.state.lokasi.load_kecamatan">Mohon tunggu ...</p>
              <selectize-component :settings="select_kecamatan" v-model="selected_kecamatan" ref="kecamatan" v-on:input="pilihWilayah('kelurahan')">
                <option v-for="kecamatan, index in kecamatan" v-bind:value="kecamatan.id">{{ kecamatan.name }} </option>
              </selectize-component>
            </div>
            <div class="form-group">
              <label>Kelurahan</label>
              <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kelurahan"></md-progress-bar>
              <p class="waiting" v-if="this.$store.state.lokasi.load_kelurahan">Mohon tunggu ...</p>
              <selectize-component :settings="select_kelurahan" v-model="selected_kelurahan" ref="kelurahan" v-on:input="changeKelurahan()">
                <option v-for="kelurahan, index in kelurahan" v-bind:value="kelurahan.id">{{ kelurahan.name }} </option>
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
  import { mapState } from 'vuex'

  export default {
    props: [
      "userAddress", "select_provinsi", "select_kabupaten", 
      "select_kecamatan", "select_kelurahan", "provinsi" , 
      "kabupaten" , "kecamatan" , "kelurahan"
    ],
    data : () => ({
      url: window.location.origin + (window.location.pathname + 'user'),
      notifMessage: '',
      selected_provinsi : '',
      selected_kabupaten : '',
      selected_kecamatan : '',
      selected_kelurahan : '',
      notifSuccess: false,
      showKabupaten : false,
      showKecamatan : false,
      showKelurahan : false,
    }),
    computed : mapState ({
      profile() {
        return this.$store.state.user.profile;
      },
    }),
    watch : {
      kabupaten() {
        if (Object.keys(this.kabupaten).length) {
          this.showKabupaten = true;
          this.selected_kabupaten && this.setWilayah('kecamatan', this.selected_kabupaten);
        }
      },
      kecamatan() {
        if (Object.keys(this.kecamatan).length) {
          this.showKecamatan = true;
          this.selected_kecamatan && this.setWilayah('kelurahan',this.selected_kecamatan);
        }
      },
      kelurahan() {
        if (Object.keys(this.kelurahan).length) {
          this.showKelurahan = true;
        }
      },
      profile() {
        this.getAddress();
      }
    },
    mounted() {
      this.getAddress();
    },
    methods: {
      getAddress() {
        if (Object.keys(this.profile).length) {
          this.userAddress.name = this.profile.name;
          this.userAddress.no_telp = this.profile.no_telp;
          this.userAddress.alamat = this.profile.alamat;
          this.userAddress.provinsi = this.profile.provinsi;
          this.userAddress.kabupaten = this.profile.kabupaten;
          this.userAddress.kecamatan = this.profile.kecamatan;
          this.userAddress.kelurahan = this.profile.kelurahan;
          this.selected_provinsi = this.profile.provinsi;
          this.selected_kabupaten = this.profile.kabupaten;
          this.selected_kecamatan = this.profile.kecamatan;
          this.selected_kelurahan = this.profile.kelurahan;
          this.setWilayah('kabupaten',this.selected_provinsi);
        }
      },
      changeKelurahan () {
          this.userAddress.kelurahan = this.$refs.kelurahan.$el.selectize.getValue();
      },
      pilihWilayah(type) {
        let selectize;
        let id_wilayah;

        switch (type) {
          case "kabupaten":
            id_wilayah = this.$refs.provinsi.$el.selectize.getValue();

            if (id_wilayah) {
                this.userAddress.provinsi = id_wilayah;
                this.userAddress.kabupaten = null;
                this.userAddress.kecamatan = null;
                this.userAddress.kelurahan = null;
                this.$refs.kecamatan.$el.selectize.disable();
                this.$refs.kelurahan.$el.selectize.disable();
                selectize = this.$refs.kabupaten.$el.selectize;
            }
          break;
          case "kecamatan":
            id_wilayah = this.$refs.kabupaten.$el.selectize.getValue();

            if (id_wilayah) {
                this.userAddress.kabupaten = id_wilayah;
                this.userAddress.kecamatan = null;
                this.userAddress.kelurahan = null;
                this.$refs.kelurahan.$el.selectize.clearOptions();
                this.$refs.kelurahan.$el.selectize.disable();
                selectize = this.$refs.kecamatan.$el.selectize;
                selectize.clearOptions();
            }
          break;
          case "kelurahan":
            id_wilayah = this.$refs.kecamatan.$el.selectize.getValue()

            if (id_wilayah) {
                this.userAddress.kecamatan = id_wilayah;
                this.userAddress.kelurahan = null;
                selectize = this.$refs.kelurahan.$el.selectize;
                selectize.clearOptions();
            }
          break;
        }

        if (id_wilayah) {
          this.setWilayah(type, id_wilayah);
          selectize.enable();
          selectize.focus();
        }
      },
      setWilayah(type, id_wilayah) {
        if (id_wilayah) {
          this.$store.commit(`lokasi/${LOAD_DATA}`,{data : type, status : 1});
          this.$store.dispatch('lokasi/LOAD_WILAYAH',{
            type : type,
            id : id_wilayah,
            status : 1
          });
        }
      },
      ubahAlamat() {
        $("#tableAlamat").hide();
        $("#btnUbah").hide();
        $("#inputAlamat").show();
        $("#btnSimpan").show();
      },
      simpanAlamat() {
        axios.put(this.url + '/simpan-alamat', this.userAddress)
  			.then(resp => {
          this.notifMessage = `Berhasil Mengubah Alamat`;
          this.notifSuccess = true;

          $("#tableAlamat").show();
          $("#btnUbah").show();

          $("#inputAlamat").hide();
          $("#btnSimpan").hide();
  			})
  			.catch(resp => {
          console.log(resp);
  				this.errors = resp.response;
  			});
      },
      redirectTo() {
        window.location.replace(window.location.origin + (window.location.pathname) + "#/akun");
      },
    }
  }
</script>
