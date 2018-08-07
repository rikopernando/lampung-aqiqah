<template>
  <div>
    <Header></Header>
      <div class="container">
          <md-card md-with-hover>
            <ul class="breadcrumb">
              <li><a href="#/">Home</a></li>
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

              <span class="md-subheading" style="font-weight: bold">
                Terima kasih. Pesanan Anda telah diterima.
              </span>

              <ul class="order-detail">
                <li v-for="data, index in dataPesanan">
                  <span class="list-header">{{ data.header }}</span><br>
                  <span class="list-content">{{ data.content }}</span>
                </li>
              </ul>
              <br>

              <h4>Detail Order</h4>

              <table class="table table-striped table-hover">
                <thead>
                  <th> PRODUK </th> <th></th> <th></th> <th></th>
                </thead>
                <tbody>
                  <tr>
                    <td>Paket Premium</td> <td width="1%">x</td> <td>1</td>
                    <td style="text-align:right; font-size:15px; font-weight:bold;"> Rp. 3.200.000</td>
                  </tr>
                  <tr>
                    <td>Paket Special</td> <td width="1%">x</td> <td>1</td>
                    <td style="text-align:right; font-size:15px; font-weight:bold;"> Rp. 3.500.000</td>
                  </tr>
                </tbody>
                <tbody>
                  <tr>
                    <th class="subtotal" style="padding-top: 13px !important">TOTAL AKHIR</th>
                    <td></td> <td></td>
                    <td class="subtotal" style="text-align:right; font-size:17px; font-weight:bold;"> <strong>Rp. 6.700.000</strong></td>
                  </tr>
                </tbody>
              </table>

              <table class="table table-striped table-hover">
                <thead>
                  <th> PEMESAN </th> <th></th> <th></th>
                </thead>
                <tbody>
                  <tr>
                    <tr v-for="data, index in dataPemesan" style="text-transform: uppercase">
                      <td width="20%;">{{ data.judul }}</td> <td width="5%;">: </td>
                      <td>{{ data.isi }}</td>
                    </tr>
                  </tr>
                </tbody>
              </table>

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
      dataPesanan: [
        { header: 'Nomor Order', content: '#519' },
        { header: 'Tanggal', content: '27 Juli 2018' },
        { header: 'Total', content: 'Rp. 6.700.000' },
        { header: 'Metode Pembayaran', content: 'Transfer Bank' },
        { header: 'Bank', content: 'BNI SYARIAH' },
        { header: 'Nomor Rekening', content: '3737-8899-21' },
        { header: 'Atas Nama', content: 'Iwan Setiawan' },
      ],
      dataPemesan: [
        { judul: 'Kecamatan', isi: 'Kemiling' },
        { judul: 'Sumber Informasi', isi: 'Website' },
        { judul: 'Nama Peserta', isi: 'Muhammad Zamhari' },
        { judul: 'Tempat, Tanggal Lahir', isi: 'Lampung, 13 Juli 2015' },
        { judul: 'Jenis Kelamin', isi: 'Laki - Laki' },
        { judul: 'Nama Ayah', isi: 'Sujarwono' },
        { judul: 'Nama Ibu', isi: 'Siti Hanifah' },
        { judul: 'Lahir Di (Nama RSB / Bidan)', isi: 'RS Ibu dan Anak Asih' },
      ]
    }),
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
  
  table th{background:#da2921 !important; color:#fff !important; padding:5px !important;}
  .subtotal {background:#fff !important; color:#da2921 !important; padding-top:13px !important;}
  table td{background:#FFF !important; padding:10px !important;}


</style>
