<template>
  <sidebar>
    <div class="col-md-12" style="padding: 0">
      <md-card>
        <ul class="breadcrumb">
          <li><router-link :to="{ name: 'home' }">Home</router-link></li>
          <li class="active">Bank</li>
        </ul>
      </md-card>

  	<!-- Prompt delete bank -->
  	<md-dialog-confirm
      :md-active.sync="promptDeleteBank"
      md-title="Hapus Bank?"
      md-content="Apakah Anda yakin ingin menghapus Bank ini?"
      md-confirm-text="Ya"
      md-cancel-text="Batal"
      @md-confirm="onConfirmDelete" />

      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white">account_balance</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
              <div class="header-title md-toolbar-section-start">Bank</div>
              <div class="header-title md-toolbar-section-end">
                <div class="md-layout-item md-medium-size-50 md-small-size-50 md-xsmall-size-100">
                  <md-field md-inline>
                    <label class="media-screen-xsmall-hide" style="font-weight: 400">Cari Berdasarkan...</label>
                    <label class="media-screen-medium-hide" style="font-weight: 400">Cari Nama Bank...</label>
                     <label class="media-screen-medium-hide" style="font-weight: 400">Cari No Rekening...</label>
                    <md-input v-model="search" @input="searchOnTable" />
                  </md-field>
                </div>

                <div class="md-layout-item md-medium-size-50 md-small-size-50 md-xsmall-hide">
                  <md-field>
                    <md-select v-model="searchBy" @md-selected="searchOnTable" name="searchBy" id="searchBy" md-dense>
                      <md-option value="nama_bank">Nama Bank</md-option>
                      <md-option value="no_rek">No Rekening</md-option>
                    </md-select>
                  </md-field>
                </div>
              </div>
            </div>
          </md-card-header-text>
        </md-card-header>

        <md-card-content>

          <div class="md-toolbar-section-start">
                  <md-button :to="`/bank/create`" class="md-dense md-raised" style="background-color: #d44723; color: white"> Tambah Bank</md-button>
          </div>
          <div class="md-toolbar-section-end"></div>

          <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-fixed-header>
            <md-table-empty-state v-if="loading">
              <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
            </md-table-empty-state>
            <md-table-empty-state v-else-if="banks.length == 0" md-label="Tidak ada data"
                md-description="Belum ada data Bank yang tersimpan.">
            </md-table-empty-state>
            <md-table-empty-state v-else-if="banks.length > 0 && search != null" md-label="Tidak ada Bank ditemukan"
                :md-description="`Tidak ada Bank ditemukan untuk kata kunci '${search}'. Cobalah menggunakan kata kunci yang lain.`">
            </md-table-empty-state>

            <md-table-row slot="md-table-row" slot-scope="{ item }">
              <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
              <md-table-cell md-label="Nama Bank" md-sort-by="nama_bank">{{ item.nama_bank }}</md-table-cell>
              <md-table-cell md-label="a.n Bank" md-sort-by="atas_nama">{{ item.atas_nama }}</md-table-cell>
              <md-table-cell md-label="No Rekening" md-sort-by="no_rek">{{ item.no_rek }}</md-table-cell>
               <md-table-cell md-label="Aksi">
                <md-button :to="`/bank/edit/${item.id}`" class="md-fab md-dense md-primary">
                  <md-icon>edit</md-icon>
                  <md-tooltip md-direction="top">Edit</md-tooltip>
                </md-button>
                <md-button @click="deleteBank(item.id)" class="md-fab md-dense md-plain">
                  <md-icon>delete_forever</md-icon>
                  <md-tooltip md-direction="top">Hapus</md-tooltip>
                </md-button>
              </md-table-cell>
            </md-table-row>
          </md-table>

          <!-- Snackbar for Bank delete alert -->
        <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="snackbarDeleteBank" md-persistent>
            <span>Bank berhasil dihapus!</span>
          </md-snackbar>

        </md-card-content>
      </md-card>

    </div>
  </sidebar>
</template>

<script>
  const toLower = text => {
    return text.toString().toLowerCase();
  };

  const searchBank = (items, term, searchBy) => {
    if (term) {
      return items.filter(item => toLower(item[searchBy]).includes(toLower(term)));
    }

    return items;
  };

  export default {
    data: () => ({
    	url: window.location.origin + (window.location.pathname + 'bank/'),
      search: null,
	    promptDeleteBank: false,
			snackbarDeleteBank: false,
	    bankIdForDelete: '',
      searched: [],
      banks: [],
      searchBy: 'nama_bank',
      loading: true
    }),
    created() {
    	this.getBankData();
    },
    methods: {
    	getBankData() {
    		axios.get(this.url + 'view')
    		.then(resp => {
    			this.banks = resp.data;
    			this.searched = resp.data;
    			this.loading = false;
    		})
    		.catch(resp => {
    			console.log('Terjadi Kesalahan Data Bank :', resp);
    		});
    	},
    	onConfirmDelete() {
    		axios.delete(this.url + this.bankIdForDelete)
    		.then(resp => {
    			this.bankIdForDelete = '';
    			this.snackbarDeleteBank = true;
    			this.getBankData();
    		})
    		.catch(resp => {
    			console.log('Terjadi Kesalahan Konfirmasi Delete :', resp);
    		})
    	},
    	deleteBank(bankId) {
    		this.promptDeleteBank = true;
    		this.bankIdForDelete = bankId;
    	},
      searchOnTable() {
        this.searched = searchBank(this.banks, this.search, this.searchBy);
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
  .button-tambah{
    background-color:#d54624; 
  }
</style>