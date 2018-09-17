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
  .checkbox-list {
    padding-right: 0px !important
  }
  .md-table table {
    width: 0% !important;
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
          <li class="active">Produk</li>
        </ul>
      </md-card>

			<md-dialog-alert
				:md-active.sync="alert"
				md-title="Oooppss!"
				md-content="Produk tidak bisa dihapus karena sudah terpakai!" />


      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white">dns</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 4px">
              <div class="header-title md-toolbar-section-start" style="padding-right:10px">Produk</div>
              <div class="header-title md-toolbar-section-end">
                <div class="md-layout">
                <div class="md-layout-item md-medium-size-60 md-small-size-60 md-xsmall-size-60">
                  <md-field md-inline>
                      <label class="media-screen-xsmall-hide">Cari Dengan ...</label>
                      <label class="media-screen-medium-hide">Cari Dengan ...</label>
                    <md-input v-model="search" />
                  </md-field>
                </div>
                <div class="md-layout-item md-medium-size-40 md-small-size-40 md-xsmall-size-40">
                  <md-field>
                    <md-select v-model="searchBy" name="searchBy" id="searchBy" md-dense>
                      <md-option value="nama_produk">Nama</md-option>
                      <md-option value="harga_coret">Harga Coret</md-option>
                      <md-option value="harga_jual">Harga Jual</md-option>
                    </md-select>
                  </md-field>
                  </div>
                </div>
              </div>
            </div>
          </md-card-header-text>
        </md-card-header>

        <md-card-content>
          <md-button :to="`/produk/create`" class="md-dense md-raised" style="background-color: #d44723; color: white">Tambah Produk</md-button>
          <md-table v-model="searchable_produk" md-sort="name" md-sort-order="asc" md-fixed-header>
            <md-table-empty-state v-if="loading">
      		    <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
            </md-table-empty-state>
            <md-table-empty-state v-else-if="Object.keys(produks).length == 0" md-label="Tidak Ada Data"
                md-description="Belum Ada Produk Yang Tersimpan.">
            </md-table-empty-state>
            <md-table-empty-state v-else-if="Object.keys(produks).length > 0 && search != null" md-label="Produk Tidak Ditemukan"
                :md-description="`Tidak Ada Produk Dengan Kata Kunci '${search}'. Cobalah Menggunakan Kata Kunci Lain.`">
            </md-table-empty-state>

            <md-table-row slot="md-table-row" slot-scope="{item}">
              <md-table-cell md-label="Tampil Produk" style="text-align: center; padding-left: 15px;">
                <md-checkbox v-model="item.tampil_produk"
                  :disabled="(item.tampil_produk == false && maxChecked >= 4) || item.stok == 2"
                  @change="tampilProduk(item.id, item.tampil_produk, item.nama_produk)" />
              </md-table-cell>
              <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
              <md-table-cell md-label="Nama" md-sort-by="nama_produk">{{ item.nama_produk | capitalize }}</md-table-cell>
              <md-table-cell md-label="Harga Coret" md-sort-by="harga_coret">{{ item.harga_coret | currency }}</md-table-cell>
              <md-table-cell md-label="Harga Jual" md-sort-by="harga_jual">{{ item.harga_jual | currency }}</md-table-cell>
              <md-table-cell md-label="Stok" md-sort-by="stok">
                <span style="color: green" v-if="item.stok == 1">Tersedia</span>
                <span style="color: red" v-else>Tidak Tersedia</span>
              </md-table-cell>
              <md-table-cell md-label="Edit">
                <md-button :to="`/produk/edit/${item.id}`" class="md-fab md-dense md-primary">
                  <md-icon>edit</md-icon>
                  <md-tooltip md-direction="top">Edit</md-tooltip>
                </md-button>
              </md-table-cell>
              <md-table-cell md-label="Hapus">
                <md-button  @click="deleteProduk(item.id, item.nama_produk)" class="md-fab md-dense md-plain">
                  <md-icon>delete_forever</md-icon>
                  <md-tooltip md-direction="top">Hapus</md-tooltip>
                </md-button>
              </md-table-cell>
            </md-table-row>
          </md-table>

          <!-- Snackbar for success alert -->
          <md-snackbar md-position="center" :md-duration="1500" :md-active.sync="notifSuccess">
            <span id="span-snackbar">{{notifMessage}}</span>
            <span><md-icon style="color: white">done_all</md-icon></span>
          </md-snackbar>

          <div align="rigth">
            <pagination :data="produks" v-on:pagination-change-page="getProdukData" :limit="4"></pagination>
          </div>

        </md-card-content>
      </md-card>

      <md-dialog-confirm style="text-transform: capitalize" :md-active.sync="promptDelete" md-title="Konfirmasi Hapus"
        :md-content="notifMessage"
        md-confirm-text="Ya"
        md-cancel-text="Batal"
        @md-confirm="onConfirmDelete" />
    </div>
  </sidebar>
</template>


<script>
  const toLower = text => {
    return text.toString().toLowerCase();
  };

  export default {
    data: () => ({
    	url: window.location.origin + window.location.pathname,
      search: null,
	    promptDelete: false,
			snackbarDelete: false,
	    produkId: '',
      produkDelete: '',
      notifMessage: '',
      notifSuccess: false,
      searchable_produk: [],
      produks: {},
      searchBy: 'nama_produk',
      loading: true,
      maxChecked: 0,
      searchResult: {},
      alert: false
    }),
    mounted() {
      const app = this
    	app.getProdukData();
    },
    watch: {
      search() {
        const app = this
        app.searchProduks();
      },
      searchBy() {
        const app = this
        app.searchProduks();
      }
    },
    filters: {
      currency(number) {
        return accounting.formatMoney(number, '', '2', '.', ',')
      },
      capitalize: function (value) {
        return value.replace(/(^|\s)\S/g, l => l.toUpperCase())
      },
    },
    methods: {
      searchProduks() {
        const app = this
        if (app.search != null) {
          app.searchResult = app.produks.data.filter(item => toLower(item[app.searchBy]).includes(toLower(app.search)));
        } else {
          app.searchResult = app.produks.data;
        }
      },
      getPaginatedItems(value) {
        const app = this
        app.searchable_produk = value;
      },
    	getProdukData(page) {
        const app = this
        if(typeof page === 'undefined'){
          page = 1
        }
    		axios.get(`${app.url}produk?page=${page}`).then(resp => {
          const { produk } = resp.data
          $.each(produk.data, (i, item) => {
            produk.data[i].tampil_produk = item.tampil_produk == 1 ? true : false;
          });
          app.produks = produk;
      		app.searchable_produk = produk.data;
          app.jumlahTampil();
    			app.loading = false;
    		})
    		.catch(resp => {
          console.log('catch getProdukData:', resp);
    		});
    	},
      tampilProduk(id, data, nama) {
        const app = this
        let hasil = data == true ? "Ditampilkan" : "Disembunyikan";

    		axios.get(`${app.url}produk/update-tampil-produk/${id}/${data}`)
    		.then(resp => {
          app.jumlahTampil();
          app.notifMessage = `${nama.replace(/(^|\s)\S/g, l => l.toUpperCase())} Berhasil ${hasil}.`
          app.notifSuccess = true;
    		})
    		.catch(resp => {
    			console.log('catch tampilProduk:', resp);
    		})
      },
      jumlahTampil() {
        const app = this
        axios.get(`${app.url}produk/jumlah-tampil`)
    		.then(resp => {
          app.maxChecked = resp.data
    		})
    		.catch(resp => {
          console.log('catch jumlahTampil:', resp);
    			console.log(resp);
    		})
      },
    	onConfirmDelete() {
        const app = this
    		axios.delete(`${app.urlproduk}/${app.produkId}`)
    		.then(resp => {
          if(resp.data === 200){
              app.notifMessage = `Berhasil Menghapus Produk ${app.produkDelete}.`
              app.produkId = '';
              app.produkDelete = '';
              app.snackbarDelete = true;
              app.notifSuccess = true;
              app.getProdukData();
          }else{
              app.alert = true
          }
    		})
    		.catch(resp => {
    			console.log('catch onConfirmDelete:', resp);
    		})
    	},
    	deleteProduk(produkId, produkName) {
    		app.promptDelete = true;
    		app.produkId = produkId;
    		app.produkDelete = produkName;
    		app.notifMessage = `Apakah Anda Yakin Menghapus Produk <b>${produkName}</b> ?`;
    	}
    }
  }
</script>
