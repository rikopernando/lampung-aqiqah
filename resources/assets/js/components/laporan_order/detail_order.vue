<style scoped>
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

      <md-dialog :md-active.sync="showDialog">
        <md-dialog-title> {{ showDialogTitle }} </md-dialog-title>
        <md-dialog-content v-if="loadingInDialog">
          <span v-if="emailLoading">Mengirim email...</span>
          <span v-else>Loading...</span>
          <md-progress-bar md-mode="indeterminate"></md-progress-bar>
        </md-dialog-content>
        <md-dialog-content v-else>
          <div v-if="emailFailed">
            <div v-if="closeDialogWhenEmailFailed">
              Menutup pop-up ini ketika email gagal dikirim menyebabkan Anda tidak dapat mengirim ulang email kembali. Kami menyarankan agar Anda mengirim ulang email mengingat opsi kirim ulang email tidak akan muncul lagi ketika anda menutupnya.
            </div>
            <div v-else> Email gagal dikirim karena gangguan server. </div>
          </div>
          <div v-else>
            <div v-if="emailSent"> Email berhasil dikirim! </div>
            <div v-else> {{ showDialogText }} </div>
          </div>
        </md-dialog-content>
        <md-dialog-actions v-if="!loadingInDialog">
          <span v-if="emailFailed">
            <md-button v-if="!closeDialogWhenEmailFailed" @click="closeDialogWhenEmailFailed = true"> Tutup </md-button>
            <md-button v-else @click="showDialog = false; emailLoading = false; emailFailed = false"> Tutup </md-button>
            <md-button @click="sendMail(showDialogKey.n, () => {
              this.loadingInDialog = false;
              this.emailSent = true;
              this.emailFailed = false;
              this.emailLoading = false;
            })"> Kirim Ulang </md-button>
          </span>
          <span v-else>
            <md-button @click="showDialog = false"> Tutup </md-button>
            <md-button v-if="!emailSent" @click="showDialogExecute"> Ya </md-button>
          </span>
        </md-dialog-actions>
      </md-dialog>

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
            <md-tab :md-label="tabInfoPemesan.label" :md-icon="tabInfoPemesan.icon">
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

            <md-tab :md-label="tabDetailPeserta.label" :md-icon="tabDetailPeserta.icon">
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

            <md-tab :md-label="tabAlamatPengiriman.label" :md-icon="tabAlamatPengiriman.icon">
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

            <md-tab :md-label="tabInfoPesanan.label" :md-icon="tabInfoPesanan.icon">
              <div v-if="statusPesanan == 0" class="md-toolbar" style="margin-top: -20px; padding: 0px">
                <div class="header-title md-toolbar-section-start">
                  <md-button class="md-dense md-raised" disabled>Pesanan telah dibatalkan</md-button>
                </div>
                <div class="header-title md-toolbar-section-end">
                </div>
              </div>
              <div v-else-if="statusPesanan == null" class="md-toolbar" style="margin-top: -20px; padding: 0px">
                <div class="header-title md-toolbar-section-start">
                  <md-button @click="showDialogData('Batalkan Pesanan?', 'Apakah Anda yakin ingin membatalkan pesanan ini?', {n: 0, email: false})" class="md-dense md-raised md-accent">Batalkan</md-button>
                </div>
                <div class="header-title md-toolbar-section-end">
                  <md-button @click="showDialogData('Konfirmasi', 'Apakah Anda yakin ingin mengonfirmasi pesanan ini?', {n: 1, email: true})" class="md-dense md-raised md-primary">Konfirmasi</md-button>
                </div>
              </div>
              <div v-else-if="statusPesanan == 1" class="md-toolbar" style="margin-top: -20px; padding: 0px">
                <div class="header-title md-toolbar-section-start">
                  <md-button @click="showDialogData('Batal Konfirmasi Pesanan', 'Apakah Anda yakin ingin membatalkan konfirmasi pesanan ini?', {n: null, email: false})" class="md-dense md-raised md-accent">Batal Konfirmasi</md-button>
                </div>
                <div class="header-title md-toolbar-section-end">
                  <md-button @click="showDialogData('Selesaikan Pesanan', 'Apakah Anda yakin ingin selesaikan pesanan ini?', {n: 2, email: true})" class="md-dense md-raised md-primary">Selesaikan</md-button>
                </div>
              </div>
              <div v-else-if="statusPesanan == 2" class="md-toolbar" style="margin-top: -20px; padding: 0px">
                <div class="header-title md-toolbar-section-start">
                  <md-button @click="showDialogData('Batal Selesaikan Pesanan', 'Apakah Anda yakin ingin membatalkan penyelesaian pesanan ini?', {n: 1, email: false})" class="md-dense md-raised md-accent">Batal Selesaikan Pesanan</md-button>
                </div>
                <div class="header-title md-toolbar-section-end">
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

      <!-- Snackbar pesanan dibatalkan -->
      <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="snackbarBatalkanPesanan" md-persistent>
        <span>Pesanan berhasil dibatalkan!</span>
      </md-snackbar>

      <!-- Snackbar pesanan diselesaikan -->
      <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="snackbarKonfirmasiPesanan" md-persistent>
        <span>Pesanan berhasil dikonfirmasi!</span>
      </md-snackbar>

      <!-- Snackbar pesanan diselesaikan -->
      <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="snackbarBatalKonfirmasiPesanan" md-persistent>
        <span>Konfirmasi Pesanan berhasil dibatalkan!</span>
      </md-snackbar>

      <!-- Snackbar pesanan diselesaikan -->
      <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="snackbarSelesaikanPesanan" md-persistent>
        <span>Pesanan berhasil diselesaikan!</span>
      </md-snackbar>

      <!-- Snackbar pesanan diselesaikan -->
      <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="snackbarBatalSelesaikanPesanan" md-persistent>
        <span>Selesaikan Pesanan berhasil dibatalkan!</span>
      </md-snackbar>

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
    statusPesanan: null,

    // snackbar
    snackbarBatalkanPesanan: false,
    snackbarKonfirmasiPesanan: false,
    snackbarBatalKonfirmasiPesanan: false,
    snackbarSelesaikanPesanan: false,
    snackbarBatalSelesaikanPesanan: false,
    windowWidth: 0,

    // tab
    tabInfoPemesan: {
      label: 'Info Pemesan',
      icon: 'perm_identity'
    },
    tabDetailPeserta: {
      label: 'Detail Peserta',
      icon: 'face'
    },
    tabAlamatPengiriman: {
      label: 'Alamat Pengiriman',
      icon: 'room'
    },
    tabInfoPesanan: {
      label: 'Info Pesanan',
      icon: 'shopping_cart'
    },
    emailLoading: false,
    loadingInDialog: false,
    emailSent: false,
    emailFailed: false,
    showDialog: false,
    showDialogTitle: '',
    showDialogText: '',
    showDialogKey: { n: null, email: false },
    closeDialogWhenEmailFailed: false
  }),
  watch: {
    windowWidth(width) {
      if (width > 660) {
        // desktop
        this.tabInfoPemesan = { label: 'Info Pemesan', icon: '' }
        this.tabDetailPeserta = { label: 'Detail Peserta', icon: '' }
        this.tabAlamatPengiriman = { label: 'Alamat Pengiriman', icon: '' }
        this.tabInfoPesanan = { label: 'Info Pesanan', icon: '' }
      } else {
        // mobile 
        this.tabInfoPemesan = { label: '', icon: 'perm_identity' }
        this.tabDetailPeserta = { label: '', icon: 'face' }
        this.tabAlamatPengiriman = { label: '', icon: 'room' }
        this.tabInfoPesanan = { label: '', icon: 'shopping_cart' }
      }
    }
  },
  mounted() {
    this.windowWidth = screen.width;
    this.$nextTick(() => {
      window.addEventListener('resize', () => {
        this.windowWidth = window.innerWidth
      });
    });
  },
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
        this.infoPesanan = resp.data;
      })
      .catch(resp => {
        console.log('catch getInfoPesanan:', resp);
      })
    },
    getStatusPesanan() {
      axios.get(this.url + '/status-pesanan/' + this.$route.params.id_pesanan)
      .then(resp => {
        this.statusPesanan = resp.data.status_pesanan;
      })
      .catch(resp => {
        console.log('catch getStatusPesanan:', resp);
      })
    },
    showDialogExecute() {
      this.loadingInDialog = true;
      setTimeout(() => {
        axios.post(this.url + '/ubah-status-pesanan', { id_pesanan: this.$route.params.id_pesanan, angka: this.showDialogKey.n })
        .then(resp => {
          this.getStatusPesanan();

          if (this.showDialogKey.email) {
            this.emailLoading = true;
            this.sendMail(this.showDialogKey.n, () => {
              this.loadingInDialog = false;
              this.emailSent = true;
              this.emailFailed = false;
              this.emailLoading = false;
            })
          } else {
            this.showDialog = false;
            this.loadingInDialog = false;
          }

          // snackbar
          if (this.showDialogKey.n == 0 && !this.showDialogKey.email) this.snackbarBatalkanPesanan = true;
          if (this.showDialogKey.n == 1 && this.showDialogKey.email) this.snackbarKonfirmasiPesanan = true;
          if (this.showDialogKey.n == null && !this.showDialogKey.email) this.snackbarBatalKonfirmasiPesanan = true;
          if (this.showDialogKey.n == 2 && this.showDialogKey.email) this.snackbarSelesaikanPesanan = true;
          if (this.showDialogKey.n == 1 && !this.showDialogKey.email) this.snackbarBatalSelesaikanPesanan = true;

        })
        .catch(resp => {
          console.log('catch batalkanPesanan:', resp);
        })
      }, 500);
    },
    showDialogData(title, text, n) {
      if (!this.emailLoading && !this.emailFailed) {
        this.showDialogTitle = title;
        this.showDialogText = text;
        this.emailSent = false;
        this.showDialogKey = {n: n.n, email: n.email};
        this.emailFailed = false;
        this.emailSent = false;
      }
      this.showDialog = true;
    },
    sendMail(n, cb) {
      this.loadingInDialog = true;
      this.emailLoading = true;
      axios.post(this.url + '/kirim-email', { id_pesanan: this.$route.params.id_pesanan, n: n })
      .then(resp => {
        console.log('then sendMail:', resp);
        cb();
      })
      .catch(resp => {
        console.log('catch sendMail:', resp);
        this.emailFailed = true;
        this.loadingInDialog = false;
        this.emailLoading = false;
        this.closeDialogWhenEmailFailed = false;
      })
    }
  }
}
	
</script>
