<template>
  <div>
    <Header></Header>
    <div class="container">
      <md-card md-with-hover>
				<ul class="breadcrumb">
				  <li><router-link :to="`/`">Home</router-link></li>
				  <li class="active">Keranjang Belanja</li>
				</ul>
			</md-card>

			<md-dialog-confirm 
				:md-active.sync="promptDeleteKeranjang"
		    md-title="Hapus Produk?"
		    md-content="Apakah Anda yakin ingin menghapus Produk ini?"
		    md-confirm-text="Ya"
		    md-cancel-text="Batal"
		    @md-confirm="onConfirmDelete" />

    	<md-dialog-alert 
    		:md-active.sync="promptGagalEdit"
      	md-title="Gagal !!"
      	md-content="Produk tidak bisa dengan jumlah 0 ,Silakan hapus produk " />

	    <div class="row">
		    <div class="col-md-1"></div>
    		<div class="col-md-7">
				<h3>KERANJANG BELANJA</h3>
					<table class="table-responsive">
				   				 <thead>
				       				<tr>
				       					<th class="product-name">Aksi</th>
				            			<th class="product-name" colspan="2">Produk</th>
				            			<th class="product-price">Harga</th>
				            			<th class="product-quantity">Jumlah</th>
				            			<th class="product-subtotal">Subtotal</th>
				        			</tr>
				    			</thead>
				    			<tbody v-if="this.$store.state.keranjangbelanja.countKeranjang > 0"  class="data-ada">
				    				<md-empty-state v-if="this.$store.state.keranjangbelanja.loading">
							                <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
							        </md-empty-state>
							  <tr class="woocommerce-cart-form__cart-item cart_item scrollable-menu" v-for="keranjangbelanja in keranjangbelanjas"> 
							    <td class="product-remove">
							        <md-button @click="deleteKeranjang(keranjangbelanja.id_keranjang_belanja,keranjangbelanja.subtotal)" class="md-icon-button md-dense md-raised" style="background-color:#da2921">
					        			<md-icon style="color:#ffffff">delete</md-icon>
					      			</md-button>
							      </td>
						            <td class="product-thumbnail">
						            	<img width="50" height="50" :src="url_picture+'/default.jpg'" v-if="keranjangbelanja.produk.foto == null" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wp-post-image" alt="" sizes="(max-width: 300px) 100vw, 300px" />
						            	<img width="50" height="50" :src="url_picture+'/'+keranjangbelanja.produk.foto" v-else class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wp-post-image" alt="" sizes="(max-width: 300px) 100vw, 300px" />
						       		 </td>

				          			<td class="product-name" data-title="Produk">
				           			 	{{ keranjangbelanja.produk.nama_produk | capitalize }}
				           			</td>

					            	<td class="product-price" data-title="Harga" style="text-align:right">
					            		<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">Rp </span><b>{{ keranjangbelanja.harga_produk | pemisahTitik }}</b></span>
					        		</td>

				                 	<td class="product-quantity" data-title="Jumlah" style="text-align:right">
					               	   <div class="quantity buttons_added">
					               	   		<button class="btn btn-md" @click="kurangJumlahKeranjang(keranjangbelanja.id_keranjang_belanja,keranjangbelanja.harga_produk)" style="background-color:#da2921;color:white;">&nbsp;( - )</button>

									    	<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"></span><b>{{ keranjangbelanja.jumlah_produk | pemisahTitik }}</b></span>

									    	<button class="btn btn-md" @click="tambahJumlahKeranjang(keranjangbelanja.id_keranjang_belanja,keranjangbelanja.harga_produk)" style="background-color:#da2921;color:white;">( + )</button>
									   	</div>
					             	</td>

				             		 <td class="product-subtotal" data-title="Subtotal" style="text-align:right">
				             	 		<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">Rp </span><b>{{ keranjangbelanja.subtotal | pemisahTitik }}</b></span>
				             		</td>
				            	</tr>
				            </tbody>

				            <tbody class="data-tidak-ada" v-else>
                                   <tr><td colspan="6" class="text-center">Tidak Ada Data Keranjang Belanja</td></tr>
                            </tbody>
						</table>

						<md-button :to="`/list-produk`" style="align:right;" class="md-dense md-raised md-primary">Lanjut Belanja<md-icon>undo</md-icon> </md-button>
			</div>
			<div class="col-md-3">
				 	<h3>RINCIAN PESANAN</h3>
					<table class="table table-striped table-hover">
		        <tbody>
		          <tr>
		          	<th>Subtotal</th>
		            <td style="text-align:right">
		            	<span class="woocommerce-Price-amount amount">
		            		<span class="woocommerce-Price-currencySymbol">Rp </span>
		            		<b>{{ this.$store.state.keranjangbelanja.subtotal | pemisahTitik }}</b>
		            	</span>
		            </td>
		          </tr>
		          <tr>
		          	<th>Total Akhir</th>
		            <td style="text-align:right"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">Rp </span><b>{{ this.$store.state.keranjangbelanja.total_akhir | pemisahTitik }}</b></span></td>    
		          </tr>
		        </tbody>
		      </table>
				  <md-button :to="`/checkout`" v-if="this.$store.state.keranjangbelanja.countKeranjang > 0"  style="align:right;" class="md-dense md-raised md-accent">Proses Checkout  <md-icon>send</md-icon> </md-button>
				</div>
			 	<div class="col-md-1"></div>
				 <!-- Snackbar for Bank delete alert -->
			        <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="snackbarDeleteKeranjang" md-persistent>
			            <span>Produk Keranjang berhasil dihapus!</span>
			          </md-snackbar>
			</div>
		</div>
    <Footer></Footer>
	</div>
