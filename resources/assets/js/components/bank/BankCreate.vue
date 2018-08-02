<template>
  <sidebar>
    <div class="col-md-12" style="padding: 0">
      <md-card>
        <ul class="breadcrumb">
          <li><router-link :to="{ name: 'home'}">Home</router-link></li>
          <li><router-link :to="{ name: 'bank'}">Bank</router-link></li>
          <li class="active">Tambah Bank</li>
        </ul>
      </md-card>

      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white">account_balance</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
              <div class="header-title md-toolbar-section-start">Tambah Bank</div>
              <div class="header-title md-toolbar-section-end"></div>
            </div>
          </md-card-header-text>
        </md-card-header>

        <md-card-content>
          <ul class="error-message">
            <li class="text-error" v-for="err in errors"> {{ err.toString() }} </li>
          </ul>
          <form v-on:submit.prevent="saveForm()">    
            <md-field>
              <label for="nama_bank">Nama Bank</label>
              <md-input name="nama_bank" id="nama_bank" autocomplete="off" v-model="bank.nama_bank" />
            </md-field>
            <md-field>
              <label for="atas_nama">Atas Nama</label>
              <md-input type="atas_nama" name="atas_nama" id="atas_nama" autocomplete="off" v-model="bank.atas_nama" />
            </md-field>
            <md-field>
              <label for="no_rek">No Rekening</label>
              <md-input type="no_rek" name="no_rek" id="no_rek" autocomplete="off" v-model="bank.no_rek" />
            </md-field>
            <md-card-actions>
              <md-button type="submit" class="md-primary">Submit Bank</md-button>
            </md-card-actions>
          </form>
        </md-card-content>
      </md-card>
   
      <!-- Snackbar for bank edit alert -->
      <md-snackbar md-position="center" :md-duration="1500" :md-active.sync="snackbarTambahBank" @md-closed="redirectToBankList">
        <span>Bank berhasil di Tambah !</span>
      </md-snackbar>
    </div>
  </sidebar>
</template>
<script>
export default {
  data: () => ({
    errors: [],
    url: window.location.origin + window.location.pathname,
    bank: {
      nama_bank: '',
      atas_nama: '',
      no_rek: '',
    },
    snackbarTambahBank: false
  }),
  methods: {
    saveForm() {
      const app = this;
      axios.post(app.url+'bank', app.bank)
      .then((resp) => {
        this.snackbarTambahBank = true;
      })
      .catch((err) => {
        this.errors = err.response.data
        console.log('catch:', resp);
      })
    },
    redirectToBankList() {
      this.$router.replace('/bank');  
    }
  }
}  
</script>

<style scoped>
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
</style>
