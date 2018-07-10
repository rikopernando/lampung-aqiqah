<style lang="scss" scoped>

.md-toolbar.md-theme-default {
     background-color:#d21d24;
  }
  .md-toolbar.md-theme-default .md-title, .md-toolbar.md-theme-default .md-display-1, .md-toolbar.md-theme-default .md-display-2 {
    color: white;
    font-size: 25px;
    font-family: "Roboto", Sans-serif;
    font-weight: 600;
    align-items:center;
}
  .md-content {
    width: 200px;
    height: 200px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
  }
  .md-layout-item {
    height: 40px;

    &:nth-child(1) {
      background: md-get-palette-color(grey, 300);
    }

    &:nth-child(2) {
      background: md-get-palette-color(grey, 400);
    }

    &:nth-child(3) {
      background: md-get-palette-color(grey, 500);
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
  <div>
  <div >
    <vueper-slides fade slide-content-outside="top" slide-content-outside-class="max-widthed" :touchable="false" :slide-ratio="0.3">
      <vueper-slide 
          v-for="(slide, i) in slides" 
          :key="i" 
          :image="slide.image">
      </vueper-slide>
    </vueper-slides>
    <md-toolbar class="md-dense">
      <center><h3 class="md-title" >MENGAPA MEMILIH AQIQAH LAMPUNG?</h3></center>
    </md-toolbar>
    </div>
   <div class="md-layout">
    <div class="md-layout-item">

    </div>
    <div class="md-layout-item">  
        <md-icon class="md-size-2x fa fa-local_shipping"></md-icon><h3 class="headDesc"><b>Free Ongkir</b></h3>
      <p class="desc">Kami memberikan bebas biaya Pengiriman untuk wilayah Bandar Lampung dan sekitarnya dengan radius maksimal 30 KM</p>
    </div>
     <div class="md-layout-item">  

    </div>
     <div class="md-layout-item">  
    </div>
    <div class="md-layout-item">
    </div>
  </div>
  </div>
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