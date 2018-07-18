<template>
  <div>
    <form v-on:submit.prevent="saveForm()">
      <md-card>
        <md-card-header>
          <div class="md-title">Users</div>
        </md-card-header>

        <md-card-content>
          <div v-if="loading" class="_spinner-container">
            <div class="_spinner">
              <md-progress-spinner :md-diameter="80" :md-stroke="5" md-mode="indeterminate"></md-progress-spinner>
            </div>
          </div>
          <md-field>
            <label v-if="!loading" for="name">Nama</label>
            <md-input name="name" id="name" v-model="user.name" />
          </md-field>
          <md-field>
            <label v-if="!loading" for="email">Email</label>
            <md-input type="email" name="email" id="email" v-model="user.email" />
          </md-field>
        </md-card-content>
        <md-card-actions>
          <md-progress-spinner v-if="submitted" :md-diameter="30" :md-stroke="3" md-mode="indeterminate"></md-progress-spinner>
          <md-button v-else type="submit" class="md-primary">Edit User</md-button>
        </md-card-actions>
      </md-card>
    </form>

    <!-- Snackbar for user edit alert -->
    <md-snackbar md-position="center" :md-duration="1500" :md-active.sync="snackbarEditUser" @md-closed="redirectToUserList">
      <span>User berhasil diedit!</span>
    </md-snackbar>
  </div>
</template>
<script>
export default {
  data: () => ({
    url: window.location.origin + (window.location.pathname + 'user/'),
    user: {
      name: '',
      email: ''
    },
    snackbarEditUser: false,
    submitted: false,
    loading: true
  }),
  mounted() {
    this.getDataUser(this.$route.params.id);
  },
  methods: {
    getDataUser(userId) {
      axios.get(this.url + userId)
      .then(resp => {
        this.user = resp.data;
        this.loading = false;
      })
      .catch(resp => {
        console.log('catch getDataUser:', resp);
      });
    },
    saveForm() {
      this.submitted = true;
      axios.patch(this.url + this.$route.params.id, this.user)
      .then(resp => {
        this.snackbarEditUser = true;
        this.submitted = false;
      })
      .catch(resp => {
        console.log('catch saveForm:', resp);
      });
    },
    redirectToUserList() {
      this.$router.replace('/user');  
    }
  }
}  
</script>

<style>
  ._spinner-container {
    position: absolute; 
    left: 50%;
  }
  ._spinner {
    position: relative; 
    left: -50%;
  }
</style>