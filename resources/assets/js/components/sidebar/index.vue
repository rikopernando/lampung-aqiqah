<style>
@keyframes animateDisplay {
  from {opacity: 0;}
  to {opacity: 1;}
}
.main-content {
  -webkit-animation: animateDisplay 1s; /* Safari 4.0 - 8.0 */
  animation: animateDisplay 1s;
}
.sidebar-footer {
  font-size: small !important;
}
@media (max-width: 600px) {
  .sidebar-screen-small-hide { 
    display: none; 
  }
  #sidebarMobileVersion { 
    display: block; 
  }
  .main-content {
    background: #fafafa;
    transition: all .2s ease-in-out;
  }
  .md-list-item-content {
    padding: 4px 7px !important;
    justify-content: flex-start !important;
  }
  .md-list-item-content>.md-icon:first-child {
    margin-right: 5px !important;
  }
  .md-theme-default a:not(.md-button) {
    color: #767676 !important;
  }
  .sidebar-footer {
    text-align: center;
  }
  .toolbar-mobile {
    position: fixed;
  }
  .toolbar-mobile-wrapper {
    height: 70px;
  }
}
@media (min-width: 601px) {
  #sidebarMobileVersion { display: none; }
  .main-content.active {
    padding-left: 275px;
  }
  .main-content {
    background: #fafafa;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    top: 50px;
    left: 0;
    height: 94vh;
    padding: 15px;
    padding-left: 75px;
  }
  .dekstop-menu {
    text-transform: uppercase;
    color: #767676;
  }
  .sidebar-footer {
    text-align: center;
    margin-bottom: 10px;
  }
  .sidebar-footer a {
    color: grey !important;
  }
  .header {
    position: fixed;
    z-index: 10;
    top: 0;
    left: 0;
    background: #da2921;
    width: 100%;
    height: 50px;
    line-height: 50px;
    color: #fff;
  }
  .header .logo {
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  .header #menu-toggle {
    display: block;
    float: left;
    width: 60px;
    height: 50px;
    line-height: 50px;
    margin-right: 15px;
    color: #fff;
    text-decoration: none;
    text-align: center;
    background: rgba(0, 0, 0, 0.15);
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  .header #menu-toggle i {
    display: inline-block;
    margin: 0 5px;
  }
  .header #menu-toggle span {
    width: 0px;
    display: none;
    overflow: hidden;
    transition: all .2s ease-in-out;
  }
  .header #menu-toggle:hover {
    background: rgba(0, 0, 0, 0.25);
  }
  .header #menu-toggle.active {
    width: 250px;
    transition: all .2s ease-in-out;
  }
  .header #menu-toggle.active span {
    display: inline;
    width: auto;
    transition: all .2s ease-in-out;
  }
  .sidebar {
    position: fixed;
    z-index: 10;
    left: 0;
    top: 50px;
    height: 90%;
    width: 60px;
    background: #fff;
    border-right: 1px solid #ddd;
    text-align: center;
    transition: all .2s ease-in-out;
    overflow-y: auto;
  }
  .sidebar.active, .sidebar.hovered {
    width: 250px;
    transition: all .2s ease-in-out;
  }
  .sidebar ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
  }
  .sidebar ul li {
    display: block;
  }
  .sidebar ul li a {
    display: block;
    position: relative;
    white-space: nowrap;
    overflow: hidden;
    color: #444;
    text-align: left;
  }
  .sidebar ul.md-list.md-theme-default li div div.md-list-item-content {
    border-bottom: 1px solid #ddd;
  }
  .sidebar ul.md-list.md-theme-default li div div.md-list-item-content.md-ripple.md-disabled {
    padding: 0px !important;
  }
  .sidebar ul.md-list.md-theme-default li div div.md-list-expand ul li div div a {
    color: #868686;
  }
  .sidebar ul.md-list.md-theme-default li div div.md-list-item-content.md-ripple.md-disabled a {
    width: 100%;
  }
  .sidebar ul li a i {
    display: inline-block;
    width: 60px;
    height: 60px;
    line-height: 60px;
    text-align: center;
    -webkit-animation-duration: .7s;
            animation-duration: .7s;
    -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
  }
  .sidebar ul li a span {
    display: inline-block;
    height: 60px;
    line-height: 60px;
  }
  .sidebar ul li a:hover {
    background-color: #eee;
  }
}
</style>

