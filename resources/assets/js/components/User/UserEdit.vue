<template>
  <div>
    <form v-on:submit.prevent="saveForm()">
      <md-card>
        <md-card-header>
          <div class="md-title">Users</div>
        </md-card-header>

        <md-card-content>
          <md-field>
            <label for="name">Nama</label>
            <md-input name="name" id="name" v-model="user.name" />
          </md-field>
          <md-field>
            <label for="email">Email</label>
            <md-input type="email" name="email" id="email" v-model="user.email" />
          </md-field>
        </md-card-content>
        <md-card-actions>
          <md-button type="submit" class="md-primary">Edit User</md-button>
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
    snackbarEditUser: false
  }),
  mounted() {
    this.getDataUser(this.$route.params.id);
  },
  methods: {
    getDataUser(userId) {
      axios.get(this.url + userId)
      .then(resp => {
        this.user = resp.data;
      })
      .catch(resp => {
        console.log('catch getDataUser:', resp);
      });
    },
    saveForm() {
      axios.patch(this.url + this.$route.params.id, this.user)
      .then(resp => {
        this.snackbarEditUser = true;
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
