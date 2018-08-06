<template>
  <div class="row footer">
	  <div class="container">
	  	<div class="md-layout md-gutter">
		    <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">
		    	<div class="head">
		        <span class="md-title">Download Katalog</span>
		    	</div>
		      <div> 
	      		<md-field>
				      <label>Nama</label>
				      <md-input></md-input>
				    </md-field>
	      		<md-field>
				      <label>Email</label>
				      <md-input></md-input>
				    </md-field>
	      		<md-field>
				      <label>Telpon</label>
				      <md-input></md-input>
				    </md-field>
				    <div style="text-align: center;">
					    <md-button type="submit" class="md-primary">Download</md-button>
				    </div>
					</div>
		    </div>

		    <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">
		    	<div class="head">
		        <span class="md-title">Alamat</span>
		    	</div>
		      <div>
	      		<p>www.aqiqahlampung.co.id</p>
						<p>Alamat: Jl. Komarudin Blok B No.1 Rajabasa Raya, Bandar Lampung, Lampung</p>
						<p>Telp/Whatsapp 081249995599</p>
					</div>
		    </div>

		    <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">
		    	<div class="head">
		        <span class="md-title">Lainnya</span>
		    	</div>
		      <div>
					</div>
		    </div>
		  </div>
		  <p class="copyright">
		  	Copyright © 2018 PT. Andaglos Global Teknologi.
		  </p>
	  </div>
	</div>
</template>
<script >
export default {
  mounted() {
    console.log('Component mounted.')
  }
}
</script>
<style scoped>
.row {
	padding: 10px;
}
.footer {
	background: #f5f5fc;
	border-top: 1px solid #e0e0f7;
	margin-top: 10px;
	padding: 30px;
}
.copyright {
	margin-top: 20px;
	font-weight: bold;
	text-align: center;
}
.head {
	margin-bottom: 10px;
}
  
</style>
