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
                        <md-option value="judul_berita">Judul Berita</md-option>
                        <md-option value="isi_berita">Isi Berita</md-option>
                      </md-select>
                    </md-field>
                    </div>
                  </div>
                </div>
              </div>
            </md-card-header-text>
          </md-card-header>

          <md-card-content>
            <md-button :to="`/berita-kami/create`" class="md-dense md-raised" style="background-color: #d44723; color: white">Tambah Berita</md-button>

            <md-table v-model="searchable_berita" md-sort="name" md-sort-order="asc" md-fixed-header>
            <md-table-empty-state v-if="$store.state.berita.loading">
              <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
            </md-table-empty-state>

              <md-table-empty-state v-else-if="beritas.length == 0" md-label="Tidak Ada Data"
                  md-description="Belum Ada Berita Yang Tersimpan.">
              </md-table-empty-state>

              <md-table-empty-state v-else-if="beritas.length > 0 && search != null" md-label="Berita Tidak Ditemukan"
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

                <md-table-cell md-label="Aksi">
                  <md-button :to="`/berita-kami/edit/${item.id}`" class="md-fab md-dense md-primary">
                    <md-icon>edit</md-icon>
                    <md-tooltip md-direction="top">Edit</md-tooltip>
                  </md-button>
                  <md-button  @click="deleteBerita(item.id, item.judul_berita)" class="md-fab md-dense md-plain">
                    <md-icon>delete_forever</md-icon>
                    <md-tooltip md-direction="top">Hapus</md-tooltip>
                  </md-button>
                </md-table-cell>
              </md-table-row>
            </md-table>

            <paging
              v-if="!$store.state.berita.loading"
              :dataPaging="beritas"
              :itemPerPage="10"
              :range="5"
              :search="searchResult"
              @paginatedItems="getPaginatedItems($event)"></paging>

            <!-- Snackbar for success alert -->
            <md-snackbar md-position="center" :md-duration="1500" :md-active.sync="notifSuccess">
              <span id="span-snackbar">{{notifMessage}}</span>
              <span><md-icon style="color: white">done_all</md-icon></span>
            </md-snackbar>

            <div style="display: none">
              {{ daftarBerita }}
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

  import { mapState } from 'vuex';

  const toLower = text => {
    return text.toString().toLowerCase();
  };

  export default {
    data: () => ({
      url: window.location.origin + (window.location.pathname + 'berita/'),
      beritas: [],
      searchable_berita: [],
      search: null,
  	  promptDelete: false,
  	  snackbarDelete: false,
      notifMessage: '',
      notifSuccess: false,
      searchBy: 'judul_berita',
      beritaId: '',
      beritaDelete: '',
      searchResult: {},
    }),
    mounted() {
      this.$store.dispatch('berita/LOAD_BERITA');
    },
    computed: mapState ({
      daftarBerita() {
        this.beritas = this.$store.state.berita.daftarBerita;
        this.searchable_berita = this.$store.state.berita.daftarBerita;
        return this.$store.state.berita.daftarBerita;
      }
    }),
    watch: {
      search() {
        this.searchBerita();
      },
      searchBy() {
        this.searchBerita();
      }
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
      searchBerita() {
        if (this.search != null) {
          this.searchResult = this.beritas.filter(item => toLower(item[this.searchBy]).includes(toLower(this.search)));
        } else {
          this.searchResult = this.beritas;
        }
      },
      getPaginatedItems(value) {
        this.searchable_berita = value;
      },
      searchOnTable() {
        this.searchable_berita = searchBerita(this.beritas, this.search, this.searchBy);
      },
    	deleteBerita(beritaId, judul) {
    		this.promptDelete = true;
    		this.beritaId = beritaId;
    		this.beritaDelete = judul;
    		this.notifMessage = `Apakah Anda Yakin Menghapus Berita <strong>${judul}</strong> ?`;
    	},
      onConfirmDelete() {
    		axios.delete(this.url + this.beritaId)
    		.then(resp => {
          this.notifMessage = `Berhasil Menghapus Berita ${this.beritaDelete}.`;
          this.beritaId = '';
          this.beritaDelete = '';
          this.snackbarDelete = true;
          this.notifSuccess = true;
          this.$store.dispatch('berita/LOAD_BERITA');

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
  .md-table-row {
    background:#f7e1e1 !important;
    padding:8px !important;
  }
  .md-layout-item{
    padding:5px !important;
  }
</style>
