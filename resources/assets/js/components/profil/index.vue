<template>
  <div>
    <link rel="stylesheet" :href="urlOrigin+'/css/profil-pelanggan.css'">

    <Header></Header>
      <div class="container">
          <md-card md-with-hover>
            <ul class="breadcrumb">
              <li><router-link :to="{name: 'home'}">Home</router-link></li>
              <li class="active">Akun</li>
            </ul>
          </md-card>

          <md-card md-with-hover>
						<md-card-header>
                <div class="md-toolbar-section-start">
                  <router-link class="simple-text logo-mini" :to="{name: 'indexAkun'}">
                    <div class="wrapper">
                      <img src="https://www.fancyhands.com/images/default-avatar-250x250.png" alt="" class="image--cover" />
                    </div>
                  </router-link>
                  <div class="md-title" style="color: #868686">
                    #{{ user.id }} {{ user.name }}
                  </div>
                </div>
						</md-card-header>

						<md-card-content>

              <div class="row">
                <div class="col-md-3" style="padding: 0px;">
                  <div class="md-medium-size-50 md-small-size-50 md-xsmall-hide">
                    <ul class="nav nav-tabs tabs-left">
                      <li class="tab-profil active" id="dashboard"><a style="color: #db4a24" href="#dashboard-v" data-toggle="tab">DASHBOARD</a></li>
                      <li class="tab-profil"><a style="color: #db4a24" href="#order-v" data-toggle="tab">ORDER</a></li>
                      <li class="tab-profil"><a style="color: #db4a24" href="#alamat-v" data-toggle="tab">ALAMAT</a></li>
                      <li class="tab-profil"><a style="color: #db4a24" href="#akun-v" data-toggle="tab">DETAIL AKUN</a></li>
                      <li class="tab-profil"><a style="color: #db4a24" @click="logout" data-toggle="tab">KELUAR</a></li>
                    </ul>
                  </div>

                    <div id="displayTabs" style="padding: 0px !important">
                      <ul class="nav nav-tabs tabs-mobile">
                        <li class="active" id="dashboard"><a style="color: #db4a24" href="#dashboard-v" data-toggle="tab">DASHBOARD</a></li>
                        <li><a style="color: #db4a24" href="#order-v" data-toggle="tab">ORDER</a></li>
                        <li><a style="color: #db4a24" href="#alamat-v" data-toggle="tab">ALAMAT</a></li>
                        <li><a style="color: #db4a24" href="#akun-v" data-toggle="tab">AKUN</a></li>
                      </ul>
                    </div><br>
                </div>
                <div class="col-md-9">
                  <div class="tab-content">
                    <div class="tab-pane active" id="dashboard-v">
                      <md-card>
                        <md-card-content>
                          <p class="md-subheading">
                            Halo <b>{{ user.name }}</b> (bukan <b>{{ user.name }}</b> ? <a @click="logout()">Keluar</a>)
                          </p><br>
                          <p class="subheading">
                            Dari Dashboard akun Anda, Anda dapat melihat pesanan terbaru Anda,
                            mengelola alamat pengiriman dan penagihan Anda
                            dan mengedit kata sandi dan detail akun Anda.
                          </p><br>

                          <!-- DASHBOARD CARD -->
                          <div class="row" id="portfolio">
                            <div class="col-md-4 col-xs-6">
                              <div class="card border-card" id="orderCard">
                                <div class="card-title">ORDER</div>
                                <div class="card-icon"><i class="material-icons">shopping_basket</i></div>
                                <div class="card-data"></div>
                                <hr/>
                                <div class="card-hint">
                                  <i class="material-icons">list</i>
                                  <a href="#order-v" data-toggle="tab">Lihat Pesanan</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4 col-xs-6">
                              <div class="card border-card" id="alamatCard">
                                <div class="card-title">ALAMAT</div>
                                <div class="card-icon"><i class="material-icons">location_on</i></div>
                                <div class="card-data"></div>
                                <hr/>
                                <div class="card-hint">
                                  <i class="material-icons">edit_location</i>
                                  <a href="#alamat-v" data-toggle="tab">Kelola Alamat</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4 col-xs-6">
                              <div class="card border-card" id="akunCard">
                                <div class="card-title">AKUN</div>
                                <div class="card-icon"><i class="material-icons">account_circle</i></div>
                                <div class="card-data"></div>
                                <hr/>
                                <div class="card-hint">
                                  <i class="material-icons">edit</i>
                                  <a href="#akun-v" data-toggle="tab">Ubah Akun</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </md-card-content>
                      </md-card>

                    </div>
                    <div class="tab-pane" id="order-v">
                      <md-card>
                        <md-card-content>
                          <div class="md-subheading">
                            <span>Belum Ada Pesanan Yang Dibuat.</span>
                            <md-button class="md-dense md-raised" style="background-color: #d44723; color: white">
                              <router-link style="color: white" :to="{name: 'listProduk'}">
                                Lanjutkan Belanja
                              </router-link>
                            </md-button>
                          </div>
                        </md-card-content>
                      </md-card>
                    </div>
                    <div class="tab-pane" id="alamat-v">

                      <md-card>
                        <md-card-content>
                          <table class="table table-hover" id="tableAlamat">
                            <thead>
                              <th width="20%">Nama Lengkap</th>
                              <th>Alamat</th>
                              <th>No. Telepon</th>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Rindang Ramadhan</td>
                                <td>
                                  Jl. Pramuka, Sentra Bisnis Terminal Kemiling Blok R3 No.7,
                                  Sumber Rejo, Kemiling, Kota Bandar Lampung,
                                  Lampung 35153 ( PT. Andaglos Global Teknologi.)
                                </td>
                                <td>082281597835</td>
                              </tr>
                            </tbody>
                          </table>

                          <div id="inputAlamat" class="row" style="display: none">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <md-field>
                                <label>Nama Lengkap</label>
                                <md-input v-model="user.name"></md-input>
                                <span-error v-if="errors.name" class="label-danger">{{errors.name[0]}}</span-error>
                              </md-field>
                              <md-field>
                                <label>No. Telepon</label>
                                <md-input v-model="user.email"></md-input>
                                <span-error v-if="errors.email" class="label-danger">{{errors.email[0]}}</span-error>
                              </md-field>
                              <md-field>
                                <label>Alamat</label>
                                <md-textarea></md-textarea>
                              </md-field>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <md-field>
                                <label for="provinsi">Provinsi</label>
                                <md-select name="provinsi" id="provinsi" md-dense>
                                  <md-option value="provinsi">Sample Provinsi</md-option>
                                </md-select>
                              </md-field>
                              <md-field>
                                <label for="kabupaten">Kabupaten</label>
                                <md-select name="kabupaten" id="kabupaten" md-dense>
                                  <md-option value="kabupaten">Sample Kabupaten</md-option>
                                </md-select>
                              </md-field>
                              <md-field>
                                <label for="kecamatan">Kecamatan</label>
                                <md-select name="kecamatan" id="kecamatan" md-dense>
                                  <md-option value="kecamatan">Sample Kecamatan</md-option>
                                </md-select>
                              </md-field>
                            </div>
                          </div>
                        </md-card-content>

                        <md-card-actions>
                          <md-button id="btnUbah" @click="ubahAlamat" class="md-dense md-raised" style="background-color: #d44723; color: white">
                            Ubah Alamat
                          </md-button>
                          <md-button id="btnSimpan" @click="simpanAlamat" class="md-dense md-raised" style="display: none; background-color: #d44723; color: white">
                            Simpan Alamat
                          </md-button>
                        </md-card-actions>
                      </md-card>

                    </div>
                    <div class="tab-pane" id="akun-v">
                      <md-card>

                        <md-card-content>
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
                        </md-card-content>

                        <md-card-actions>
                          <md-button @click="saveForm" class="md-dense md-raised" style="background-color: #d44723; color: white">
                            Simpan Perubahan
                          </md-button>
                        </md-card-actions>
                      </md-card>

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
    	urlOrigin: window.location.origin + (window.location.pathname),
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
      },
      ubahAlamat() {
        $("#tableAlamat").hide();
        $("#btnUbah").hide();

        $("#inputAlamat").show();
        $("#btnSimpan").show();
      },
      simpanAlamat() {
        $("#tableAlamat").show();
        $("#btnUbah").show();

        $("#inputAlamat").hide();
        $("#btnSimpan").hide();
      }
    },
    components : {
      Header,Footer
    },
  }
</script>
