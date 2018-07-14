<template>
  <div>

  	<!-- Prompt delete user -->
  	<md-dialog-confirm
      :md-active.sync="promptDeleteUser"
      md-title="Hapus User?"
      md-content="Apakah Anda yakin ingin menghapus User ini?"
      md-confirm-text="Ya"
      md-cancel-text="Batal"
      @md-confirm="onConfirmDelete" />

      <!-- <md-button class="md-primary md-raised" @click="active = true">Confirm</md-button> -->

    <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-card md-fixed-header>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">Users</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Pencarian..." v-model="search" @input="searchOnTable" />
        </md-field>
      </md-table-toolbar>

      <md-table-empty-state
      	v-if="users.length == 0"
        md-label="Tidak ada data"
        md-description="Belum ada data User yang tersimpan.">
        <md-button class="md-primary md-raised" @click="newUser">Create New User</md-button>
      </md-table-empty-state>      	
      <md-table-empty-state
      	v-else-if="users.length > 0 && search != null"
        md-label="Tidak ada User ditemukan"
        :md-description="`Tidak ada User ditemukan untuk kata kunci '${search}'. Cobalah menggunakan kata kunci yang lain.`">
        <md-button class="md-primary md-raised" @click="newUser">Create New User</md-button>
      </md-table-empty-state>

      <md-table-row slot="md-table-row" slot-scope="{ item }">
        <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
        <md-table-cell md-label="Name" md-sort-by="name">{{ item.name }}</md-table-cell>
        <md-table-cell md-label="Email" md-sort-by="email">{{ item.email }}</md-table-cell>
        <md-table-cell md-label="Aksi">
        	<md-button :to="`/user/edit/${item.id}`" class="md-dense md-raised md-primary">Edit</md-button>
        	<md-button @click="deleteUser(item.id)" class="md-dense md-raised md-accent">Hapus</md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>

    <!-- Snackbar for user delete alert -->
    <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="snackbarDeleteUser" md-persistent>
      <span>User berhasil dihapus!</span>
    </md-snackbar>
  </div>
</template>

<script>
  const toLower = text => {
    return text.toString().toLowerCase()
  }

  const searchByName = (items, term) => {
    if (term) {
      return items.filter(item => toLower(item.name).includes(toLower(term)))
    }

    return items
  }

  export default {
    name: 'TableSearch',
    searchBy: '',
    data: () => ({
    	url: window.location.origin + (window.location.pathname + 'user/'),
      search: null,
	    promptDeleteUser: false,
			snackbarDeleteUser: false,
	    userIdForDelete: '',
      searched: [],
      users: []
    }),
    mounted() {
    },
    created() {
    	this.getUserData();
    },
    methods: {
    	getUserData() {
    		axios.get(this.url + 'view')
    		.then(resp => {
    			this.users = resp.data;
    			this.searched = resp.data;
    			console.log(this.searched);
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
      newUser () {
        window.alert('Noop')
      },
      searchOnTable () {
        this.searched = searchByName(this.users, this.search)
      }
    }
  }
</script>

<style lang="scss" scoped>
  .md-field {
    max-width: 300px;
  }
</style>