</template>

<script>
  import Header from '../header'
  import Footer from '../footer/footer'
  import { mapState } from 'vuex'

  export default {
		data : () => {
			return {
				url : window.location.origin + window.location.pathname,
				url_picture : window.location.origin + (window.location.pathname) + "image_produks/",
				filter_produk: 'populer',
				promptDeleteKeranjang: false,
				promptGagalEdit:false,
	    	keranjangIdForDelete: '',
	    	snackbarDeleteKeranjang:false,
		    subtotalIdForDelete: '',
			}
		},
		mounted() {
		  this.$store.dispatch('keranjangbelanja/LOAD_KERANJANG_LIST')
      	  this.$store.dispatch('keranjangbelanja/LOAD_SUBTOTAL_LIST')
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
    keranjangbelanjas(){
      return this.$store.state.keranjangbelanja.datakeranjang.data_keranjang
    }
  }),
	methods:{
    deleteKeranjang(id,subtotal) {
      this.promptDeleteKeranjang = true;
      this.keranjangIdForDelete = id;
      this.subtotalsIdForDelete = subtotal;
    },
    onConfirmDelete() {
  	  this.$store.dispatch('keranjangbelanja/LOAD_DELETE_LIST',{id :this.keranjangIdForDelete,subtotal:this.subtotalsIdForDelete})
  	  this.keranjangIdForDelete = '';
      this.subtotalIdForDelete = '';
      this.snackbarDeleteKeranjang = true;
  	},
     tambahJumlahKeranjang(id,harga_produk){
     	var operator = "+";
     	this.$store.dispatch('keranjangbelanja/LOAD_TAMBAH_JUMLAH_LIST',{id_keranjang_belanja :id,harga_produk:harga_produk,operator:operator})
    },
    kurangJumlahKeranjang(id,harga_produk){
    	var operator = "-";
    	this.$store.dispatch('keranjangbelanja/LOAD_KURANG_JUMLAH_LIST',{id_keranjang_belanja :id,harga_produk:harga_produk,operator:operator})
    	if(this.$store.state.keranjangbelanja.status == 0){
    		this.promptGagalEdit = true;
    	}else{
    		this.promptGagalEdit = false;
    	}
    }
	},

  components : {
      Header, Footer
    }
  }
</script>

<style scoped>
.breadcrumb {
  padding: 8px 15px;
  margin-bottom: 22px;
  margin-top: 22px;
  list-style: none;
  background-color: #ffffff;
  border-radius: 1px;
}
.h3, h3 {
  font-size: 24px;
  color: black;
}
table th {
	background:#da2921 !important; 
	color:#fff !important; 
	padding:4px !important;
}
table td {
	background:#f7e1e1 !important;
	padding:8px !important;
}
.scrollable-menu {
  max-height: 15px;
  overflow-x: hidden;
}
</style>