<template>
  <div v-bind:style="{ 'background-image': 'url(' + url+'/images/background-batik.jpg' + ')' }">
  <div class="container">
       
        <div class="md-medium-size-50 md-small-size-50 md-xsmall-hide" style="margin:30px">
          <div v-for="produk in produks">
              <div class="col-md-3 col-sm-6 col-xs-6" style="padding: 25px 15px">
                  <div class="md-layout-item">
                     <md-card md-with-hover>
                       <md-card-media class="card-image">
                          <md-card md-with-hover style="margin-top: -50px!important">
                            <img :src="url_picture+'/default.jpg'" class="image" v-if="produk.foto == null">
                            <img :src="url_picture+'/'+produk.foto" class="image" v-else>
                          </md-card>
                       </md-card-media>
                       <p class="flexFont">
                         <center> {{ produk.nama_produk | capitalize }} </center>
                       </p>
                       <md-card-actions class="card-action">
                         <div class="md-toolbar-section-start harga-coret">Rp {{ produk.harga_coret | pemisahTitik }} </div>
                         <div class="md-toolbar-section-end harga-jual">Rp {{ produk.harga_jual | pemisahTitik }} </div>
                       </md-card-actions>
                       <md-card-actions class="card-action">
                         <md-button @click="createKeranjang(produk.id)" class="beli-sekarang" style="background-color: #db4a24; color: white">
                           Add To Chart <span class="bg"></span>
                         </md-button>
                       </md-card-actions>
                     </md-card>
                  </div>
              </div>
            </div>
        </div>

        <div id="displayMobile" style="margin:30px">
            <div v-for="produk in produks">
              <div class="col-md-3 col-sm-6 col-xs-6" style="padding: 25px 5px">
                  <div class="md-layout-item">
                     <md-card md-with-hover>
                       <md-card-media class="card-image">
                          <md-card md-with-hover style="margin-top: -50px!important">
                            <img :src="url_picture+'/default.jpg'" class="image" v-if="produk.foto == null">
                            <img :src="url_picture+'/'+produk.foto" class="image" v-else>
                          </md-card>
                       </md-card-media>
                       <p class="flexFont">
                         <center> {{ produk.nama_produk | capitalize }} </center>
                       </p>
                       <md-card-actions class="card-action">
                         <div class="md-toolbar-section-start harga-coret"> {{ produk.harga_coret | pemisahTitik }} </div>
                         <div class="md-toolbar-section-end harga-jual"> {{ produk.harga_jual | pemisahTitik }} </div>
                       </md-card-actions>
                       <md-card-actions class="card-action">
                         <md-button  @click="createKeranjang(produk.id)" class="md-raised beli-sekarang">
                           Add To Chart
                         </md-button>
                       </md-card-actions>
                     </md-card>
                  </div>
              </div>
            </div>
          </div>

        <!-- Snackbar for Bank delete alert -->
        <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="snackbarBerhasil" md-persistent>
            <span>Produk Berhasil Masuk Keranjang !</span>
          </md-snackbar>
  </div>
  </div>
</template>

<script>
  export default {
    name: 'ElevationExample',
    data : () => {
      return {
        url : window.location.origin + window.location.pathname,
        url_picture : window.location.origin + (window.location.pathname) + "image_produks/",
        produks:[],
        loading: true,
        snackbarBerhasil: false,
      }
    },
    mounted() {
      this.getProdukTerbaruData();
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
  methods:{
        getProdukTerbaruData() {
        axios.get(this.url + 'produk/view-produk-terbaru')
        .then(resp => {
          this.produks = resp.data;
          this.loading = false;
        })
        .catch(resp => {
          console.log('catch getProdukData:', resp);
        });
      },
      createKeranjang(id){
        axios.post(this.url + 'keranjang-belanja/create/'+id)
        .then(resp => {
          this.snackbarBerhasil = true;
        })
        .catch(resp => {
          console.log('Terjadi Kesalahan :', resp);
        })
      }
  }
}


  function flexFont () {
    var divs = document.getElementsByClassName("flexFont");
      for(var i = 0; i < divs.length; i++) {
        var relFontsize = divs[i].offsetWidth*0.08;
        divs[i].style.fontSize = relFontsize+'px';
      }
  };

  window.onload = function(event) {
      flexFont();
  };
  window.onresize = function(event) {
      flexFont();
  };
</script>


<style scoped>
  .md-card {
    border-radius: 10px;
    flex-wrap: wrap;
  }
  .flexFont {
    height:3em;
    padding:3%;
    margin: 5px;
    font-family: Helvetica,Arial,sans-serif;
  }
  .card-image {
    padding: 10px;
    position: relative;
  }
  img {
    border-radius: 10px;
  }

  /*MOBILE CSS*/
  @media (max-width: 600px) {
    .md-xsmall-hide { display: none; }
    #displayMobile { display: block; }
    .container {
      padding: 0px !important;
    }
    .beli-sekarang {
      background-color: rgb(219, 74, 36) !important;
      color: white !important;
      width: 100%;
      height: 25px;
      border-radius: 5px;
      font-size: 12px;
    }
    .harga-coret {
      text-decoration: line-through;
      color: #636363;
      font-size: 12px;
    }
    .harga-jual {
      color: #FF3100;
      font-size: 12px;
    }
  }

  /* DEKSTOP CSS */
  @media (min-width: 600px) {
    #displayMobile { display: none; }

    .beli-sekarang {
      background-color: rgb(219, 74, 36);
      color: white;
      width: 100%;
      height: 35px;
      border-radius: 5px;
      font-size: 15px;
    }
    .harga-coret {
      text-decoration: line-through;
      color: #636363;
      font-size: 15px;
    }
    .harga-jual {
      color: #FF3100;
      font-size: 15px;
    }
  }
</style>


