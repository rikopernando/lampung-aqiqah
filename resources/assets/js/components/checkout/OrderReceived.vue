<template>
  <div>
    <Header></Header>
      <div class="container">
          <md-card md-with-hover>
            <ul class="breadcrumb">
              <li><a href="#/">Home</a></li>
              <li><a href="#/keranjang-belanja" id="keranjang-belanja">Keranjang</a></li>
              <li><a href="#/checkout">Checkout</a></li>
              <li class="active">Pesanan Diterima</li>
            </ul>
          </md-card>

          <md-card md-with-hover>
						<md-card-header>
							<div class="md-title">Pesanan Diterima</div>
              <hr style="margin-bottom: 0px;">
						</md-card-header>

						<md-card-content>

              <div v-if="loading">
                <center><md-progress-spinner md-mode="indeterminate"></md-progress-spinner></center>
              </div>
              <div v-else>

                <div v-if="status">
										<md-empty-state
											md-description="Tidak ada pesanan yang diterima">
                      <md-button to="/list-produk" class="md-accent md-raised">Lanjut Belanja</md-button>
										</md-empty-state>
                </div>
                <div v-else>
									<div class="alert alert-success" role="alert">
                    Terima kasih. Pesanan Anda telah diterima, Kami telah mengirimkan email konfirmasi ke email anda.
									</div>

                  <ul class="order-detail">
                    <li v-for="data, index in data_pesanan.pesanan">
                      <span class="list-header">{{ data.header }}</span><br>
                      <span class="list-content" v-if="data.header == 'Total'">{{ data.content | pemisahTitik }}</span>
                      <span class="list-content" v-else>{{ data.content }}</span>
                    </li>
                  </ul>
                  <br>

                  <table class="table table-striped table-hover">
                    <thead>
                      <th> PRODUK </th> <th></th> <th></th> <th></th>
                    </thead>
                    <tbody v-if="data_pesanan.detail_pesanan.length">
                      <tr v-for="detail_pesanans, index in data_pesanan.detail_pesanan">
                        <td style="font-style: oblique;">{{detail_pesanans.produk.nama_produk | capitalize}}</td> <td width="1%">x</td> <td>{{ detail_pesanans.jumlah_produk | pemisahTitik }}</td>
                        <td style="text-align:right; font-size:15px; font-weight:bold;"> Rp. {{ detail_pesanans.subtotal | pemisahTitik }}</td>
                      </tr>
                    </tbody>
                    <tbody>
                      <tr>
                        <th class="subtotal" style="padding-top: 13px !important">KODE UNIK</th>
                        <td></td> <td></td>
                        <td class="subtotal" style="text-align:right; font-size:17px; font-weight:bold;"> <strong>Rp. {{ data_pesanan.kode_unik | pemisahTitik }}</strong></td>
                      </tr>
                      <tr>
                        <th class="subtotal" style="padding-top: 13px !important">TOTAL AKHIR</th>
                        <td></td> <td></td>
                        <td class="subtotal" style="text-align:right; font-size:17px; font-weight:bold;"> <strong>Rp. {{ data_pesanan.subtotal | pemisahTitik }}</strong></td>
                      </tr>
                    </tbody>
                  </table>

                  <table class="table table-striped table-hover">
                    <thead>
                      <th> PEMESAN </th> <th></th> <th></th>
                    </thead>
                    <tbody>
                      <tr>
                        <tr v-for="data, index in data_pesanan.pemesan" style="text-transform: uppercase">
                          <td width="20%;">{{ data.judul }}</td> <td width="5%;">: </td>
                          <td>{{ data.isi }}</td>
                        </tr>
                      </tr>
                    </tbody>
                  </table>

                  <table class="table table-striped table-hover" v-if="data_pesanan.kirim_tempat_lain.length">
                    <thead>
                      <th>ALAMAT KIRIM</th> <th></th> <th></th>
                    </thead>
                    <tbody>
                      <tr>
                        <tr v-for="data, index in data_pesanan.kirim_tempat_lain" style="text-transform: uppercase">
                          <td width="20%;">{{ data.judul }}</td> <td width="5%;">: </td>
                          <td>{{ data.isi }}</td>
                        </tr>
                      </tr>
                    </tbody>
                  </table>
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
      loading : true,
    	url: window.location.origin + window.location.pathname,
      data_pesanan : {},
      status : false,
    }),
    components : {
      Header,Footer
    },
	  filters: {
      pemisahTitik: function (value) {
          var angka = [value];
          var numberFormat = new Intl.NumberFormat('es-ES');
          var formatted = angka.map(numberFormat.format);
          return formatted.join('; ');
      },
		  capitalize: function (value) {
		    return value.replace(/(^|\s)\S/g, l => l.toUpperCase())
	    },
  	},
    mounted() {
     this.getDataPesanan()
		 document.getElementById("keranjang-belanja").focus({reventScroll:true})
    },
    methods : {
      getDataPesanan() {
        const app = this 
        const id = app.$router.app._route.params.id
        axios.get(app.url+'pesanan/'+id)
        .then((resp) => {
          resp.data == 0 ? app.status = true : app.data_pesanan = resp.data
          app.loading = false
          console.log(app.status)
        })
        .catch((err) => {
          console.log(err)
        })
      }
    }
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

	.list-header {
		font-size: 12px;
    color: grey;
    text-transform: uppercase;
	}

	.list-content {
    font-size: 15px;
    color: black !important;
    font-weight: 400;
    & br {padding: 5px 0px}
	}

  /*MOBILE CSS*/
  @media (max-width: 600px) {
    .md-xsmall-hide { display: none; }
/*    #displayMobile { display: block; }*/
			ul.order-detail {
				margin: 0 0 3em;
				padding: 0px;
				list-style: none;
			}

      ul.order-detail li {
				float: left;
				margin-right: 1em;
				text-transform: uppercase;
				font-size: 10px;
				border-right: 1px dashed #d3ced2;
				padding-right: 1em;
				margin-left: 0;
				margin-bottom: 10px;
				padding-left: 0;
				list-style-type: none;
				width: 139px;
      }
  }

  /* DEKSTOP CSS */
  @media (min-width: 600px) {
/*    #displayMobile { display: none; }*/
			ul.order-detail {
				margin: 0 0 3em;
				padding: 0px;
				list-style: none;
			}

      ul.order-detail li {
        float: left;
        margin-right: 2em;
        text-transform: uppercase;
        font-size: 12px;
        border-right: 1px dashed #d3ced2;
        padding-right: 2em;
        margin-left: 0;
        padding-left: 0;
        list-style-type: none;
      }
  
  }

  table th{background:#da2921 !important; color:#fff !important; padding:5px !important;}
  .subtotal {background:#fff !important; color:#da2921 !important; padding-top:13px !important;}
  table td{background:#FFF !important; padding:10px !important;}


</style>
