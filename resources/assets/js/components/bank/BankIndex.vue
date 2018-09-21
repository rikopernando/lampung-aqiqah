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

  	<!-- Prompt delete bank -->
  	<md-dialog-confirm
      :md-active.sync="promptDeleteBank"
      md-title="Hapus Bank?"
      md-content="Apakah Anda yakin ingin menghapus Bank ini?"
      md-confirm-text="Ya"
      md-cancel-text="Batal"
      @md-confirm="onConfirmDelete" />

      <md-dialog-alert 
        :md-active.sync="promptGagalHapus"
        md-title="Peringatan !!"
        md-content="Maaf bank telah disetting default tidak bisa dihapus, silakan ganti default banknya terlebih dahulu." />

      <md-card>
        <ul class="breadcrumb">
          <li><router-link :to="{ name: 'dashboard' }">Dashboard</router-link></li>
          <li class="active">Bank</li>
        </ul>
      </md-card>

      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white">account_balance</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 4px">
              <div class="header-title md-toolbar-section-start" style="padding-right:10px">Bank</div>
            </div>
          </md-card-header-text>
        </md-card-header>

        <md-card-content>

          <div class="row">
            <div class="col-md-9">
               <md-button :to="`/bank/create`" class="md-dense md-raised" style="background-color: #d44723; color: white"> Tambah Bank</md-button>
            </div>
            <div class="col-md-3">
              <input class="form-control" name="pencarian" v-model="search" placeholder="Masukan Pencarian disini ..." style="font-size : 13px; font-style: italic">
            </div>
          </div>

         <md-table v-model="searchable_bank" md-sort="name" md-sort-order="asc" md-fixed-header>
            <md-table-empty-state v-if="loading">
              <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
            </md-table-empty-state>
            <md-table-empty-state v-else-if="Object.keys(banks).length == 0" md-label="Tidak ada data"
                md-description="Belum ada data Bank yang tersimpan.">
            </md-table-empty-state>
            <md-table-empty-state v-else-if="Object.keys(banks).length > 0 && search != null" md-label="Tidak ada Bank ditemukan"
                :md-description="`Tidak ada Bank yang ditemukan untuk kata kunci '${search}'. Cobalah menggunakan kata kunci yang lain.`">
            </md-table-empty-state>

            <md-table-row slot="md-table-row" slot-scope="{ item }" >
              <md-table-cell md-label="ID" md-sort-by="id" md-numeric  >{{ item.id }}</md-table-cell>
              <md-table-cell md-label="Nama Bank" md-sort-by="nama_bank" >{{ item.nama_bank }}</md-table-cell>
              <md-table-cell md-label="a.n Bank" md-sort-by="atas_nama" >{{ item.atas_nama }}</md-table-cell>
              <md-table-cell md-label="No Rekening" md-sort-by="no_rek" >{{ item.no_rek }}</md-table-cell>
              <md-table-cell md-label="Default" style="text-align: center; padding-left: 15px;">
                <md-radio v-model="item.default"  @change="tampilDefault(item.id,item.default,item.nama_bank)" :value="false"></md-radio>
              </md-table-cell>
              <md-table-cell md-label="Edit">
                <md-button :to="`/bank/edit/${item.id}`" class="md-fab md-dense md-primary">
                  <md-icon>edit</md-icon>
                  <md-tooltip md-direction="top">Edit</md-tooltip>
                </md-button>
              </md-table-cell>
              <md-table-cell md-label="Hapus">
                <md-button @click="deleteBank(item.id,item.default)" class="md-fab md-dense md-plain">
                  <md-icon>delete_forever</md-icon>
                  <md-tooltip md-direction="top">Hapus</md-tooltip>
                </md-button>
              </md-table-cell>
            </md-table-row>
          </md-table>

          <pagination :data="banks" v-on:pagination-change-page="getBankData" :limit="4"></pagination>

        </md-card-content>
      </md-card>

      <!-- Snackbar for Bank delete alert -->
      <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="snackbarDeleteBank" md-persistent>
        <span>Bank berhasil dihapus!</span>
      </md-snackbar>

     <md-snackbar md-position="center" :md-duration="1500" :md-active.sync="notifSuccess">
        <span id="span-snackbar">{{notifMessage}}</span>
        <span><md-icon style="color: white">done_all</md-icon></span>
      </md-snackbar>

    </div>
  </sidebar>
</template>

<script>
  export default {
    data: () => ({
    	url: window.location.origin + window.location.pathname + 'bank',
      search: null,
	    promptDeleteBank: false,
			snackbarDeleteBank: false,
      promptGagalHapus : false,
	    bankIdForDelete: '',
      searchable_bank: [],
      banks: {},
      notifMessage: '',
      notifSuccess: false,
      loading: true,
    }),
    created() {
      const app = this
    	app.getBankData();
    },
    watch: {
      search() {
        const app = this
    	  app.getBankData();
      },
    },
    methods: {
    	getBankData(page = 1) {
        const app = this
        let url
        app.search ? url = `${app.url}/pencarian?page=${page}&search=${app.search}` : url = `${app.url}?page=${page}`  
    		axios.get(url)
    		.then(resp => {
          const { bank } = resp.data
          $.each(bank.data, (i, item) => {
            bank.data[i].default = item.default == 1 ? false : true;
          });
    			app.banks = bank
    			app.searchable_bank = bank.data 
    			app.loading = false;
    		})
    		.catch(resp => {
    			console.log('catch getBankData:', resp);
    		});
    	},
      tampilDefault(id, data, nama) {
        const app = this
        axios.get(`${app.url}/update-default-bank/${id}/${data}`)
        .then(resp => {
          app.notifMessage = `Bank ${nama.replace(/(^|\s)\S/g, l => l.toUpperCase())} Berhasil update Default.`
          app.notifSuccess = true;
          app.getBankData();
        })
        .catch(resp => {
          console.log('catch tampilDefault:', resp);
        })

      },
    	onConfirmDelete() {
        const app = this
    		axios.delete(`${app.url}/${app.bankIdForDelete}`)
    		.then(resp => {
    			app.bankIdForDelete = '';
    			app.snackbarDeleteBank = true;
    			app.getBankData();
    		})
    		.catch(resp => {
    			console.log('catch onConfirmDelete:', resp);
    		})
    	},
    	deleteBank(bankId,bankDefault) {
        const app = this
        if (bankDefault == false) {
          app.promptGagalHapus = true;
        } else {
          app.promptDeleteBank = true;
          app.bankIdForDelete = bankId;
        }   
    	}
    }
  }
</script>
