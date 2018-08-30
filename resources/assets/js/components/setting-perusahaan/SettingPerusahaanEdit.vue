<style>
  ._spinner-container {
    position: absolute; 
    left: 50%;
  }
  ._spinner {
    position: relative; 
    left: -50%;
  }
  .breadcrumb {
    border-color: #ffffff;
    border-style: solid;
    border-width: 0 1px 4px 1px;
    padding: 8px 15px;
    margin-bottom: 35px;
    list-style: none;
    background-color: #ffffff;
    border-radius: 4px;
  }
  .header-card i {
    background-color: #d44723;
    width: 50px;
    height: 50px;
    text-align: center;
    line-height: 50px;
    border-radius: 3px;
    font-size: 30px !important;
    margin: -30px 0px 0;
    position: relative;
    box-shadow: -4px -3px 0px 0px #ff000045;
  }
  .header-title {
    color: #867f7f;
    font-size: 20px;
    padding: 4px 0px 0px 10px;
  }
  .error-message {
    background-color:  #ff4d4d;
    border-radius: 6px;
  }
  .text-error {
    font-weight: bold;
    color: white;
    padding: 4px;
  }
</style>

<template>
  <sidebar>
    <div class="col-md-12">
      <md-card>
        <ul class="breadcrumb">
          <li><router-link :to="{name: 'home'}">Home</router-link></li>
          <li><router-link :to="{name: 'setting_perusahaan'}">Setting Perusahaan</router-link></li>
          <li class="active">Edit</li>
        </ul>
      </md-card>

      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white;">group</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
              <div class="header-title md-toolbar-section-start">Edit Setting Perusahaan</div>
              
            </div>
          </md-card-header-text>
        </md-card-header>
        <md-card-content>
           <ul class="error-message">
             <li class="text-error" v-for="err in errors"> {{ err.toString() }} </li>
           </ul>
          <form v-on:submit.prevent="saveForm()">

            <!-- Loading -->
            <div v-if="loading" class="_spinner-container">
              <div class="_spinner">
                <md-progress-spinner 
                  :md-diameter="80" 
                  :md-stroke="5" 
                  md-mode="indeterminate">
                </md-progress-spinner>
              </div>
            </div>

            <md-field>
              <label v-if="!loading" for="name">Nama</label>
              <md-input name="name" id="name" v-model="setting_perusahaan.name" />
            </md-field>

            <md-field>
              <label v-if="!loading" for="email">Email</label>
              <md-input name="email" type="email" id="email" v-model="setting_perusahaan.email" />
            </md-field>

            <md-field>
              <label v-if="!loading" for="no_telp">No. Telepon</label>
              <md-input name="no_telp" id="no_telp" v-model="setting_perusahaan.no_telp" />
            </md-field>

            <md-field>
              <label v-if="!loading" for="name">Alamat</label>
              <md-input name="alamat" id="alamat" v-model="setting_perusahaan.alamat" />
            </md-field>

            <md-card-actions>
              <md-progress-spinner 
                v-if="submitted" 
                :md-diameter="30" 
                :md-stroke="3" 
                md-mode="indeterminate">
              </md-progress-spinner>
              <md-button v-else type="submit" class="md-primary">Edit</md-button>
            </md-card-actions>

          </form>
        </md-card-content>
      </md-card>

      <!-- Snackbar for setting_perusahaan edit alert -->
      <md-snackbar md-position="center" :md-duration="1500" :md-active.sync="snackbarEditSettingPerusahaan" @md-closed="redirectToSettingPerusahaanList">
        <span>Perusahaan berhasil diedit!</span>
      </md-snackbar>
    </div>
  </sidebar>
</template>

<script>

export default {
  data: () => ({
    errors : [],
    url: window.location.origin + (window.location.pathname + 'setting-perusahaan'),
    setting_perusahaan: {
      name: '',
      email: '',
      no_telp: '',
      alamat: ''
    },
    snackbarEditSettingPerusahaan: false,
    submitted: false,
    loading: true,
  }),
  mounted() {
    this.getDataSettingPerusahaan(this.$route.params.id);
  },
  methods: {
    getDataSettingPerusahaan(setting_perusahaanId) {
      axios.get(this.url + '/' + setting_perusahaanId)
      .then(resp => {
        this.setting_perusahaan = resp.data;
        this.loading = false;
      })
      .catch(resp => {
        console.log('catch getDataSettingPerusahaan:', resp);
      });
    },
    saveForm() {
      this.submitted = true;
      axios.patch(this.url + '/' + this.$route.params.id, this.setting_perusahaan)
      .then(resp => {
        this.snackbarEditSettingPerusahaan = true;
        this.submitted = false;
      })
      .catch(err => {
        this.errors = err.response.data
        console.log(this.errors)
        this.submitted = false;
        alert('Terjadi Kesalahan')
        console.log('catch saveForm:', err);
      });
    },
    redirectToSettingPerusahaanList() {
      this.$router.replace('/setting-perusahaan');  
    }
  }
}  
</script>
