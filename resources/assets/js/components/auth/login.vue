<template>
  <div class="container">
   <form novalidate class="md-layout" @submit.prevent="saveLogin">
      <md-card class="md-layout-item">
        <md-card-header>
          <div class="md-title">Login</div>
        </md-card-header>

        <md-card-content>
            
						<md-field :class="messageClass">
              <md-icon>email</md-icon>
							<label>Email</label>
							<md-input v-model="login.email" type="email"></md-input>
              <span v-if="errors.email" class="md-error">{{ errors.email[0] }}</span>
						</md-field>
						<md-field :class="messageClass">
              <md-icon>lock</md-icon>
							<label>Password</label>
							<md-input v-model="login.password" type="password"></md-input>
              <span v-if="errors.password" class="md-error">{{ errors.password[0] }}</span>
						</md-field>

            <md-progress-bar md-mode="indeterminate" v-if="loading"></md-progress-bar>
            <center><md-button class="btn" type="submit" :disabled="loading">Login</md-button></center>

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
			login : {
        email : '',
        password : '',
			},
      validation : false,
      loading : false,
		}),
    computed : {
      messageClass () {
        return {
          'md-invalid': this.validation
        }
      }
    },
    methods : {
      saveLogin() {
        const app = this
        app.loading = true
        axios.post(app.url+'login', app.login)
        .then((resp) => {
          console.log(resp)
          app.loading = false
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
        app.register.email = ""
        app.register.password = ""
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
