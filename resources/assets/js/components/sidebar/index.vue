<template>
  <div>
    <link rel="stylesheet" :href="url + 'css/sidebar-admin.css'">
    <div id="dekstopVersion" class="md-medium-size-50 md-small-size-50 md-xsmall-hide">

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

        <footer>
          Copyright © {{ tahun }}
          <a href="https://andaglos.id/">
              PT. Andaglos Global Teknologi.
          </a>
        </footer>
      </div>
    </div>

    <div id="mobileVersion">
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
    <div class="main">
      <slot/>
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
  methods: {
    expandSettingSidebar() {
      let main = $(".main")[0];
      let sidebar = $(".sidebar")[0];
      let menutoggle = $('.menu-toggle-sidebar')[0];

      if (!menutoggle.classList.contains('active') && !this.expandSetting) {
        menutoggle.classList.add('active');
        main.classList.add('active');
        sidebar.classList.add('active');
      }
    },
    menuToggleSidebar() {
      let main = $(".main")[0];
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
