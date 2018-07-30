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
                  <h5>Billing Details </h5>
                  
                  <div class="form-group">
                    <input type="text" class="form-control" placeholder="Nama Pemesan" v-model="pesanan.nama_pemesan">
                  </div>
									<div class="form-group">
										<input type="text" v-model="pesanan.alamat" class="form-control" placeholder="Alamat">
									</div>
									<div class="form-group">
                    <selectize-component :settings="select_provinsi" v-model="pesanan.provinsi" ref="provinsi">
                      <option v-for="provinsi, index in provinsi" v-bind:value="provinsi.id">{{ provinsi.name }} </option> 
                    </selectize-component>
									</div>
									<div class="form-group">
                    <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kabupaten"></md-progress-bar>
                    <p class="waiting" v-if="this.$store.state.lokasi.load_kabupaten">Mohon tunggu ...</p>
                    <selectize-component :settings="select_kabupaten" v-model="pesanan.kabupaten" ref="kabupaten">
                      <option v-for="kabupaten, index in kabupaten" v-bind:value="kabupaten.id">{{ kabupaten.name }} </option> 
                    </selectize-component>
									</div>
									<div class="form-group">
                    <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kecamatan"></md-progress-bar>
                    <p class="waiting" v-if="this.$store.state.lokasi.load_kecamatan">Mohon tunggu ...</p>
                    <selectize-component :settings="select_kecamatan" v-model="pesanan.kecamatan" ref="kecamatan">
                      <option v-for="kecamatan, index in kecamatan" v-bind:value="kecamatan.id">{{ kecamatan.name }} </option> 
                    </selectize-component>
									</div>
									<div class="form-group">
                    <md-progress-bar md-mode="indeterminate" v-if="this.$store.state.lokasi.load_kelurahan"></md-progress-bar>
                    <p class="waiting" v-if="this.$store.state.lokasi.load_kelurahan">Mohon tunggu ...</p>
                    <selectize-component :settings="select_kelurahan" v-model="pesanan.kelurahan" ref="kelurahan">
                      <option v-for="kelurahan, index in kelurahan" v-bind:value="kelurahan.id">{{ kelurahan.name }} </option> 
                    </selectize-component>
									</div>
									<div class="form-group">
										<input type="text" v-model="pesanan.handphone" class="form-control" placeholder="Handphone">
									</div>
									<div class="form-group">
										<input type="email" v-model="pesanan.email" class="form-control" placeholder="Email">
									</div>
									<div class="form-group">
                    <selectize-component :settings="sumberInformasi" v-model="pesanan.sumber_informasi" ref="sumber_informasi">
                      <option v-for="sumberinformasi, index in sumber_informasi" v-bind:value="sumberinformasi">{{ sumberinformasi }} </option> 
                    </selectize-component>
									</div>
                  <div class="form-group">
                    <textarea v-model="pesanan.notes" class="form-control" placeholder="Catatan"></textarea>
                  </div>
                </div>

                <div class="col-md-6">
                  <md-checkbox v-model="kirim_ke_alamat_lain">Kirim ke alamat lain ?</md-checkbox>
                  <span v-if="kirim_ke_alamat_lain">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" v-model="kirim_tempat_lain.nama_depan" placeholder="Nama Depan" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="text" v-model="kirim_tempat_lain.nama_belakang" placeholder="Nama Belakang" class="form-control">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <input type="text" v-model="kirim_tempat_lain.company_name" placeholder="Company Name" class="form-control">
                  </div>
                  <div class="form-group">
                    <input type="text" v-model="kirim_tempat_lain.alamat" placeholder="Alamat" class="form-control">
                  </div>
                  <div class="form-group">
                    <input type="text" v-model="kirim_tempat_lain.kecamatan" class="form-control" placeholder="Kecamatan">
                  </div>
                  <div class="form-group">
                    <input type="text" v-model="kirim_tempat_lain.kota"  class="form-control" placeholder="Kota">
                  </div>
                  </span>
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

  export default {
    data : () => ({
      kirim_ke_alamat_lain : false,
      sumberInformasi : {
        placeholder : 'Sumber Informasi'
      },
      jenisKelamin : {
        placeholder : 'Jenis Kelamin'
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
        kecamatan : '',
        kota : ''
      },
			sumber_informasi: ['Google','Facebook','Instagram','Teman','Bidan','Website','Spanduk','X-Banner','Televisi','Radio']
    }),
    mounted () {
      this.$store.dispatch('lokasi/LOAD_PROVINSI')
      this.$refs.kabupaten.$el.selectize.disable()
      this.$refs.kecamatan.$el.selectize.disable()
      this.$refs.kelurahan.$el.selectize.disable()
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
    watch : {
      'pesanan.provinsi' : function(){
          if(this.pesanan.provinsi){
            const wilayah = "kabupaten"
            this.pilihWilayah(wilayah,this.pesanan.provinsi)
          }
      },
      'pesanan.kabupaten' : function(){
          if(this.pesanan.kabupaten){
            const wilayah = "kecamatan"
            this.pilihWilayah(wilayah,this.pesanan.kabupaten)
          }
      },
      'pesanan.kecamatan' : function(){
          if(this.pesanan.kecamatan){
            const wilayah = "kelurahan"
            this.pilihWilayah(wilayah,this.pesanan.kecamatan)
          }
      }
    },
    components : {
      Header,Footer
    },
    methods : {
      pilihWilayah(type, id_wilayah) {
          const app = this
          var selectize
            switch (type) {
                case "kabupaten":
                  selectize = app.$refs.kabupaten.$el.selectize
                  selectize.clearOptions()
                  app.$refs.kecamatan.$el.selectize.clearOptions()
                  app.$refs.kelurahan.$el.selectize.clearOptions()
                  app.$refs.kecamatan.$el.selectize.disable()
                  app.$refs.kelurahan.$el.selectize.disable()
                    break;
                case "kecamatan":
                  selectize = app.$refs.kecamatan.$el.selectize
                  selectize.clearOptions()
                  app.$refs.kelurahan.$el.selectize.clearOptions()
                  app.$refs.kelurahan.$el.selectize.disable()
                    break;
                case "kelurahan":
                  selectize = app.$refs.kelurahan.$el.selectize
                  selectize.clearOptions()
                    break;
            }
          app.$store.commit(`lokasi/${LOAD_DATA}`,type)
          app.$store.dispatch('lokasi/LOAD_WILAYAH',{
            type : type,
            id : id_wilayah
          })
          selectize.enable()
      },
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
  
  .waiting {
    font-style: italic;
  }

  table th{background:#da2921 !important; color:#fff !important; padding:5px !important;}
  table td{background:#FFF !important; padding:10px !important;}

</style>
