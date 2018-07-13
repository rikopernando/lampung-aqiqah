<template>
  <div class="md-layout md-gutter">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="../resources/assets/js/components/header/HeaderStyle.css">

        <div class="md-layout-item md-medium-hide">
          <div class="md-tabs-navigation header-top">
            <div class="menu-kanan">
              <a href="#/pemesanan" class="md-button md-theme-default md-active">
                <div class="md-ripple">
                  <div class="label-nav">Pemesanan</div>
                </div>
              </a>
              <a href="#/pembayaran" class="md-button md-theme-default md-active">
                <div class="md-ripple">
                  <div class="label-nav">Pembayaran</div>
                </div>
              </a>
              <a href="#/keagenan" class="md-button md-theme-default md-active">
                <div class="md-ripple">
                  <div class="label-nav">Keagenan</div>
                </div>
              </a>
              <a href="#/informasi" class="md-button md-theme-default md-active">
                <div class="md-ripple">
                  <div class="label-nav">Informasi</div>
                </div>
              </a>
              <a href="#/kritik-saran" class="md-button md-theme-default md-active">
                <div class="md-ripple">
                  <div class="label-nav">Ruang Saran dan Pengaduan</div>
                </div>
              </a>

              <a href="#/facebook">
                <i class="fa fa-facebook-f icon-link"></i>
                <md-tooltip md-direction="bottom">Follow On Facebook </md-tooltip>
              </a>
              <a href="#/instagram">
                <i class="fa fa-instagram icon-link"></i>
                <md-tooltip md-direction="bottom">Follow On Instagram </md-tooltip>
              </a>
              <a href="#/whatsapp">
                <i class="fa fa-whatsapp icon-link"></i>
                <md-tooltip md-direction="bottom">Send us Whatsapp </md-tooltip>
              </a>
            </div>
          </div>

          <md-toolbar class="header-main">
              <a href="#/" class="icon-aqiqah md-button md-theme-default md-active">
                  <img src="https://rumahaqiqah.org/wp-content/uploads/2018/01/rumahaqiqah3.png" alt="Aqiqah Lampung">
              </a>

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

              <div class="menu-kanan">
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
          </md-toolbar>
        </div>

        <div id="displaySidenav">
          <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" @click="closeNav()">&times;</a>
            <a href="#">About</a>
            <a href="#">Services</a>
            <a href="#">Clients</a>
            <a href="#">Contact</a>
          </div>

          <div class="container header-top" style="height: 30px"> </div>

          <md-toolbar class="header-main">
            <span style="font-size:30px;cursor:pointer;color: #868686;" @click="openNav()">&#9776;</span>

            <a href="#/" class="icon-aqiqah-mobile">
                <img src="https://rumahaqiqah.org/wp-content/uploads/2018/01/rumahaqiqah3.png" alt="Aqiqah Lampung">
            </a>

            <i class="fa fa-shopping-basket icon-shop-mobile"></i>
          </md-toolbar>

        </div>

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