<template>
  <div>
    <div id="dekstopVersion" class="md-medium-size-50 md-small-size-50 sidebar-screen-small-hide">

      <!-- Header -->
      <div class="header">
        <a @click="menuToggleSidebar" id="menu-toggle" class="menu-toggle-sidebar">
          <md-icon style="color: white">menu</md-icon>
          <span>Menu</span>
        </a>
        <div class="logo">
          <router-link style="color: white;" :to="{name: 'home'}">Aqiqah Lampung</router-link>
          <div class="pull-right">
            <router-link :to="{name: 'logout'}" tag="div">
            <md-icon style="color: white">power_settings_new</md-icon>
            <span class="btn" style="color: white; font-weight: bold">
              Logout
            </span>
            </router-link>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="sidebar">
        <md-list>
          <md-list-item>
            <router-link :to="{name: 'dashboard'}" style="margin: 0px; color: #767676 !important">
              <md-icon>dashboard</md-icon>
              <span>Dashboard</span>
            </router-link>
          </md-list-item>

          <md-list-item>
            <router-link :to="{name: 'produk'}" style="margin: 0px; color: #767676 !important">
              <md-icon>fastfood</md-icon>
              <span>Produk</span>
            </router-link>
          </md-list-item>

          <md-list-item>
            <router-link :to="{name: 'bank'}" style="margin: 0px; color: #767676 !important">
              <md-icon>attach_money</md-icon>
              <span>Bank</span>
            </router-link>
          </md-list-item>

          <md-list-item>
            <router-link :to="{name: 'user'}" style="margin: 0px; color: #767676 !important">
              <md-icon>account_box</md-icon>
              <span>User</span>
            </router-link>
          </md-list-item>

          <md-list-item>
            <router-link :to="{name: 'pelanggan'}" style="margin: 0px; color: #767676 !important">
              <md-icon>contacts</md-icon>
              <span>Pelanggan</span>
            </router-link>
          </md-list-item>

          <md-list-item>
            <router-link :to="{name: 'mitra'}" style="margin: 0px; color: #767676 !important">
              <md-icon>group</md-icon>
              <span>Mitra</span>
            </router-link>
          </md-list-item>

          <md-list-item>
            <router-link :to="{name: 'laporanOrder'}" style="margin: 0px; color: #767676 !important">
              <md-icon>notes</md-icon>
              <span>Laporan Order</span>
            </router-link>
          </md-list-item>
          <md-list-item @click="expandSettingSidebar" md-expand :md-expanded.sync="expandSetting">
            <span class="menu-toggle-sidebar" style="margin: 0px; color: #767676 !important">
              <md-icon>settings_applications</md-icon>
              <span style="margin-left: 20px;">Setting</span>
            </span>
            <md-list slot="md-expand">
              <md-list-item class="md-inset">
                <router-link :to="{name: 'testimoni'}">
                  <span>Testimoni</span>
                </router-link>
              </md-list-item>
              <md-list-item class="md-inset">
                <router-link :to="{name: 'beritaKami'}">
                  <span>Berita Kami</span>
                </router-link>
              </md-list-item>
              <md-list-item class="md-inset">
                <router-link :to="{name: 'setting_perusahaan'}">
                  <span>Setting Perusahaan</span>
                </router-link>
              </md-list-item>
            </md-list>
          </md-list-item>

        </md-list>
      </div>
    </div>

    <div id="sidebarMobileVersion">
      <div class="toolbar-mobile-wrapper">
        <md-toolbar class="md-primary toolbar-mobile" style="background-color: #da2921 !important;">
          <md-button class="md-icon-button" @click="showNavigation = true">
            <md-icon>menu</md-icon>
          </md-button>
          <router-link style="color: white;" :to="{name: 'home'}">
            <span class="md-title">Aqiqah Lampung</span>
          </router-link>

          <div class="md-toolbar-section-end">
            <md-button class="md-icon-button">
              <router-link :to="{name: 'logout'}" tag="div">
                <md-icon style="color: white">power_settings_new</md-icon>
              </router-link>
              <md-tooltip md-direction="left">Logout</md-tooltip>
            </md-button>
          </div>
        </md-toolbar>
      </div>

      <md-drawer :md-active.sync="showNavigation" style="width: 213px !important">
        <md-toolbar class="md-transparent" md-elevation="0">
          <span class="md-title">AQIQAH LAMPUNG</span>
        </md-toolbar>

        <md-list>
          <md-list-item>
            <router-link :to="{name: 'dashboard'}" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
              <md-icon>dashboard</md-icon>
              <span>Dashboard</span>
            </router-link>
          </md-list-item>

          <md-list-item>
            <router-link :to="{name: 'produk'}" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
              <md-icon>fastfood</md-icon>
              <span>Produk</span>
            </router-link>
          </md-list-item>

          <md-list-item>
            <router-link :to="{name: 'bank'}" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
              <md-icon>attach_money</md-icon>
              <span>Bank</span>
            </router-link>
          </md-list-item>

          <md-list-item>
            <router-link :to="{name: 'user'}" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
              <md-icon>account_box</md-icon>
              <span>User</span>
            </router-link>
          </md-list-item>

          <md-list-item>
            <router-link :to="{name: 'mitra'}" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
              <md-icon>group</md-icon>
              <span>Mitra</span>
            </router-link>
          </md-list-item>

          <md-list-item>
            <router-link :to="{name: 'laporanOrder'}" class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
              <md-icon>notes</md-icon>
              <span>Laporan Order</span>
            </router-link>
          </md-list-item>
          <md-list-item md-expand :md-expanded.sync="expandSetting">
            <span class="md-list-item-content md-ripple md-button" style="margin: 0px; color: #767676 !important">
              <md-icon>settings_applications</md-icon>
              <span>Setting</span>
            </span>
            <md-list slot="md-expand">
              <md-list-item class="md-inset">
                <router-link :to="{name: 'testimoni'}">
                  <span class="md-list-item-text">Testimoni</span>
                </router-link>
              </md-list-item>
              <md-list-item class="md-inset">
                <router-link :to="{name: 'beritaKami'}">
                  <span class="md-list-item-text">Berita Kami</span>
                </router-link>
              </md-list-item>
              <md-list-item class="md-inset">
                <router-link :to="{name: 'setting_perusahaan'}">
                  <span class="md-list-item-text">Setting Perusahaan</span>
                </router-link>
              </md-list-item>
            </md-list>
          </md-list-item>

        </md-list>
      </md-drawer>
    </div>

    <!-- Content -->
    <div class="main-content">
      <div style="margin-bottom: 15px;">
        <slot/>
      </div>
      <footer class="sidebar-footer">
        Copyright © {{ tahun }}
        <a href="https://andaglos.id/">
          PT. Andaglos Global Teknologi.
        </a>
      </footer>
    </div>
  </div>
