<style scoped>
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
          <li><router-link :to="{name: 'user'}">User</router-link></li>
          <li class="active">Edit</li>
        </ul>
      </md-card>

      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white;">account_box</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
              <div class="header-title md-toolbar-section-start">Edit User</div>
              
            </div>
          </md-card-header-text>
        </md-card-header>
        <md-card-content>
          <form novalidate v-on:submit.prevent="validateUser">
            <div v-if="loading" class="_spinner-container">
              <div class="_spinner">
                <md-progress-spinner :md-diameter="80" :md-stroke="5" md-mode="indeterminate"></md-progress-spinner>
              </div>
            </div>
            <md-field :class="getValidationClass('name')">
              <label v-if="!loading" for="name">Nama</label>
              <md-input name="name" id="name" v-model="user.name" />
              <span class="md-error" v-if="!$v.user.name.required">Tolong isi kolom Nama</span>
              <span class="md-error" v-else-if="!$v.user.name.minlength">Nama setidaknya mengandung 3 karakter</span>
            </md-field>
            <md-field :class="getValidationClass('email')">
              <label v-if="!loading" for="email">Email</label>
              <md-input type="email" name="email" id="email" v-model="user.email" />
              <span class="md-error" v-if="!$v.user.email.required">Tolong isi kolom Email</span>
              <span class="md-error" v-else-if="!$v.user.email.email">Format Email salah</span>
            </md-field>
            <md-card-actions>
              <md-progress-spinner v-if="submitted" :md-diameter="30" :md-stroke="3" md-mode="indeterminate"></md-progress-spinner>
              <md-button v-else type="submit" class="md-primary">Edit User</md-button>
            </md-card-actions>
          </form>
        </md-card-content>
      </md-card>

      <!-- Snackbar for user edit alert -->
      <md-snackbar md-position="center" :md-duration="1500" :md-active.sync="snackbarEditUser" @md-closed="redirectToUserList">
        <span>User berhasil diedit!</span>
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
    url: window.location.origin + (window.location.pathname + 'user'),
    user: {
      name: '',
      email: ''
    },
    snackbarEditUser: false,
    submitted: false,
    loading: true,
  }),
  validations: {
    user: {
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
    this.getDataUser(this.$route.params.id);
  },
  methods: {
    getValidationClass (fieldName) {
      const field = this.$v.user[fieldName]

      if (field) {
        return {
          'md-invalid': field.$invalid && field.$dirty
        }
      }
    },
    validateUser() {
      this.$v.$touch()

      if (!this.$v.$invalid) {
        this.saveForm()
      }
    },
    getDataUser(userId) {
      axios.get(this.url + '/' + userId)
      .then(resp => {
        this.user = resp.data;
        this.loading = false;
      })
      .catch(resp => {
        console.log('catch getDataUser:', resp);
      });
    },
    saveForm() {
      this.submitted = true;
      axios.patch(this.url + '/' + this.$route.params.id, this.user)
      .then(resp => {
        this.snackbarEditUser = true;
        this.submitted = false;
      })
      .catch(resp => {
        console.log('catch saveForm:', resp);
      });
    },
    redirectToUserList() {
      this.$router.replace('/user');  
    }
  }
}  
</script>
