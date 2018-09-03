
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
    width: 50%;
    height: 50%;
    display: block;
    background: md-get-palette-color(purple, 200);
    content: " ";
  }
}
.desc{
  color: #7a7a7a;
  font-family: "Gill Sans", sans-serif;
  font-weight: 400;
}
.headDesc{
  color: #d21d24;
  font-size: 25px;
  font-family: "Gill Sans", sans-serif;
  font-weight: 400;
}
/*MOBILE VERSION*/
@media (max-width: 600px) {
  .md-toolbar.md-theme-default .md-title  { font-size: 15px; }
}
@media (min-width: 600px) {
  .md-toolbar.md-theme-default .md-title  { font-size: 25px; }
}

</style>

<template>
  <div >
    <div>
       <center v-if="this.$store.state.setting_perusahaan.loading">
            <md-progress-spinner :md-diameter="100" :md-stroke="10" md-mode="indeterminate"></md-progress-spinner>
            <p style="font-style:italic;">Mohon Tunggu ...</p>
       </center>

      <vueper-slides fade slide-content-outside="top" slide-content-outside-class="max-widthed" :touchable="false" :slide-ratio="0.2" autoplay :bullets="false" v-else>
        <vueper-slide
            v-for="(slide, i) in slides" 
            :key="i" 
            :image="slide.image">
        </vueper-slide>
      </vueper-slides>

      <md-toolbar class="md-dense">
        <div class="md-toolbar-section-start"></div>
        <h3 class="md-title"><b>MENGAPA MEMILIH AQIQAH LAMPUNG ?</b></h3>
         <div class="md-toolbar-section-end"></div>
      </md-toolbar>
    </div>
    <!-- class div slider-->
    
    <!-- class container-->
    <div class="container">
      <div class="md-layout md-gutter md-alignment-center ">
        <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">        
          <h2 class="headDesc"><i class="fa fa-truck"></i> Free Ongkir</h2>
          <p class="desc">Kami memberikan bebas biaya Pengiriman untuk wilayah Bandar Lampung dan sekitarnya dengan radius maksimal 30 KM</p>
        </div>
        <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100"> 
          <h2 class="headDesc"><i class="fa fa-clock-o"></i> Tepat Waktu</h2>
          <p class="desc">Pesanan kami antar sesuai permintaan secara langsung dan dikirim sesuai jadwal ke alamat Pemesan Layanan Aqiqah</p>
        </div>
        <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100"> 
          <h2 class="headDesc"><i class="fa fa-thumbs-up"></i> Citarasa Istimewa</h2>
          <p class="desc">Daging Aqiqah dimasak menggunakan bumbu tradisional dan rempah-rempah alami oleh juru masak berpengalaman</p>
        </div>
      </div>

      <div class="md-layout md-gutter md-alignment-center">
        <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">        
          <h2 class="headDesc"><i class="fa fa-book"></i> Sesuai Syar'i</h2>
          <p class="desc">Hewan Aqiqah disembelih sesuai standar syar’i dan kesehatan, dan di lakukan oleh Team kami yang berpengalaman</p>
        </div>
        <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">
        <h2 class="headDesc"><i class="fa fa-child"></i> Memberdayakan</h2>
          <p class="desc">Dengan memesan layanan aqiqah kepada kami berarti  telah ikut meningkatkan kesejahteraan peternak lokal</p>
        </div>
        <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100"> 
          <h2 class="headDesc"><i class="fa fa-group"></i> Peduli Sesama</h2>
          <p class="desc">Aqiqah Peduli mendistribusikan aqiqah Anda ke daerah miskin, daerah rawan gizi, Rumah Yatim Piatu, Pondok Pesantren</p>  
        </div>
      </div>

      <div class="md-layout md-gutter md-alignment-center">
        <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">
          <h2 class="headDesc"><i class="fa fa-video-camera"></i> Dokumentasi</h2>
          <p class="desc">Kami dokumentasikan pemotongan untuk ayah bunda jika tidak bisa menyaksikan pemotongan secara langsung</p>
        </div>
        <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">
          <h2 class="headDesc"><i class="fa fa-credit-card-alt"></i> Pembayaran Mudah</h2>
          <p class="desc">Pembayaran dapat dilakukan dengan cara transfer dengan fitur Invoice dan konfirmasi pembayaran secara Real-Time</p>
        </div>
        <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100"> 
          <h2 class="headDesc"><i class="fa fa-puzzle-piece"></i> Pilihan Paket</h2>
            <p class="desc">Anda dapat memilih paket sesuai keinginan, Anda juga bisa berkonsultasi dengan customer service kami.</p>  
        </div>
      </div>
    </div>
    <!-- class container-->
    
    <md-toolbar class="md-dense">
      <div class="md-toolbar-section-start"></div>
        <h3 class="md-title"><b>PRODUK TERBARU</b></h3>
      <div class="md-toolbar-section-end"></div>
    </md-toolbar>
  </div>
  <!-- class div template-->
</template>

<script>
  import { VueperSlides, VueperSlide } from 'vueperslides'
  import { mapState } from 'vuex'
  export default {
    components: { VueperSlides, VueperSlide },
    data : () => {
      return {
        slides : []
      }
    },
    computed : mapState ({
       setting_perusahaan () {
        return this.$store.state.setting_perusahaan.data
       },
    }),
    watch : {
      setting_perusahaan : function () {
        if(Object.keys(this.setting_perusahaan).length){
          this.setData(this.setting_perusahaan)
        }
      }
    },
    methods : {
      setData(slide){
          let url = window.location.origin + window.location.pathname
          let data = [
            {
              title: 'Slider 1',
              content: 'Slide Content',
              image : `${url}images_slide/${slide.foto_slide_1}`,
            },{
              title: 'Slider 2',
              content: 'Slide Content',
              image : `${url}images_slide/${slide.foto_slide_2}`,
            },{
              title: 'Slider 3',
              content: 'Slide Content',
              image : `${url}images_slide/${slide.foto_slide_3}`,
            }
          ]
          this.slides = data
      }
    }
}
</script>
