<template>
  <sidebar>
    <div class="col-md-12" style="padding: 0">
      <md-card>
        <ul class="breadcrumb">
          <li><router-link :to="{name: 'home'}">Home</router-link></li>
          <li class="active">Produk</li>
        </ul>
      </md-card>

      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white">dns</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
              <div class="header-title md-toolbar-section-start">Produk</div>
              <div class="header-title md-toolbar-section-end">
                <div class="md-layout-item md-medium-size-50 md-small-size-50 md-xsmall-size-100">
                  <md-field md-inline>
                    <label class="media-screen-xsmall-hide" style="font-weight: 400">Cari Berdasarkan...</label>
                    <label class="media-screen-medium-hide" style="font-weight: 400">Cari Produk...</label>
                    <md-input v-model="search" @input="searchOnTable" />
                  </md-field>
                </div>
                <div class="md-layout-item md-medium-size-50 md-small-size-50 md-xsmall-hide">
                  <md-field>
                    <md-select v-model="searchBy" @md-selected="searchOnTable" name="searchBy" id="searchBy" md-dense>
                      <md-option value="nama_produk">Nama</md-option>
                      <md-option value="harga_coret">Harga Coret</md-option>
                      <md-option value="harga_jual">Harga Jual</md-option>
                    </md-select>
                  </md-field>
                </div>
              </div>
            </div>
          </md-card-header-text>
        </md-card-header>

        <md-card-content>
          <md-button :to="`/produk/create`" class="md-dense md-raised" style="background-color: #d44723; color: white">Tambah Produk</md-button>
          <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-fixed-header>
            <md-table-empty-state v-if="loading">
      		    <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
            </md-table-empty-state>
            <md-table-empty-state v-else-if="produks.length == 0" md-label="Tidak ada data"
                md-description="Belum ada data User yang tersimpan.">
            </md-table-empty-state>
            <md-table-empty-state v-else-if="produks.length > 0 && search != null" md-label="Tidak ada User ditemukan"
                :md-description="`Tidak ada User ditemukan untuk kata kunci '${search}'. Cobalah menggunakan kata kunci yang lain.`">
            </md-table-empty-state>

            <md-table-row slot="md-table-row" slot-scope="{item}">
              <md-table-cell md-label="Tampil Produk" style="text-align: center; padding-left: 15px;">
                <md-checkbox v-model="item.tampil_produk"
                  :disabled="(item.tampil_produk == false && maxChecked >= 4) || item.stok == 2"
                  @change="tampilProduk(item.id, item.tampil_produk, item.nama_produk)" />
              </md-table-cell>
              <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
              <md-table-cell md-label="Nama`" md-sort-by="nama_produk">{{ item.nama_produk | capitalize }}</md-table-cell>
              <md-table-cell md-label="Harga Coret" md-sort-by="harga_coret">{{ item.harga_coret | pemisahTitik }}</md-table-cell>
              <md-table-cell md-label="Harga Jual" md-sort-by="harga_jual">{{ item.harga_jual | pemisahTitik }}</md-table-cell>
              <md-table-cell md-label="Stok" md-sort-by="stok">
                <span style="color: green" v-if="item.stok === 1">Tersedia</span>
                <span style="color: red" v-else>Tidak Tersedia</span>
              </md-table-cell>
              <md-table-cell md-label="Aksi">
                <md-button :to="`/produk/edit/${item.id}`" class="md-fab md-dense md-primary">
                  <md-icon>edit</md-icon>
                  <md-tooltip md-direction="top">Edit</md-tooltip>
                </md-button>
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

  const searchProduk = (items, term, searchBy) => {
    if (term) {
      return items.filter(item => toLower(item[searchBy]).includes(toLower(term)));
    }

    return items;
  };

  export default {
    data: () => ({
    	url: window.location.origin + (window.location.pathname + 'produk/'),
      search: null,
	    promptDelete: false,
			snackbarDelete: false,
	    produkId: '',
      produkDelete: '',
      notifMessage: '',
      notifSuccess: false,
      searched: [],
      produks: [],
      searchBy: 'nama_produk',
      loading: true,
      maxChecked: 0
    }),
    created() {
    	this.getProdukData();
    },
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
    },
    methods: {
    	getProdukData() {
        let app = this;
    		axios.get(app.url + 'view')
    		.then(resp => {
          $.each(resp.data, function (i, item) {
            resp.data[i].tampil_produk = item.tampil_produk == 1 ? true : false;
          });

          app.produks = resp.data;
      		app.searched = resp.data;
          app.jumlahTampil(app)

    			app.loading = false;
    		})
    		.catch(resp => {
    			console.log(resp);
    		});
    	},
      tampilProduk(id, data, nama) {
        let app = this;
        let hasil = data == true ? "Ditampilkan" : "Disembunyikan";

    		axios.get(app.url+"update-tampil-produk/"+id+"/"+data)
    		.then(resp => {
          app.jumlahTampil(app)
          app.notifMessage = `${nama.replace(/(^|\s)\S/g, l => l.toUpperCase())} Berhasil ${hasil}.`
          app.notifSuccess = true;
    		})
    		.catch(resp => {
    			console.log('catch onConfirmDelete:', resp);
    		})
      },
      jumlahTampil(app) {
        axios.get(app.url+"jumlah-tampil")
    		.then(resp => {
          app.maxChecked = resp.data
    		})
    		.catch(resp => {
    			console.log(resp);
    		})
      },
    	onConfirmDelete() {
        let app = this;
    		axios.delete(app.url + app.produkId)
    		.then(resp => {
          app.notifMessage = `Berhasil Menghapus Produk ${app.produkDelete}.`
    			app.produkId = '';
    			app.produkDelete = '';
    			app.snackbarDelete = true;
          app.notifSuccess = true;
    			app.getProdukData();
    		})
    		.catch(resp => {
    			console.log('catch onConfirmDelete:', resp);
    		})
    	},
    	deleteProduk(produkId, produkName) {
        let app = this;

    		app.promptDelete = true;
    		app.produkId = produkId;
    		app.produkDelete = produkName;
    		app.notifMessage = `Apakah Anda Yakin Menghapus Produk <strong>${produkName}</strong> ?`;
    	},
      searchOnTable() {
        this.searched = searchProduk(this.produks, this.search, this.searchBy);
      }
    }
  }
</script>

<style scoped>
	@media (max-width: 600px) {
		.media-screen-medium-hide {
			display: block;
		}
		.media-screen-xsmall-hide {
			display: none
		}
	}
	@media (min-width: 601px) {
		.media-screen-xsmall-hide {
			display: block;
		}
		.media-screen-medium-hide {
			display: none;
		}
	}
</style>


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
  .checkbox-list {
    padding-right: 0px !important
  }
  .md-table table {
    width: 0% !important;
  }
</style>
