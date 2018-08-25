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

					<md-list class="md-triple-line">
							<md-list-item>
								<div class="md-list-item-text white-space">
									<span>Aqiqah Lampung</span>
									<span>Rajabasa</span>
                  <p>Jl. Komarudin Blok B No.1 Rajabasa Raya, Bandar Lampung, Lampung</p>
								</div>
							</md-list-item>
              <hr>
							<md-list-item>
								<div class="md-list-item-text white-space">
									<span>Aqiqah Lampung</span>
									<span>Kemiling</span>
                  <p>Jl. Pramuka, Sentra Bisnis Terminal Kemiling Blok R3 No.7, Sumber Rejo, Kemiling, Kota Bandar Lampung, Lampung 35153</p>
								</div>
							</md-list-item>
              <hr>
							<md-list-item>
								<div class="md-list-item-text white-space">
									<span>Aqiqah Lampung</span>
									<span>Kedaton</span>
                  <p>Jl. Pahlawan, No. 103, Surabaya, Kedaton, Kota Bandar Lampung, Lampung 35153</p>
								</div>
							</md-list-item>
						</md-list>
      </div>
    <Footer></Footer>
  </div>
</template>

<script>

  import Header from '../header'
  import Footer from '../footer/footer'

  export default {
    mounted() {
      console.log(14)
    },
    components : {
      Header,Footer
    },
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

	
</style>
