<template>
	<div>
	<Header></Header>
	<Slider></Slider>
	<Produk></Produk>
	<Footer></Footer>
	</div>
</template>
<script>
	import Header from '../header/HeaderIndex'
	import Slider from './slider'
	import Produk from './produk'
	import Footer from '../Footer/Footer'

	 export default {
    	components: { Header,Slider,Produk,Footer },
    	mounted(){
    		console.log('');
    	}
	}
</script>