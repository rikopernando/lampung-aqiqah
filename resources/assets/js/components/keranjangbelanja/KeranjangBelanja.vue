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


			 <md-card-content>
    		<div class="col-md-9">
				      <md-table style="height: 400px;max-height: 400px;" >
				      <md-table-toolbar>
				      	<h3>KERANJANG BELANJA</h3>
      				  </md-table-toolbar>

			<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
   				 <thead>
       				<tr>
       					<th class="product-name">Aksi</th>
            			<th class="product-name" colspan="2">Produk</th>
            			<th class="product-price">Harga</th>
            			<th class="product-quantity">Jumlah</th>
            			<th class="product-subtotal">Subtotal</th>
        			</tr>
    			</thead>
    			<tbody>
            		<tr class="woocommerce-cart-form__cart-item cart_item" v-for="keranjangbelanja in keranjangbelanjas">
		         	 
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
           			 	<a href="#">{{ keranjangbelanja.produk.nama_produk | capitalize }}</a>  
           			</td>

	            	<td class="product-price" data-title="Harga">
	            		<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">Rp </span>{{ keranjangbelanja.harga_produk | pemisahTitik }}</span>
	        		</td>

                 	<td class="product-quantity" data-title="Jumlah">
	               	   <div class="quantity buttons_added">
	               	   		<button class="btn btn-sm" @click="kurangJumlahKeranjang(keranjangbelanja.id_produk,keranjangbelanja.harga_produk)" style="background-color:#da2921;color:white;">(-)</button>

					    	<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"></span>{{ keranjangbelanja.jumlah_produk | pemisahTitik }}</span>

					    	<button class="btn btn-sm" @click="tambahJumlahKeranjang(keranjangbelanja.id_produk,keranjangbelanja.harga_produk)" style="background-color:#da2921;color:white;">(+)</button>
					   	</div>
	             	</td>

             		 <td class="product-subtotal" data-title="Subtotal">
             	 		<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">Rp </span>{{ keranjangbelanja.subtotal | pemisahTitik }}</span>
             		</td>
            	</tr>
            </tbody>
		</table>

		<div class="continue-shopping pull-left text-left">
			<md-button :to="`/list-produk`" style="align:right;" class="md-dense md-raised md-primary">Lanjut Belanja<md-icon>undo</md-icon> </md-button>
		</div>

		</md-table>
			</div>
	</md-card-content>
				 

	<div class="col-md-3" style="background-color:white;">
				 	<h3>RINCIAN PESANAN</h3>
				 	<br><br>
					<table class="table table-striped table-hover">
				        <tbody>
				          <tr>
				          	<th>Subtotal</th>
				            <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">Rp </span>{{ subtotal | pemisahTitik }}</span></td></tr>
				          <tr>
				          	<th>Total Akhir</th>
				            <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">Rp </span>{{ total_akhir | pemisahTitik }}</span></td>    
				          </tr>
				        </tbody>
				      </table>

				      <md-button style="align:right;" class="md-dense md-raised md-accent">Proses Checkout  <md-icon>send</md-icon> </md-button>

				 </div>
				 <!-- Snackbar for Bank delete alert -->
			        <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="snackbarDeleteKeranjang" md-persistent>
			            <span>Produk Keranjang berhasil dihapus!</span>
			          </md-snackbar>
			</div>
      <Footer></Footer>
  </div>
</template>

<script>
    import Header from '../header'
    import Footer from '../footer/footer'


    export default {
	data : () => {
		return {
			url : window.location.origin + window.location.pathname,
			url_picture : window.location.origin + (window.location.pathname) + "image_produks/",
			filter_produk: 'populer',
			promptDeleteKeranjang: false,
			snackbarDeleteKeranjang: false,
	    	keranjangIdForDelete: '',
			keranjangbelanjas: [],
			subtotal:0,
			total_akhir:0
		}
	},
	mounted() {
	      this.getKeranjangBelanjaData();
	      this.getSubtotalTbs();
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
	methods:{
		getKeranjangBelanjaData() {
        axios.get(this.url + 'keranjang-belanja/view')
        .then(resp => {
          this.keranjangbelanjas = resp.data;
          this.loading = false;
        })
        .catch(resp => {
          console.log('Gagal Proses KeranjangData:', resp);
        });
      },
      getSubtotalTbs(){
        var app =  this;
        axios.get(app.url+'keranjang-belanja/subtotal-keranjang-belanja')
        .then(resp => {
         app.subtotal += resp.data.subtotal;
         app.total_akhir += resp.data.subtotal;
         })
        .catch(resp => {
          console.log('Gagal Proses SubtotalKeranjangData:',resp);
        });
      },
      deleteKeranjang(id,subtotal) {
        this.promptDeleteKeranjang = true;
        this.keranjangIdForDelete = id;
        this.subtotalsIdForDelete = subtotal;
      },
      onConfirmDelete() {
    		axios.delete(this.url+ 'keranjang-belanja/'+ this.keranjangIdForDelete)
    		.then(resp => {
    			var subtotal = parseInt(this.subtotal) - parseInt(this.subtotalsIdForDelete)
                this.subtotal = subtotal;
                this.total_akhir = subtotal;
    			this.keranjangIdForDelete = '';
    			this.subtotalsIdForDelete = '';
    			this.snackbarDeleteKeranjang = true;
    			this.getKeranjangBelanjaData();
    		})
    		.catch(resp => {
    			console.log('Terjadi Kesalahan Konfirmasi Delete :', resp);
    		})
    	},
       tambahJumlahKeranjang(id,harga_produk){
        axios.post(this.url + 'keranjang-belanja/tambah-jumlah-keranjang/'+id)
        .then(resp => {
              	var subtotalupdate = parseInt(this.subtotal) + parseInt(harga_produk)
                this.subtotal = subtotalupdate;
                this.total_akhir = subtotalupdate;
    			this.getKeranjangBelanjaData();
        })
        .catch(resp => {
          console.log('Terjadi Kesalahan :', resp);
        })
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
	padding:5px !important;
}
table td {
	background:#FFF !important;
	padding:10px !important;
}
</style>