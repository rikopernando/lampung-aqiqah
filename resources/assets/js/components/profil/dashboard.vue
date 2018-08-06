<template>
  <div>
    <md-card>
      <md-card-content>
        <p class="md-subheading">
          Halo <b>{{ user.name }}</b> (bukan <b>{{ user.name }}</b> ? ) <router-link :to="{name: 'logout'}" tag="div" style="color: blue">KELUAR</router-link>
        </p><br>
        <p class="subheading">
          Dari Dashboard akun Anda, Anda dapat melihat pesanan terbaru Anda,
          mengelola alamat pengiriman dan penagihan Anda
          dan mengedit kata sandi dan detail akun Anda.
        </p>
        <br>

        <!-- DASHBOARD CARD -->
        <div class="row" id="portfolio">
          <div class="col-md-4 col-xs-6">
            <div class="card border-card" id="orderCard">
              <div class="card-title">ORDER</div>
              <div class="card-icon"><i class="material-icons">shopping_basket</i></div>
              <div class="card-data"></div>
              <hr/>
              <div class="card-hint">
                <i class="material-icons">list</i>
                <a href="#order-v" data-toggle="tab">Lihat Pesanan</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-xs-6">
            <div class="card border-card" id="alamatCard">
              <div class="card-title">ALAMAT</div>
              <div class="card-icon"><i class="material-icons">location_on</i></div>
              <div class="card-data"></div>
              <hr/>
              <div class="card-hint">
                <i class="material-icons">edit_location</i>
                <a href="#alamat-v" data-toggle="tab">Kelola Alamat</a>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-xs-6">
            <div class="card border-card" id="akunCard">
              <div class="card-title">AKUN</div>
              <div class="card-icon"><i class="material-icons">account_circle</i></div>
              <div class="card-data"></div>
              <hr/>
              <div class="card-hint">
                <i class="material-icons">edit</i>
                <a href="#akun-v" data-toggle="tab">Ubah Akun</a>
              </div>
            </div>
          </div>
        </div>
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
  export default {
    props: ["user"],
    methods: {
      logout() {
        document.getElementById('logout-form').submit();
        this.$store.commit('user/LOGOUT')
      }
    }
  }
}

</script>
