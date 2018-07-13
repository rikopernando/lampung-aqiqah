<template>
  <div class="container">
   <form novalidate class="md-layout" @submit.prevent="saveRegister",
      <md-card class="md-layout-item">
        <md-card-header>
          <div class="md-title">Register</div>
        </md-card-header>

        <md-card-content>
            
						<md-field :class="messageClass">
              <md-icon>perm_identity</md-icon>
							<label>Nama</label>
							<md-input v-model="register.name" type="text"></md-input>
              <span v-if="errors.name" class="md-error">{{ errors.name[0] }}</span>
						</md-field>
						<md-field :class="messageClass">
              <md-icon>email</md-icon>
							<label>Email</label>
							<md-input v-model="register.email" type="email"></md-input>
              <span v-if="errors.email" class="md-error">{{ errors.email[0] }}</span>
						</md-field>
						<md-field :class="messageClass">
              <md-icon>lock</md-icon>
							<label>Password</label>
							<md-input v-model="register.password" type="password"></md-input>
              <span v-if="errors.password" class="md-error">{{ errors.password[0] }}</span>
						</md-field>
						<md-field :class="messageClass">
              <md-icon>lock</md-icon>
							<label>Konfirmasi Password</label>
							<md-input v-model="register.password_confirmation" type="password"></md-input>
						</md-field>

            <md-progress-bar md-mode="indeterminate" v-if="loading"></md-progress-bar>
            <md-snackbar :md-active.sync="snackbar">Registrasi Berhasil!</md-snackbar>
            <center><md-button class="btn" type="submit" :disabled="loading">Registrasi</md-button></center>

				</md-card-content>
      </md-card>
   </form>
  </div>
</template>

<script>
  export default {
		data: () => ({
      errors : {},
      url : window.location.origin + window.location.pathname,
			register : {
				name : '',
        email : '',
        password : '',
        password_confirmation : ''
			},
      validation : false,
      loading : false,
      snackbar : false
		}),
    computed : {
      messageClass () {
        return {
          'md-invalid': this.validation
        }
      }
    },
    methods : {
      saveRegister() {
        const app = this
        app.loading = true
        axios.post(app.url+'register', app.register)
        .then((resp) => {
          console.log(resp)
          app.loading = false
          app.snackbar = true
          app.clearForm()
        })
        .catch((err) => {
          app.errors = err.response.data
          console.log(app.errors)
					app.validation = true
					app.loading = false
        })
      },
      clearForm() {
        const app = this
        app.register.name = ""
        app.register.email = ""
        app.register.password = ""
        app.register.password_confirmation = ""
      }
    }
  }
</script>

<style lang="scss" scoped>
  .btn {
    color : #212121;
    background-color : #3fffbe;
    width : 400px;
    height : 45px;
  }
</style>
