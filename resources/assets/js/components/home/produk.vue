<template>
    <md-layout md-gutter md-row md-align="start center" class="card-row">
				<md-layout md-flex="30" md-row md-align="center">
						<md-card md-with-hover class="card-hover">
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
				</md-layout>
				<md-layout md-flex="30" md-row md-align="center">
						<md-card md-with-hover class="card-hover">
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
				</md-layout>
				<md-layout md-flex="30" md-row md-align="center">
						<md-card md-with-hover class="card-hover">
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
				</md-layout>
    </md-layout>
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
    width: 350px;
    margin: 4px;
    flex-wrap: wrap;
  }

  .image {
    padding: 1px;
  }
  
  .card-action {
    padding : 10px;
  }
  
  .card-row {
    display: flex;
    flex-wrap: wrap;
    margin: auto;
  }

  .card-hover {
    padding : 4px;
  }

</style>

