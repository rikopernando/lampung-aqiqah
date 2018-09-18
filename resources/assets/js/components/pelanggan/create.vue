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
          <li><router-link :to="{name: 'dashboard'}">Dashboard</router-link></li>
          <li><router-link :to="{name: 'pelanggan'}" id="pelanggan">Pelanggan</router-link></li>
          <li class="active">Tambah</li>
        </ul>
      </md-card>

      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white;">account_box</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
              <div class="header-title md-toolbar-section-start">Tambah Pelanggan</div>
              
            </div>
          </md-card-header-text>
        </md-card-header>
        <md-card-content>
          <ul class="error-message">
            <li class="text-error" v-for="err in errors"> {{ err.toString() }} </li>
          </ul>
          <form novalidate v-on:submit.prevent="saveForm">

            <md-field>
              <label for="name">Nama</label>
              <md-input name="name" id="name" v-model="pelanggan.name" />
            </md-field>

            <md-field>
              <label for="email">Email</label>
              <md-input type="email" name="email" id="email" v-model="pelanggan.email" />
            </md-field>

            <md-field>
              <label for="no_telp">No. Telpon</label>
              <md-input type="text" name="no_telp" id="no_telp" v-model="pelanggan.no_telp" />
            </md-field>

            <md-field>
              <label for="alamat">Alamat</label>
              <md-input type="alamat" name="alamat" id="alamat" v-model="pelanggan.alamat" />
            </md-field>

            <md-field>
              <label for="password">Password</label>
              <md-input type="password" name="password" id="password" v-model="pelanggan.password" />
            </md-field>

            <md-field>
              <label for="password_confirmation">Ulangi Password</label>
              <md-input type="password" name="password_confirmation" id="password_confirmation" v-model="pelanggan.password_confirmation" />
            </md-field>

            <md-progress-bar v-if="submitted" md-mode="indeterminate"></md-progress-bar>
            <md-button v-else type="submit" class="md-dense md-raised" style="background-color: #d44723; color: white"> Submit </md-button>

          </form>
        </md-card-content>
      </md-card>

      <!-- Snackbar for pelanggan edit alert -->
      <md-snackbar md-position="center" :md-duration="1500" :md-active.sync="snackbarCreatePelanggan" @md-closed="redirectToPelangganList">
        <span>Berhasil menambahkan Pelanggan!</span>
      </md-snackbar>
    </div>
  </sidebar>
</template>

<script>

export default {
  data: () => ({
    errors: [],
    url: window.location.origin + (window.location.pathname + 'pelanggan'),
    pelanggan: {
      name: '',
      email: '',
      no_telp: '',
      alamat: '',
      password: '',
      password_confirmation: ''
    },
    snackbarCreatePelanggan: false,
    submitted: false,
  }),
  methods: {
    saveForm() {
      this.submitted = true;

      axios.post(this.url, this.pelanggan)
      .then(resp => {
        this.snackbarCreatePelanggan = true;
        this.submitted = false;
      })
      .catch(resp => {
        console.log('catch saveForm:', resp);
        this.errors = resp.response.data
        this.submitted = false;
        console.log(this.errors)
		    document.getElementById("pelanggan").focus({reventScroll:true})
      });
    },
    redirectToPelangganList() {
      this.$router.replace('/pelanggan');  
    }
  }
}  

</script>
