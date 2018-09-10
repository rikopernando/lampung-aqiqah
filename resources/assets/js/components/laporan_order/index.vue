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
        	<li><router-link :to="{name: 'dashboard'}">Dashboard</router-link></li>
        	<li class="active">Laporan Order</li>
      	</ul>
      </md-card>

      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white">notes</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
              <div class="header-title md-toolbar-section-start" style="padding-right:10px">Laporan Order</div>
              <div class="header-title md-toolbar-section-end">
                <div class="md-layout">
                  <div class="md-layout-item md-medium-size-60 md-small-size-60 md-xsmall-size-60">
    				        <md-field md-inline>
                      <label class="media-screen-xsmall-hide">Cari Dengan ...</label>
                      <label class="media-screen-medium-hide">Cari Laporan ...</label>
                      <md-input v-model="search" />
                    </md-field>
                  </div>
                  <div class="md-layout-item md-medium-size-40 md-small-size-40 md-xsmall-size-40">
                    <md-field>
                      <md-select v-model="searchBy" name="searchBy" id="searchBy" md-dense>
                        <md-option value="nama_pelanggan">Nama Pelanggan</md-option>
                        <md-option value="status_pesanan">Status Pesanan</md-option>
                      </md-select>
                    </md-field>
                  </div>
                </div>
              </div>
            </div>
          </md-card-header-text>
        </md-card-header>
        <md-card-content>
      		<md-table v-model="searchable_laporan_order" md-sort="name" md-sort-order="asc" md-fixed-header>
			      <md-table-empty-state v-if="loading">
					    <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
			      </md-table-empty-state>
			      <md-table-empty-state
			      	v-else-if="searchable_laporan_order.length == 0"
			        md-label="Tidak ada data"
			        md-description="Belum ada data Laporan yang tersimpan.">
			      </md-table-empty-state>    	
			      <md-table-empty-state
			      	v-if="searchable_laporan_order.length == 0 && search != null"
			        md-label="Tidak ada Laporan ditemukan"
			        :md-description="`Tidak ada Laporan ditemukan untuk kata kunci '${search}'. Cobalah menggunakan kata kunci yang lain.`">
			      </md-table-empty-state>

			      <md-table-row slot="md-table-row" slot-scope="{ item }">
			        <md-table-cell md-label="ID Order" md-sort-by="id_laporan" md-numeric>
                {{ item.id_pesanan }}
              </md-table-cell>
			        <md-table-cell md-label="Pelanggan" md-sort-by="nama_pelanggan">
                {{ item.nama_pelanggan }}
              </md-table-cell>
			        <md-table-cell md-label="Waktu" md-sort-by="waktu">
                <md-tooltip md-direction="top">{{ item.timeago }}</md-tooltip>
                {{ item.waktu }}
              </md-table-cell>
              <md-table-cell md-label="Total" md-sort-by="total">
                {{ item.total | currency }}
              </md-table-cell>
              <md-table-cell md-label="Status Pesanan">
                <div v-if="item.status_pesanan == null">
                  Belum Dikonfirmasi
                </div>
                <div v-else-if="item.status_pesanan == 0">
                  <span style="color: red;">Dibatalkan</span>
                </div>
                <div v-else-if="item.status_pesanan == 1">
                  <span style="color: green;">Belum Selesai</span>
                </div>
                <div v-else-if="item.status_pesanan == 2">
                  <span style="color: blue;">Selesai</span>
                </div>
              </md-table-cell>
              <md-table-cell md-label="Detail Order">
                <md-button :to="`/laporan-order/detail-order/${item.id_pesanan}`" class="md-dense md-primary">
                  Detail Order
                </md-button>
              </md-table-cell>
            </md-table-row>
          </md-table>
        </md-card-content>

        <!-- 
          PAGING:
          v-if (wajib) = agar jalan hanya saat loading selesai
          :dataPaging (wajib) = data Array of Object yang akan dipaging
          :itemPerPage (opsional) = jumlah item yang ditampilkan per halaman
          :range (opsional) = range paging
          :search (opsional) = data Array of Object hasil dari pencarian
          @paginatedItems (wajib) = event untuk mengambil hasil data yang dikembalikan dari component paging
         -->
        <paging
          v-if="!loading"
          :dataPaging="laporan_order"
          :itemPerPage="10"
          :range="5"
          :search="searchResult"
          @paginatedItems="getPaginatedItems($event)"></paging>

      </md-card>
		</div>
	</sidebar>
</template>

<script>

const toLower = text => {
  return text.toString().toLowerCase();
};

export default {
  data: () => ({
  	url: window.location.origin + (window.location.pathname + 'laporan-order'),
    search: null,
    laporan_order: {},
    searchable_laporan_order: {},
    loading: true,
    searchResult: {},
    searchBy: 'nama_pelanggan',
  }),
  created() {
  	this.getLaporanOrderData();
  },
  watch: {
    search(val) {
      this.searchLaporanOrder(val);
    },
    searchBy(val) {
      this.searchLaporanOrder(val);
    }
  },
  filters: {
    currency(number) {
      return accounting.formatMoney(number, '', '2', '.', ',');
    }
  },
  methods: {
    getPaginatedItems(value) {
      this.searchable_laporan_order = value;
    },
    searchLaporanOrder(val) {
      if (val != null) {
        if (this.searchBy == 'status_pesanan') {
          this.searchByStatusPesanan(val);
        } else {
          this.searchResult = this.laporan_order.filter(item => toLower(item.nama_pelanggan).includes(toLower(val)));
        }
      } else {
        this.searchResult = this.laporan_order;
      }
    },
    searchByStatusPesanan(term) {
      term = toLower(term);
      switch (term) {
        case 'belum dikonfirmasi':
          return this.searchResult = this.laporan_order.filter(item => toLower(String(item.status_pesanan)).includes('null'));
        break;
        case 'belum selesai':
          return this.searchResult = this.laporan_order.filter(item => toLower(String(item.status_pesanan)).includes('1'));
        break;
        case 'selesai':
          return this.searchResult = this.laporan_order.filter(item => toLower(String(item.status_pesanan)).includes('2'));
        break;
        case 'dibatalkan':
          return this.searchResult = this.laporan_order.filter(item => toLower(String(item.status_pesanan)).includes('0'));
        break;
        default:
          return this.searchResult = this.laporan_order;
      }
    },
    getLaporanOrderData() {
      axios.get(this.url + '/' + 'view')
      .then(resp => {
        this.laporan_order = resp.data;
        this.searchable_laporan_order = resp.data;
        this.loading = false;
      })
      .catch(resp => {
        console.log('catch getLaporanOrderData:', resp);
      })
  	}
  }
}
	
</script>
