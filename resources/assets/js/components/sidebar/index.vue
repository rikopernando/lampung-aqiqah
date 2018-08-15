<template>
  <div>
    <link rel="stylesheet" :href="url + 'css/sidebar-admin.css'">
    <div id="dekstopVersion" class="md-medium-size-50 md-small-size-50 md-xsmall-hide">

      <!-- Header -->
      <div class="header">
        <a href="#dashboard" id="menu-toggle" class="">
          <md-icon style="color: white">menu</md-icon>
          <span>Menu</span>
        </a>
        <div class="logo">
          Aqiqah Lampung
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
        <ul>
          <li>
            <router-link :to="{name: 'dashboard'}">
              <md-icon>dashboard</md-icon><span class="dekstop-menu">Dashboard</span>
            </router-link>
          </li>
          <li>
            <router-link :to="{name: 'produk'}">
              <md-icon>fastfood</md-icon><span class="dekstop-menu">Produk</span>
            </router-link>
          </li>
          <li>
            <router-link :to="{name: 'bank'}">
              <md-icon>attach_money</md-icon><span class="dekstop-menu">Bank</span>
            </router-link>
          </li>
          <li>
            <router-link :to="{name: 'user'}">
              <md-icon>account_box</md-icon><span class="dekstop-menu">User</span>
            </router-link>
          </li>
          <li>
            <router-link :to="{name: 'laporanOrder'}">
              <md-icon>notes</md-icon><span class="dekstop-menu">Laporan Order</span>
            </router-link>
          </li>
        </ul>

        <footer>
          Copyright © {{ tahun }}
          <a href="https://andaglos.id/">
              PT. Andaglos Global Teknologi.
          </a>
        </footer>
      </div>
    </div>

    <div id="mobileVersion">
      <md-toolbar class="md-primary toolbar-mobile" style="background-color: #d44723 !important;">
        <md-button class="md-icon-button" @click="showNavigation = true">
          <md-icon>menu</md-icon>
        </md-button>
        <span class="md-title">Aqiqah Lampung</span>

        <div class="md-toolbar-section-end">
          <md-button class="md-icon-button">
            <router-link :to="{name: 'logout'}" tag="div">
              <md-icon style="color: white">power_settings_new</md-icon>
            </router-link>
            <md-tooltip md-direction="left">Logout</md-tooltip>
          </md-button>
        </div>
      </md-toolbar>

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
    showSidepanel: false
  }),
  mounted() {
    var main = document.querySelector(".main");
    var sidebar = document.querySelector(".sidebar");
    var menutoggle = document.getElementById("menu-toggle");

    menutoggle.addEventListener("click", function(e) {
      menutoggle.classList.toggle("active");
      main.classList.toggle("active");
      sidebar.classList.toggle("active");

      sidebar.classList.contains("active") ? menutoggle.querySelector("i").classList.remove("fa-bars") : menutoggle.querySelector("i").classList.add("fa-bars");
    });
  }
}

</script>
