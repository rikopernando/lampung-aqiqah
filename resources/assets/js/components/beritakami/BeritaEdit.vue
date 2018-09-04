<template>
  <sidebar>
    <div class="col-md-12" style="padding: 0">
      <md-card>
        <ul class="breadcrumb">
          <li><router-link :to="{name: 'dashboard'}">Dashboard</router-link></li>
          <li><router-link :to="{name: 'beritaKami'}">Berita Kami</router-link></li>
          <li class="active">Edit Berita Kami</li>
        </ul>
      </md-card>

      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white">rate_review</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
              <div class="header-title md-toolbar-section-start">Berita Kami</div>
            </div>
          </md-card-header-text>
        </md-card-header>

        <md-card-content>
          <md-field>
            <label for="judul_berita">Judul Berita</label>
            <md-input name="judul_berita" id="judul_berita" v-model="berita.judul_berita" ref="judul_berita"/>
            <span-error v-if="errors.judul_berita" class="label-danger">{{errors.judul_berita[0]}}</span-error>
          </md-field>

          
          <label for="isi_berita">Isi Berita</label>
          <quill-editor v-model="berita.isi_berita" ref="myQuillEditor" :options="editorOption" style="height:10%">
          </quill-editor>
            <span-error v-if="errors.isi_berita" class="label-danger">{{errors.isi_berita[0]}}</span-error>
          

          <md-field>
            <label>Foto</label>
            <md-file v-model="berita.foto" id="foto" accept="image/*" @change="onFileChange" />
          </md-field>

            <md-card class="thumbnail-foto" v-if="berita.foto != null">
            <md-card-media-cover md-text-scrim>
                <md-card-media md-ratio="16:9">
                  <img :src="url_picture+'/'+berita.foto" alt="Foto">
                  <img :src="previewFoto" alt="Foto" v-if="previewFoto != ''">
                </md-card-media>

                <md-card-area>
                  <md-card-actions>
                    <md-button @click="removeImage">Hapus Foto</md-button>
                  </md-card-actions>
                </md-card-area>
              </md-card-media-cover>
          </md-card>

            <md-button v-if="!loading" @click="editBerita" class="md-dense md-raised" style="background-color: #d44723; color: white">
              Simpan
            </md-button>
            <md-progress-spinner v-else :md-diameter="30" :md-stroke="3" md-mode="indeterminate"></md-progress-spinner>

          <!-- Snackbar for success alert -->
          <md-snackbar md-position="center" :md-duration="1500" :md-active.sync="notifSuccess" @md-closed="redirectToBerita">
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
    	url: window.location.origin + (window.location.pathname + 'berita'),
      url_picture : window.location.origin + (window.location.pathname) + "image_berita/",
      errors: [],
      beritaId: null,
      berita: {
        judul_berita: '',
        isi_berita: '',
        foto: ''
      },
      editorOption: {
      },
      previewFoto: '',
      notifMessage: '',
      notifSuccess: false,
      loading: false,
    }),
    mounted() {
      let app = this;
      let id = app.$route.params.id;

      app.beritaId = id;
      app.getBerita(app, id);
    },
    computed: {
    editor() {
      return this.$refs.myQuillEditor.quill
    }
    },
    methods: {
      getBerita(app, id){
        axios.get(app.url+"/"+id)
        .then(function (resp) {
          console.log(resp.data);
          app.berita = resp.data;
          app.berita.id = id;
        })
        .catch(function (resp) {
          console.log('catch getBerita:', resp);
        });
      },
      onFileChange(e) {
        var files = e.target.files || e.dataTransfer.files;
        if (!files.length)
          return;
        this.createImage(files[0]);
      },
      createImage(file) {
        var image = new Image();
        var reader = new FileReader();
        var app = this;

        reader.onload = (e) => {
          app.previewFoto = e.target.result;
        };
        reader.readAsDataURL(file);
      },
      removeImage() {
        this.berita.foto = null;
      },
      editBerita() {
        let app = this;
  			let dataBerita = app.inputData(app);

        app.loading = true;
        axios.post(app.url+"/"+app.beritaId, dataBerita)
        .then(resp => {
          app.notifMessage = `Berhasil Mengubah Berita ${app.berita.judul_berita}`
          app.notifSuccess = true;
        })
        .catch(resp => {
          console.log(resp);
  				app.errors = resp.response.data
          app.loading = false;
        });
      },
  		inputData(app) {
  			let dataBerita = new FormData();
          if (document.getElementById('foto').files[0] != undefined) {
            dataBerita.append('foto', document.getElementById('foto').files[0]);
          }
          dataBerita.append('judul_berita', app.berita.judul_berita);
          dataBerita.append('isi_berita', app.berita.isi_berita);

  			return dataBerita;
  		},
      redirectToBerita() {
        this.$router.replace('/berita-kami');
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
</style>


<style scoped>
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
  span-error {
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
