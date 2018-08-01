<template>
  <div>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" :href="url + 'css/HeaderStyle.css'">

        <div class="user-modal-container" id="login-modal" v-on:click="closeModal" v-if="modal">
          <div class="user-modal">
            <ul class="form-switcher">
              <li v-on:click="flip('register')"><a href="#" id="register-form">Register</a></li>
              <li v-on:click="flip('login')"><a href="#" id="login-form">Login</a></li>
            </ul>
            <div class="form-register" id="form-register">
                  <ul class="error-message">
                    <li class="text-error" v-for="err in errors"> {{ err.toString() }} </li>
                  </ul>
                <input type="text" name="name" placeholder="Nama" v-model="register.name" autocomplete="off">
                <input type="email" name="email" placeholder="Email" v-model="register.email" autocomplete="off">
                <input type="password" name="password" placeholder="Password" v-model="register.password" autocomplete="off">
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" v-model="register.password_confirmation" autocomplete="off">
                <input type="submit" v-on:click="submit('register')" v-model="registerSubmit" id="registerSubmit">
                <div class="links">
                  <a href="#" v-on:click="flip('login')">Sudah Punya Akun ?</a>
                </div>
            </div>
            <div class="form-login" id="form-login">
                  <ul class="error-message">
                    <li class="text-error" v-for="err in errors"> {{ err.toString() }} </li>
                  </ul>
                <input type="email" name="email" placeholder="Email" v-model="login.email" autocomplete="off">
                <input type="password" name="password" placeholder="Password" v-model="login.password" autocomplete="off">
                <input type="submit" v-on:click="submit('login')" v-model="loginSubmit"  id="loginSubmit">
                <div class="links">
                  <a href="#" v-on:click="flip('password')">Lupa password?</a>
                </div>
            </div>
            <div class="form-password" id="form-password">
                <input type="text" name="email" placeholder="Email" v-model="password.email" autocomplete="off">
                <input type="submit" v-on:click="submit('password')" v-model="passwordSubmit" id="passwordSubmit">
            </div>
          </div>
       </div>

     <div class="md-medium-size-50 md-small-size-50 md-xsmall-hide">
        <md-toolbar md-elevation="0" style="background-color: #da2921; min-height:10px">

        <md-snackbar :md-active.sync="snackbar">{{ alertSnackbar }}</md-snackbar>

        <h3 class="md-title" style="flex: 1"></h3>
        <md-button href="#/pemesanan" style="color: white; font-size: 12px">Pemesanan</md-button>
        <md-button href="#/pembayaran" style="color: white; font-size: 12px">Pembayaran</md-button>
        <md-button href="#/keagenan" style="color: white; font-size: 12px">Keagenan</md-button>
        <md-button href="#/informasi" style="color: white; font-size: 12px">Informasi</md-button>
        <md-button href="#/kritik-saran" style="color: white; font-size: 12px">Ruang Saran dan Pengaduan</md-button>
        <md-button class="md-icon-button">
          <a href="#/facebook">
            <i class="fa fa-facebook-f icon-link"></i>
            <md-tooltip md-direction="bottom">Follow On Facebook </md-tooltip>
          </a>
        </md-button>
        <md-button class="md-icon-button">
          <a href="#/instagram">
            <i class="fa fa-instagram icon-link"></i>
            <md-tooltip md-direction="bottom">Follow On Instagram </md-tooltip>
          </a>
        </md-button>
        <md-button class="md-icon-button">
          <a href="#/whatsapp">
            <i class="fa fa-whatsapp icon-link"></i>
            <md-tooltip md-direction="bottom">Send us Whatsapp </md-tooltip>
          </a>
        </md-button>
      </md-toolbar>

      <md-toolbar class="md-dense" md-elevation="2" style="background-color: white">
        <div class="md-toolbar-row">
            <a href="#/" class="icon-aqiqah md-button md-theme-default md-active">
                <img src="https://rumahaqiqah.org/wp-content/uploads/2018/01/rumahaqiqah3.png" alt="Aqiqah Lampung">
            </a>

          <div class="md-toolbar-section-start">
            <div style="padding-left: 50px">
              <i class="fa fa-search icon-box"></i>
              <input type="text" placeholder="Search..." class="input-box">
            </div>
            <a href="#/" class="md-button md-theme-default md-active">
              <div class="md-ripple">
                <div class="label-nav-main">HOME</div>
              </div>
            </a>
            <a href="#/list-produk" class="md-button md-theme-default md-active">
              <div class="md-ripple">
                <div class="label-nav-main">PRODUK</div>
              </div>
            </a>
          </div>

          <div class="md-toolbar-section-end">

            <md-button v-on:click="openModal('login')" v-if="!this.$store.state.user.loggedIn">
              <div class="md-ripple">
                <div class="label-nav-main">LOGIN</div>
              </div>
            </md-button>

            <md-menu v-else>
                <a href="#" class="md-button md-theme-default md-active" md-menu-trigger>
                  <div class="md-ripple">
                    <div class="label-nav-main">{{this.$store.state.user.profile.name}}</div>
                  </div>
                </a>
                <md-menu-content>
                  <md-menu-item @click="logout()">LOGOUT</md-menu-item>
                  <md-menu-item @click="myProfile">AKUN SAYA</md-menu-item>
                </md-menu-content>
            </md-menu>

            <form id="logout-form" v-bind:action="url+'logout'" method="POST" style="display: none;">
              <input type="hidden" name="_token" v-bind:value="token">
            </form>

            <a href="#/keranjang-belanja" class="md-button md-theme-default md-active">
              <div class="md-ripple">
                <div class="label-nav-main">CART</div>
                <md-badge v-bind:md-content="daftarKeranjang">
                  <i class="fa fa-shopping-basket icon-shop"></i>
                </md-badge>
              </div>
            </a>

          </div>

        </div>
      </md-toolbar>
    </div>


    <div id="displaySidenav">
        <md-toolbar md-elevation="0" style="background-color: #da2921; min-height:30px">
        </md-toolbar>

        <md-toolbar class="md-default" style="background-color: white;">
          <div class="md-toolbar-section-start">
            <md-button class="md-icon-button" @click="showNavigation = true">
              <i class="fa fa-bars icon-shop-mobile"></i>
            </md-button>
          </div>

          <a href="#/" class="md-toolbar-section-end">
              <img src="https://rumahaqiqah.org/wp-content/uploads/2018/01/rumahaqiqah3.png" alt="Aqiqah Lampung">
          </a>

          <div class="md-toolbar-section-end">
            <md-button class="md-icon-button">
              <a href="#" v-on:click="openModal('login')">
                  <i class="fa fa-user icon-shop-mobile"></i>
              </a>
            </md-button>
            <md-button class="md-icon-button">
              <a href="#/cart">
                <md-badge md-content="0">
                  <i class="fa fa-shopping-basket icon-shop-mobile"></i>
                </md-badge>
              </a>
            </md-button>
          </div>
        </md-toolbar>

        <md-drawer :md-active.sync="showNavigation">
          <md-toolbar class="md-transparent" md-elevation="0">
            <span class="md-title">
              <a href="#/" class="md-toolbar-section-end">
                  <img src="https://rumahaqiqah.org/wp-content/uploads/2018/01/rumahaqiqah3.png" alt="Aqiqah Lampung">
              </a>
            </span>
          </md-toolbar>

          <md-list style="padding: 0px">
            <md-list-item>
              <md-icon>home</md-icon>
              <span class="md-list-item-text">
                <a href="#/" class="md-button md-theme-default md-active side-menu">HOME</a>
              </span>
            </md-list-item>

            <md-list-item>
              <md-icon>store</md-icon>
              <span class="md-list-item-text">
                <a href="#/list-produk" class="md-button md-theme-default md-active side-menu">PRODUK</a>
              </span>
            </md-list-item>

            <md-list-item>
              <md-icon>add_shopping_cart</md-icon>
              <span class="md-list-item-text">
                <a href="#/pemesanan" class="md-button md-theme-default md-active side-menu">PEMESANAN</a>
              </span>
            </md-list-item>

            <md-list-item>
              <md-icon>local_atm</md-icon>
              <span class="md-list-item-text">
                <a href="#/pembayaran" class="md-button md-theme-default md-active side-menu">PEMBAYARAN</a>
              </span>
            </md-list-item>

          </md-list>

          <div class="social-media">
            <md-button class="md-icon-button">
              <a href="#/facebook">
                <i class="fa fa-facebook-f" style="color: #868686;"></i>
                <md-tooltip md-direction="bottom">Follow On Facebook </md-tooltip>
              </a>
            </md-button>
            <md-button class="md-icon-button">
              <a href="#/instagram">
                <i class="fa fa-instagram" style="color: #868686;"></i>
                <md-tooltip md-direction="bottom">Follow On Instagram </md-tooltip>
              </a>
            </md-button>
            <md-button class="md-icon-button">
              <a href="#/whatsapp">
                <i class="fa fa-whatsapp" style="color: #868686;"></i>
                <md-tooltip md-direction="bottom">Send us Whatsapp </md-tooltip>
              </a>
            </md-button>
          </div>
        </md-drawer>

      </div>
  </div>
