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
          <form novalidate v-on:submit.prevent="validatePelanggan">

            <md-field :class="getValidationClass('name')">
              <label for="name">Nama</label>
              <md-input name="name" id="name" v-model="pelanggan.name" />
              <span class="md-error" v-if="!$v.pelanggan.name.required">Tolong isi kolom Nama</span>
              <span class="md-error" v-else-if="!$v.pelanggan.name.minlength">Nama setidaknya mengandung 3 karakter</span>
            </md-field>

            <md-field :class="getValidationClass('email')">
              <label for="email">Email</label>
              <md-input type="email" name="email" id="email" v-model="pelanggan.email" />
              <span class="md-error" v-if="!$v.pelanggan.email.required">Tolong isi kolom Email</span>
              <span class="md-error" v-else-if="!$v.pelanggan.email.email">Format Email salah</span>
            </md-field>

            <md-field :class="getValidationClass('password')">
              <label for="password">Password</label>
              <md-input type="password" name="password" id="password" v-model="pelanggan.password" />
              <span class="md-error" v-if="!$v.pelanggan.password.required">Tolong isi kolom Password</span>
              <span class="md-error" v-else-if="!$v.pelanggan.password.minlength">Password setidaknya mengandung 6 karakter</span>
            </md-field>

            <md-field :class="getValidationClass('repeatPassword')">
              <label for="repeatPassword">Ulangi Password</label>
              <md-input type="password" name="repeatPassword" id="repeatPassword" v-model="pelanggan.repeatPassword" />
              <span class="md-error" v-if="!$v.pelanggan.repeatPassword.sameAsPassword">Password tidak sama</span>
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

import { validationMixin } from 'vuelidate'
import {
  required,
  email,
  minLength,
  maxLength,
  sameAs
} from 'vuelidate/lib/validators'

export default {
  mixins: [validationMixin],
  data: () => ({
    url: window.location.origin + (window.location.pathname + 'pelanggan'),
    pelanggan: {
      name: '',
      email: '',
      password: '',
      repeatPassword: ''
    },
    snackbarCreatePelanggan: false,
    submitted: false,
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
      },
      password: {
        required,
        minLength: minLength(6)
      },
      repeatPassword: {
        sameAsPassword: sameAs('password')
      }
    }
  },
  methods: {
    getValidationClass (fieldName) {
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
    saveForm() {
      this.submitted = true;

      axios.post(this.url, this.pelanggan)
      .then(resp => {
        this.snackbarCreatePelanggan = true;
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
