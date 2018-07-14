<template>
  <div>
    <md-toolbar md-elevation="0" style="background-color: #da2921; min-height:10px">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="../resources/assets/js/components/header/HeaderStyle.css">

      <h3 class="md-title" style="flex: 1"></h3>
      <md-button href="#/pemesanan" style="color: white; font-size: 12px">Pemesanan</md-button>
      <md-button href="#/pembayaran" style="color: white; font-size: 12px">Pembayaran</md-button>
      <md-button href="#/keagenan" style="color: white; font-size: 12px">Keagenan</md-button>
      <md-button href="#/informasi" style="color: white; font-size: 12px">Informasi</md-button>
      <md-button href="#/kritik-saran" style="color: white; font-size: 12px">Ruang Saran dan Pengaduan</md-button>
      <md-button class="md-icon-button">
        <a href="#/facebook">
          <i class="fa fa-facebook-f icon-link"></i>
          <md-tooltip md-direction="bottom">Follow On Facebook </md-tooltip>
        </a>
      </md-button>
      <md-button class="md-icon-button">
        <a href="#/instagram">
          <i class="fa fa-instagram icon-link"></i>
          <md-tooltip md-direction="bottom">Follow On Instagram </md-tooltip>
        </a>
      </md-button>
      <md-button class="md-icon-button">
        <a href="#/whatsapp">
          <i class="fa fa-whatsapp icon-link"></i>
          <md-tooltip md-direction="bottom">Send us Whatsapp </md-tooltip>
        </a>
      </md-button>
    </md-toolbar>

    <md-toolbar class="md-dense" md-elevation="0" style="background-color: white">
      <div class="md-toolbar-row">
          <a href="#/" class="icon-aqiqah md-button md-theme-default md-active">
              <img src="https://rumahaqiqah.org/wp-content/uploads/2018/01/rumahaqiqah3.png" alt="Aqiqah Lampung">
          </a>

        <div class="md-toolbar-section-start">
          <div style="padding-left: 50px">
            <i class="fa fa-search icon-box"></i>
            <input type="text" placeholder="Search..." class="input-box">
          </div>
          <a href="#/" class="md-button md-theme-default md-active">
            <div class="md-ripple">
              <div class="label-nav-main">HOME</div>
            </div>
          </a>
          <a href="#/produk-list" class="md-button md-theme-default md-active">
            <div class="md-ripple">
              <div class="label-nav-main">PRODUK</div>
            </div>
          </a>
        </div>

        <div class="md-toolbar-section-end">
          <a href="#/login" class="md-button md-theme-default md-active">
            <div class="md-ripple">
              <div class="label-nav-main">LOGIN</div>
            </div>
          </a>
          <a href="#/cart" class="md-button md-theme-default md-active">
            <div class="md-ripple">
              <div class="label-nav-main">CART/Rp. 0</div>
              <i class="fa fa-shopping-basket icon-shop"></i>
            </div>
          </a>
        </div>

      </div>
    </md-toolbar>
  </div>
</template>

<script>
export default {
	methods: {
    openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
    },
    closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.body.style.backgroundColor = "white";
    }
  }
}
</script>
