<template>
  <div>
    <Header/>

      <div class="container">
        <md-card md-with-hover>
          <ul class="breadcrumb">
            <li><router-link :to="{name: 'home'}">Home</router-link></li>
            <li class="active">Tentang Kami</li>
          </ul>
        </md-card>

        <div class="row">
          <div class="col-md-6 col-xs-12">
            <md-tabs class="md-transparent" md-alignment="fixed">
              <md-tab id="tab-home" md-label="Tentang Kami">
                <p>
                  Lampung Aqiqah adalah layanan aqiqah, catering dan hewan qurban yang berasal dari Bandar Lampung. Kami sudah memiliki banyak pengalaman menangani Paket Aqiqah untuk wilayah Bandar Lampung dan sekitarnya.
                </p>

                <p>
                  Keunggulan kami adalah kami memiliki peternakan sendiri, kambing yang dijual adalah berasal dari peternakan yang kami kelola dan kami jaga kualitasnya. Dari segi pangan hewan hingga cek kesehatan dari dokter hewan secara berkala.
                </p>

                <p>
                  Paket Aqiqah dari kami juga tersedia beragam pilihan yang dapat memudahkan Anda. Menu dapat disesuaikan dengan selera dan keinginan Anda.
                </p><br><br><br>
              </md-tab>
            </md-tabs>
          </div>
          <div class="col-md-6 col-xs-12">
            <md-tabs class="md-transparent" md-alignment="fixed">
              <md-tab id="tab-pages" md-label="Keunggulan Kami">
                <ol>
                  <li>
                    Kami memberikan bebas biaya Pengiriman untuk wilayah Bandar Lampung dan sekitarnya dengan radius maksimal 30 KM
                  </li>
                  <li>
                    Pesanan kami antar sesuai permintaan secara langsung dan dikirim sesuai jadwal ke alamat Pemesan Layanan Aqiqah
                  </li>
                  <li>
                    Daging Aqiqah dimasak menggunakan bumbu tradisional dan rempah-rempah alami oleh juru masak berpengalaman
                  </li>
                  <li>
                    Hewan Aqiqah disembelih sesuai standar syar’i dan kesehatan, dan di lakukan oleh Team kami yang berpengalaman
                  </li>
                  <li>
                    Dengan memesan layanan aqiqah kepada kami berarti telah ikut meningkatkan kesejahteraan peternak lokal
                  </li>
                  <li>
                    Aqiqah Peduli mendistribusikan aqiqah Anda ke daerah miskin, daerah rawan gizi, Rumah Yatim Piatu, Pondok Pesantren
                  </li>
                  <li>
                    Kami dokumentasikan pemotongan untuk ayah bunda jika tidak bisa menyaksikan pemotongan secara langsung
                  </li>
                  <li>
                    Pembayaran dapat dilakukan dengan cara transfer dengan fitur Invoice dan konfirmasi pembayaran secara Real-Time
                  </li>
                  <li>
                    Anda dapat memilih paket sesuai keinginan, Anda juga bisa berkonsultasi dengan customer service kami.
                  </li>
                </ol>
              </md-tab>
            </md-tabs>
          </div>
        </div>
      </div>

    <Footer/>
  </div>
</template>

<script>
  import Header from '../header'
  import Footer from '../footer/footer'

  export default {
    components : {
      Header, Footer
    }
  }
</script>

<style scoped>
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
</style>
