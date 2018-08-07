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
        	<li><router-link :to="{name: 'home'}">Home</router-link></li>
        	<li class="active">User</li>
      	</ul>
      </md-card>

      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white">account_box</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
              <div class="header-title md-toolbar-section-start">User</div>
              <div class="header-title md-toolbar-section-end">
                <div class="md-layout">
			        		<div class="md-layout-item md-medium-size-50 md-small-size-50 md-xsmall-size-100">
						        <md-field md-inline>
						        	<label class="media-screen-xsmall-hide">Cari dengan...</label>
						        	<label class="media-screen-medium-hide">Cari User...</label>
						          <md-input v-model="search" @input="searchOnTable" />
						        </md-field>
			        		</div>
			        		<div class="md-layout-item md-medium-size-50 md-small-size-50 md-xsmall-hide">
						        <md-field>
						          <md-select v-model="searchBy" @md-selected="searchOnTable" name="searchBy" id="searchBy" md-dense>
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
      		<md-table v-model="searched" md-sort="name" md-sort-order="asc" md-fixed-header>

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
			        <md-table-cell md-label="Aksi">
			        	<md-button :to="`/user/edit/${item.id}`" class="md-dense md-raised md-primary">Edit</md-button>
			        	<md-button @click="deleteUser(item.id)" class="md-dense md-raised md-accent">Hapus</md-button>
			        </md-table-cell>
			      </md-table-row>
			    </md-table>  	
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

  const searchUser = (items, term, searchBy) => {
    if (term) {
      return items.filter(item => toLower(item[searchBy]).includes(toLower(term)));
    }

    return items;
  };

  export default {
    data: () => ({
    	url: window.location.origin + (window.location.pathname + 'user/'),
      search: null,
	    promptDeleteUser: false,
			snackbarDeleteUser: false,
	    userIdForDelete: '',
      searched: [],
      users: [],
      searchBy: 'name',
      loading: true
    }),
    created() {
    	this.getUserData();
    },
    methods: {
    	getUserData() {
    		axios.get(this.url + 'view')
    		.then(resp => {
    			this.users = resp.data;
    			this.searched = resp.data;
    			this.loading = false;
    		})
    		.catch(resp => {
    			console.log('catch getUserData:', resp);
    		});
    	},
    	onConfirmDelete() {
    		axios.delete(this.url + this.userIdForDelete)
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
    	},
      searchOnTable() {
        this.searched = searchUser(this.users, this.search, this.searchBy);
      }
    }
  }
</script>

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
</style>