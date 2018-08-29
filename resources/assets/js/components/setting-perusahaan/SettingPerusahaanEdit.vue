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
          <form novalidate v-on:submit.prevent="validateSettingPerusahaan">

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

            <md-field :class="getValidationClass('name')">
              <label v-if="!loading" for="name">Nama</label>
              <md-input name="name" id="name" v-model="setting_perusahaan.name" />
              <span class="md-error" v-if="!$v.setting_perusahaan.name.required">Nama tidak boleh kosong</span>
            </md-field>

            <md-field :class="getValidationClass('email')">
              <label v-if="!loading" for="email">Email</label>
              <md-input name="email" type="email" id="email" v-model="setting_perusahaan.email" />
              <span class="md-error" v-if="!$v.setting_perusahaan.email.required">Email tidak boleh kosong</span>
            </md-field>

            <md-field :class="getValidationClass('no_telp')">
              <label v-if="!loading" for="no_telp">No. Telepon</label>
              <md-input name="no_telp" id="no_telp" v-model="setting_perusahaan.no_telp" />
              <span class="md-error" v-if="!$v.setting_perusahaan.no_telp.required">No. Telepon tidak boleh kosong</span>
            </md-field>

            <md-field :class="getValidationClass('alamat')">
              <label v-if="!loading" for="name">Alamat</label>
              <md-input name="alamat" id="alamat" v-model="setting_perusahaan.alamat" />
              <span class="md-error" v-if="!$v.setting_perusahaan.alamat.required">Alamat tidak boleh kosong</span>
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

import { validationMixin } from 'vuelidate'
import {
  required,
  email,
  minLength,
  maxLength
} from 'vuelidate/lib/validators'

export default {
  mixins: [validationMixin],
  data: () => ({
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
  validations: {
    setting_perusahaan: {
      name: {
        required,
      },
      no_telp: {
        required,
      },
      email: {
        required,
      },
      alamat: {
        required,
      }
    }
  },
  mounted() {
    this.getDataSettingPerusahaan(this.$route.params.id);
  },
  methods: {
    getValidationClass(fieldName) {
      const field = this.$v.setting_perusahaan[fieldName]

      if (field) {
        return {
          'md-invalid': field.$invalid && field.$dirty
        }
      }
    },
    validateSettingPerusahaan() {
      this.$v.$touch()

      if (!this.$v.$invalid) {
        this.saveForm()
      }
    },
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
      .catch(resp => {
        this.submitted = false;
        alert('Terjadi Kesalahan')
        console.log('catch saveForm:', resp);
      });
    },
    redirectToSettingPerusahaanList() {
      this.$router.replace('/setting-perusahaan');  
    }
  }
}  
</script>
