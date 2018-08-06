<template>
  <div>
    <Header></Header>
    <Slider></Slider>
    <Produk></Produk>
    <Footer></Footer>
  </div>
</template>

<script>

import Header from '../header'
import Slider from './slider'
import Produk from './produk'
import Footer from '../footer/footer'

export default {
	data : () => ({
	}),
  components : {
    Header, Slider, Produk, Footer
  }
}

</script>