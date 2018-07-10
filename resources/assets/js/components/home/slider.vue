<template>
    <vueper-slides autoplay :infinite="false" :bullets-outside="true">
      <vueper-slide 
          v-for="(slide, i) in slides" 
          :key="i" 
          :image="slide.image">
      </vueper-slide>
    </vueper-slides>
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
                  image : 'https://aqiqahlampung.co.id/wp-content/uploads/2018/04/menu5.png'
               },
               {
                  title: 'Slider 1',
                  content: 'Slide Content',
                  image: 'https://aqiqahlampung.co.id/wp-content/uploads/2018/04/menu4.png'
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

<style lang="scss" scoped>
.vueperslides__bullet {
  background-color: rgba(0, 0, 0, 0.3);
  border: none;
  box-shadow: none;
  transition: 0.3s;
  width: 16px;
  height: 16px;
}

.vueperslides__bullet--active {
  background-color: #ff5252;
}

.vueperslides__bullet span {
  display: block;
  color: #fff;
  font-size: 10px;
  opacity: 0.8;
}

</style>

