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
	      :md-active.sync="promptDeleteUser"
	      md-title="Hapus User?"
	      md-content="Apakah Anda yakin ingin menghapus User ini?"
	      md-confirm-text="Ya"
	      md-cancel-text="Batal"
	      @md-confirm="onConfirmDelete" />

     	<md-card>
      	<ul class="breadcrumb">
        	<li><router-link :to="{name: 'dashboard'}">Dashboard</router-link></li>
        	<li class="active">User</li>
      	</ul>
      </md-card>

      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white">account_box</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 4px">
              <div class="header-title md-toolbar-section-start" style="padding-right:10px">User</div>
            </div>
          </md-card-header-text>
        </md-card-header>
        <md-card-content>
          <div class="row">
            <div class="col-md-9">
          <md-button :to="`/user/create`" class="md-dense md-raised" style="background-color: #d44723; color: white">Tambah User</md-button>
            </div>
            <div class="col-md-3">
              <input class="form-control" name="pencarian" v-model="search" placeholder="Masukan Pencarian disini ..." style="font-size : 13px; font-style: italic">
            </div>
          </div>
      		<md-table v-model="searchable_user" md-sort="name" md-sort-order="asc" md-fixed-header>
			      <md-table-empty-state v-if="loading">
					    <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
			      </md-table-empty-state>
			      <md-table-empty-state
			      	v-else-if="Object.keys(users).length == 0"
			        md-label="Tidak ada data"
			        md-description="Belum ada data User yang tersimpan.">
			      </md-table-empty-state>
			      <md-table-empty-state
			      	v-else-if="Object.keys(users).length > 0 && search != null"
			        md-label="Tidak ada User ditemukan"
			        :md-description="`Tidak ada User ditemukan untuk kata kunci '${search}'. Cobalah menggunakan kata kunci yang lain.`">
			      </md-table-empty-state>

			      <md-table-row slot="md-table-row" slot-scope="{ item }">
			        <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
			        <md-table-cell md-label="Nama" md-sort-by="name">{{ item.name }}</md-table-cell>
			        <md-table-cell md-label="Email" md-sort-by="email">{{ item.email }}</md-table-cell>
              <md-table-cell md-label="Edit">
                <md-button :to="`/user/edit/${item.id}`" class="md-fab md-dense md-primary">
                  <md-icon>edit</md-icon>
                  <md-tooltip md-direction="top">Edit</md-tooltip>
                </md-button>
              </md-table-cell>
              <md-table-cell md-label="Hapus">
                <md-button @click="deleteUser(item.id)" class="md-fab md-dense md-plain">
                  <md-icon>delete_forever</md-icon>
                  <md-tooltip md-direction="top">Hapus</md-tooltip>
                </md-button>
              </md-table-cell>
			      </md-table-row>
			    </md-table>

            <pagination :data="users" v-on:pagination-change-page="getUserData" :limit="4"></pagination>

        </md-card-content>
      </md-card>

	    <!-- Snackbar for user delete alert -->
	    <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="snackbarDeleteUser" md-persistent>
	      <span>User berhasil dihapus!</span>
	    </md-snackbar>
	  </div>
  </sidebar>
</template>

<script>
export default {
  data: () => ({
  	url: window.location.origin + window.location.pathname + 'user',
    search: null,
    promptDeleteUser: false,
		snackbarDeleteUser: false,
    userIdForDelete: '',
    searchable_user: [],
    users: {},
    loading: true,
  }),
  created() {
    const app = this
  	app.getUserData();
  },
  watch: {
    search() {
      const app = this
  	  app.getUserData()
    },
  },
  methods: {
  	getUserData(page = 1) {
      const app = this
      let url
      app.search ? url = `${app.url}/pencarian?page=${page}&search=${app.search}` : url = `${app.url}?page=${page}`
  		axios.get(url)
  		.then(resp => {
        const { user } = resp.data
  			app.users = user;
  			app.searchable_user = user.data;
  			app.loading = false;
  		})
  		.catch(resp => {
  			console.log('catch getUserData:', resp);
  		});
  	},
  	onConfirmDelete() {
      const app = this
  		axios.delete(app.url + '/' + app.userIdForDelete)
  		.then(resp => {
  			app.userIdForDelete = '';
  			app.snackbarDeleteUser = true;
  			app.getUserData();
  		})
  		.catch(resp => {
  			console.log('catch onConfirmDelete:', resp);
  		})
  	},
  	deleteUser(userId) {
      const app = this
  		app.promptDeleteUser = true;
  		app.userIdForDelete = userId;
  	}
  }
}

</script>
