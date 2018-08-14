<template>
	<sidebar>
    <md-dialog :md-active.sync="showDialog">
      <md-dialog-title>
        Produk
      </md-dialog-title>

      <md-dialog-actions>
        <md-button class="md-primary" @click="showDialog = false">Tutup</md-button>
      </md-dialog-actions>
    </md-dialog>

		<div class="col-md-12" style="padding: 0">
			<md-card>
      	<ul class="breadcrumb">
        	<li><router-link :to="{name: 'home'}">Home</router-link></li>
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
              <div class="header-title md-toolbar-section-start">Laporan Order</div>
              <div class="header-title md-toolbar-section-end">
				        <md-field md-inline>
				        	<label>Cari Laporan...</label>
				          <md-input v-model="search" @input="searchOnTable" />
				        </md-field>
              </div>
            </div>
          </md-card-header-text>
        </md-card-header>
        <md-card-content>
      		<md-table v-model="searched" md-sort="name" md-sort-order="asc" md-fixed-header>
			      <md-table-empty-state v-if="loading">
					    <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
			      </md-table-empty-state>
			      <md-table-empty-state
			      	v-else-if="laporan_order.length == 0"
			        md-label="Tidak ada data"
			        md-description="Belum ada data Laporan yang tersimpan.">
			      </md-table-empty-state>    	
			      <md-table-empty-state
			      	v-else-if="laporan_order.length > 0 && search != null"
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
                  <span style="color: red;">Ditolak/Dibatalkan</span>
                </div>
                <div v-else-if="item.status_pesanan == 1">
                  Belum Selesai
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
      </md-card>
		</div>
	</sidebar>
</template>

<script>

const toLower = text => {
  return text.toString().toLowerCase();
};

const searchLaporanOrder = (items, term) => {
  if (term) {
    return items.filter(item => toLower(item.nama_pelanggan).includes(toLower(term)));
  }

  return items;
};

export default {
  data: () => ({
  	url: window.location.origin + (window.location.pathname + 'laporan-order'),
    search: null,
    searched: {},
    laporan_order: {},
    loading: true,
    showDialog: false,
    detail_order: {},
  }),
  created() {
  	this.getLaporanOrderData();
  },
  filters: {
    currency(number) {
      return accounting.formatMoney(number, '', '2', '.', ',')
    }
  },
  methods: {
    getLaporanOrderData() {
      axios.get(this.url + '/' + 'view')
      .then(resp => {
        console.log(resp.data)
        this.laporan_order = resp.data;
        this.searched = resp.data;
        this.loading = false;
      })
      .catch(resp => {
        console.log('catch getLaporanOrderData:', resp);
      })
  	},
    searchOnTable() {
      this.searched = searchLaporanOrder(this.laporan_order, this.search);
      this.loading = false;
    },
    showDialogDetailOrder(detail_order) {
      this.showDialog = true;
      this.detail_order = detail_order;
    }
  }
}
	
</script>

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