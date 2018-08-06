<style scoped>
p {
  font-size: 16px;
  line-height: 1.428571429;
}

.header {
  position: fixed;
  z-index: 10;
  top: 0;
  left: 0;
  background: #d44723;
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
  transition: all .2s ease-in-out;
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
  height: 100%;
  width: 60px;
  background: #fff;
  border-right: 1px solid #ddd;
  text-align: center;
  transition: all .2s ease-in-out;
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
  border-bottom: 1px solid #ddd;
  color: #444;
  text-align: left;
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
.sidebar ul li a:hover i {
  opacity: .9;
}

.main {
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
  transition: all .2s ease-in-out;
}
.main.active {
  padding-left: 275px;
  transition: all .2s ease-in-out;
}
.main .jumbotron {
  background-color: #fff;
  padding: 30px !important;
  border: 1px solid #dfe8f1;
  border-radius: 3px;
}
.main .jumbotron h1 {
  font-size: 24px;
  margin: 0;
  padding: 0;
  margin-bottom: 12px;
}
.main .footer {
  align-self: flex-end;
  /*background: #fff;*/
  padding: 15px;
}
.main .footer p {
  color: #bbb;
}
</style>

<template>
  <div>
    <div class="header">
      <a href="#" id="menu-toggle" class="">
        <md-icon style="color: white">menu</md-icon>
        <span>Menu</span>
      </a>
      <div class="logo">
        Aqiqah Lampung
      <div class="pull-right">
        <md-icon style="color: white">power_settings_new</md-icon>
        <span class="btn" style="color: white; font-weight: bold">
          <router-link :to="{name: 'logout'}" tag="div">Logout</router-link>
        </span>
      </div>
      </div>
    </div>
    <div class="sidebar">
      <ul>
        <li>
          <router-link :to="{name: 'dashboard'}">
            <md-icon>dashboard</md-icon><span>Dashboard</span>
          </router-link>
        </li>
        <li>
          <router-link :to="{name: 'produk'}">
            <md-icon>fastfood</md-icon><span>Produk</span>
          </router-link>
        </li>
        <li>
          <router-link :to="{name: 'bank'}">
            <md-icon>attach_money</md-icon><span>Bank</span>
          </router-link>
        </li>
        <li>
          <router-link :to="{name: 'user'}">
            <md-icon>account_box</md-icon><span>User</span>
          </router-link>
        </li>
      </ul>
    </div>

    <!-- Content -->
    <div class="main">
      <slot>
      </slot>
      <div class="footer">
        <p>Copyright © 2018 PT. Andaglos Global Teknologi.</p>
      </div>
    </div>
  </div>
</template>
<script>

export default {
  mounted() {
    this.init()
  },
  methods: {
    init() {
      var main = document.querySelector(".main");
      var sidebar = document.querySelector(".sidebar");
      var menutoggle = document.getElementById("menu-toggle");
      console.log(menutoggle)

      menutoggle.addEventListener("click", function(e) {
        menutoggle.classList.toggle("active");
        main.classList.toggle("active");
        sidebar.classList.toggle("active");

        if (sidebar.classList.contains("active")) {
          menutoggle.querySelector("i").classList.remove("fa-bars");
        } else {
          menutoggle.querySelector("i").classList.add("fa-bars");
        }
      });
    }
  }
}

</script>