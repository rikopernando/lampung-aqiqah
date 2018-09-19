<template>
    <sidebar>
      <div class="col-md-12" style="padding: 0">
        <md-card>
          <ul class="breadcrumb">
            <li><router-link :to="{name: 'dashboard'}">Dashboard</router-link></li>
            <li class="active">Berita Kami</li>
          </ul>
        </md-card>

        <md-card>
          <md-card-header>
            <div class="header-card">
              <md-icon style="color: white">rate_review</md-icon>
            </div>
            <md-card-header-text>
              <div class="md-toolbar" style="margin-top: -20px; padding: 4px">
                <div class="header-title md-toolbar-section-start" style="padding-right:10px">Berita Kami</div>
              </div>
            </md-card-header-text>
          </md-card-header>

          <md-card-content>
              <div class="row">
                <div class="col-md-9">
                  <md-button :to="`/berita-kami/create`" class="md-dense md-raised" style="background-color: #d44723; color: white">Tambah Berita</md-button>
                </div>
                <div class="col-md-3">
                  <input class="form-control" name="pencarian" v-model="search" placeholder="Masukan Pencarian disini ..." style="font-size : 13px; font-style: italic">
                </div>
              </div>

            <md-table v-model="searchable_berita" md-sort="name" md-sort-order="asc" md-fixed-header>
            <md-table-empty-state v-if="loading">
              <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
            </md-table-empty-state>

              <md-table-empty-state v-else-if="searchable_berita.length == 0" md-label="Tidak Ada Data"
                  md-description="Belum Ada Berita Yang Tersimpan.">
              </md-table-empty-state>

              <md-table-empty-state v-else-if="Object.keys(beritas).length > 0 && search != null" md-label="Berita Tidak Ditemukan"
                  :md-description="`Tidak Ada Berita Dengan Kata Kunci '${search}'. Cobalah Menggunakan Kata Kunci Lain.`">
              </md-table-empty-state>

              <md-table-row slot="md-table-row" slot-scope="{item}">
                <md-table-cell md-label="ID" md-sort-by="id" md-numeric>
                  {{ item.id }}
                </md-table-cell>
                <md-table-cell md-label="Judul Berita" md-sort-by="judul_berita">
                  {{ item.judul_berita | capitalize }}
                </md-table-cell>
                <md-table-cell md-label="Isi Berita" md-sort-by="isi_berita">
                  {{ item.isi_berita }}
                </md-table-cell>

                <md-table-cell md-label="Edit">
                  <md-button :to="`/berita-kami/edit/${item.id}`" class="md-fab md-dense md-primary">
                    <md-icon>edit</md-icon>
                    <md-tooltip md-direction="top">Edit</md-tooltip>
                  </md-button>
                </md-table-cell>
                <md-table-cell md-label="Hapus">
                  <md-button  @click="deleteBerita(item.id, item.judul_berita)" class="md-fab md-dense md-plain">
                    <md-icon>delete_forever</md-icon>
                    <md-tooltip md-direction="top">Hapus</md-tooltip>
                  </md-button>
                </md-table-cell>
              </md-table-row>
            </md-table>

            <pagination :data="beritas" v-on:pagination-change-page="getBeritaData" :limit="4"></pagination>

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
  export default {
    data: () => ({
      url: window.location.origin + window.location.pathname + 'berita',
      beritas: {},
      searchable_berita: [],
      search: null,
  	  promptDelete: false,
  	  snackbarDelete: false,
      notifMessage: '',
      notifSuccess: false,
      beritaId: '',
      beritaDelete: '',
      loading: true
    }),
    mounted() {
      const app = this
      app.getBeritaData()
    },
    watch: {
      search() {
        const app = this
        app.getBeritaData()
      },
    },
    filters: {
      selengkapnya: (value) => {
        return value.substr(0, 50);
      },
     capitalize: function (value) {
          return value.replace(/(^|\s)\S/g, l => l.toUpperCase());
      }
    },
    methods: {
      getBeritaData(page){
        const app = this
        let url 
        if(typeof page === 'undefined'){
          page = 1
        }
        app.search ? url = `${app.url}/pencarian?page=${page}&search=${app.search}` : url = `${app.url}?page=${page}`
        axios.get(url).then((resp) => {
          const { berita_kami } = resp.data
          app.beritas = berita_kami
          app.searchable_berita = berita_kami.data
          app.loading = false
        })
        .catch((err) => {
    			console.log('catch getTestimoniData:',err);
        })
      },
    	deleteBerita(beritaId, judul) {
        const app = this
    		app.promptDelete = true;
    		app.beritaId = beritaId;
    		app.beritaDelete = judul;
    		app.notifMessage = `Apakah Anda Yakin Menghapus Berita <strong>${judul}</strong> ?`;
    	},
      onConfirmDelete() {
        const app = this
    		axios.delete(`${app.url}/${app.beritaId}`)
    		.then(resp => {
          app.notifMessage = `Berhasil Menghapus Berita ${app.beritaDelete}.`;
          app.beritaId = '';
          app.beritaDelete = '';
          app.snackbarDelete = true;
          app.notifSuccess = true;
          app.getBeritaData()
    		})
    		.catch(resp => {
    			console.log('catch onConfirmDelete:', resp);
    		})
      }
    }
  }
  
</script>

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