</template>

<script>

export default {
  data: () => ({
    url : window.location.origin + window.location.pathname,
    tahun: new Date().getFullYear(),
    showNavigation: false,
    showSidepanel: false,
    expandSetting: false,
  }),
  mounted() {
    let el = document.getElementById('wh-widget-send-button');
    el == null ? '' : el.style.display = 'none';
  },
  methods: {
    expandSettingSidebar() {
      let main = $(".main-content")[0];
      let sidebar = $(".sidebar")[0];
      let menutoggle = $('.menu-toggle-sidebar')[0];

      if (!menutoggle.classList.contains('active') && !this.expandSetting) {
        menutoggle.classList.add('active');
        main.classList.add('active');
        sidebar.classList.add('active');
      }
    },
    menuToggleSidebar() {
      let main = $(".main-content")[0];
      let sidebar = $(".sidebar")[0];
      let menutoggle = $('.menu-toggle-sidebar')[0];
      let settings = $('.menu-toggle-sidebar')[1];

      menutoggle.classList.toggle("active");
      main.classList.toggle("active");
      sidebar.classList.toggle("active");
      if (!menutoggle.classList.contains('active')) this.expandSetting = false;
    }
  }
}

</script>

<style scoped>
  .drop-menu {
    background: #eaeaea;
    padding-left: 63px !important;
  }
</style>
