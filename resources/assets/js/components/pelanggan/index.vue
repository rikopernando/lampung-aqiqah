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

	  	<!-- Prompt delete pelanggan -->
	  	<md-dialog-confirm
	      :md-active.sync="promptDeletePelanggan"
	      md-title="Hapus Pelanggan?"
	      md-content="Apakah Anda yakin ingin menghapus Pelanggan ini?"
	      md-confirm-text="Ya"
	      md-cancel-text="Batal"
	      @md-confirm="onConfirmDelete" />

			<md-dialog-alert
				:md-active.sync="alert"
				md-title="Oooppss!"
				md-content="Pelanggan tidak bisa dihapus karena sudah terpakai!" />

     	<md-card>
      	<ul class="breadcrumb">
        	<li><router-link :to="{name: 'dashboard'}">Dashboard</router-link></li>
        	<li class="active">Pelanggan</li>
      	</ul>
      </md-card>

      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white">contacts</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 4px">
              <div class="header-title md-toolbar-section-start" style="padding-right:10px">Pelanggan</div>
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
						            <md-option value="name">Nama</md-option>
						            <md-option value="email">Email</md-option>
						          </md-select>
						        </md-field>
			        		</div>
			        	</div>
              </div>
            </div>
          </md-card-header-text>
        </md-card-header>
        <md-card-content>
          <md-button :to="`/pelanggan/create`" class="md-dense md-raised" style="background-color: #d44723; color: white">Tambah Pelanggan</md-button>
      		<md-table v-model="searchable_pelanggan" md-sort="name" md-sort-order="asc" md-fixed-header>
			      <md-table-empty-state v-if="loading">
					    <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
			      </md-table-empty-state>
			      <md-table-empty-state
			      	v-else-if="pelanggans.length == 0"
			        md-label="Tidak ada data"
			        md-description="Belum ada data Pelanggan yang tersimpan.">
			      </md-table-empty-state>
			      <md-table-empty-state
			      	v-else-if="pelanggans.length > 0 && search != null"
			        md-label="Tidak ada Pelanggan ditemukan"
			        :md-description="`Tidak ada Pelanggan ditemukan untuk kata kunci '${search}'. Cobalah menggunakan kata kunci yang lain.`">
			      </md-table-empty-state>

			      <md-table-row slot="md-table-row" slot-scope="{ item }">
			        <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
			        <md-table-cell md-label="Nama" md-sort-by="name">{{ item.name }}</md-table-cell>
			        <md-table-cell md-label="Email" md-sort-by="email">{{ item.email }}</md-table-cell>
               <md-table-cell md-label="Aksi">
                <md-button :to="`/pelanggan/edit/${item.id}`" class="md-fab md-dense md-primary">
                  <md-icon>edit</md-icon>
                  <md-tooltip md-direction="top">Edit</md-tooltip>
                </md-button>
                <md-button @click="deletePelanggan(item.id)" class="md-fab md-dense md-plain">
                  <md-icon>delete_forever</md-icon>
                  <md-tooltip md-direction="top">Hapus</md-tooltip>
                </md-button>
              </md-table-cell>
			      </md-table-row>
			    </md-table>

          <paging
            v-if="!loading"
            :dataPaging="pelanggans"
            :itemPerPage="10"
            :range="5"
            :search="searchResult"
            @paginatedItems="getPaginatedItems($event)"></paging>
        </md-card-content>
      </md-card>

	    <!-- Snackbar for pelanggan delete alert -->
	    <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="snackbarDeletePelanggan" md-persistent>
	      <span>Pelanggan berhasil dihapus!</span>
	    </md-snackbar>
	  </div>
  </sidebar>
</template>

<script>

const toLower = text => {
  return text.toString().toLowerCase();
};

export default {
  data: () => ({
  	url: window.location.origin + (window.location.pathname + 'pelanggan'),
    search: null,
    promptDeletePelanggan: false,
		snackbarDeletePelanggan: false,
    pelangganIdForDelete: '',
    searchable_pelanggan: [],
    pelanggans: [],
    searchBy: 'name',
    loading: true,
    searchResult: false,
		alert: false
  }),
  created() {
  	this.getPelangganData();
  },
  watch: {
    search() {
      this.searchPelanggans();
    },
    searchBy() {
      this.searchPelanggans();
    }
  },
  methods: {
    searchPelanggans() {
      if (this.search != null) {
        this.searchResult = this.pelanggans.filter(item => toLower(item[this.searchBy]).includes(toLower(this.search)));
      } else {
        this.searchResult = this.pelanggans;
      }
    },
    getPaginatedItems(value) {
      this.searchable_pelanggan = value;
    },
  	getPelangganData() {
  		axios.get(this.url)
  		.then(resp => {
  			this.pelanggans = resp.data;
  			this.searchable_pelanggan = resp.data;
  			this.loading = false;
  		})
  		.catch(resp => {
  			console.log('catch getPelangganData:', resp);
  		});
  	},
  	onConfirmDelete() {
  		axios.delete(this.url + '/' + this.pelangganIdForDelete)
  		.then(resp => {
        if(resp.data == 200){
            this.pelangganIdForDelete = '';
            this.snackbarDeletePelanggan = true;
            this.getPelangganData();
        }else{
            this.alert =  true
        }
  		})
  		.catch(resp => {
  			console.log('catch onConfirmDelete:', resp);
  		})
  	},
  	deletePelanggan(pelangganId) {
  		this.promptDeletePelanggan = true;
  		this.pelangganIdForDelete = pelangganId;
  	}
  }
}

</script>
