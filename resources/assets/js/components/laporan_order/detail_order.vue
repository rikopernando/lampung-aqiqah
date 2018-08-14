<style scoped>
  @media (max-width: 620px) {
    .media-screen-medium-hide {
      display: block;
    }
    .media-screen-xsmall-hide {
      display: none
    }
  }
  @media (min-width: 621px) {
    .media-screen-xsmall-hide {
      display: block;
    }
    .media-screen-medium-hide {
      display: none;
    }
  }
  .breadcrumb {
    border-color: #ffffff;
    border-style: solid;
    border-width: 0 1px 4px 1px;
    padding: 8px 15px;
    margin-bottom: 35px;
    list-style: none;
    background-color: #ffffff;
    border-radius: 4px;
  }
  .header-card i {
    background-color: #d44723;
    width: 50px;
    height: 50px;
    text-align: center;
    line-height: 50px;
    border-radius: 3px;
    font-size: 30px !important;
    margin: -30px 0px 0;
    position: relative;
    box-shadow: -4px -3px 0px 0px #ff000045;
  }
  .header-title {
    color: #867f7f;
    font-size: 20px;
    padding: 4px 0px 0px 10px;
  }
</style>

<template>
	<sidebar>
		<div class="col-md-12" style="padding: 0">
			<md-card>
      	<ul class="breadcrumb">
          <li><router-link :to="{name: 'home'}">Home</router-link></li>
        	<li><router-link :to="{name: 'laporanOrder'}">Laporan Order</router-link></li>
        	<li class="active">Detail Order</li>
      	</ul>
      </md-card>

      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white">notes</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
              <div class="header-title md-toolbar-section-start">Detail Order</div>
            </div>
          </md-card-header-text>
        </md-card-header>
        <md-card-content>
      		<md-tabs class="md-transparent" md-alignment="fixed">

            <md-tab md-label="Info Pemesan">
              <md-progress-bar v-if="loading" md-mode="indeterminate"></md-progress-bar>
              <md-table v-else v-model="infoPemesan">
                <md-table-row slot="md-table-row" slot-scope="{ item }">
                  <md-table-cell md-label="Entri">
                    {{ item.entri }}
                  </md-table-cell>
                  <md-table-cell md-label="">
                    <b>:</b>
                  </md-table-cell>
                  <md-table-cell md-label="Keterangan">
                    {{ item.keterangan }}
                  </md-table-cell>
                </md-table-row>
              </md-table>
            </md-tab>

            <md-tab md-label="Detail Peserta">
              <md-table v-model="detailPeserta">
                <md-table-row slot="md-table-row" slot-scope="{ item }">
                  <md-table-cell md-label="Entri">
                    {{ item.entri }}
                  </md-table-cell>
                  <md-table-cell md-label="">
                    <b>:</b>
                  </md-table-cell>
                  <md-table-cell md-label="Keterangan">
                    {{ item.keterangan }}
                  </md-table-cell>
                </md-table-row>
              </md-table>
            </md-tab>

            <md-tab md-label="Alamat Pengiriman">
              <md-table v-model="alamatPengiriman">
                <md-table-row slot="md-table-row" slot-scope="{ item }">
                  <md-table-cell md-label="Entri">
                    {{ item.entri }}
                  </md-table-cell>
                  <md-table-cell md-label="">
                    <b>:</b>
                  </md-table-cell>
                  <md-table-cell md-label="Keterangan">
                    {{ item.keterangan }}
                  </md-table-cell>
                </md-table-row>
              </md-table>
            </md-tab>

            <md-tab md-label="Info Pesanan">
              <div v-if="statusPesanan == null" class="md-toolbar" style="margin-top: -20px; padding: 0px">
                <div class="header-title md-toolbar-section-start">
                  <md-button class="md-dense md-raised md-accent">Batalkan</md-button>
                </div>
                <div class="header-title md-toolbar-section-end">
                  <md-button @click="konfirmasiPesanan()" class="md-dense md-raised md-primary">Konfirmasi</md-button>
                </div>
              </div>
              <div v-else-if="statusPesanan == 1" class="md-toolbar" style="margin-top: -20px; padding: 0px">
                <div class="header-title md-toolbar-section-start">
                  <md-button class="md-dense md-raised md-accent">Batal Konfirmasi</md-button>
                </div>
                <div class="header-title md-toolbar-section-end">
                  <md-button class="md-dense md-raised md-primary">Selesaikan</md-button>
                </div>
              </div>

              <md-table v-model="infoPesanan">
                <md-table-row slot="md-table-row" slot-scope="{ item }">
                  <md-table-cell md-label="Nama Produk" md-sort-by="nama_produk">
                    {{ item.nama_produk }}
                  </md-table-cell>
                  <md-table-cell md-label="Harga" md-sort-by="harga">
                    {{ item.harga | currency }}
                  </md-table-cell>
                  <md-table-cell md-label="Qty" md-sort-by="qty">
                    {{ item.qty }}
                  </md-table-cell>
                </md-table-row>
              </md-table>
            </md-tab>

          </md-tabs>
        </md-card-content>
      </md-card>
		</div>
	</sidebar>
</template>

<script>

export default {
  data: () => ({
  	url: window.location.origin + (window.location.pathname + 'laporan-order'),
    loading: true,
    infoPemesan: {},
    detailPeserta: {},
    alamatPengiriman: {},
    infoPesanan: {},
    statusPesanan: null
  }),
  created() {
    this.getLaporanOrderData();
  	this.getInfoPesanan();
    this.getStatusPesanan();
  },
  filters: {
    currency(number) {
      return accounting.formatMoney(number, '', '2', '.', ',')
    }
  },
  methods: {
    getLaporanOrderData() {
      axios.get(this.url + '/detail-order/' + this.$route.params.id_pesanan)
      .then(resp => {
        console.log(resp.data)
        this.infoPemesan = resp.data[0];
        this.detailPeserta = resp.data[1];
        this.alamatPengiriman = resp.data[2];
        this.loading = false;
      })
      .catch(resp => {
        console.log('catch getLaporanOrderData:', resp);
      })
  	},
    getInfoPesanan() {
      axios.get(this.url + '/info-pesanan/' + this.$route.params.id_pesanan)
      .then(resp => {
        console.log('then getInfoPesanan:', resp.data);
        this.infoPesanan = resp.data;
      })
      .catch(resp => {
        console.log('catch getInfoPesanan:', resp);
      })
    },
    getStatusPesanan() {
      axios.get(this.url + '/status-pesanan/' + this.$route.params.id_pesanan)
      .then(resp => {
        // console.log('then getStatusPesanan:', resp.data.status_pesanan);
        this.statusPesanan = resp.data.status_pesanan;
        console.log('then getStatusPesanan:', this.status_pesanan);
      })
      .catch(resp => {
        console.log('catch getStatusPesanan:', resp);
      })
    },
    konfirmasiPesanan() {
      axios.get(this.url + '/konfirmasi-pesanan/' + this.$route.params.id_pesanan)
      .then(resp => {
        console.log('then konfirmasiPesanan:', resp.data);
        this.getStatusPesanan();
      })
      .catch(resp => {
        console.log('catch konfirmasiPesanan:', resp);
      })
    }
  }
}
	
</script>
