<template>
  <div>
    <md-toolbar class="md-dense" md-elevation="2" style="background-color: white">
      <md-toolbar class="md-transparent" md-elevation="0">
        <div style="padding-right: 15px">
        <md-avatar>
          <img src="https://cdn-images-1.medium.com/max/1600/1*DOJsfgBEBqzudQeakxGBbw.jpeg" alt="Avatar">
        </md-avatar>
        </div>
        <div style="font-weight: bold; font-size: 20px;">Aqiqah Lampung</div>

        <div class="md-toolbar-section-start"></div>
        <div class="md-toolbar-section-end">
          <div style="font-weight: bold; font-size: 20px;">
            Logout
          </div>
        </div>
      </md-toolbar>
    </md-toolbar>

    <side-nav>
      <md-list>
        <md-list-item>
          <md-icon>local_atm</md-icon>
          <span class="md-list-item-text">
            <a href="#/produk" class="md-button md-theme-default md-active side-menu">PRODUK</a>
          </span>
        </md-list-item>
      </md-list>
    </side-nav>

    <content>
      <slot></slot>
    </content>
  </div>
</template>

<script>
  export default {
    name: 'LayoutHorizontalGutter'
  }
</script>

<style lang="scss" scoped>
  side-nav {
    background-color:white;
    width:200px;
    height:100%;
    position:fixed;
    left:0;
    top:55px;
    overflow: auto;
  }
  content {
    background-color:white;
    width:100%;
    height:100%;
    position:fixed;
    left:210px;
    top:55px;
    overflow: auto;
  }
  .side-menu {
    padding-top: 12px;
    color: #868686 !important;
  }
</style>
