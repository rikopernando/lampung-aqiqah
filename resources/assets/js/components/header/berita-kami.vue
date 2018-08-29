<template>
  <div>
    <Header/>

      <div class="container">
      	 <md-card md-with-hover>
          <ul class="breadcrumb">
            <li><router-link :to="{name: 'home'}">Home</router-link></li>
            <li class="active">Berita Kami</li>
          </ul>
        </md-card>
          
          <center v-if="this.$store.state.berita.loading"><md-progress-spinner md-mode="indeterminate"></md-progress-spinner></center>

      	<div class="card-expansion">
			    <md-card class="content" v-for="berita, index in beritas" :key="index">
			      <md-card-media>
			      	<img :src="url+'images/default_berita.jpg'" alt="People" v-if="berita.foto == null">
			        <img :src="url_picture+'/'+berita.foto" alt="People" v-else>
			      </md-card-media>

			      <md-card-header>
			        <div class="md-title">{{ berita.judul_berita | capitalize | selengkapnya }} ...</div>
			      </md-card-header>

			      	<md-card-actions md-alignment="space-between">
			          <div>
			          	 <p style="color:grey;">{{ berita.created_at }}</p>
			          </div>

			          <md-card-expand-trigger>
			            <md-button>Learn more</md-button>
			          </md-card-expand-trigger>
			        </md-card-actions>
			    </md-card>
			  </div>

   	  </div>

    <Footer/>
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import Header from '../header'
  import Footer from '../footer/footer'

  export default {
  	data: () => ({
    	url: window.location.origin + (window.location.pathname),
        url_picture : window.location.origin + (window.location.pathname) + "image_berita/", 
    }),
     mounted() {
      const app = this;
      app.$store.dispatch('berita/LOAD_BERITA');
    },
    computed: mapState ({
      beritas(){
        return this.$store.state.berita.daftarBerita;
      }
    }),
    filters: {
      selengkapnya: (value) => {
        return value.substr(0, 20);
      },
      capitalize: function (value) {
          return value.replace(/(^|\s)\S/g, l => l.toUpperCase())
      }
    },
    components : {
      Header, Footer
    }
  }

</script>

<style>
  
    .breadcrumb {
    border-color: #ffffff;
    border-style: solid;
    border-width: 0 1px 4px 1px;
    padding: 8px 15px;
    margin-top: 22px;
    list-style: none;
    background-color: #ffffff;
    border-radius: 4px;
  }

  /*MOBILE CSS*/
  @media (max-width: 620px) {
	 .content {
	    width: 270px;
	    margin: 28px;
	    display: inline-block;
	    vertical-align: top;
	  }
	   .md-card .md-title {
	    font-size: 15px;
	    letter-spacing: 0;
	    line-height: 32px;
		}
  }
  /* DEKSTOP CSS */
  @media (min-width: 620px) {
     .content {
	    width: 300px;
	    margin: 35px;
	    display: inline-block;
	    vertical-align: top;
  	}
  	.md-card .md-title {
    font-size: 18px;
    letter-spacing: 0;
    line-height: 32px;
	}
  }


</style>

