<template>
  <div>
    <Header></Header>

      <div class="background" v-bind:style="{ 'background-image': 'url(' + url+'/images/background-batik.jpg' + ')' }">
        <div class="container">

          <div class="md-medium-size-50 md-small-size-50 md-xsmall-hide">
            <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
              <div class="header-title md-toolbar-section-start">

              </div>
              <div class="header-title md-toolbar-section-end">
                  <div class="md-layout-item layout-filter"></div>
  	                <div class="md-layout-item layout-filter">
  	                	<md-field>
  		                   <md-select v-model="filter_produk" name="filter_produk" id="filter_produk">
      						            <md-option value="populer">Urutkan Terpopuler</md-option>
      						            <md-option value="murah">Urutkan Termurah</md-option>
      						            <md-option value="mahal">Urutkan Termahal</md-option>
      						            <md-option value="baru">Urutkan Terbaru</md-option>
      		         			 </md-select>
                    	</md-field>
  	                </div>
  	           </div>
  	        </div>

            <div v-for="produk in produks">
              <div class="col-md-3 col-xs-6" style="padding: 25px 15px">
                  <div class="md-layout-item">
                     <md-card md-with-hover>
                       <md-card-media class="card-image">
                          <md-card md-with-hover style="margin-top: -50px!important">
                            <img :src="url_picture+'/default.jpg'" class="image" v-if="produk.foto == null">
                            <img :src="url_picture+'/'+produk.foto" class="image" v-else>
                          </md-card>
                       </md-card-media>
                       <div class="flexFont" style="font-size: 18px; margin-top: 0px">
                         <center> {{ produk.nama_produk | capitalize }} </center>
                       </div>
                       <md-card-actions class="card-action">
                         <div class="md-toolbar-section-start flexFont harga-coret">Rp {{ produk.harga_coret | pemisahTitik }} </div>
                         <div class="md-toolbar-section-end flexFont harga-jual">Rp {{ produk.harga_jual | pemisahTitik }} </div>
                       </md-card-actions>
                       <md-card-actions class="card-action">
                         <md-button class="beli-sekarang" style="background-color: #db4a24; color: white">
                           Add To Chart <span class="bg"></span>
                         </md-button>
                       </md-card-actions>
                     </md-card>
                  </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    <Footer></Footer>
  </div>
</template>

<script type="text/javascript">
  import Header from '../header'
  import Footer from '../footer/footer'

  export default {
  	data : () => ({
  			url : window.location.origin + window.location.pathname,
        url_picture : window.location.origin + (window.location.pathname) + "image_produks/",
  			filter_produk: 'populer',
        produks: [],
        loading: true
  	}),
  	mounted() {
      this.getProdukData()
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
    methods: {
      getProdukData() {
    		axios.get(this.url + 'produk/view')
    		.then(resp => {
    			this.produks = resp.data;
    			this.loading = false;
    		})
    		.catch(resp => {
    			console.log('catch getProdukData:', resp);
    		});
    	}
    },
    components : {
      Header, Footer
    }
  }

  /*
    FLEXFONT
  */
  var divs = document.getElementsByClassName("flexFont");
  for(var i = 0; i < divs.length; i++) {
    var relFontsize = divs[i].offsetWidth*0.08;
    divs[i].style.fontSize = relFontsize+'px';
  }
</script>

<style scoped>
  .md-card {
    border-radius: 10px;
    flex-wrap: wrap;
  }
  .flexFont {
    padding:3%;
    margin: 5px;
  }
  .beli-sekarang {
    position: relative;
    z-index: 1;
    float: right;
    display: inline-block;
    font-size: 13px;
    font-weight: 900;
    text-transform: uppercase;
    padding: 12px 18px;
    cursor: pointer;
    transition: all .3s ease-in-out;
    line-height: .95;
    border: none;
    background: none;
    outline: none;
    border: 1px solid #FF3100;
    border-radius: 20px;
    overflow: hidden;
    width: 100%;
  }
  .harga-coret {
    text-decoration: line-through;
    color: #b9b2b0;
    font-size: 15px;
  }
  .harga-jual {
    color: #FF3100;
    font-size: 15px;
  }
  .card-image {
    padding: 10px;
    position: relative;
  }

  /*MOBILE VERSION*/
  @media (max-width: 600px) {
    .md-xsmall-hide { display: none; }
    #displaySidenav { display: block; }
  }
  @media (min-width: 600px) {
    #displaySidenav { display: none; }
  }
</style>
