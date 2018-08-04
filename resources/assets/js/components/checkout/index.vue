<template>
  <div>
    <Header></Header>
      <div class="container">
          <md-card md-with-hover>
            <ul class="breadcrumb">
              <li><a href="#/">Home</a></li>
              <li><a href="#/keranjang-belanja">CART</a></li>
              <li class="active">Checkout</li>
            </ul>
          </md-card>

          <md-card md-with-hover>
						<md-card-header>
							<div class="md-title">Checkout</div>
              <hr>
						</md-card-header>

						<md-card-content>
							<div class="row">
                <div class="col-md-6">
                  <h4>Billing Details</h4>

                  <BillingDetails 
                      :pesanan="pesanan" :select_provinsi="select_provinsi" :select_kabupaten="select_kabupaten"
                      :select_kecamatan="select_kecamatan" :select_kelurahan="select_kelurahan" :selectsumberInformasi="sumberInformasi"
                      :sumber_informasi="sumber_informasi" :provinsi="provinsi" :kabupaten="kabupaten" :kecamatan="kecamatan" :kelurahan="kelurahan"
                      />

                </div>

                <div class="col-md-6">
                  <md-checkbox v-model="pesanan.kirim_ke_alamat_lain">Kirim ke alamat lain ?</md-checkbox>

                  <KirimTempatLain :kirim_tempat_lain="pesanan.kirim_tempat_lain" :select_provinsi="select_provinsi" :select_kabupaten="select_kabupaten" :select_kecamatan="select_kecamatan" 
                  :select_kelurahan="select_kelurahan"  :provinsi="provinsi" :kabupaten="kabupaten" :kecamatan="kecamatan" :kelurahan="kelurahan" v-if="pesanan.kirim_ke_alamat_lain" />

                  <h4>Data Peserta Aqiqah</h4>
                  <DataPesertaAqiqah :pesanan="pesanan" />
                  
                </div>
              </div>

              <h4>Pesanan Anda</h4>

              <table class="table table-striped table-hover">
                <thead>
                  <th> PRODUCT </th>
                  <th style="text-align:right;"> TOTAL </th>
                </thead>
				    		<tbody v-if="this.$store.state.keranjangbelanja.countKeranjang > 0">
                  <tr v-for="produks, index in data_produk">
                    <td style="font-style: oblique;"> {{ produks.produk.nama_produk }} <span style="font-weight:bold">x {{ produks.jumlah_produk }} </span></td>
                    <td style="text-align:right; font-size:15px; font-weight:bold;"> Rp. {{ produks.subtotal | pemisahTitik }}</td>
                  </tr>
                </tbody>
                <tbody v-else>
                   <tr v-if="this.$store.state.keranjangbelanja.loading">
                       <td colspan="2" class="text-center" >
                         <md-progress-spinner :md-diameter="30" :md-stroke="3" md-mode="indeterminate"></md-progress-spinner>
                       </td>
                   </tr>
                   <tr else>
                       <td colspan="2" class="text-center" style="font-style: oblique 40deg;">Produk Kosong</td>
                   </tr>
                </tbody>
                <tbody v-if="this.$store.state.keranjangbelanja.countKeranjang > 0">
                  <tr>
                    <th>Subtotal</th>
                    <td style="text-align:right; font-size:17px; font-weight:bold;"> <strong>Rp. {{ this.$store.state.keranjangbelanja.subtotal | pemisahTitik }}</strong></td>
                  </tr>
                  <tr>
                    <th>Total</th>
                    <td style="text-align:right; font-size:17px; font-weight:bold;"><strong>Rp. {{ this.$store.state.keranjangbelanja.total_akhir | pemisahTitik }}</strong> </td>
                  </tr>
                </tbody>
              </table>
							
							<h4>Metode Pembayaran</h4>
							<md-steppers md-vertical>
								<md-step id="first" md-label="Transfer Bank" v-on:click="pesanan.metode_pembayaran = 'Transfer Bank'">
										Lakukan pembayaran Anda langsung ke rekening bank kami. Harap gunakan ID Pesanan Anda sebagai referensi pembayaran. Pesanan Anda tidak akan dikirim sampai dana telah masuk ke rekening kami.
								</md-step>

								<md-step id="second" md-label="Cash On Delivery" v-on:click="pesanan.metode_pembayaran = 'Cash On Delivery'">
										Pembayaran di tempat saat barang datang
								</md-step>
							</md-steppers>
							
							<md-button class="md-raised md-accent" type="button" v-on:click="pesanSekarang()">Pesan Sekarang!</md-button>
						</md-card-content>

          </md-card>
      </div>
    <Footer></Footer>
  </div>
