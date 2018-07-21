<template>
  <div>
      <Header></Header>

			<div v-bind:style="{ 'background-image': 'url(' + url+'/images/background-batik.jpg' + ')' }">
			  <div class="container ">
			  
	            <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
	              <div class="header-title md-toolbar-section-start"></div>
	              <div class="header-title md-toolbar-section-end">
	              	<div class="md-layout-item md-medium-size-50 md-small-size-100 md-xsmall-hide layout-filter">
	              	</div>
	                <div class="md-layout-item md-medium-size-50 md-small-size-100 md-xsmall-hide layout-filter">
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



			    <div class="md-layout ">
			        <div class="md-layout-item md-medium-size-25 md-small-size-50 md-xsmall-size-100">
			           <md-card md-with-hover  class="card-hover">
			                    <md-card-header class="card-header">
			                            <div class="md-title">Paket Superman</div>
			                            </md-card-header>

			                            <md-card-media class="card-media">
			                                <img :src="url+'/images/paketExample2.png'" class="image">
			                            </md-card-media>

			                            <md-card-actions class="card-action">
			                          <md-button class="md-raised md-accent">Beli Sekarang</md-button>
			                    </md-card-actions>
			            </md-card>
			        </div>

			        <div class="md-layout-item md-medium-size-25 md-small-size-50 md-xsmall-size-100">
			              <md-card md-with-hover  class="card-hover">
			                      <md-card-header class="card-header">
			                                <div class="md-title">Paket Superman</div>
			                            </md-card-header>

			                            <md-card-media class="card-media">
			                                <img :src="url+'/images/paketExample.png'" class="image">
			                            </md-card-media>

			                            <md-card-actions class="card-action">
			                         <md-button class="md-raised md-accent">Beli Sekarang</md-button>
			                      </md-card-actions>
			               </md-card>
			        </div>

			        <div class="md-layout-item md-medium-size-25 md-small-size-50 md-xsmall-size-100">
			                 <md-card md-with-hover  class="card-hover">
			                            <md-card-header class="card-header">
			                                <div class="md-title">Paket Spesial</div>
			                            </md-card-header>

			                            <md-card-media class="card-media">
			                                <img :src="url+'/images/paketSpesial.png'" class="image">
			                            </md-card-media>

			                            <md-card-actions class="card-action">
			                      <md-button class="md-raised md-accent">Beli Sekarang</md-button>
			                            </md-card-actions>
			                  </md-card>
			        </div>

			        <div class="md-layout-item md-medium-size-25 md-small-size-50 md-xsmall-size-100">
			                 <md-card md-with-hover  class="card-hover">
			                            <md-card-header class="card-header">
			                                <div class="md-title">Paket Spesial</div>
			                            </md-card-header>

			                            <md-card-media class="card-media">
			                                <img :src="url+'/images/paketSpesial.png'" class="image">
			                            </md-card-media>

			                            <md-card-actions class="card-action">
			                      <md-button class="md-raised md-accent">Beli Sekarang</md-button>
			                            </md-card-actions>
			                  </md-card>
			        </div>
			    </div>
			  </div>
		</div>
      <Footer></Footer>
  </div>
</template>


<script>

    import Header from '../header'
    import Footer from '../Footer/Footer'


    export default {
	data : () => {
		return {
			url : window.location.origin + window.location.pathname,
			filter_produk: 'populer',
		}
	},
	mounted() {
	      console.log(this.url)
	},
    components : {
        Header, Footer
      }
    }
</script>

<style scoped>
  .md-card {
    border-radius: 10px;
    margin: 4px;
    flex-wrap: wrap;
  }

  .image {
    padding: 10px;
  }
  
  .card-action {
    padding : 10px;
  }
  
  .card-row {
    display: flex;
    flex-wrap: wrap;
    margin: auto;
  }

  .card-media {
    padding: 1px;
  }

  .card-hover {
    padding : 4px;
  }
</style>

<style scoped>
  .header-title {
    color: #867f7f;
    font-size: 20px;
    padding: 30px 0px 0px 10px;
  }

  	@media (max-width: 600px) {
		.layout-filter {
			display: block;
		}
	}
	@media (min-width: 601px) {
		.layout-filter {
			display: block;
		}	
	}
</style>

