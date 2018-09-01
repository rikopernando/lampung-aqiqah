<template>
  <div>
    <Header/>

      <div class="container">
      	 <md-card md-with-hover>
          <ul class="breadcrumb">
            <li><router-link :to="{name: 'home'}">Home</router-link></li>
            <li><router-link :to="{name: 'beritaKamiList'}">Berita Kami</router-link></li>
            <li class="active">Detail Berita</li>
          </ul>
        </md-card>
          
          <center v-if="this.$store.state.berita.loading"><md-progress-spinner md-mode="indeterminate"></md-progress-spinner></center>
           
            <md-card md-with-hover>
           <div class="md-toolbar-section-start" style="padding:10px">
           	{{berita.created_at}}
           </div>
           <h1 style="padding:10px">"{{ berita.judul_berita | capitalize }}"</h1>
            
			<center style="padding:10px">
			<img :src="url+'images/default_berita.jpg'" alt="People" v-if="berita.foto == null">
			<img :src="url_picture+'/'+berita.foto" alt="People" v-else>
			</center>

           <div class="md-toolbar-section-end">
      		</div>
          	
          	<div v-html="berita.isi_berita" style="padding:15px"></div>

          </md-card>
      		
			  

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
        beritaId: null,
    }),
     mounted() {
      const app = this;
      let id = app.$route.params.id;

      app.beritaId = id;
      app.$store.dispatch('berita/LOAD_BERITA_DETAIL',{id:id});
    },
    computed: mapState ({
      berita(){
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

  .container {
    margin-right: auto;
    margin-left: auto;
    padding-left: 15px;
    padding-right: 15px;
    padding-bottom: 15px
}


</style>

