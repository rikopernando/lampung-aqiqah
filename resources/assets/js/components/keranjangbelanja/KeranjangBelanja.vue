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
    		<div class="col-md-9">
				      <md-table style="height: 400px;max-height: 400px;" v-model="keranjangbelanjas" md-sort="name" md-sort-order="asc" md-card md-fixed-header>
				      <md-table-toolbar>
				      	<h3>KERANJANG BELANJA</h3>
      				  </md-table-toolbar>

			<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
   				 <thead>
       				<tr>
            			<th class="product-name" colspan="3">Produk</th>
            			<th class="product-price">Harga</th>
            			<th class="product-quantity">Jumlah</th>
            			<th class="product-subtotal">Subtotal</th>
        			</tr>
    			</thead>
    			<tbody>
            		<tr class="woocommerce-cart-form__cart-item cart_item">
		         	 <td class="product-remove">
		         	 	  <md-button class="md-icon-button md-dense md-raised" style="background-color:#da2921">
        			      <md-icon style="color:#ffffff">delete</md-icon>
      					 </md-button>
		       		 </td>

		            <td class="product-thumbnail">
		            	<a href="#"><img width="50" height="50" src="https://rumahaqiqah.org/wp-content/uploads/2016/05/menu5.png" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wp-post-image" alt="" srcset="https://rumahaqiqah.org/wp-content/uploads/2016/05/menu5.png 500w, https://rumahaqiqah.org/wp-content/uploads/2016/05/menu5-114x114.png 114w, https://rumahaqiqah.org/wp-content/uploads/2016/05/menu5-300x300.png 300w" sizes="(max-width: 300px) 100vw, 300px" /></a>
		       		 </td>

          			<td class="product-name" data-title="Produk">
           			 	<a href="#">Paket Prima - Bandung</a>  
           			</td>

	            	<td class="product-price" data-title="Harga">
	            		<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">Rp </span>1.530.000</span>
	        		</td>

                 	<td class="product-quantity" data-title="Jumlah">
	               	   <div class="quantity buttons_added">
					    	<input type="button" value="-" class="minus btn btn-primary"> 
					    	<input type="number" class="input-text qty text" step="1" min="0" max="9999" name="" value="2" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric" />
					   	 	<input type="button" value="+" class="plus btn btn-primary">
					   	</div>
	             	</td>

             		 <td class="product-subtotal" data-title="Subtotal">
             	 		<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">Rp </span>3.060.000</span>
             		</td>
            	</tr>
            	<tr>
		            <td colspan="6" class="actions clear">
		                <div class="continue-shopping pull-left text-left">
						   <md-button style="align:right;" class="md-dense md-raised md-primary">Lanjut <md-icon>undo</md-icon> </md-button>
						</div>

		             	<md-button style="align:right;" class="md-dense md-raised md-primary">Refresh  <md-icon>refresh</md-icon> </md-button>
		            </td>
       			</tr>
            </tbody>
		</table>
		</md-table>

				 </div>
				 <div class="col-md-3" style="background-color:white;">
				 	<h3>RINCIAN PESANAN</h3>
				 	<br>
					<table class="table table-striped table-hover">
				        <tbody>
				          <tr>
				          	<th>Subtotal</th>
				            <td>Rp </span>3.060.000</span></td>       
				          </tr>
				          <tr>
				          	<th>Total</th>
				            <td>Rp </span>3.060.000</span></td>    
				          </tr>
				        </tbody>
				      </table>

				      <md-button style="align:right;" class="md-dense md-raised md-accent">Proses Checkout  <md-icon>send</md-icon> </md-button>

				 </div>
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
			filter_produk: 'populer',
			 keranjangbelanjas: [
				        {
				          foto: "papa.jpg",
				          produk: "Pepsodent",
				          harga: 35000,
				          jumlah: 1,
				          subtotal:35000,
				        },
				        {
				          foto: "popo.jpg",
				          produk: "Selaras",
				          harga: 45000,
				          jumlah: 3,
						  subtotal:135000,
				        },
				        				        {
				          foto: "popo.jpg",
				          produk: "Selaras",
				          harga: 45000,
				          jumlah: 3,
						  subtotal:135000,
				        }
				  ]
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

table th{background:#da2921 !important; color:#fff !important; padding:5px !important;}
table td{background:#FFF !important; padding:10px !important;}
</style>