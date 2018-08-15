<template>
  <div v-bind:style="{ 'background-image': 'url(' + url+'/images/background-batik.jpg' + ')' }">
      <div class="row">
          <div class="col-md-12">
            <md-toolbar class="md-dense">
              <div class="md-toolbar-section-start"></div>
                <h3 class="md-title"><b>TESTIMONIAL</b></h3>
              <div class="md-toolbar-section-end"></div>
            </md-toolbar>

              <div class="carousel slide" data-ride="carousel" id="quote-carousel">
                  <!-- Carousel Slides / Quotes -->
                  <div class="carousel-inner text-center">
                    <!-- Quote -->
                    <div v-for="data, index in daftarTestimoni" class="item active" v-if="index == 0">
                      <ol class="carousel-indicators image">
                        <li data-target="#quote-carousel" data-slide-to="2"  v-if="data.foto != null">
                          <img class="img-responsive" :src="url+'image_produks/'+data.foto" alt="">
                        </li>

                        <li data-target="#quote-carousel" data-slide-to="2" v-else>
                          <img class="img-responsive" :src="url+'images/default-avatar.png'" alt="">
                        </li>
                      </ol>
                      <blockquote>
                          <div class="row">
                              <div class="col-sm-8 col-sm-offset-2">
                                  <p> {{ data.testimoni | capitalize }} </p>
                                  <small> {{ data.nama_lengkap | capitalize }} </small>
                                  <small> {{ data.profesi | capitalize }} </small>
                              </div>
                          </div>
                      </blockquote>
                    </div>

                    <div v-for="data, index in daftarTestimoni" class="item" v-if="index > 0">
                      <ol class="carousel-indicators image">
                        <li data-target="#quote-carousel" data-slide-to="2"  v-if="data.foto != null">
                          <img class="img-responsive" :src="url+'image_produks/'+data.foto" alt="">
                        </li>

                        <li data-target="#quote-carousel" data-slide-to="2" v-else>
                          <img class="img-responsive" :src="url+'images/default-avatar.png'" alt="">
                        </li>
                      </ol>
                      <blockquote>
                          <div class="row">
                              <div class="col-sm-8 col-sm-offset-2">
                                  <p> {{ data.testimoni | capitalize }} </p>
                                  <small> {{ data.nama_lengkap | capitalize }} </small>
                                  <small> {{ data.profesi | capitalize }} </small>
                              </div>
                          </div>
                      </blockquote>
                    </div>
                  </div>
                  <!-- Carousel Buttons Next/Prev -->
                  <a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i class="fa fa-chevron-left"></i></a>
                  <a data-slide="next" href="#quote-carousel" class="right carousel-control"><i class="fa fa-chevron-right"></i></a>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'

  export default {
    data: () => ({
      url : window.location.origin + window.location.pathname,
      dataClass: 'item'
    }),
    mounted() {
      const app = this;

      app.$store.dispatch('testimoni/LOAD_TESTIMONI');
    },
    filters: {
      capitalize: (value) => {
        return value.replace(/(^|\s)\S/g, l => l.toUpperCase())
      }
    },
    computed: mapState ({
      daftarTestimoni() {
        const app = this;
        
        return app.$store.state.testimoni.daftarTestimoni;
      }
    }),
  }
</script>

<style scoped>
  .md-toolbar.md-theme-default {
    background-color:#d21d24;
  }
  .md-toolbar.md-theme-default .md-title, .md-toolbar.md-theme-default .md-display-1, .md-toolbar.md-theme-default .md-display-2 {
    color: white;
    font-size: 25px;
    font-family: "Roboto", Sans-serif;
    padding: 600;
  }
  #quote-carousel {
    padding: 0 10px 10% 10px;
    margin-top: 60px;
  }
  #quote-carousel .carousel-control {
    background: none;
    color: #d44722;
    font-size: 2.3em;

    text-shadow: none;
    margin-top: 10%;
  }
  #quote-carousel .carousel-indicators {
    position: relative;
    right: 50%;
    top: auto;
    bottom: 0px;
    margin-top: 20px;
    margin-right: -19px;
  }
  #quote-carousel .carousel-indicators.image li {
    width: 100px;
    height: 100px;
    cursor: pointer;
    border: 1px solid #ffffff;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    opacity: 1;
    overflow: hidden;
    transition: all .4s ease-in;
    vertical-align: middle;
  }
  .item blockquote {
    border-left: none;
    margin: 0;
  }
  .item blockquote p:before {
    content: "\f10d";
    font-family: 'Fontawesome';
    float: left;
    margin-right: 10px;
  }
  ol {
    margin : 10px 20% !important;
  }
</style>
