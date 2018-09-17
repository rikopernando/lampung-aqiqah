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
          <md-button :to="`/user/create`" class="md-dense md-raised" style="background-color: #d44723; color: white">Tambah User</md-button>
      		<md-table v-model="searchable_user" md-sort="name" md-sort-order="asc" md-fixed-header>
			      <md-table-empty-state v-if="loading">
					    <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
			      </md-table-empty-state>
			      <md-table-empty-state
			      	v-else-if="users.length == 0"
			        md-label="Tidak ada data"
			        md-description="Belum ada data User yang tersimpan.">
			      </md-table-empty-state>
			      <md-table-empty-state
			      	v-else-if="users.length > 0 && search != null"
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

          <paging
            v-if="!loading"
            :dataPaging="users"
            :itemPerPage="10"
            :range="5"
            :search="searchResult"
            @paginatedItems="getPaginatedItems($event)"></paging>
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

const toLower = text => {
  return text.toString().toLowerCase();
};

export default {
  data: () => ({
  	url: window.location.origin + (window.location.pathname + 'user'),
    search: null,
    promptDeleteUser: false,
		snackbarDeleteUser: false,
    userIdForDelete: '',
    searchable_user: [],
    users: [],
    searchBy: 'name',
    loading: true,
    searchResult: false,
  }),
  created() {
  	this.getUserData();
  },
  watch: {
    search() {
      this.searchUsers();
    },
    searchBy() {
      this.searchUsers();
    }
  },
  methods: {
    searchUsers() {
      if (this.search != null) {
        this.searchResult = this.users.filter(item => toLower(item[this.searchBy]).includes(toLower(this.search)));
      } else {
        this.searchResult = this.users;
      }
    },
    getPaginatedItems(value) {
      this.searchable_user = value;
    },
  	getUserData() {
  		axios.get(this.url + '/' + 'view')
  		.then(resp => {
  			this.users = resp.data;
  			this.searchable_user = resp.data;
  			this.loading = false;
  		})
  		.catch(resp => {
  			console.log('catch getUserData:', resp);
  		});
  	},
  	onConfirmDelete() {
  		axios.delete(this.url + '/' + this.userIdForDelete)
  		.then(resp => {
  			this.userIdForDelete = '';
  			this.snackbarDeleteUser = true;
  			this.getUserData();
  		})
  		.catch(resp => {
  			console.log('catch onConfirmDelete:', resp);
  		})
  	},
  	deleteUser(userId) {
  		this.promptDeleteUser = true;
  		this.userIdForDelete = userId;
  	}
  }
}

</script>
