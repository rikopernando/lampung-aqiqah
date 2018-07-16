<template>
  <div>
    <div class="md-medium-size-50 md-small-size-50 md-xsmall-hide">
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

      <md-toolbar class="md-dense" md-elevation="2" style="background-color: white">
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
                <div class="label-nav-main">CART</div>
                <md-badge md-content="0">
                  <i class="fa fa-shopping-basket icon-shop"></i>
                </md-badge>
              </div>
            </a>
          </div>

        </div>
      </md-toolbar>
    </div>


    <div id="displaySidenav">
        <md-toolbar md-elevation="0" style="background-color: #da2921; min-height:30px">
        </md-toolbar>

        <md-toolbar class="md-default" style="background-color: white;">
          <div class="md-toolbar-section-start">
            <md-button class="md-icon-button" @click="showNavigation = true">
              <i class="fa fa-bars icon-shop-mobile"></i>
            </md-button>
          </div>

          <a href="#/" class="md-toolbar-section-end">
              <img src="https://rumahaqiqah.org/wp-content/uploads/2018/01/rumahaqiqah3.png" alt="Aqiqah Lampung">
          </a>

          <div class="md-toolbar-section-end">
            <md-button class="md-icon-button">
              <a href="#/cart">
                <md-badge md-content="0">
                  <i class="fa fa-shopping-basket icon-shop-mobile"></i>
                </md-badge>
              </a>
            </md-button>
          </div>
        </md-toolbar>

        <md-drawer :md-active.sync="showNavigation">
          <md-toolbar class="md-transparent" md-elevation="0">
            <span class="md-title">
              <a href="#/" class="md-toolbar-section-end">
                  <img src="https://rumahaqiqah.org/wp-content/uploads/2018/01/rumahaqiqah3.png" alt="Aqiqah Lampung">
              </a>
            </span>
          </md-toolbar>

          <md-list style="padding: 0px">
            <md-list-item>
              <md-icon>home</md-icon>
              <span class="md-list-item-text">
                <a href="#/" class="md-button md-theme-default md-active side-menu">HOME</a>
              </span>
            </md-list-item>

            <md-list-item>
              <md-icon>store</md-icon>
              <span class="md-list-item-text">
                <a href="#/produk-list" class="md-button md-theme-default md-active side-menu">PRODUK</a>
              </span>
            </md-list-item>

            <md-list-item>
              <md-icon>add_shopping_cart</md-icon>
              <span class="md-list-item-text">
                <a href="#/produk-list" class="md-button md-theme-default md-active side-menu">PEMESANAN</a>
              </span>
            </md-list-item>

            <md-list-item>
              <md-icon>local_atm</md-icon>
              <span class="md-list-item-text">
                <a href="#/produk-list" class="md-button md-theme-default md-active side-menu">PEMBAYARAN</a>
              </span>
            </md-list-item>

          </md-list>

          <div class="social-media">
            <md-button class="md-icon-button">
              <a href="#/facebook">
                <i class="fa fa-facebook-f" style="color: #868686;"></i>
                <md-tooltip md-direction="bottom">Follow On Facebook </md-tooltip>
              </a>
            </md-button>
            <md-button class="md-icon-button">
              <a href="#/instagram">
                <i class="fa fa-instagram" style="color: #868686;"></i>
                <md-tooltip md-direction="bottom">Follow On Instagram </md-tooltip>
              </a>
            </md-button>
            <md-button class="md-icon-button">
              <a href="#/whatsapp">
                <i class="fa fa-whatsapp" style="color: #868686;"></i>
                <md-tooltip md-direction="bottom">Send us Whatsapp </md-tooltip>
              </a>
            </md-button>
          </div>
        </md-drawer>

        <md-content>
          CONTENT ...
        </md-content>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Temporary',
    data: () => ({
      showNavigation: false,
      showSidepanel: false
    })
  }
</script>
