<template>
<div>
  <md-card-header-text id="header-history">
    <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
      <div class="header-title md-toolbar-section-start">
      </div>
      <div class="header-title md-toolbar-section-end">
        <div class="md-layout-item md-medium-size-50 md-small-size-50 md-xsmall-size-100">
          <md-field md-inline>
            <label class="media-screen-xsmall-hide" style="font-weight: 400">Cari Berdasarkan...</label>
            <md-input v-model="search" @input="searchOnTable" />
          </md-field>
        </div>
        <div class="md-layout-item md-medium-size-50 md-small-size-50 md-xsmall-hide">
          <md-field>
            <md-select v-model="searchBy" @md-selected="searchOnTable" name="searchBy" id="searchBy" md-dense>
              <md-option value="id">Pesanan</md-option>
              <md-option value="nama_peserta">Nama Peserta</md-option>
              <md-option value="total">Total</md-option>
            </md-select>
          </md-field>
        </div>
      </div>
    </div>
  </md-card-header-text>

  <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-fixed-header>
    <md-table-empty-state v-if="loading">
      <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
    </md-table-empty-state>

    <md-table-empty-state v-else-if="orders.length == 0" md-label="Belum Ada Pesanan Yang Dibuat.">
      <md-button class="md-dense md-raised" style="background-color: #d44723; color: white">
        <a href="#/list-produk" style="color: white">Lanjutkan Belanja</a>
      </md-button>
    </md-table-empty-state>


    <md-table-empty-state v-else-if="orders.length > 0 && search != null" md-label="Pesanan Tidak Ditemukan"
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
        {{ item.total | pemisahTitik }}
      </md-table-cell>
      <md-table-cell md-label="Pembayaran" md-sort-by="metode_pembayaran">
        {{ item.metode_pembayaran | capitalize }}
      </md-table-cell>
      <md-table-cell md-label="Waktu" md-sort-by="created_at">
        {{ item.created_at }}
      </md-table-cell>
    </md-table-row>
  </md-table>
  <h4 style="text-align: left; color: red; padding-left: 40px"><i> * Klik Data Untuk Melihat Detail Pesanan</i></h4>

  <md-dialog :md-active.sync="showDialog">
      <md-dialog-title style="margin: 0px !important">
        Detail Pesanan #{{idPesanan}}
      </md-dialog-title>

      <md-table v-model="detailOrder" md-sort="name" md-sort-order="asc">
        <md-table-row slot="md-table-row" slot-scope="{ item }">
          <md-table-cell md-label="Nama Produk`" md-sort-by="produk.nama_produk">
            {{ item.produk.nama_produk | capitalize }}
          </md-table-cell>
          <md-table-cell md-label="Jumlah Produk" md-sort-by="jumlah_produk" style="text-align: right">
            {{ item.jumlah_produk | pemisahTitik }}
          </md-table-cell>
          <md-table-cell md-label="Harga Produk" md-sort-by="harga_produk" style="text-align: right">
            {{ item.harga_produk | pemisahTitik }}
          </md-table-cell>
          <md-table-cell md-label="Subtotal" md-sort-by="subtotal" style="text-align: right">
            {{ item.subtotal | pemisahTitik }}
          </md-table-cell>
        </md-table-row>
      </md-table>

      <md-dialog-actions>
        <md-button class="md-primary" @click="showDialog = false">Close</md-button>
      </md-dialog-actions>
    </md-dialog>
  </div>
</template>

<script>
  const toLower = text => {
    return text.toString().toLowerCase();
  };

  const searchOrder = (items, term, searchBy) => {
    if (term) {
      return items.filter(item => toLower(item[searchBy]).includes(toLower(term)));
    }
    return items;
  };

  export default{
    data: () => ({
    	urlOrder: window.location.origin + (window.location.pathname + 'pesanan'),
      detailOrder: [],
      idPesanan: '',
      showDialog: false
    }),
    props: ["orders", "searched", "search", "searchBy", "loading"],
    filters: {
        pemisahTitik: function (value) {
          var angka = [value];
          var numberFormat = new Intl.NumberFormat('es-ES');
          var formatted = angka.map(numberFormat.format);
          return formatted.join('; ');
        },
        capitalize: function (value) {
          return value.replace(/(^|\s)\S/g, l => l.toUpperCase())
        }
    },
    methods: {
      searchOnTable() {
        let app = this;
        app.searched = searchOrder(app.orders, app.search, app.searchBy);
      },
      detailPesanan(id) {
        let app = this;

        app.idPesanan = id;

        axios.get(app.urlOrder+"/detail-order/"+id)
        .then(resp => {
          app.detailOrder = resp.data;
          app.showDialog = true;
        })
        .catch(resp => {
          console.log(resp);
        });
      }
    }
  }
</script>
