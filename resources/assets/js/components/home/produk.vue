<style scoped>
  .layer {
    background-color: rgba(248, 247, 216, 0.72);
  }
</style>

<template>
  <div v-bind:style="background">
        <div class="produk-modal-container" id="produk-modal" >
            <div class="produk-modal">
                <div class="title-produk">
                     <div class="md-toolbar-section-start"></div>
                    {{ this.$store.state.detailproduk.detailProduk.nama_produk  }}
                     <div class="md-toolbar-section-end" style="padding:10px">
                          <button type="button" @click="closeModalProduk" class="btn btn-danger btn-lg" >X </button>
                     </div>
                </div>
                <md-empty-state v-if="this.$store.state.detailproduk.loadingModal">
                              <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
              </md-empty-state>
                <div class="form-produk" id="form-produk">
                  <div class="row">
                    <div class="col-md-6">
                            <img :src="url_picture+'/default.jpg'" v-if="this.$store.state.detailproduk.detailProduk.foto == null">
                            <img :src="url_picture+'/'+this.$store.state.detailproduk.detailProduk.foto" v-else>
                    </div>
                    <div class="col-md-6">
                      <h3> <strike style="color: #636363;">Rp {{ this.$store.state.detailproduk.detailProduk.harga_coret | pemisahTitik }}</strike> Rp {{ this.$store.state.detailproduk.detailProduk.harga_jual | pemisahTitik }} </h3>
                      <p class="desc">
                      {{ this.$store.state.detailproduk.detailProduk.deskripsi_produk }}
                      </p>
                      <input type="number" name="jumlah_produk" ref="jumlah_produk" class="jumlah_produk" v-model="jumlah_produk" >
                      <button @click="createKeranjangDetail(id_detail)" class="btn-add-cart">Masukan Ke Keranjang</button>
                    </div>
                  </div>
                </div>
            </div>
        </div>

  <div class="layer">
      <div class="container">
            <div class="md-medium-size-50 md-small-size-50 md-xsmall-hide" style="margin:30px">
              <md-empty-state v-if="this.$store.state.daftarproduk.loading">
                    <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
               </md-empty-state>

              <div v-for="produk in produks">
                  <div class="col-md-3 col-sm-6 col-xs-6" style="padding: 25px 15px">
                      <div class="md-layout-item">
                       <md-card md-with-hover>
                          <div id="card-atas" @click="openModalProduk(produk.id)">
                           <md-card-media class="card-image" >
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
                           </div>
                           <div id="card-bawah">
                           <md-card-actions class="card-action">
                             <md-button @click="createKeranjang(produk.id)" class="beli-sekarang" style="background-color: #db4a24; color: white">
                               Masuk Keranjang <span class="bg"></span>
                             </md-button>
                           </md-card-actions>
                         </div>
                         </md-card>
                      </div>
                  </div>
                </div>
            </div>

            <div id="displayMobile" style="margin:30px">

               <md-empty-state v-if="this.$store.state.daftarproduk.loading">
                    <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
               </md-empty-state>

                <div v-for="produk in produks">
                  <div class="col-xs-6" style="padding: 25px 5px">
                      <div class="md-layout-item">
                         <md-card md-with-hover>
                          <div id="card-atas" @click="openModalProduk(produk.id)">
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
                         </div>
                         <div id="card-bawah" >
                           <md-card-actions class="card-action">
                             <md-button  @click="createKeranjang(produk.id)" class="md-raised beli-sekarang">
                               Masuk Keranjang
                             </md-button>
                           </md-card-actions>
                         </div>
                         </md-card>
                      </div>
                  </div>
                </div>
              </div>

            <!-- Snackbar for Bank delete alert -->
            <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="snackbarBerhasil" md-persistent>
                <span>Produk Berhasil Masuk Keranjang !</span>
              </md-snackbar>
            <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="snackbarAdmin" md-persistent>
                <span>Untuk belanja produk silakan login sebagai pelanggan</span>
              </md-snackbar>
      </div>
      </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'

  export default {
    name: 'ElevationExample',
    data : () => {
      return {
        background : {
          backgroundImage: 'url(' + window.location.origin + window.location.pathname+'/images/background-produk.jpg' + ')' 
        },
        url : window.location.origin + window.location.pathname,
        url_picture : window.location.origin + (window.location.pathname) + "image_produks/",
        snackbarBerhasil: false,
        snackbarAdmin: false,
        jumlah_produk:0,
        id_detail:"",
      }
    },
    mounted() {
      this.$store.dispatch('daftarproduk/LOAD_DAFTAR_PRODUK',{tampil_produk :1 });
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
  computed : mapState ({
      produks(){
        return this.$store.state.daftarproduk.daftarProduk
      },
      is_admin(){
        return this.$store.state.user.is_admin
      }
  }),
  methods:{
      createKeranjang(id){
        if(this.is_admin) {
            this.snackbarAdmin = true;
        }else{
            this.$store.dispatch('keranjangbelanja/LOAD_CREATE_LIST',{id :id,jumlah_produk:1})
            this.snackbarBerhasil = true;
        }
      },
      openModalProduk(id_produk) {
          let app = this;
          $("#produk-modal").addClass('active')
          $('#form-produk').addClass('active')
          app.$store.dispatch('detailproduk/LOAD_DETAIL_PRODUK',{id:id_produk})
          app.jumlah_produk = 1;
          app.$refs.jumlah_produk.focus();
          app.id_detail = id_produk;
      },
      closeModalProduk() {
        $('#produk-modal').removeClass('active');
        app.id_detail = "";
      },
      createKeranjangDetail(id){
        console.log(id)
            var jumlah_produk = this.jumlah_produk;
            this.$store.dispatch('keranjangbelanja/LOAD_CREATE_LIST',{id :id,jumlah_produk:jumlah_produk})
            $('#produk-modal').removeClass('active');
            app.id_detail = "";
            this.snackbarBerhasil = true;
      },
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
.produk-modal-container * {
    box-sizing: border-box;
}
.produk-modal-container {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: 0;
    visibility: hidden;
    cursor: pointer;
    overflow-y: auto;
    z-index: 3;
    font-family:'Lato', 'Helvetica Neue', 'Helvetica', 'Arial', 'sans-serif';
    font-size: 14px;
    background-color: rgba(17, 17, 17, .9);
    -webkit-transition: all 0.25s linear;
    -moz-transition: all 0.25s linear;
    -o-transition: all 0.25s linear;
    -ms-transition: all 0.25s linear;
    transition: all 0.25s linear;
}
.produk-modal-container.active {
    opacity: 1;
    visibility: visible;
}
.produk-modal-container .produk-modal {
    position: relative;
    margin: 100px auto;
    width: 100%;
    max-width: 1000px;
    background-color: #f6f6f6;
    cursor: initial;
}
.produk-modal-container .form-produk{
    padding: 75px 25px 25px;
    display: none;
}
.produk-modal-container .form-produk.active{
    display: block;
}
.produk-modal-container div.title-produk {
    margin: 0;
    padding: 0;
    list-style: none;
    display: inline-block;
    width: 50%;
    float: left;
    width: 100%;
    display: block;
    height: 50px;
    line-height: 50px;
    color: #666666;
    background-color: #dddddd;
    text-align: center;
    font-size : 25px;
    font-weight : 5px;
}
  .desc{
    color: #7a7a7a;
    font-family: "Gill Sans", sans-serif;
    font-weight: 400;
    font-size : 17px;
}
.jumlah_produk {
    text-align : center;
    justify-content : center;
    border-width : 2px;
    width : 15%;
    border-color : #7a7a7a;
    padding : 9px;
    font-size : 19px;
    margin-bottom : 10px;
}
.btn-add-cart {
    color: #f6f6f6;
    border: 0;
    background-color: #ff5252;
    cursor: pointer;
    text-align : center;
    padding : 10px;
    font-size : 17px;
    margin-bottom : 10px;
}
.btn-add-cart:hover {
    background-color: #d21d24;
}
.btn-add-cart:active {
    background-color:  #e60000;
}
</style>
