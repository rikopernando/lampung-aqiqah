<template>
  <div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" :href="url + 'css/header-style.css'">

    <div class="user-modal-container" id="login-modal" v-on:click="closeModal" v-if="modal">
      <div class="user-modal">
        <ul class="form-switcher">
          <li v-on:click="flip('register')"><a href="#" id="register-form">Register</a></li>
          <li v-on:click="flip('login')"><a hr ef="#" id="login-form">Login</a></li>
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
					<div class="alert alert-success" role="alert" v-if="successSendEmail">
            Kami telah mengirimkan tautan Reset Password Anda melalui email!
					</div>
          <ul class="error-message">
            <li class="text-error" v-for="err in errors"> {{ err.toString() }} </li>
          </ul>
          <input type="text" name="email" placeholder="Email" v-model="password.email" autocomplete="off">
          <input type="hidden" name="token" v-model="password.token" autocomplete="off">
          <input type="submit" v-on:click="submit('password')" v-model="passwordSubmit" id="passwordSubmit">
        </div>
      </div>
    </div>

    <div class="md-medium-size-50 md-small-size-50 md-xsmall-hide">
      <md-toolbar md-elevation="0" style="background-color: #da2921; min-height:10px">
        <md-snackbar :md-active.sync="snackbar">{{ alertSnackbar }}</md-snackbar>

        <h3 class="md-title" style="flex: 1"></h3>
        <md-button  :to="{name: 'tentangKami'}" style="color: white; font-size: 12px">Tentang Kami</md-button>
        <md-button  :to="{name: 'beritaKamiList'}" style="color: white; font-size: 12px">Berita Kami</md-button>
        <md-button :to="{name: 'kemitraan'}"  style="color: white; font-size: 12px">Kemitraan</md-button>
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
						<md-progress-spinner :md-diameter="30" :md-stroke="3" md-mode="indeterminate" v-if="this.$store.state.setting_perusahaan.loading"></md-progress-spinner>
            <img :src="url+'images_logo/'+this.$store.state.setting_perusahaan.data.logo" alt="Aqiqah Lampung" v-else>
          </a>

          <div class="md-toolbar-section-start">
            <a href="#/" class="md-button md-theme-default md-active">
              <div class="md-ripple">
                <div class="label-nav-main">HOME</div>
              </div>
            </a>
            <router-link class="md-button md-theme-default md-active" :to="{name: 'dashboard'}" v-if="this.$store.state.user.is_admin">
              <div class="md-ripple">
                <div class="label-nav-main">Dashboard</div>
              </div>
            </router-link>
            <router-link class="md-button md-theme-default md-active" :to="{name: 'listProduk'}">
              <div class="md-ripple">
                <div class="label-nav-main">PRODUK</div>
              </div>
            </router-link>

            <router-link class="md-button md-theme-default md-active" :to="{name: 'indexAkun'}">
              <div class="md-ripple">
                <div class="label-nav-main">PEMESANAN</div>
              </div>
            </router-link>

            <router-link class="md-button md-theme-default md-active" :to="{name: 'checkout'}">
              <div class="md-ripple">
                <div class="label-nav-main">PEMBAYARAN</div>
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
					<md-progress-spinner :md-diameter="30" :md-stroke="3" md-mode="indeterminate" v-if="this.$store.state.setting_perusahaan.loading"></md-progress-spinner>
          <img :src="url+'images_logo/'+this.$store.state.setting_perusahaan.data.logo" alt="Aqiqah Lampung" v-else>
        </a>

        <div class="md-toolbar-section-end">
          <md-button class="md-icon-button">
            <a href="#" v-on:click="openModal('login')" v-if="!this.$store.state.user.loggedIn">
              <i class="fa fa-user icon-shop-mobile"></i>
            </a>
            <md-menu v-else>
              <a href="#" class="md-button md-theme-default md-active" md-menu-trigger>
                <div class="md-ripple"> <i class="fa fa-user icon-shop-mobile"></i> </div>
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
							<md-progress-spinner :md-diameter="30" :md-stroke="3" md-mode="indeterminate" v-if="this.$store.state.setting_perusahaan.loading"></md-progress-spinner>
              <img :src="url+'images_logo/'+this.$store.state.setting_perusahaan.data.logo" alt="Aqiqah Lampung" v-else>
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

          <md-list-item v-if="this.$store.state.user.is_admin">
            <router-link :to="{name: 'dashboard'}" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
              <md-icon>dashboard</md-icon>
              <span>Dashboard</span>
            </router-link>
          </md-list-item>

          <md-list-item>
            <router-link :to="{name: 'listProduk'}" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
              <md-icon>store</md-icon>
              <span>Produk</span>
            </router-link>
          </md-list-item>

          <md-list-item>
            <a href="#/akun" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
              <md-icon>add_shopping_cart</md-icon>
              <span>Pemesanan</span>
            </a>
          </md-list-item>

          <md-list-item>
            <a href="#/checkout" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
              <md-icon>local_atm</md-icon>
              <span>Pembayaran</span>
            </a>
          </md-list-item>

          <md-list-item>
            <a href="#/kemitraan" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
              <md-icon>group</md-icon>
              <span>Kemitraan</span>
            </a>
          </md-list-item>

          <md-list-item>
            <a href="#/tentang-kami" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
              <md-icon>group</md-icon>
              <span>Tentang Kami</span>
            </a>
          </md-list-item>

          <md-list-item>
            <a href="#/berita-kami-list" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
              <md-icon>timeline</md-icon>
              <span>Berita Kami</span>
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
        token : $('meta[name="csrf-token"]').attr('content'),
      },
      successSendEmail : false
		}),
    mounted () {
      this.modal = true;
      this.$store.dispatch('setting_perusahaan/LOAD_SETTING_PERUSAHAAN');
    },
		methods : {
			openModal(which) {
				if (this.active !== null) {
					$('#form-' + this.active).removeClass('active');
					$('#' + this.active + '-form').removeClass('active');
				}

        $("#login-modal").addClass('active');
				$('#form-' + which).addClass('active');
				$('#' + which + '-form').addClass('active');

				this.active = which;
      },
      closeModal(e) {
        if (e.path[1] === this.$el) {
          $('#login-modal').removeClass('active');
        }
      },
			flip(which) {
				if (which !== this.active) {
					$('#form-' + this.active).removeClass('active');
					$('#form-' + which).addClass('active');
					$('#' + which + '-form').addClass('active');
					$('#' + this.active + '-form').removeClass('active');

					this.active = which;
				}
			},
      submit(which) {
        $('#' + which + 'Submit').addClass('disabled');

        switch(which) {
          case 'register':
            this.registerSubmit = 'Registering ...';
						this.prosesRegister();
          break;
          case 'login':
            this.loginSubmit = 'Logging In ...';
            this.prosesLogin();
          break;
          case 'password':
            this.passwordSubmit = 'Resetting Password ...';
            this.prosesKirimLinkLupaPassword();
          break;
        }
      },
			prosesRegister() {
        axios.post(this.url + 'register', this.register)
        .then((resp) => {
          console.log(resp.data)
          this.alertSnackbar = 'Registrasi Berhasil!!';
          this.snackbar = true;
          this.$store.commit('user/LOGIN',resp.data);
          this.$store.state.user.is_admin ? this.$router.push('/dashboard') : this.$router.push('/');
          $('#login-modal').removeClass('active');
        })
        .catch((err) => {
          this.errors = err.response.data;
          console.log('catch prosesRegister:', this.errors);
          $('#registerSubmit').removeClass('disabled');
          this.registerSubmit = "Register";
        })
			},
      prosesLogin() {
        axios.post(this.url + 'login', this.login)
        .then((resp) => {
          this.alertSnackbar = 'Login Berhasil!!';
          this.snackbar = true;
          this.$store.commit('user/LOGIN',resp.data);
          this.$store.state.user.is_admin ? this.$router.push('/dashboard') : this.$router.push('/');
          $('#login-modal').removeClass('active');
        })
        .catch((err) => {
          this.errors = err.response.data;
          console.log('catch prosesLogin:', this.errors);
          $('#loginSubmit').removeClass('disabled');
          this.loginSubmit = "Login";
        })
      },
      prosesKirimLinkLupaPassword(){
        axios.post(this.url + 'password/email', this.password)
        .then((resp) => {
          this.successSendEmail = true;
          this.passwordSubmit = "Reset Password";
          $('#passwordSubmit').removeClass('disabled');
          this.password.email = "";
        })
        .catch((err) => {
          this.errors = err.response.data;
          console.log('catch prosesKirimLinkLupaPassword:', this.errors);
          $('#passwordSubmit').removeClass('disabled');
          this.passwordSubmit = "Reset Password";
        })
      },
      keranjangBelanja() {
        axios.post(this.url + 'keranjang-belanja/jumlah-pesanan')
        .then((resp) => {
          this.daftarKeranjang = resp.data;
        })
        .catch((err) => {
          this.errors = err.response.data;
          console.log('catch keranjangbelanja:', this.errors);
        })
      }
		}
  }

</script>

<style scoped>
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
    padding: 4px;
  }
  .blackLink {
    color: #868686;
    text-decoration: none;
  }
</style>
