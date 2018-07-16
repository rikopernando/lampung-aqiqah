<template>
  <div>
    <form v-on:submit.prevent="saveForm()">
      <md-card>
        <md-card-header>
          <div class="md-title">Users</div>
        </md-card-header>

        <md-card-content>
          <md-field>
            <label for="first-name">First Name</label>
            <md-input name="first-name" id="first-name" autocomplete="given-name" v-model="user.name" />
          </md-field>
          <md-field>
            <label for="email">Email</label>
            <md-input type="email" name="email" id="email" autocomplete="email" v-model="user.email" />
          </md-field>
        </md-card-content>
        <md-card-actions>
          <md-button type="submit" class="md-primary">Edit User</md-button>
        </md-card-actions>
      </md-card>
    </form>
  </div>
</template>
<script>
export default {
  data: () => ({
    url: window.location.origin + (window.location.pathname + 'user/'),
    user: {
      name: '',
      email: ''
    }
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
        console.log('catch:', resp);
      });
    },
    saveForm() {
      axios.patch(this.url + this.$route.params.id, this.user)
      .then(resp => {
        console.log('then:', resp);
      })
      .catch(resp => {
        console.log('catch:', resp);
      });
    }
  }
}  
</script>