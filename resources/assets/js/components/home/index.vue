<template>
  <div>
      <Header></Header>
      <Slider></Slider>
      <Produk></Produk>
      <Testimoni></Testimoni>
      <Footer></Footer>
  </div>
</template>

<script>

    import Header from '../header'
    import Slider from './slider'
    import Produk from './produk'
    import Footer from '../footer/footer'
    import Testimoni from './testimoni'

    export default {
			data : () => ({
			}),
      components : {
        Header, Slider, Produk, Footer, Testimoni
      }
    }
</script>
