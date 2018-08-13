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
                    Kambing sehat, cukup umur, dari peternakan sendiri, sertifikat dokter hewan
                  </li>
                  <li>
                    Kambing dapat dipilih dan dipotong langsung
                  </li>
                  <li>
                    5% dari keuntungan disalurkan ke zakat dan kegiatan sosial Islam
                  </li>
                  <li>
                    Menu pilihan : Malbi, Kare, Gule, Tongseng, Sop dan Sate
                  </li>
                  <li>
                    Pembelian dapat dilakukan melalui telepon, Whastapp
                  </li>
                  <li>
                    Pembayaran dapat dilakukan secara Cash maupun Transfer
                  </li>
                  <li>
                    Bersedia menyalurkan aqiqah Anda ke rumah yatim piatu dan dhuafa
                  </li>
                  <li>
                    Gratis biaya potong dan antar (Wilayah Bandar Lampung), wilayah tertentu dikenakan ongkos kirim
                  </li>
                  <li>
                    Sertifikat Aqiqah dan Risalah Aqiqah
                  </li>
                  <li>
                    Kerjasama dengan lembaga amil zakat Dompet Dhuafa, Yatim Mandiri, dan DPU Darut Tauhid
                  </li>
                  <li>
                    Mendapatkan Sertifikat Aqiqah dan Mugh yang sangat cantik.
                  </li>
                  <li>
                    Terdapat Taman Bermain untuk anak-anak.
                  </li>
                  <li>
                    Menyediakan area selfi dengan Objek 3 Dimensi, Objek hewan (burung, kelinci, kambing perah) dll.
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
