<template>
  <div>
    <Header></Header>
      <div class="container">
          <md-card md-with-hover>
            <ul class="breadcrumb">
              <li><a href="#/">Home</a></li>
              <li class="active">Akun</li>
            </ul>
          </md-card>

          <md-card md-with-hover>
						<md-card-header>
                <div class="md-toolbar-section-start">
                  <a href="#/akun" class="simple-text logo-mini">
                    <div class="wrapper">
                      <img src="https://www.fancyhands.com/images/default-avatar-250x250.png" alt="" class="image--cover" />
                    </div>
                  </a>

                  <div class="md-title" style="color: #868686">
                    Rindang Ramadhan
                  </div>
                </div>
						</md-card-header>

						<md-card-content>

              <div class="row">
                <div class="col-md-3">
                  <ul class="nav nav-tabs tabs-left sideways">
                    <li class="active"><a style="color: #db4a24" href="#dashboard-v" data-toggle="tab">DASHBOARD</a></li>
                    <li><a style="color: #db4a24" href="#order-v" data-toggle="tab">ORDER</a></li>
                    <li><a style="color: #db4a24" href="#alamat-v" data-toggle="tab">ALAMAT</a></li>
                    <li><a style="color: #db4a24" href="#akun-v" data-toggle="tab">DETAIL AKUN</a></li>
                    <li><a style="color: #db4a24" @click="logout()" data-toggle="tab">KELUAR</a></li>
                  </ul>
                </div>
                <div class="col-md-9">
                  <div class="tab-content">
                    <div class="tab-pane active" id="dashboard-v">DASHBOARD</div>
                    <div class="tab-pane" id="order-v">ORDER</div>
                    <div class="tab-pane" id="alamat-v">ALAMAT</div>
                    <div class="tab-pane" id="akun-v">DETAIL AKUN</div>
                  </div>
                </div>
              </div>

              <form id="logout-form" v-bind:action="url+'logout'" method="POST" style="display: none;">
                <input type="hidden" name="_token" v-bind:value="token">
              </form>

						</md-card-content>

          </md-card>
      </div>
    <Footer></Footer>
  </div>
</template>

<script>

  import Header from '../header'
  import Footer from '../footer/footer'

  export default {
    data : () => ({
      dataPesanan: [
        { header: 'Nomor Order', content: '#519' },
        { header: 'Tanggal', content: '27 Juli 2018' },
        { header: 'Total', content: 'Rp. 6.700.000' },
        { header: 'Metode Pembayaran', content: 'Transfer Bank' },
        { header: 'Bank', content: 'BNI SYARIAH' },
        { header: 'Nomor Rekening', content: '3737-8899-21' },
        { header: 'Atas Nama', content: 'Iwan Setiawan' },
      ],
      dataPemesan: [
        { judul: 'Kecamatan', isi: 'Kemiling' },
        { judul: 'Sumber Informasi', isi: 'Website' },
        { judul: 'Nama Peserta', isi: 'Muhammad Zamhari' },
        { judul: 'Tempat, Tanggal Lahir', isi: 'Lampung, 13 Juli 2015' },
        { judul: 'Jenis Kelamin', isi: 'Laki - Laki' },
        { judul: 'Nama Ayah', isi: 'Sujarwono' },
        { judul: 'Nama Ibu', isi: 'Siti Hanifah' },
        { judul: 'Lahir Di (Nama RSB / Bidan)', isi: 'RS Ibu dan Anak Asih' },
      ]
    }),
    methods: {
      logout() {
        document.getElementById('logout-form').submit();
        this.$store.commit('user/LOGOUT')
      }
    },
    components : {
      Header,Footer
    },
  }

</script>

<style lang="scss" scoped>
  .breadcrumb {
    border-color: #ffffff;
    border-style: solid;
    border-width: 0 1px 4px 1px;
    padding: 8px 15px;
    margin-bottom: 35px;
    margin-top: 22px;
    list-style: none;
    background-color: #ffffff;
    border-radius: 4px;
  }

  .image--cover {
    width: 85px;
    height: 85px;
    border-radius: 50%;
    margin: 5px;

    object-fit: cover;
    object-position: center right;
  }

  .tabs-left {
    border-bottom: none;
    border-right: 1px solid #ddd;
  }

  .tabs-left>li {
    float: none;
    margin:0px;
  }

  .tabs-left>li.active>a,
  .tabs-left>li.active>a:hover,
  .tabs-left>li.active>a:focus {
    border-bottom-color: #ddd;
    border-right-color: transparent;
    background:#db4a24;
    color: #fff !important;
    border:none;
    border-radius:0px;
    margin:0px;
  }

  .nav-tabs>li>a:hover {
    line-height: 1.42857143;
    border: 1px solid transparent;
  }

  .tabs-left>li.active>a::after{content: "";
    position: absolute;
    top: 10px;
    right: -10px;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    border-left: 10px solid #db4a24;
    color: #fff !important;
    display: block;
    width: 0;
  }
</style>
