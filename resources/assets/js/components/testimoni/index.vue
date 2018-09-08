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
                        <md-option value="nama_lengkap">Nama</md-option>
                        <md-option value="profesi">Profesi</md-option>
                        <md-option value="testimoni">Testimoni</md-option>
                      </md-select>
                    </md-field>
                    </div>
                  </div>
                </div>
              </div>
            </md-card-header-text>
          </md-card-header>

          <md-card-content>
            <md-button :to="`/testimoni/create`" class="md-dense md-raised" style="background-color: #d44723; color: white">Tambah Testimoni</md-button>

            <md-table v-model="searchable_testimoni" md-sort="name" md-sort-order="asc" md-fixed-header>
              <md-table-empty-state v-if="$store.state.testimoni.loading">
        		    <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
              </md-table-empty-state>

              <md-table-empty-state v-else-if="testimonis.length == 0" md-label="Tidak Ada Data"
                  md-description="Belum Ada Testimoni Yang Tersimpan.">
              </md-table-empty-state>

              <md-table-empty-state v-else-if="testimonis.length > 0 && search != null" 
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
                <md-table-cell md-label="Aksi">
                  <md-button :to="`/testimoni/edit/${item.id}`" class="md-fab md-dense md-primary">
                    <md-icon>edit</md-icon>
                    <md-tooltip md-direction="top">Edit</md-tooltip>
                  </md-button>
                  <md-button  @click="deleteTestimoni(item.id, item.nama_lengkap)" class="md-fab md-dense md-plain">
                    <md-icon>delete_forever</md-icon>
                    <md-tooltip md-direction="top">Hapus</md-tooltip>
                  </md-button>
                </md-table-cell>
              </md-table-row>
            </md-table>

            <paging
              v-if="!loading"
              :dataPaging="testimonis"
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
              {{ daftarTestimoni }}
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
  import { mapState } from 'vuex'

  const toLower = text => {
    return text.toString().toLowerCase();
  };

  export default{
    data: () => ({
      url: window.location.origin + (window.location.pathname + 'testimoni/'),
      testimonis: [],
      searchable_testimoni: [],
      search: null,
	    promptDelete: false,
			snackbarDelete: false,
      notifMessage: '',
      notifSuccess: false,
      searchBy: 'nama_lengkap',
      testimoniId: '',
      testimoniDelete: '',
      searchResult: {},
      loading: true
    }),
    mounted() {
      this.$store.dispatch('testimoni/LOAD_TESTIMONI');
    },
    computed: mapState ({
      daftarTestimoni() {
        this.testimonis = this.$store.state.testimoni.daftarTestimoni;
        this.searchable_testimoni = this.$store.state.testimoni.daftarTestimoni;
        this.loading = false;
        return this.$store.state.testimoni.daftarTestimoni;
      }
    }),
    watch: {
      search() {
        this.searchTestimoni();
      },
      searchBy() {
        this.searchTestimoni();
      }
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
      searchTestimoni() {
        if (this.search != null) {
          this.searchResult = this.testimonis.filter(item => toLower(item[this.searchBy]).includes(toLower(this.search)));
        } else {
          this.searchResult = this.testimonis;
        }
      },
      getPaginatedItems(value) {
        this.searchable_testimoni = value;
      },
    	deleteTestimoni(testimoniId, namaLengkap) {
    		this.promptDelete = true;
    		this.testimoniId = testimoniId;
    		this.testimoniDelete = namaLengkap;
    		this.notifMessage = `Apakah Anda Yakin Menghapus Testimoni <strong>${namaLengkap}</strong> ?`;
    	},
      onConfirmDelete() {
    		axios.delete(this.url + this.testimoniId)
    		.then(resp => {
          this.notifMessage = `Berhasil Menghapus Testimoni ${this.testimoniDelete}.`
    			this.testimoniId = '';
    			this.testimoniDelete = '';
    			this.snackbarDelete = true;
          this.notifSuccess = true;
    			this.$store.dispatch('testimoni/LOAD_TESTIMONI');
    		})
    		.catch(resp => {
    			console.log('catch onConfirmDelete:', resp);
    		})
      }
    }
  }
</script>