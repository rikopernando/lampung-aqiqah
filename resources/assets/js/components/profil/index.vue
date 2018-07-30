<template>
  <div>
    <Header></Header>
      <div class="container">
          <md-card md-with-hover>
            <ul class="breadcrumb">
              <li><a href="#/">Home</a></li>
              <li class="active">Akun</li>
            </ul>
          </md-card>

          <md-card md-with-hover>
						<md-card-header>
                <div class="md-toolbar-section-start">
                  <a href="#/akun" class="simple-text logo-mini">
                    <div class="wrapper">
                      <img src="https://www.fancyhands.com/images/default-avatar-250x250.png" alt="" class="image--cover" />
                    </div>
                  </a>

                  <div class="md-title" style="color: #868686">
                    #{{ user.id }} {{ user.name }}
                  </div>
                </div>
						</md-card-header>

						<md-card-content>

              <div class="row">
                <div class="col-md-3">
                  <ul class="nav nav-tabs tabs-left sideways">
                    <li class="active" id="dashboard"><a style="color: #db4a24" href="#dashboard-v" data-toggle="tab">DASHBOARD</a></li>
                    <li><a style="color: #db4a24" href="#order-v" data-toggle="tab">ORDER</a></li>
                    <li><a style="color: #db4a24" href="#alamat-v" data-toggle="tab">ALAMAT</a></li>
                    <li><a style="color: #db4a24" href="#akun-v" data-toggle="tab">DETAIL AKUN</a></li>
                    <li><a style="color: #db4a24" @click="logout" data-toggle="tab">KELUAR</a></li>
                  </ul>
                </div>
                <div class="col-md-9">
                  <div class="tab-content">
                    <div class="tab-pane active" id="dashboard-v">
                      <p class="md-subheading">
                        Halo <b>{{ user.name }}</b> (bukan <b>{{ user.name }}</b> ? <a @click="logout()">Keluar</a>)
                      </p><br>
                      <p class="subheading">
                        Dari Dashboard akun Anda, Anda dapat melihat pesanan terbaru Anda,
                        mengelola alamat pengiriman dan penagihan Anda
                        dan mengedit kata sandi dan detail akun Anda.
                      </p>
                    </div>
                    <div class="tab-pane" id="order-v">ORDER</div>
                    <div class="tab-pane" id="alamat-v">ALAMAT</div>
                    <div class="tab-pane" id="akun-v">
                      <md-field>
                        <label>Nama Lengkap</label>
                        <md-input v-model="user.name"></md-input>
                        <span-error v-if="errors.name" class="label-danger">{{errors.name[0]}}</span-error>
                      </md-field>
                      <md-field>
                        <label>Email</label>
                        <md-input v-model="user.email"></md-input>
                        <span-error v-if="errors.email" class="label-danger">{{errors.email[0]}}</span-error>
                      </md-field>

                      <div class="md-subheading" style="color: #868686">
                        PERUBAHAN SANDI
                      </div>

                      <md-field>
                        <label>Sandi Baru (Biarkan Kosong Jika Tidak Diubah)</label>
                        <md-input v-model="user.password" type="password"></md-input>
                        <span-error v-if="errors.password" class="label-danger">{{errors.password[0]}}</span-error>
                      </md-field>
                      <md-field>
                        <label>Ulangi Sandi Baru</label>
                        <md-input v-model="user.password_confirmation" type="password"></md-input>
                      </md-field>

                      <md-button @click="saveForm" class="md-dense md-raised" style="background-color: #d44723; color: white">
                        Simpan Perubahan
                      </md-button>

                      <!-- Snackbar for success alert -->
                      <md-snackbar md-position="center" :md-duration="1500" :md-active.sync="notifSuccess" @md-closed="redirectTo">
                        <span id="span-snackbar">{{notifMessage}}</span>
                        <span><md-icon style="color: white">done_all</md-icon></span>
                      </md-snackbar>

                    </div>
                  </div>
                </div>
              </div>

						</md-card-content>

          </md-card>
      </div>
    <Footer></Footer>
  </div>
</template>

<script>

  import Header from '../header'
  import Footer from '../footer/footer'

  export default {
    data : () => ({
    	url: window.location.origin + (window.location.pathname + 'user'),
      token : $('meta[name="csrf-token"]').attr('content'),
      errors: [],
      user: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        id: ''
      },
      notifMessage: '',
      notifSuccess: false,

    }),
    mounted() {
      let app = this;

      app.getProfile(app);
    },
    methods: {
      getProfile(app){
        axios.get(app.url+"/detail-akun")
        .then(resp => {
          app.user = resp.data;
        })
        .catch(resp => {
          console.log(resp);
        });
      },
      saveForm() {
        var app = this;

  			axios.put(app.url+'/simpan-detail-akun', app.user)
  			.then(function (resp) {
          app.notifMessage = `Berhasil Mengubah Akun ${app.user.name}`
          app.kosongkanData(app);
          app.notifSuccess = true;
  			})
  			.catch(function (resp) {
  				app.errors = resp.response.data
  			});
      },
      kosongkanData(app){
        app.user.password = '';
        app.user.password_confirmation = '';
      },
      redirectTo() {
        window.location.replace(window.location.origin+(window.location.pathname)+"#/akun")
      },
      logout() {
        document.getElementById('logout-form').submit();
        this.$store.commit('user/LOGOUT')
      }
    },
    components : {
      Header,Footer
    },
  }

</script>

<style lang="scss" scoped>
  .breadcrumb {
    border-color: #ffffff;
    border-style: solid;
    border-width: 0 1px 4px 1px;
    padding: 8px 15px;
    margin-bottom: 35px;
    margin-top: 22px;
    list-style: none;
    background-color: #ffffff;
    border-radius: 4px;
  }

  .image--cover {
    width: 85px;
    height: 85px;
    border-radius: 50%;
    margin: 5px;

    object-fit: cover;
    object-position: center right;
  }

  .tabs-left {
    border-bottom: none;
    border-right: 1px solid #ddd;
  }

  .tabs-left>li {
    float: none;
    margin:0px;
  }

  .tabs-left>li.active>a,
  .tabs-left>li.active>a:hover,
  .tabs-left>li.active>a:focus {
    border-bottom-color: #ddd;
    border-right-color: transparent;
    background:#db4a24;
    color: #fff !important;
    border:none;
    border-radius:0px;
    margin:0px;
  }

  .nav-tabs>li>a:hover {
    line-height: 1.42857143;
    border: 1px solid transparent;
  }

  .tabs-left>li.active>a::after{content: "";
    position: absolute;
    top: 10px;
    right: -10px;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    border-left: 10px solid #db4a24;
    color: #fff !important;
    display: block;
    width: 0;
  }

  span-error {
    color: white;
    height: 20px;
    position: absolute;
    bottom: -22px;
    font-size: 12px;
    transition: .3s cubic-bezier(.4,0,.2,1);
  }
  .label-danger {
    background-color: red;
    border-radius: 12px;
    padding: 0px 10px;
    text-transform: uppercase;
    font-size: 10px;
    font-weight: bold
  }
</style>
