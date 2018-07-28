<template>
  <div>
      <Header></Header>
				<div class="produk-modal-container" id="produk-modal" v-on:click="closeModalProduk">
						<div class="produk-modal">
								<div class="title-produk">
									 Paket Special
								</div>
								<div class="form-produk" id="form-produk">
									<div class="row">
                    <div class="col-md-6">
                      <img :src="url+'/images/paketExample.png'">
                    </div>
                    <div class="col-md-6">
                      <h3> <strike>Rp. 350.000</strike> Rp. 400.000 </h3> 
                      <p class="desc">
                      Satu ekor Hewan Aqiqah + Masak Sate 180 tusuk + gule 30 porsi + Nasi Box 30 porsi Varian isi Nasi Box : Nasi, Cah Buncis Wortel, krupuk Palembang, Buah pisang, sendok, lembar doa, buku risalah
                      </p>
                      <input type="number" name="jumlah_produk" class="jumlah_produk" value="1">
                      <button class="btn-add-cart">Masukan Ke Keranjang</button>
                      <p class="desc">
                      Kategori: Paket Aqiqah aqiqah, gule, Hewan Aqiqah, krupuk Palembang, Nasi Box, Sate
                      </p>
								    </div>
								  </div>
								</div>
						</div>
				</div>
        <md-button class="md-raised md-primary" v-on:click="openModalProduk()">Primary</md-button>
  </div>
</template>

<script>
  
  import Header from '../header'
  
  export default {
    name : 'detail_produk',
    data : () => ({
       url : window.location.origin +  window.location.pathname, 
       active : null
    }),
    components : { Header },
    mounted() {
      console.log('Haiiiii Freedom')
    },
    methods : {
      openModalProduk() {
          $("#produk-modal").addClass('active')
          $('#form-produk').addClass('active')
      },
      closeModalProduk(e) {
          console.log(e.path[1])
          console.log(this.$el)
            if (e.path[1] === this.$el) {
                $('#produk-modal').removeClass('active')
            }
      }
    }
  }

</script>

<style>

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
