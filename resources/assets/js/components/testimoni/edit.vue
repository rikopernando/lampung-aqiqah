<template>
  <sidebar>
    <div class="col-md-12" style="padding: 0">
      <md-card>
        <ul class="breadcrumb">
          <li><router-link :to="{name: 'dashboard'}">Dashboard</router-link></li>
          <li><router-link :to="{name: 'testimoni'}">Testimoni</router-link></li>
          <li class="active">Edit Testimoni</li>
        </ul>
      </md-card>

      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white">rate_review</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
              <div class="header-title md-toolbar-section-start">Testimoni</div>
            </div>
          </md-card-header-text>
        </md-card-header>

        <md-card-content>
          <md-field>
            <label for="nama_lengkap">Nama Lengkap</label>
            <md-input name="nama_lengkap" id="nama_lengkap" v-model="testimoni.nama_lengkap" ref="nama_lengkap"/>
            <span v-if="errors.nama_lengkap" class="label-danger span-error">{{errors.nama_lengkap[0]}}</span>
          </md-field>

          <md-field>
            <label for="profesi">Profesi</label>
            <md-input name="profesi" id="profesi" v-model="testimoni.profesi" ref="profesi"/>
            <span v-if="errors.profesi" class="label-danger span-error">{{errors.profesi[0]}}</span>
          </md-field>

          <md-field>
            <label>Testimoni</label>
            <md-textarea v-model="testimoni.testimoni"></md-textarea>
            <span v-if="errors.testimoni" class="label-danger span-error">{{errors.testimoni[0]}}</span>
          </md-field>

          <md-field>
            <label>Foto</label>
            <md-file v-model="testimoni.foto" id="foto" accept="image/*" @change="onFileChange" />
          </md-field>

          <md-card class="thumbnail-foto" v-if="testimoni.foto != null">
            <md-card-media-cover md-text-scrim>
              <md-card-media md-ratio="16:9">
                <img :src="url_picture + '/' + testimoni.foto" alt="Foto">
                <img :src="previewFoto" alt="Foto" v-if="previewFoto != ''">
              </md-card-media>

              <md-card-area>
                <md-card-actions>
                  <md-button @click="removeImage">Hapus Foto</md-button>
                </md-card-actions>
              </md-card-area>
            </md-card-media-cover>
          </md-card>

          <md-progress-bar v-if="submitted" md-mode="indeterminate"></md-progress-bar>
          <md-button v-else @click="editTestimoni" class="md-dense md-raised" style="background-color: #d44723; color: white">
            Simpan
          </md-button>

          <!-- Snackbar for success alert -->
          <md-snackbar md-position="center" :md-duration="1500" :md-active.sync="notifSuccess" @md-closed="redirectToTestimoni">
            <span id="span-snackbar">{{notifMessage}}</span>
            <span><md-icon style="color: white">done_all</md-icon></span>
          </md-snackbar>
        </md-card-content>
      </md-card>

    </div>
  </sidebar>
</template>


<script>
  export default {
    data: () => ({
    	url: window.location.origin + (window.location.pathname + 'testimoni'),
      url_picture : window.location.origin + (window.location.pathname) + "image_produks/",
      errors: [],
      testimoniId: null,
      testimoni: {
        nama_lengkap: '',
        profesi: '',
        testimoni: '',
        foto: null,
        id: '',
      },
      previewFoto: '',
      notifMessage: '',
      notifSuccess: false,
      submitted: false
    }),
    mounted() {
      let id = this.$route.params.id;
      this.testimoniId = id;
      this.getTestimoni(id);
    },
    methods: {
      getTestimoni(id){
        axios.get(this.url + "/" + id)
        .then(resp => {
          this.testimoni = resp.data;
          this.testimoni.id = id;
          resp.data.stok === 1 ? this.testimoni.stok = true : this.testimoni.stok = false;
        })
        .catch(resp => {
          console.log('catch getTestimoni:', resp);
        });
      },
      onFileChange(e) {
        let files = e.target.files || e.dataTransfer.files;
        if (!files.length)
          return;
        this.createImage(files[0]);
      },
      createImage(file) {
        let image = new Image();
        let reader = new FileReader();

        reader.onload = (e) => {
          this.previewFoto = e.target.result;
        };
        reader.readAsDataURL(file);
      },
      removeImage() {
        this.testimoni.foto = null;
      },
      editTestimoni() {
  			let dataTestimoni = this.inputData();

        this.submitted = true;
        axios.post(this.url + "/" + this.testimoniId, dataTestimoni)
        .then(resp => {
          this.notifMessage = `Berhasil Mengubah Testimoni ${this.testimoni.nama_lengkap}`
          this.notifSuccess = true;
          this.submitted = false;
        })
        .catch(resp => {
          console.log(resp);
  				this.errors = resp.response.data
          this.submitted = false;
        });
      },
  		inputData() {
  			let dataTestimoni = new FormData();
          if (document.getElementById('foto').files[0] != undefined) {
            dataTestimoni.append('foto', document.getElementById('foto').files[0]);
          }
            dataTestimoni.append('nama_lengkap', this.testimoni.nama_lengkap);
      			dataTestimoni.append('profesi', this.testimoni.profesi);
      			dataTestimoni.append('testimoni', this.testimoni.testimoni);

  			return dataTestimoni;
  		},
      redirectToTestimoni() {
        this.$router.replace('/testimoni');
      }
    }
  }
</script>

<style scoped>
	@media (max-width: 600px) {
		.media-screen-medium-hide {
			display: block;
		}
		.media-screen-xsmall-hide {
			display: none
		}
	}
	@media (min-width: 601px) {
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
  .span-error {
    color: white;
    height: 20px;
    position: absolute;
    bottom: -22px;
    font-size: 12px;
    transition: .3s cubic-bezier(.4,0,.2,1);
  }
  .label-danger {
    background-color: red;
    border-radius: 12px;
    padding: 0px 10px;
    text-transform: uppercase;
    font-size: 10px;
    font-weight: bold
  }
  .thumbnail-foto {
    width: 25%;
  }
</style>
