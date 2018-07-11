<template>
  <div class="container">
   <form novalidate class="md-layout" @submit.prevent="saveRegister">
      <md-card class="md-layout-item">
        <md-card-header>
          <div class="md-title">Users</div>
        </md-card-header>

        <md-card-content>
						<md-field :class="messageClass">
              <md-icon>perm_identity</md-icon>
							<label>Nama</label>
							<md-input v-model="register.name" type="text"></md-input>
              <span v-if="errors.name" class="md-error">{{ errors.name[0] }}</span>
						</md-field>
						<md-field>
              <md-icon>email</md-icon>
							<label>Email</label>
							<md-input v-model="register.email" type="email"></md-input>
						</md-field>
						<md-field>
              <md-icon>lock</md-icon>
							<label>Password</label>
							<md-input v-model="register.password" type="password"></md-input>
						</md-field>
						<md-field>
              <md-icon>lock</md-icon>
							<label>Konfirmasi Password</label>
							<md-input v-model="register.password_confirmation" type="password"></md-input>
						</md-field>
            
            <center><md-button class="btn" type="submit">Registrasi</md-button></center>
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
      hasMessages : false
		}),
    computed : {
      messageClass () {
        return {
          'md-invalid': this.hasMessages
        }
      }
    },
    mounted() {
      console.log('yey')
    },
    methods : {
      saveRegister() {
        const app = this
        axios.post(app.url+'/register', app.register)
        .then((resp) => {
          console.log(resp)
        })
        .catch((err) => {
          app.errors = err.response.data
          console.log(app.errors)
					app.hasMessages = true
        })
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
