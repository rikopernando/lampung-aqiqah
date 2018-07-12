<template>
	<div>
	<Slider></Slider>
	<Produk></Produk>
	<Footer></Footer>
	</div>
</template>
<script>
	import Slider from './slider'
	import Produk from './produk'
	import Footer from '../Footer/Footer'

	 export default {
    	components: { Slider,Produk,Footer },
    	mounted(){
    		console.log('s');
    	}
	}
</script>