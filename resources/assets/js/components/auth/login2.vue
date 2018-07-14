<template>
    <div class="container">
       <md-button class="md-raised md-accent" v-on:click="openModal('login')">Login</md-button>
       <md-button class="md-raised md-accent" v-on:click="openModal('register')">Register</md-button>

       <md-snackbar :md-active.sync="snackbar">Registrasi Berhasil!</md-snackbar>
       <div class="user-modal-container" id="login-modal" v-on:click="closeModal">
          <div class="user-modal">
						<ul class="form-switcher">  
              <li v-on:click="flip('register')"><a href="#" id="register-form">Register</a></li>
							<li v-on:click="flip('login')"><a href="#" id="login-form">Login</a></li>
						</ul>            
						<div class="form-register" id="form-register">
            	<div class="error-message" v-text="registerError"></div>  
								<input type="text" name="name" placeholder="Nama" v-model="register.name">  
								<input type="email" name="email" placeholder="Email" v-model="register.email">  
								<input type="password" name="password" placeholder="Password" v-model="register.password"> 
								<input type="password" name="password_confirmation" placeholder="Konfirmasi Password" v-model="register.password_confirmation"> 
								<input type="submit" v-on:click="submit('register')" v-model="registerSubmit" id="registerSubmit">  
								<div class="links">  
									<a href="" v-on:click="flip('login')">Sudah Punya Akun ?</a>
								</div>  
            </div>
						<div class="form-login" id="form-login">
								<div class="error-message" v-text="loginError"></div>  
                <input type="email" name="email" placeholder="Email" v-model="login.email"> 
								<input type="password" name="password" placeholder="Password" v-model="login.password">  
								<input type="submit" v-on:click="submit('login')" v-model="loginSubmit"  id="loginSubmit">  
								<div class="links">  
									<a href="" v-on:click="flip('password')">Lupa password?</a>
								</div>  
						</div>
						<div class="form-password" id="form-password">
								<div class="error-message" v-text="passwordError"></div>  
								<input type="text" name="email" placeholder="Email" v-model="password.email">  
								<input type="submit" v-on:click="submit('password')" v-model="passwordSubmit" id="passwordSubmit">  

						</div>
          </div>  
       </div>
    </div>
</template>

<script>
    export default {
      name : 'Login',
			data : () => ({
        url : window.location.origin + window.location.pathname,
        snackbar: false,
				active : null,
				registerSubmit: 'Register',
				passwordSubmit: 'Reset Password',
				loginSubmit: 'Login',
        register : {
            name:     '',
            email:    '',
            password: '',
            password_confirmation: '',
        },
        login : {
            email:    '',
            password:    '',
        },
				registerError: '',
				passwordError: '',
				loginError:    '',
        password : {
            email: '',
        }
			}),
			methods : {
				openModal(which) {
          console.log(which)
					if (this.active !== null) {
							$('#form-'+this.active).removeClass('active')
							$('#'+this.active+'-form').removeClass('active')
					}
          
          $("#login-modal").addClass('active')
					$('#form-'+which).addClass('active')
					$('#'+which+'-form').addClass('active')
					this.active = which

        },
        closeModal(e) {
            console.log(e.path[1])
            console.log(this.$el)
            if (e.path[1] === this.$el) {
                $('#login-modal').removeClass('active')
            }
        },
				flip(which) {
					if (which !== this.active) {
						$('#form-' + this.active).removeClass('active')
						$('#form-' + which).addClass('active')
						$('#'+which+'-form').addClass('active')
						$('#'+this.active+'-form').removeClass('active')

						this.active = which
					}
				},
        submit(which) {
          $('#'+which+'Submit').addClass('disabled')

          switch(which) {
            case 'register':
                this.registerSubmit = 'Registering ...'
								this.prosesRegister()
                break;
            case 'login':
                this.loginSubmit = 'Logging In ...'
                break;
            case 'password':
                this.passwordSubmit = 'Resetting Password ...'
          }
        },
				prosesRegister() {
          const app = this
          axios.post(app.url+'register', app.register)
          .then((resp) => {
              console.log(resp)
              app.snackbar = true
              app.clearForm()
          })
          .catch((err) => {
              app.errors = err.response.data
              console.log(app.errors)
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
    .user-modal-container * {
      box-sizing: border-box;
    }

		.user-modal-container {
			position: fixed;
			width: 100%;
			height: 100%;
			top: 0;
			left: 0;
			opacity: 0;
			visibility: hidden;
			cursor: pointer;
			overflow-y: auto;
			z-index: 3;
			font-family: 'Lato', 'Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif';
			font-size: 14px;
			background-color: rgba(17,17,17,.9);
			-webkit-transition: all 0.25s linear;
			-moz-transition: all 0.25s linear;
			-o-transition: all 0.25s linear;
			-ms-transition: all 0.25s linear;
			transition: all 0.25s linear;
    }

		.user-modal-container.active {
			opacity: 1;
			visibility: visible;
    }

		.user-modal-container .user-modal {
			position: relative;
			margin: 50px auto;
			width: 90%;
			max-width: 500px;
			background-color: #f6f6f6;
			cursor: initial;
		}

		.user-modal-container .form-login, .user-modal-container .form-register, .user-modal-container .form-password {
				padding: 75px 25px 25px;
				display: none;
		}
		.user-modal-container .form-login.active, .user-modal-container .form-register.active, .user-modal-container .form-password.active {
				display: block;
		}

		.user-modal-container ul.form-switcher {
			margin: 0;
			padding: 0;
		}

		.user-modal-container ul.form-switcher li {
			list-style: none;
			display: inline-block;
			width: 50%;
			float: left;
			margin: 0;
		}

		.user-modal-container ul.form-switcher li a {
			width: 100%;
			display: block;
			height: 50px;
			line-height: 50px;
			color: #666666;
			background-color: #dddddd;
			text-align: center;
		}

		.user-modal-container ul.form-switcher li a.active {
			color: #000000;
			background-color: #f6f6f6;
		}

		.user-modal-container input {
			width: 100%;
			padding: 10px;
			margin-bottom: 10px;
			border: 1px solid #eeeeee;
		}

		.user-modal-container input[type="submit"] {
			color: #f6f6f6;
			border: 0;
			margin-bottom: 0;
			background-color: #3fb67b;
			cursor: pointer;
		}

		.user-modal-container input[type="submit"]:hover {
			background-color: #3aa771;
		}

		.user-modal-container input[type="submit"]:active {
			background-color: #379d6b;
		}

		.user-modal-container .links {
			text-align: center;
			padding-top: 25px;
		}

		.user-modal-container .links a {
			color: #3fb67b;
		}

		.user-modal-container input[type="submit"].disabled {
				background-color: #98d6b7;
		}
</style>
