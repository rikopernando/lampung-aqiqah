<template>
  <div v-bind:style="{ 'background-image': 'url(' + url+'/images/background-batik.jpg' + ')' }">
  <div class="container ">
    <div class="md-layout ">
        <div class="md-layout-item md-medium-size-25 md-small-size-50 md-xsmall-size-50">
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

        <div class="md-layout-item md-medium-size-25 md-small-size-50 md-xsmall-size-50">
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

        <div class="md-layout-item md-medium-size-25 md-small-size-50 md-xsmall-size-50">
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

        <div class="md-layout-item md-medium-size-25 md-small-size-50 md-xsmall-size-50">
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
</template>

<script>
  export default {
    name: 'ElevationExample',
    data : () => {
      return {
        url : window.location.origin + window.location.pathname
      }
    },
    mounted() {
      console.log(this.url)
    }
  }
</script>

<style lang="scss" scoped>

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

  /*MOBILE VERSION*/
  @media (max-width: 600px) {
      .md-title  { font-size: 15px; }
      .md-button  { font-size: 10px;}
    }
    @media (min-width: 600px) {
      .md-title  { font-size: 24px; }
      .md-button  { font-size: 14px;}
    }

</style>

