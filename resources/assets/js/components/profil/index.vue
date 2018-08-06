<template>
  <div>
    <link rel="stylesheet" :href="urlOrigin+'/css/profil-pelanggan.css'">
    <Header/>
    <div class="container">
      <md-card>
        <ul class="breadcrumb">
          <li><router-link :to="{name: 'home'}">Home</router-link></li>
          <li class="active">Akun</li>
        </ul>
      </md-card>

      <md-card>
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
                  <li class="tab-profil active" id="dashboard">
                    <a style="color: #db4a24" href="#dashboard-v" data-toggle="tab">DASHBOARD</a>
                  </li>
                  <li class="tab-profil">
                    <a style="color: #db4a24" href="#order-v" data-toggle="tab">ORDER</a>
                  </li>
                  <li class="tab-profil">
                    <a style="color: #db4a24" href="#alamat-v" data-toggle="tab">ALAMAT</a>
                  </li>
                  <li class="tab-profil">
                    <a style="color: #db4a24" href="#akun-v" data-toggle="tab">DETAIL AKUN</a>
                  </li>
                  <li class="tab-profil">
                    <a style="color: #db4a24" @click="logout" data-toggle="tab">KELUAR</a>
                  </li>
                </ul>
              </div>
              <div id="displayTabs" style="padding: 0px !important">
                <ul class="nav nav-tabs tabs-mobile">
                  <li class="active" id="dashboard"><a style="color: #db4a24" href="#dashboard-v" data-toggle="tab">DASHBOARD</a></li>
                  <li><a style="color: #db4a24" href="#order-v" data-toggle="tab">ORDER</a></li>
                  <li><a style="color: #db4a24" href="#alamat-v" data-toggle="tab">ALAMAT</a></li>
                  <li><a style="color: #db4a24" href="#akun-v" data-toggle="tab">AKUN</a></li>
                </ul>
              </div>
              <br>
            </div>
            <div class="col-md-9">
              <div class="tab-content">
                <div class="tab-pane active" id="dashboard-v">
                  <DashboardTab :user="user"/>
                </div>
                <div class="tab-pane" id="order-v">
                  <OrderTab/>
                </div>
                <div class="tab-pane" id="alamat-v">
                  <AlamatTab 
                    :userAddress="userAddress" 
                    :select_provinsi="select_provinsi"
                    :select_kabupaten="select_kabupaten" :select_kecamatan="select_kecamatan" 
                    :select_kelurahan="select_kelurahan"
                    :provinsi="provinsi" 
                    :kabupaten="kabupaten" 
                    :kecamatan="kecamatan" 
                    :kelurahan="kelurahan"
                  />
                </div>
                <div class="tab-pane" id="akun-v">
                  <AkunTab 
                    :user="user" 
                    :error="errors" 
                    :notifMessage="notifMessage" 
                    :notifSuccess="notifSuccess"
                  />
                </div>
              </div>
            </div>
          </div>
				</md-card-content>
      </md-card>
    </div>
    <Footer/>
  </div>
</template>

<script>

import { mapState } from 'vuex'
import Header from '../header'
import Footer from '../footer/footer'
import DashboardTab from './dashboard'
import OrderTab from './order'
import AlamatTab from './alamat'
import AkunTab from './akun'

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
    userAddress: {
      name: '',
      no_telp: '',
      alamat: '',
      provinsi: '',
      kabupaten: '',
      kecamatan: '',
      kelurahan: '',
      id: ''
    },
    select_provinsi : {
      placeholder : '--PILIH PROVINSI--'
    },
    select_kabupaten : {
      placeholder : '--PILIH KABUPATEN / KOTA--'
    },
    select_kecamatan : {
      placeholder : '--PILIH KECAMATAN--'
    },
    select_kelurahan : {
      placeholder : '--PILIH KELURAHAN--'
    },
    notifMessage: '',
    notifSuccess: false,
  }),
  mounted() {
    let app = this;

    app.getProfile(app)
    app.$store.dispatch('lokasi/LOAD_PROVINSI')
  },
  computed : mapState ({
    provinsi () {
      return this.$store.state.lokasi.provinsi
    },
    kabupaten () {
      return this.$store.state.lokasi.kabupaten
    },
    kecamatan () {
      return this.$store.state.lokasi.kecamatan
    },
    kelurahan () {
      return this.$store.state.lokasi.kelurahan
    },
  }),
  methods: {
    getProfile(app){
      axios.get(app.url+"/detail-akun")
      .then(resp => {
        app.user = resp.data;
        app.userAddress = resp.data;
      })
      .catch(resp => {
        console.log(resp);
      });
    },
    logout() {
      document.getElementById('logout-form').submit();
      this.$store.commit('user/LOGOUT')
    }
  },
  components : {
    Header, Footer, DashboardTab, OrderTab, AlamatTab, AkunTab,
  },
}

</script>
