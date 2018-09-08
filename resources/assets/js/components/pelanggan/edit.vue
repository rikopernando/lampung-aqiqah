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
          <li><router-link :to="{name: 'pelanggan'}">Pelanggan</router-link></li>
          <li class="active">Edit</li>
        </ul>
      </md-card>

      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white;">contacts</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
              <div class="header-title md-toolbar-section-start">Edit Pelanggan</div>
              
            </div>
          </md-card-header-text>
        </md-card-header>
        <md-card-content>
          <form novalidate v-on:submit.prevent="validatePelanggan">

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
              <md-input name="name" id="name" v-model="pelanggan.name" />
              <span class="md-error" v-if="!$v.pelanggan.name.required">Tolong isi kolom Nama</span>
              <span class="md-error" v-else-if="!$v.pelanggan.name.minlength">Nama setidaknya mengandung 3 karakter</span>
            </md-field>

            <md-field :class="getValidationClass('email')">
              <label v-if="!loading" for="email">Email</label>
              <md-input type="email" name="email" id="email" v-model="pelanggan.email" />
              <span class="md-error" v-if="!$v.pelanggan.email.required">Tolong isi kolom Email</span>
              <span class="md-error" v-else-if="!$v.pelanggan.email.email">Format Email salah</span>
            </md-field>

            <md-progress-bar v-if="submitted" md-mode="indeterminate"></md-progress-bar>
            </md-progress-spinner>
            <md-button v-else type="submit" class="md-dense md-raised" style="background-color: #d44723; color: white"> Submit </md-button>

          </form>
        </md-card-content>
      </md-card>

      <!-- Snackbar for pelanggan edit alert -->
      <md-snackbar md-position="center" :md-duration="1500" :md-active.sync="snackbarEditPelanggan" @md-closed="redirectToPelangganList">
        <span>Pelanggan berhasil diedit!</span>
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
    url: window.location.origin + (window.location.pathname + 'pelanggan'),
    pelanggan: {
      name: '',
      email: ''
    },
    snackbarEditPelanggan: false,
    submitted: false,
    loading: true,
  }),
  validations: {
    pelanggan: {
      name: {
        required,
        minLength: minLength(3)
      },
      email: {
        required,
        email
      }
    }
  },
  mounted() {
    this.getDataPelanggan(this.$route.params.id);
  },
  methods: {
    getValidationClass(fieldName) {
      const field = this.$v.pelanggan[fieldName]

      if (field) {
        return {
          'md-invalid': field.$invalid && field.$dirty
        }
      }
    },
    validatePelanggan() {
      this.$v.$touch()

      if (!this.$v.$invalid) {
        this.saveForm()
      }
    },
    getDataPelanggan(pelangganId) {
      axios.get(this.url + '/' + pelangganId)
      .then(resp => {
        this.pelanggan = resp.data;
        this.loading = false;
      })
      .catch(resp => {
        console.log('catch getDataPelanggan:', resp);
      });
    },
    saveForm() {
      this.submitted = true;
      axios.patch(this.url + '/' + this.$route.params.id, this.pelanggan)
      .then(resp => {
        this.snackbarEditPelanggan = true;
        this.submitted = false;
      })
      .catch(resp => {
        console.log('catch saveForm:', resp);
      });
    },
    redirectToPelangganList() {
      this.$router.replace('/pelanggan');  
    }
  }
}  
</script>
