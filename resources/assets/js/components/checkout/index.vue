<template>
  <div>
    <Header></Header>
      <div class="container">
          <md-card md-with-hover>
            <ul class="breadcrumb">
              <li><a href="#/">Home</a></li>
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
                  <h5>Billing Details</h5>
                  <BillingDetails 
                      :pesanan="pesanan" :select_provinsi="select_provinsi" :select_kabupaten="select_kabupaten"
                      :select_kecamatan="select_kecamatan" :select_kelurahan="select_kelurahan" :selectsumberInformasi="sumberInformasi"
                      :sumber_informasi="sumber_informasi" :provinsi="provinsi" :kabupaten="kabupaten" :kecamatan="kecamatan" :kelurahan="kelurahan"
                      />
                </div>

                <div class="col-md-6">
                  <md-checkbox v-model="kirim_ke_alamat_lain">Kirim ke alamat lain ?</md-checkbox>
                  <KirimTempatLain :kirim_tempat_lain="kirim_tempat_lain" :select_provinsi="select_provinsi" :select_kabupaten="select_kabupaten" :select_kecamatan="select_kecamatan" :select_kelurahan="select_kelurahan"  :provinsi="provinsi" :kabupaten="kabupaten" :kecamatan="kecamatan" :kelurahan="kelurahan" v-if="kirim_ke_alamat_lain" />
                  <h5>Data Peserta Aqiqah</h5>
                  <div class="form-group">
                    <input type="text" v-model="pesanan.nama_peserta" class="form-control" placeholder="Nama Peserta">
                  </div>
                  <div class="form-group">
                    <input type="text" v-model="pesanan.ttl_peserta" class="form-control" placeholder="Tempat & Tanggal Lahir">
                  </div>
                  <div class="form-group">
                    <selectize-component :settings="jenisKelamin" v-model="pesanan.jenis_kelamin_peserta" ref="jenis_kelamin_peserta">
                      <option v-bind:value="1">Laki-laki</option>
                      <option v-bind:value="2">Perempuan</option>
                    </selectize-component>
                  </div>
                  <div class="form-group">
                    <input type="text" v-model="pesanan.nama_ayah" class="form-control" placeholder="Nama Ayah">
                  </div>
                  <div class="form-group">
                    <input type="text" v-model="pesanan.nama_ibu" class="form-control" placeholder="Nama Ibu">
                  </div>
                  <div class="form-group">
                    <input type="text" v-model="pesanan.tempat_lahir" class="form-control" placeholder="Lahir Di(Nama RSB/Bidan)">
                  </div>
                </div>
              </div>

              <h4>Pesanan Anda</h4>

              <table class="table table-striped table-hover">
                <thead>
                  <th> PRODUCT </th>
                  <th style="text-align:right;"> TOTAL </th>
                </thead>
                <tbody>
                  <tr>
                    <td>Paket Premium x 2 </td>
                    <td style="text-align:right; font-size:15px; font-weight:bold;"> Rp. 1.000.000</td>
                  </tr>
                  <tr>
                    <td>Paket Special x 3 </td>
                    <td style="text-align:right; font-size:15px; font-weight:bold;"><strong>Rp. 1.000.000</strong> </td>
                  </tr>
                </tbody>
                <tbody>
                  <tr>
                    <th>Subtotal</th>
                    <td style="text-align:right; font-size:17px; font-weight:bold;"> <strong>Rp. 2.000.000</strong></td>
                  </tr>
                  <tr>
                    <th>Total</th>
                    <td style="text-align:right; font-size:17px; font-weight:bold;"><strong>Rp. 2.000.000</strong> </td>
                  </tr>
                </tbody>
              </table>
							
							<h5>Metode Pembayaran</h5>
							<md-steppers md-vertical>
								<md-step id="first" md-label="Transfer Bank">
										Lakukan pembayaran Anda langsung ke rekening bank kami. Harap gunakan ID Pesanan Anda sebagai referensi pembayaran. Pesanan Anda tidak akan dikirim sampai dana telah masuk ke rekening kami.
								</md-step>

								<md-step id="second" md-label="Cash On Delivery">
										Pembayaran di tempat saat barang datang
								</md-step>
							</md-steppers>
							
							<md-button class="md-raised md-accent" type="submit">Pesan Sekarang!</md-button>
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

  export default {
    data : () => ({
      kirim_ke_alamat_lain : false,
      jenisKelamin : {
        placeholder : 'Jenis Kelamin'
      },
      sumberInformasi : {
        placeholder : 'Sumber Informasi'
      },
      select_provinsi : {
        placeholder : 'Pilih Provinsi'
      },
      select_kabupaten : {
        placeholder : 'Pilih Kabupaten atau Kota'
      },
      select_kecamatan : {
        placeholder : 'Pilih Kecamatan'
      },
      select_kelurahan : {
        placeholder : 'Pilih Kelurahan'
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
        notes : '',
        nama_peserta : '',
        ttl_peserta : '',
        jenis_kelamin_peserta : '',
        nama_ayah : '',
        nama_ibu : '',
        tempat_lahir :''
      },
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
    }),
    mounted () {
      this.$store.dispatch('lokasi/LOAD_PROVINSI')
      console.log(5)
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
    components : {
      Header,Footer, BillingDetails, KirimTempatLain
    },
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

  table th{background:#da2921 !important; color:#fff !important; padding:5px !important;}
  table td{background:#FFF !important; padding:10px !important;}

</style>
