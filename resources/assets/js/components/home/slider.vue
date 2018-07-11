
<style lang="scss" scoped>
.md-toolbar.md-theme-default {
     background-color:#d21d24;
  }
  .md-toolbar.md-theme-default .md-title, .md-toolbar.md-theme-default .md-display-1, .md-toolbar.md-theme-default .md-display-2 {
    color: white;
    font-size: 25px;
    font-family: "Roboto", Sans-serif;
    padding: 600;
}
.md-title {
    font-size: 20px;
    font-weight: 500;
    letter-spacing: .0001em;
    line-height: 26px;
}
  .md-content {
    width: 200px;
    height: 200px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
  }
 .md-layout-item {
    height: 80px;
    margin-top: 10px;
    margin-bottom: 50px;

    &:after {
      width: 100%;
      height: 100%;
      display: block;
      background: md-get-palette-color(purple, 200);
      content: " ";
    }
  }
  .desc{
      color: #7a7a7a;
      font-family: "Roboto", Sans-serif;
      font-weight: 400;
  }
  .headDesc{
      color: #d21d24;
      font-size: 25px;
      font-weight: 400;
  }

</style>

<template>
  <div >
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
      <div><!-- class div slider-->
            <vueper-slides fade slide-content-outside="top" slide-content-outside-class="max-widthed" :touchable="false" :slide-ratio="0.2">
              <vueper-slide 
                  v-for="(slide, i) in slides" 
                  :key="i" 
                  :image="slide.image">
              </vueper-slide>
            </vueper-slides>
            <md-toolbar class="md-dense">
              <h3 class="md-title"><b>MENGAPA MEMILIH AQIQAH LAMPUNG ?</b></h3>
            </md-toolbar>
     </div><!-- class div slider-->
    <div class="container"><!-- class container-->
           <div class="md-layout md-gutter md-alignment-center ">
            <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">        
              <h2 class="headDesc"><b><i class="fa fa-car icon-link"></i> Free Ongkir</b></h2>
              <p class="desc">Kami memberikan bebas biaya Pengiriman untuk wilayah Bandar Lampung dan sekitarnya dengan radius maksimal 30 KM</p>
            </div>
            <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100"> 
              <h2 class="headDesc"><b><i class="fa fa-clock-o icon-link"></i> Tepat Waktu</b></h2>
              <p class="desc">Pesanan kami antar sesuai permintaan secara langsung dan dikirim sesuai jadwal ke alamat Pemesan Layanan Aqiqah</p>
            </div>
            <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100"> 
              <h2 class="headDesc"><b><i class="fa fa-thumbs-up icon-link"></i> Citarasa Istimewa</b></h2>
              <p class="desc">Daging Aqiqah dimasak menggunakan bumbu tradisional dan rempah-rempah alami oleh juru masak berpengalaman</p>
            </div>
          </div>

          <div class="md-layout md-gutter md-alignment-center">
            <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">        
               <h2 class="headDesc"><b><i class="fa fa-book icon-link"></i> Sesuai Syar'i</b></h2>
              <p class="desc">Hewan Aqiqah disembelih sesuai standar syar’i dan kesehatan, dan di lakukan oleh Team kami yang berpengalaman</p>
            </div>
            <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">
            <h2 class="headDesc"><b><i class="fa fa-child icon-link"></i> Memberdayakan</b></h2>
              <p class="desc">Dengan memesan layanan aqiqah kepada kami berarti  telah ikut meningkatkan kesejahteraan peternak lokal</p>
            </div>
            <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100"> 
             <h2 class="headDesc"><b><i class="fa fa-group icon-link"></i> Peduli Sesama</b></h2>
              <p class="desc">Aqiqah Peduli mendistribusikan aqiqah Anda ke daerah miskin, daerah rawan gizi, Rumah Yatim Piatu, Pondok Pesantren</p>  
            </div>
          </div>

          <div class="md-layout md-gutter md-alignment-center">
            <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">
                <h2 class="headDesc"><b><i class="fa fa-video-camera icon-link"></i> Dokumentasi</b></h2>
                <p class="desc">Kami dokumentasikan pemotongan untuk ayah bunda jika tidak bisa menyaksikan pemotongan secara langsung</p>
            </div>
            <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">
            <h2 class="headDesc"><b><i class="fa fa-credit-card-alt icon-link"></i> Pembayaran Mudah</b></h2>
            <p class="desc">Pembayaran dapat dilakukan dengan cara transfer dengan fitur Invoice dan konfirmasi pembayaran secara Real-Time</p>
            </div>
            <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100"> 
          <h2 class="headDesc"><b><i class="fa fa-puzzle-piece icon-link"></i> Pilihan Paket</b></h2>
              <p class="desc">Anda dapat memilih paket sesuai keinginan, Anda juga bisa berkonsultasi dengan customer service kami.</p>  
            </div>
          </div>

    </div><!-- class container-->
     <md-toolbar class="md-dense">
              <h3 class="md-title"><b>PRODUK TERBARU</b></h3>
     </md-toolbar>
  </div><!-- class div template-->
</template>

<script>
  import { VueperSlides, VueperSlide } from 'vueperslides'
  export default {
    components: { VueperSlides, VueperSlide },

    data : () => {
      return {
          slides : [
               {
                  title: 'Slider 1',
                  content: 'Slide Content',
                  image : 'http://aqiqahlampung.co.id/wp-content/uploads/slider2/banner-web-crop.jpeg'
               },
               {
                  title: 'Slider 1',
                  content: 'Slide Content',
                  image: 'https://aqiqahlampung.co.id/wp-content/uploads/2018/04/banner-sate-crop.jpg'
               },
               {
                  title: 'Slider 1',
                  content: 'Slide Content',
                  image: 'https://aqiqahlampung.co.id/wp-content/uploads/2018/04/menu1-1.png'
               }
           ]
      }

   },
   mounted() {
     console.log(this.slides)
   }
  }
</script>