</template>

<script>
  
  import { mapState } from 'vuex'
  import { LOAD_DATA } from '../../store/lokasi/mutations'
  import Header from '../header'
  import Footer from '../footer/footer'
  import BillingDetails from './billing-details'
  import KirimTempatLain from './kirim-tempat-lain'
  import DataPesertaAqiqah from './data-peserta-aqiqah'

  export default {
    data : () => ({
      errors : [],
    	url: window.location.origin + (window.location.pathname + 'pesanan'),
      jenisKelamin : {
        placeholder : 'Jenis Kelamin'
      },
      sumberInformasi : {
        placeholder : 'Sumber Informasi'
      },
      select_provinsi : {
        placeholder : 'Cari Provinsi ...'
      },
      select_kabupaten : {
        placeholder : 'Cari Kabupaten atau Kota ...'
      },
      select_kecamatan : {
        placeholder : 'Cari Kecamatan ...'
      },
      select_kelurahan : {
        placeholder : 'Cari Kelurahan ...'
      },
			sumber_informasi: ['Google','Facebook','Instagram','Teman','Bidan','Website','Spanduk','X-Banner','Televisi','Radio'],
      pesanan : {
        nama_pemesan : '',
        alamat : '',
        provinsi : '',
        kelurahan : '',
        kecamatan : '',
        kabupaten : '',
        handphone : '',
        email : '',
        sumber_informasi : '',
        catatan : '',
        nama_peserta : '',
        tempat_tanggal_lahir : '',
        jenis_kelamin_peserta : '',
        nama_ayah : '',
        nama_ibu : '',
        tempat_lahir :'',
        metode_pembayaran : 'Transfer Bank',
        total : 0,
        kirim_ke_alamat_lain : false,
        kirim_tempat_lain : {
          nama_depan : '',
          nama_belakang : '',
          company_name : '',
          alamat : '',
          provinsi : '',
          kelurahan : '',
          kecamatan : '',
          kabupaten : '',
        }
      },
    }),
    mounted () {
      this.$store.dispatch('lokasi/LOAD_PROVINSI')
	    this.$store.dispatch('keranjangbelanja/LOAD_SUBTOTAL_LIST')
    }, 
	  filters: {
      pemisahTitik: function (value) {
          var angka = [value];
          var numberFormat = new Intl.NumberFormat('es-ES');
          var formatted = angka.map(numberFormat.format);
          return formatted.join('; ');
      },
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
       data_produk () {
        return this.$store.state.keranjangbelanja.datakeranjang.data_keranjang
       },
    }),
    components : {
      Header,Footer, BillingDetails, KirimTempatLain, DataPesertaAqiqah
    },
    methods : {
      pesanSekarang() {
        console.log(2)
        const app = this
        app.pesanan.total = app.$store.state.keranjangbelanja.total_akhir
        axios.post(app.url,app.pesanan)
        .then((resp) => {

        })
        .catch((err) => {
           app.errors = err.response.data
        })
      }
    }
  }

</script>

<style lang="scss" scoped>
  
  .card-checkout {
    margin-right: auto;
    margin-left: auto;
    padding-left: 15px;
    padding-right: 15px;
    background-color: #ffffff;
  }

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
	
	.total-price {
		background-color : #ff5252;
	}	

  .md-table + .md-table {
    margin-top: 16px
  }

  .md-progress-bar {
    margin: 1px;
  }

  .md-progress-spinner {
    margin: 14px;
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

  table th{background:#da2921 !important; color:#fff !important; padding:5px !important;}
  table td{background:#FFF !important; padding:10px !important;}

</style>
