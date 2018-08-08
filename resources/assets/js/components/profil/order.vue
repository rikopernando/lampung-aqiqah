<template>
  <div>
    <md-card>
      <md-card-content>
        <md-card-header-text>
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

          <md-table-row slot="md-table-row" slot-scope="{ item }">
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
          </md-table-row>

        </md-table>
      </md-card-content>
    </md-card>
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
    props: ["orders", "searched"],
    data: () => ({
      search: null,
      loading: false,
      searchBy: 'nama_peserta',
    }),
    filters: {
        pemisahTitik: function (value) {
          var angka = [value];
          var numberFormat = new Intl.NumberFormat('es-ES');
          var formatted = angka.map(numberFormat.format);
          return formatted.join('; ');
        },
        capitalize: function (value) {
          return value.replace(/(^|\s)\S/g, l => l.toUpperCase())
        },
        tanggal: function (value) {
            return moment(String(value)).format('DD/MM/YYYY hh:mm')
        }
    },
    methods: {
      searchOnTable() {
        let app = this;
        app.searched = searchOrder(app.orders, app.search, app.searchBy);
      }
    }
  }
</script>