</template>

<script>

    export default {
			data : () => ({
        modal : false,
        showNavigation: false,
        showSidepanel: false,
        errors : [],
        url : window.location.origin + window.location.pathname,
        token : $('meta[name="csrf-token"]').attr('content'),
        snackbar: false,
				active : null,
				registerSubmit: 'Register',
				passwordSubmit: 'Reset Password',
				loginSubmit: 'Login',
        alertSnackbar : '',
        daftarKeranjang:0,
        register : {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        },
        login : {
            email: '',
            password: '',
        },
        password : {
            email: '',
        }
			}),
      mounted () {
        this.modal = true
        console.log(this.url)
      },
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
                this.prosesLogin()
                break;
            case 'password':
                this.passwordSubmit = 'Resetting Password ...'
          }
        },
				prosesRegister() {
          const app = this
          axios.post(app.url+'register', app.register)
          .then((resp) => {
              console.log(resp.data)
              app.alertSnackbar = 'Registrasi Berhasil!!'
              app.snackbar = true
              app.$store.commit('user/LOGIN',resp.data)
              app.$store.state.user.is_admin ? app.$router.push('/dashboard') : app.$router.push('/')
              $('#login-modal').removeClass('active')
          })
          .catch((err) => {
              app.errors = err.response.data
              console.log(app.errors)
              $('#registerSubmit').removeClass('disabled')
              app.registerSubmit = "Register"
          })
				},
        prosesLogin() {
          const app = this
          axios.post(app.url+'login', app.login)
          .then((resp) => {
            console.log(resp.data)
            app.alertSnackbar = 'Login Berhasil!!'
            app.snackbar = true
            app.$store.commit('user/LOGIN',resp.data)
            app.$store.state.user.is_admin ? app.$router.push('/dashboard') : app.$router.push('/')
            $('#login-modal').removeClass('active')
          })
          .catch((err) => {
            app.errors = err.response.data
            console.log(app.errors)
            $('#loginSubmit').removeClass('disabled')
            app.loginSubmit = "Login"
          })
        },
        myProfile() {
          this.$router.replace('/akun');
        },
        logout() {
          document.getElementById('logout-form').submit();
          this.$store.commit('user/LOGOUT')
        }
			}
    }
</script>

<style lang="scss" scoped>

    .link-item {
      display: inline-block;
    }

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
			background-color: #ff5252;
			cursor: pointer;
		}

		.user-modal-container input[type="submit"]:hover {
			background-color: #d21d24;
		}

		.user-modal-container input[type="submit"]:active {
			background-color:  #e60000;
		}

		.user-modal-container .links {
			text-align: center;
			padding-top: 25px;
		}

		.user-modal-container .links a {
			color: #8c7373;
		}

		.user-modal-container input[type="submit"].disabled {
				background-color:  #ff4d4d;
		}

    .error-message {
        background-color:  #ff4d4d;
        border-radius: 6px;
    }

    .text-error {
      font-weight: bold;
      color: white;
      padding : 4px;
    }
</style>
