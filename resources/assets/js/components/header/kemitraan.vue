<template>
  <div>
    <Header></Header>
      <div class="container">
          <md-card md-with-hover>
            <ul class="breadcrumb">
              <li><a href="#/">Home</a></li>
              <li class="active">Kemitraan</li>
            </ul>
          </md-card>
          
          

          <div v-if="countmitra > 0">
          <center v-if="loading"><md-progress-spinner md-mode="indeterminate"></md-progress-spinner></center>
					<md-list class="md-triple-line" v-else>
							<md-list-item v-for="mitra, index in mitra" :key="index">
								<div class="md-list-item-text white-space">
									<span>{{ mitra.nama_mitra }}</span>
									<span>Telp/Whatsapp : {{ mitra.no_telp }}</span>
                  <p>{{ mitra.alamat }}</p>
								</div>
							</md-list-item>
						</md-list>
            </div>
            <div v-else>
               <md-empty-state md-label="Mitra Tidak Ditemukan"
                  :md-description="`Data Mitra Masih Kosong`">
              </md-empty-state>
            </div>

      </div>
    <Footer></Footer>
  </div>
</template>

<script>

  import Header from '../header'
  import Footer from '../footer/footer'

  export default {
    data : () => ({
      url: window.location.origin + (window.location.pathname + 'mitra'),
      mitra : [],
      countmitra:0,
      loading : true
    }),
    mounted() {
      this.getMitraData()
    },
    components : {
      Header,Footer
    },
    methods : {
      getMitraData(){
        axios.get(this.url+'/data').then((resp) => {
          this.mitra = resp.data.data_mitra
          this.countmitra = resp.data.count_mitra
          this.loading = false
        })
        .catch((err) => {
          console.log(err)
          alert('Terjadi Kesalahan')
        })
      }
    }
  }
</script>

<style lang="scss" scoped>
  
  .breadcrumb {
    border-color: #ffffff;
    border-style: solid;
    border-width: 0 1px 4px 1px;
    padding: 8px 15px;
    margin-bottom: 22px;
    margin-top: 22px;
    list-style: none;
    background-color: #ffffff;
    border-radius: 4px;
  }

  .md-list {
    width: -webkit-fill-available;
    max-width: 100%;
    display: inline-block;
    vertical-align: top;
    border: 1px solid rgba(#000, .12);
  }

  .white-space {
    white-space : normal;
  }

    .container {
    margin-right: auto;
    margin-left: auto;
    padding-left: 15px;
    padding-right: 15px;
    padding-bottom: 15px;
}

	
</style>
