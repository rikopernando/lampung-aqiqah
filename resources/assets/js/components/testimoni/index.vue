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
            <li class="active">Testimoni</li>
          </ul>
        </md-card>

        <md-card>
          <md-card-header>
            <div class="header-card">
              <md-icon style="color: white">rate_review</md-icon>
            </div>
            <md-card-header-text>
              <div class="md-toolbar" style="margin-top: -20px; padding: 4px">
                <div class="header-title md-toolbar-section-start" style="padding-right:10px">Testimoni</div>
              </div>
            </md-card-header-text>
          </md-card-header>

          <md-card-content>
            <md-button :to="`/testimoni/create`" class="md-dense md-raised" style="background-color: #d44723; color: white">Tambah Testimoni</md-button>

            <md-table v-model="searchable_testimoni" md-sort="name" md-sort-order="asc" md-fixed-header>
              <md-table-empty-state v-if="loading">
        		    <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
              </md-table-empty-state>

              <md-table-empty-state v-else-if="Object.keys(testimonis).length == 0" md-label="Tidak Ada Data"
                  md-description="Belum Ada Testimoni Yang Tersimpan.">
              </md-table-empty-state>

              <md-table-empty-state v-else-if="Object.keys(testimonis).length > 0 && search != null" 
                md-label="Testimoni Tidak Ditemukan" 
                :md-description="`Tidak Ada Testimoni Dengan Kata Kunci '${search}'. Cobalah Menggunakan Kata Kunci Lain.`">
              </md-table-empty-state>

              <md-table-row slot="md-table-row" slot-scope="{item}">
                <md-table-cell md-label="ID" md-sort-by="id" md-numeric>
                  {{ item.id }}
                </md-table-cell>
                <md-table-cell md-label="Nama" md-sort-by="nama_lengkap">
                  {{ item.nama_lengkap | capitalize }}
                </md-table-cell>
                <md-table-cell md-label="Profesi" md-sort-by="profesi">
                  {{ item.profesi | capitalize }}
                </md-table-cell>
                <md-table-cell md-label="Testimoni" md-sort-by="testimoni">
                  {{ item.testimoni | selengkapnya }}
                </md-table-cell>
                <md-table-cell md-label="Edit">
                  <md-button :to="`/testimoni/edit/${item.id}`" class="md-fab md-dense md-primary">
                    <md-icon>edit</md-icon>
                    <md-tooltip md-direction="top">Edit</md-tooltip>
                  </md-button>
                </md-table-cell>
                <md-table-cell md-label="Hapus">
                  <md-button  @click="deleteTestimoni(item.id, item.nama_lengkap)" class="md-fab md-dense md-plain">
                    <md-icon>delete_forever</md-icon>
                    <md-tooltip md-direction="top">Hapus</md-tooltip>
                  </md-button>
                </md-table-cell>
              </md-table-row>
            </md-table>
            
            <pagination :data="testimonis" v-on:pagination-change-page="getTestimoniData" :limit="4"></pagination>

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
  export default{
    data: () => ({
      url: window.location.origin + window.location.pathname + 'testimoni',
      testimonis: {},
      searchable_testimoni: [],
      search: null,
	    promptDelete: false,
			snackbarDelete: false,
      notifMessage: '',
      notifSuccess: false,
      testimoniId: '',
      testimoniDelete: '',
      loading: true
    }),
    mounted() {
      const app = this
      app.getTestimoniData()
    },
    watch: {
      search() {
        const app = this
        app.getTestimoniData()
      },
    },
    filters: {
      capitalize: (value) => {
        return value.replace(/(^|\s)\S/g, l => l.toUpperCase())
      },
      selengkapnya: (teks) => {
        if (teks.length > 50)
          return `${teks.substr(0, 50)}...`;
        else
          return teks;
      }
    },
    methods: {
      getTestimoniData(page){
        const app = this
        let url 
        if(typeof page === 'undefined'){
          page = 1
        }
        app.search ? url = `${app.url}/pencarian?page=${page}&search=${app.search}` : url = `${app.url}?page=${page}`
        
        axios.get(url).then((resp) => {
          const { testimoni } = resp.data
          app.testimonis = testimoni
          app.searchable_testimoni = testimoni.data
          app.loading = false
        })
        .catch((err) => {
    			console.log('catch getTestimoniData:',err);
        })

      },
    	deleteTestimoni(testimoniId, namaLengkap) {
        const app = this
    		app.promptDelete = true;
    		app.testimoniId = testimoniId;
    		app.testimoniDelete = namaLengkap;
    		app.notifMessage = `Apakah Anda Yakin Menghapus Testimoni <strong>${namaLengkap}</strong> ?`;
    	},
      onConfirmDelete() {
        const app = this
    		axios.delete(`${app.url}/${app.testimoniId}`)
    		.then(resp => {
          app.notifMessage = `Berhasil Menghapus Testimoni ${app.testimoniDelete}.`
    			app.testimoniId = '';
    			app.testimoniDelete = '';
    			app.snackbarDelete = true;
          app.notifSuccess = true;
          app.getTestimoniData()
    		})
    		.catch(resp => {
    			console.log('catch onConfirmDelete:', resp);
    		})
      }
    }
  }
</script>
