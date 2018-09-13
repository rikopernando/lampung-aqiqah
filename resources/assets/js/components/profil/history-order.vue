<template>
  <div>
    <div id="history">
      <md-card-header-text id="header-history">
        <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
          <div class="header-title md-toolbar-section-start">
          </div>
          <div class="header-title md-toolbar-section-end">
            <div class="md-layout-item md-medium-size-50 md-small-size-50 md-xsmall-size-100">
              <md-field md-inline>
                <label class="media-screen-xsmall-hide" style="font-weight: 400">Cari Berdasarkan...</label>
                <md-input v-model="search" />
              </md-field>
            </div>
            <div class="md-layout-item md-medium-size-50 md-small-size-50 md-xsmall-hide">
              <md-field>
                <md-select v-model="searchBy" name="searchBy" id="searchBy" md-dense>
                  <md-option value="id">Pesanan</md-option>
                  <md-option value="nama_peserta">Nama Peserta</md-option>
                  <md-option value="total">Total</md-option>
                </md-select>
              </md-field>
            </div>
          </div>
        </div>
      </md-card-header-text>

      <md-table v-model="searchableHistoryOrder" md-sort="name" md-sort-order="asc" md-fixed-header>
        <md-table-empty-state v-if="historyOrder.length == 0" md-label="Belum Ada Pesanan Yang Dibuat.">
          <md-button class="md-dense md-raised" style="background-color: #d44723; color: white">
            <a href="#/list-produk" style="color: white">Lanjutkan Belanja</a>
          </md-button>
        </md-table-empty-state>


        <md-table-empty-state v-else-if="historyOrder.length > 0 && search != null" md-label="Pesanan Tidak Ditemukan"
            :md-description="`Tidak Ada Pesanan Dengan Kata Kunci '${search}'. Cobalah Menggunakan Kata Kunci Lain.`">
        </md-table-empty-state>

        <md-table-row slot="md-table-row" slot-scope="{ item }" @click="detailPesanan(item.id)">
          <md-table-cell md-label="Pesanan" md-sort-by="id" md-numeric style="text-align: center">
            #{{ item.id }}
          </md-table-cell>
          <md-table-cell md-label="Nama Peserta`" md-sort-by="nama_peserta">
            {{ item.nama_peserta | capitalize }}
          </md-table-cell>
          <md-table-cell md-label="Total" md-sort-by="total">
            {{ item.total | currency }}
          </md-table-cell>
          <md-table-cell md-label="Pembayaran" md-sort-by="metode_pembayaran">
            {{ item.metode_pembayaran | capitalize }}
          </md-table-cell>
          <md-table-cell md-label="Waktu" md-sort-by="created_at">
            {{ item.created_at }}
          </md-table-cell>
        </md-table-row>
      </md-table>

      <paging
        v-if="!loading"
        :dataPaging="historyOrder"
        :itemPerPage="10"
        :range="5"
        :search="searchResult"
        @paginatedItems="getPaginatedItems($event)"></paging>

      <h4 style="text-align: left; color: red; padding-left: 40px"><i> * Klik Data Untuk Melihat Detail Pesanan</i></h4>
    </div>

    <div id="detailHistory" style="display: none">
      <div class="row">
      <h3 class="md-toolbar-section-start header-detail">Detail Pesanan #{{idPesanan}}</h3>
      <div class="md-toolbar-section-end kembali-detail">
        <md-button @click="kembali" class="md-dense md-raised" style="background-color: #d44723; color: white">
          Kembali
        </md-button>
      </div>
      </div>
      <md-table v-model="detailOrder" md-sort="name" md-sort-order="asc">
        <md-table-row slot="md-table-row" slot-scope="{ item }">
          <md-table-cell md-label="Nama`" md-sort-by="produk.nama_produk">
            {{ item.produk.nama_produk | capitalize }}
          </md-table-cell>
          <md-table-cell md-label="Jumlah" md-sort-by="jumlah_produk" style="text-align: right">
            {{ item.jumlah_produk }}
          </md-table-cell>
          <md-table-cell md-label="Harga" md-sort-by="harga_produk" style="text-align: right">
            {{ item.harga_produk | currency }}
          </md-table-cell>
          <md-table-cell md-label="Total" md-sort-by="subtotal" style="text-align: right">
            {{ item.subtotal | currency }}
          </md-table-cell>
        </md-table-row>
      </md-table>
    </div>
  </div>
</template>

<script>
  const toLower = text => {
    return text.toString().toLowerCase();
  };

  export default{
    data: () => ({
    	urlOrder: window.location.origin + (window.location.pathname + 'pesanan'),
      detailOrder: [],
      idPesanan: '',
      searchResult: {},
      search: null,
      searchBy: 'nama_peserta',
      historyOrder: {},
      searchableHistoryOrder: {},
      loading: true
    }),
    props: ["orders", "searched"],
    filters: {
      currency(number) {
        return accounting.formatMoney(number, '', '2', '.', ',');
      },
      capitalize(value) {
        return value.replace(/(^|\s)\S/g, l => l.toUpperCase())
      }
    },
    watch: {
      searched(data) {
        this.searchableHistoryOrder = data;
      },
      orders(data) {
        this.historyOrder = data;
      },
      search() {
        this.searchHistoryOrder();
      },
      searchBy() {
        this.searchHistoryOrder();
      },
      historyOrder(data) {
        if (data.length > 0) {
          this.loading = false;
        }
      }
    },
    methods: {
      searchHistoryOrder() {
        if (this.search != null) {
          this.searchResult = this.historyOrder.filter(item => toLower(item[this.searchBy]).includes(toLower(this.search)));
        } else {
          this.searchResult = this.historyOrder;
        }
      },
      getPaginatedItems(value) {
        this.searchableHistoryOrder = value;
      },
      detailPesanan(id) {
        this.idPesanan = id;

        axios.get(this.urlOrder + "/detail-order/" + id)
        .then(resp => {
          this.detailOrder = resp.data;
          $("#history").hide();
          $("#detailHistory").show();
        })
        .catch(resp => {
          console.log(resp);
        });
      },
      kembali() {
        $("#detailHistory").hide();
        $("#history").show();
      }
    }
  }
</script>
