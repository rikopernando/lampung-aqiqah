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
          <li><router-link :to="{name: 'dashboard'}">Dashboard</router-link></li>
          <li><router-link :to="{name: 'mitra'}">Mitra</router-link></li>
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
              <div class="header-title md-toolbar-section-start">Edit Mitra</div>
              
            </div>
          </md-card-header-text>
        </md-card-header>
        <md-card-content>
          <form novalidate v-on:submit.prevent="validateMitra">

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

            <md-field :class="getValidationClass('nama_mitra')">
              <label v-if="!loading" for="name">Mitra</label>
              <md-input name="nama_mitra" id="nama_mitra" v-model="mitra.nama_mitra" />
              <span class="md-error" v-if="!$v.mitra.nama_mitra.required">Mitra tidak boleh kosong</span>
            </md-field>

            <md-field :class="getValidationClass('no_telp')">
              <label v-if="!loading" for="name">No. Telepon</label>
              <md-input name="no_telp" id="no_telp" v-model="mitra.no_telp" />
              <span class="md-error" v-if="!$v.mitra.no_telp.required">No. Telepon tidak boleh kosong</span>
            </md-field>

            <md-field :class="getValidationClass('alamat')">
              <label v-if="!loading" for="name">Alamat</label>
              <md-input name="alamat" id="alamat" v-model="mitra.alamat" />
              <span class="md-error" v-if="!$v.mitra.alamat.required">Alamat tidak boleh kosong</span>
            </md-field>

            <md-card-actions>
              <md-progress-spinner 
                v-if="submitted" 
                :md-diameter="30" 
                :md-stroke="3" 
                md-mode="indeterminate">
              </md-progress-spinner>
              <md-button v-else type="submit" class="md-primary">Edit Mitra</md-button>
            </md-card-actions>

          </form>
        </md-card-content>
      </md-card>

      <!-- Snackbar for mitra edit alert -->
      <md-snackbar md-position="center" :md-duration="1500" :md-active.sync="snackbarEditMitra" @md-closed="redirectToMitraList">
        <span>Mitra berhasil diedit!</span>
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
    url: window.location.origin + (window.location.pathname + 'mitra'),
    mitra: {
      nama_mitra: '',
      no_telp: '',
      alamat: ''
    },
    snackbarEditMitra: false,
    submitted: false,
    loading: true,
  }),
  validations: {
    mitra: {
      nama_mitra: {
        required,
      },
      no_telp: {
        required,
      },
      alamat: {
        required,
      }
    }
  },
  mounted() {
    this.getDataMitra(this.$route.params.id);
  },
  methods: {
    getValidationClass(fieldName) {
      const field = this.$v.mitra[fieldName]

      if (field) {
        return {
          'md-invalid': field.$invalid && field.$dirty
        }
      }
    },
    validateMitra() {
      this.$v.$touch()

      if (!this.$v.$invalid) {
        this.saveForm()
      }
    },
    getDataMitra(mitraId) {
      axios.get(this.url + '/' + mitraId)
      .then(resp => {
        this.mitra = resp.data;
        this.loading = false;
      })
      .catch(resp => {
        console.log('catch getDataMitra:', resp);
      });
    },
    saveForm() {
      this.submitted = true;
      axios.patch(this.url + '/' + this.$route.params.id, this.mitra)
      .then(resp => {
        this.snackbarEditMitra = true;
        this.submitted = false;
      })
      .catch(resp => {
        this.submitted = false;
        alert('Terjadi Kesalahan')
        console.log('catch saveForm:', resp);
      });
    },
    redirectToMitraList() {
      this.$router.replace('/mitra');  
    }
  }
}  
</script>
