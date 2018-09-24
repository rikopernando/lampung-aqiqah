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

	  	<!-- Prompt delete user -->
	  	<md-dialog-confirm
	      :md-active.sync="promptDeleteMitra"
	      md-title="Hapus Mitra?"
	      md-content="Apakah Anda yakin ingin menghapus Mitra ini?"
	      md-confirm-text="Ya"
	      md-cancel-text="Batal"
	      @md-confirm="onConfirmDelete" />

     	<md-card>
      	<ul class="breadcrumb">
        	<li><router-link :to="{name: 'dashboard'}">Dashboard</router-link></li>
        	<li class="active">Mitra</li>
      	</ul>
      </md-card>
 
      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white">group</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 4px">
              <div class="header-title md-toolbar-section-start" style="padding-right:10px">Mitra</div>
            </div>
          </md-card-header-text>
        </md-card-header>

        <md-card-content>
          <div class="row">
            <div class="col-md-9">
             <md-button :to="`/mitra/create`" class="md-dense md-raised" style="background-color: #d44723; color: white">Tambah Mitra</md-button>
            </div>
            <div class="col-md-3">
              <input class="form-control" name="pencarian" v-model="search" placeholder="Masukan Pencarian disini ..." style="font-size : 13px; font-style: italic">
            </div>
          </div>
      		<md-table v-model="searchable_mitra" md-sort="name" md-sort-order="asc" md-fixed-header>

			      <md-table-empty-state v-if="loading">
					    <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
			      </md-table-empty-state>
			      <md-table-empty-state
			      	v-else-if="Object.keys(mitra).length == 0"
			        md-label="Tidak ada data"
			        md-description="Belum ada data Mitra yang tersimpan.">
			      </md-table-empty-state>      	
			      <md-table-empty-state
			      	v-else-if="Object.keys(mitra).length > 0 && search != null"
			        md-label="Tidak ada Mitra ditemukan"
			        :md-description="`Tidak ada Mitra ditemukan untuk kata kunci '${search}'. Cobalah menggunakan kata kunci yang lain.`">
			      </md-table-empty-state>

			      <md-table-row slot="md-table-row" slot-scope="{ item }">
			        <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
			        <md-table-cell md-label="Mitra" md-sort-by="name">{{ item.nama_mitra }}</md-table-cell>
			        <md-table-cell md-label="No. Telepon" md-sort-by="no_telp">{{ item.no_telp }}</md-table-cell>
			        <md-table-cell md-label="Alamat" md-sort-by="alamat">{{ item.alamat }}</md-table-cell>
              <md-table-cell md-label="Edit">
               <md-button :to="`/mitra/edit/${item.id}`" class="md-fab md-dense md-primary">
                 <md-icon>edit</md-icon>
                 <md-tooltip md-direction="top">Edit</md-tooltip>
               </md-button>
              </md-table-cell>
              <md-table-cell md-label="Hapus">
               <md-button @click="deleteMitra(item.id)" class="md-fab md-dense md-plain">
                 <md-icon>delete_forever</md-icon>
                 <md-tooltip md-direction="top">Hapus</md-tooltip>
               </md-button>
              </md-table-cell>
			      </md-table-row>
			    </md-table>  	

            <pagination :data="mitra" v-on:pagination-change-page="getMitraData" :limit="4"></pagination>

        </md-card-content>
      </md-card>

	    <!-- Snackbar for user delete alert -->
	    <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="snackbarDeleteMitra" md-persistent>
	      <span>Mitra berhasil dihapus!</span>
	    </md-snackbar>

    </div>
  </sidebar>
</template>

<script>

export default {
  data : () => ({
    url: window.location.origin + window.location.pathname + 'mitra',
    promptDeleteMitra: false,
    snackbarDeleteMitra: false,
    mitraIdForDelete: '',
    search: null,
    searchable_mitra: [],
    mitra: {},
    loading: true,
  }),
  created() {
    const app = this
  	app.getMitraData();
  },
  watch: {
    search() {
      const app = this
  	  app.getMitraData();
    }
  },
  methods: {
    getMitraData(page = 1) {
      const app = this
      let url
      app.search ? url = `${app.url}/pencarian?page=${page}&search=${app.search}` : url = `${app.url}?page=${page}`
      axios.get(url)
       .then(resp => {
        const { mitra } = resp.data
        app.mitra = mitra
        app.searchable_mitra = mitra.data;
        app.loading = false;
      })
      .catch(resp => {
        console.log('catch getMitraData:', resp);
        alert('Terjadi Kesalahan')
      });
    },
    deleteMitra(id){
      const app = this
		  app.promptDeleteMitra = true;
		  app.mitraIdForDelete = id;
    },
    onConfirmDelete() {
      const app = this
      axios.delete(`${app.url}/${app.mitraIdForDelete}`)
      .then(resp => {
        app.userIdForDelete = '';
        app.snackbarDeleteUser = true;
        app.getMitraData();
      })
      .catch(resp => {
        console.log('catch onConfirmDelete:', resp);
        alert('Terjadi Kesalahan')
      })
    },
  }
}

</script>
