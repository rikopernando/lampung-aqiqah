<template>
  <div>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" :href="url + 'css/header-style.css'">

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
            <router-link class="md-button md-theme-default md-active" :to="{name: 'listProduk'}">
              <div class="md-ripple">
                <div class="label-nav-main">PRODUK</div>
              </div>
            </router-link>
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
                  <md-menu-item @click="">
                    <router-link :to="{name: 'logout'}" tag="div">LOGOUT</router-link>
                  </md-menu-item>
                  <md-menu-item @click="">
                    <router-link :to="{name: 'indexAkun'}" tag="div">AKUN SAYA</router-link>
                  </md-menu-item>
                </md-menu-content>
            </md-menu>

            <router-link :to="{name: 'keranjangBelanja'}" class="md-button md-theme-default md-active">
              <div class="md-ripple">
                <div class="label-nav-main">KERANJANG</div>
                <md-badge v-bind:md-content="this.$store.state.keranjangbelanja.countKeranjang">
                  <i class="fa fa-shopping-basket icon-shop"></i>
                </md-badge>
              </div>
            </router-link>
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
            <md-button class="md-icon-button" v-if="!this.$store.state.user.loggedIn">
              <a href="#" v-on:click="openModal('login')">
                  <i class="fa fa-user icon-shop-mobile"></i>
              </a>
            </md-button>

            <md-button class="md-icon-button" v-else>
              <md-menu>
                <a href="#" class="md-button md-theme-default md-active" md-menu-trigger>
                  <div class="md-ripple">
                    <i class="fa fa-user icon-shop-mobile"></i>
                  </div>
                </a>
                <md-menu-content>
                  <md-menu-item @click="">
                    <router-link :to="{name: 'logout'}" tag="div">LOGOUT</router-link>
                  </md-menu-item>
                  <md-menu-item @click="">
                    <router-link :to="{name: 'indexAkun'}" tag="div">AKUN SAYA</router-link>
                  </md-menu-item>
                </md-menu-content>
              </md-menu>
            </md-button>
            <md-button class="md-icon-button">
              <a href="#/keranjang-belanja">
                <md-badge v-bind:md-content="this.$store.state.keranjangbelanja.countKeranjang">
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
              <router-link :to="{name: 'home'}" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
                <md-icon>home</md-icon>
                <span>Home</span>
              </router-link>
            </md-list-item>

            <md-list-item>
              <router-link :to="{name: 'listProduk'}" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
                <md-icon>store</md-icon>
                <span>Produk</span>
              </router-link>
            </md-list-item>

            <md-list-item>
              <a href="#/pemesanan" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
                <md-icon>add_shopping_cart</md-icon>
                <span>Pemesanan</span>
              </a>
            </md-list-item>

            <md-list-item>
              <a href="#/pembayaran" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
                <md-icon>local_atm</md-icon>
                <span>Pembayaran</span>
              </a>
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

        this.$store.dispatch('keranjangbelanja/LOAD_KERANJANG_LIST')
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
        keranjangBelanja() {
          const app = this

          axios.post(app.url+'keranjang-belanja/jumlah-pesanan')
          .then((resp) => {
            app.daftarKeranjang = resp.data;
          })
          .catch((err) => {
            app.errors = err.response.data
            console.log(app.errors)
          })
        },
			}
    }
</script>
