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
  .md-layout-item{
    padding:5px !important;
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
            <div class="md-toolbar" style="margin-top: -20px; padding: 4px">
              <div class="header-title md-toolbar-section-start" style="padding-right:10px">Laporan Order</div>
            </div>
          </md-card-header-text>
        </md-card-header>
        <md-card-content>
          <div class="row">
            <div class="col-md-9">
            </div>
            <div class="col-md-3">
              <input class="form-control" name="pencarian" v-model="search" placeholder="Masukan Pencarian disini ..." style="font-size : 13px; font-style: italic">
            </div>
          </div>
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
            <pagination :data="laporan_order" v-on:pagination-change-page="getLaporanOrderData" :limit="4"></pagination>
        </md-card-content>


      </md-card>
		</div>
	</sidebar>
</template>

<script>

export default {
  data: () => ({
  	url: window.location.origin + window.location.pathname + 'laporan-order',
    search: null,
    laporan_order: {},
    searchable_laporan_order: [],
    loading: true,
  }),
  created() {
    const app = this
  	app.getLaporanOrderData();
  },
  watch: {
    search() {
      const app = this
  	  app.getLaporanOrderData();
    }
  },
  filters: {
    currency(number) {
      return accounting.formatMoney(number, '', '2', '.', ',');
    }
  },
  methods: {
    getLaporanOrderData(page) {
      const app = this
      let url
      if(typeof page === 'undefined'){
        page = 1
      }
      app.search ? url = `${app.url}/pencarian?page=${page}&search=${app.search}` : url = `${app.url}/view?page=${page}`
      axios.get(url)
      .then(resp => {
        const { laporan_order } = resp.data
        app.laporan_order = laporan_order;
        app.searchable_laporan_order = laporan_order.data;
        app.loading = false;
      })
      .catch(resp => {
        console.log('catch getLaporanOrderData:', resp);
      })
  	}
  }
}
	
</script>
