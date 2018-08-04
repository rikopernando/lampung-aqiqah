<template>
  <div>

      <md-card>
        <md-card-content>
          <md-field>
            <label>Nama Lengkap</label>
            <md-input v-model="user.name"></md-input>
            <span-error v-if="error.name" class="label-danger">{{error.name[0]}}</span-error>
          </md-field>
          <md-field>
            <label>Email</label>
            <md-input v-model="user.email"></md-input>
            <span-error v-if="error.email" class="label-danger">{{error.email[0]}}</span-error>
          </md-field>

          <div class="md-subheading" style="color: #868686">
            PERUBAHAN SANDI
          </div>

          <md-field>
            <label>Sandi Baru (Biarkan Kosong Jika Tidak Diubah)</label>
            <md-input v-model="user.password" type="password"></md-input>
            <span-error v-if="error.password" class="label-danger">{{error.password[0]}}</span-error>
          </md-field>
          <md-field>
            <label>Ulangi Sandi Baru</label>
            <md-input v-model="user.password_confirmation" type="password"></md-input>
          </md-field>
        </md-card-content>

        <md-card-actions>
          <md-button @click="saveForm" class="md-dense md-raised" style="background-color: #d44723; color: white">
            Simpan Perubahan
          </md-button>
        </md-card-actions>
      </md-card>

      <!-- Snackbar for success alert -->
      <md-snackbar md-position="center" :md-duration="1500" :md-active.sync="notifSuccess" @md-closed="redirectTo">
        <span id="span-snackbar">{{notifMessage}}</span>
        <span><md-icon style="color: white">done_all</md-icon></span>
      </md-snackbar>
  </div>
</template>

<script>
  export default {
    props: ["user", "error"],
    data : () => ({
    	url: window.location.origin + (window.location.pathname + 'user'),
      notifMessage: '',
      notifSuccess: false
    }),
    methods: {
      saveForm() {
        const app = this;

  			axios.put(app.url+'/simpan-detail-akun', app.user)
  			.then(function (resp) {
          app.notifMessage = `Berhasil Mengubah Akun ${app.user.name}`
          app.kosongkanData(app);
          app.notifSuccess = true;
  			})
  			.catch(function (resp) {
          console.log(resp);
  				app.errors = resp.response
  			});
      },
      kosongkanData(app){
        app.user.password = '';
        app.user.password_confirmation = '';
      },
      redirectTo() {
        window.location.replace(window.location.origin+(window.location.pathname)+"#/akun")
      },
    }
  }
</script>
