<template>
  <div>
    <link rel="stylesheet" :href="urlOrigin + '/css/profil-pelanggan.css'">

    <Header/>
      <div class="container" style="margin-bottom: 30px;">
        <md-card>
          <ul class="breadcrumb">
            <li><router-link :to="{name: 'home'}">Home</router-link></li>
            <li class="active">Akun</li>
          </ul>
        </md-card>

        <md-card>
					<md-card-header>
              <div class="md-toolbar-section-start">
                <div class="simple-text logo-mini">
                  <div class="wrapper">
                    <img src="https://www.fancyhands.com/images/default-avatar-250x250.png" alt="" class="image--cover" />
                  </div>
                </div>
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
                    <li class="tab-profil"><a style="color: #db4a24" href="#order-v" data-toggle="tab">ORDER</a></li>
                    <li class="tab-profil"><a style="color: #db4a24" href="#alamat-v" data-toggle="tab">ALAMAT</a></li>
                    <li class="tab-profil"><a style="color: #db4a24" href="#akun-v" data-toggle="tab">DETAIL AKUN</a></li>
                    <li class="tab-profil"><router-link :to="{name: 'logout'}" style="color: #db4a24; padding: 10px 15px;">KELUAR</router-link></li>
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
                    <DashboardTab :user="user"/>
                  </div>

                  <div class="tab-pane" id="order-v">
                    <OrderTab :orders="orders" :searched="searched"/>
                  </div>

                  <div class="tab-pane" id="alamat-v">
                    <AlamatTab 
                      :userAddress="userAddress" 
                      :select_provinsi="select_provinsi" 
                      :select_kabupaten="select_kabupaten" 
                      :select_kecamatan="select_kecamatan" 
                      :select_kelurahan="select_kelurahan" 
                      :provinsi="provinsi" 
                      :kabupaten="kabupaten" 
                      :kecamatan="kecamatan" 
                      :kelurahan="kelurahan"
                    />
                  </div>

                  <div class="tab-pane" id="akun-v">
                    <AkunTab :user="user" :error="errors" :notifMessage="notifMessage" :notifSuccess="notifSuccess"
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
  	urlOrder: window.location.origin + (window.location.pathname + 'pesanan'),
    token : $('meta[name="csrf-token"]').attr('content'),
    errors: [],
    orders: [],
    searched: [],
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
    this.getProfile()
    this.getOrder()
    this.$store.dispatch('lokasi/LOAD_PROVINSI')
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
    getProfile(){
      axios.get(this.url + "/detail-akun")
      .then(resp => {
        this.user = resp.data;
        this.userAddress = resp.data;
      })
      .catch(resp => {
        console.log(resp);
      });
    },
    getOrder(){
      axios.get(this.urlOrder + "/history-order")
      .then(resp => {
        this.orders = resp.data;
        this.searched = resp.data;
      })
      .catch(resp => {
        console.log(resp);
      });
    },
  },
  components : {
    Header, Footer, DashboardTab, OrderTab, AlamatTab, AkunTab,
  },
}
  
</script>
