<template>
  <div>
    <Header></Header>
      <div class="container">
          <md-card md-with-hover>
            <ul class="breadcrumb">
              <li><a href="#/">Home</a></li>
              <li class="active">Reset Password</li>
            </ul>
          </md-card>

          <md-card md-with-hover>
						<md-card-header>
							<div class="md-title">Reset Password</div>
              <hr>
						</md-card-header>

						<md-card-content>
                <form class="form-horizontal" v-on:submit.prevent="submitForm()"> 

                    <div class="form-group">
                      <div class="col-md-4">
                        <input type="hidden" name="_token" v-model="reset._token">
                        <input type="hidden" name="token" v-model="reset.token">
                      </div>
                      <div class="col-md-6">
                          <ul class="error-message">
                            <li class="text-error" v-for="err in errors"> {{ err.toString() }} </li>
                          </ul>
                      </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-md-4 control-label">Email</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" style="font-size: 14px;" placeholder="Email" v-model="reset.email" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">Password</label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" style="font-size: 14px;" placeholder="Password" v-model="reset.password" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="col-md-4 control-label">Konfirmasi Password</label>
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" style="font-size: 14px;" placeholder="Konfirmasi Password" v-model="reset.password_confirmation" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4" v-if="loading">
                            <md-progress-bar md-mode="indeterminate"></md-progress-bar>
                            <p class="waiting">Mohon tunggu ...</p>
                        </div>
                        <div class="col-md-6 col-md-offset-4" v-else>
                            <md-button class="md-raised md-primary" type="submit">Reset Password</md-button>
                        </div>
                    </div>
                </form>
						</md-card-content>

          </md-card>
          <md-snackbar :md-active.sync="snackbar">Reset Password berhasil !!</md-snackbar>
      </div>
  </div>
</template>

<script>
  
  import Header from '../header'

  export default {
    data : () => ({
      errors : [],
    	url: window.location.origin + (window.location.pathname + 'password/reset'),
      snackbar : false,
      loading : false,
      reset : {
        email : '',
        password_confirmation : '',
        password : '',
        _token : $('meta[name="csrf-token"]').attr('content'),
        token : ''
      }
    }),
    mounted () {
        this.reset.token = this.$route.params.token
    },
    components : {
      Header
    },
    methods : {
      submitForm() {
        const app = this
        app.loading = true
        axios.post(app.url,app.reset)
        .then((resp) => {
          app.$store.commit('user/LOGIN',resp.data)
          app.$store.state.user.is_admin ? app.$router.push('/dashboard') : app.$router.push('/')
          app.snackbar = true
          app.loading = false
        })
        .catch((err) => {
          app.errors = err.response.data
          app.loading = false
          console.log(app.errors)
        })
      }
    }
  }

</script>

<style lang="scss" scoped>
  
  .breadcrumb {
    border-color: #ffffff;
    border-style: solid;
    border-width: 0 1px 4px 1px;
    padding: 8px 15px;
    margin-bottom: 35px;
    margin-top: 22px;
    list-style: none;
    background-color: #ffffff;
    border-radius: 4px;
  }
  .error-message {
      background-color:  #ff4d4d;
      border-radius: 6px;
  }
  .text-error {
    font-weight: bold;
    color: white;
    padding: 4px;
  }
  .waiting {
    font-style: italic;
  }

</style>
