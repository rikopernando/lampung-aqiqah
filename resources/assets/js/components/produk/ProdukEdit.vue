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

<template>
  <sidebar>
    <div class="col-md-12" style="padding: 0">
      <md-card>
        <ul class="breadcrumb">
          <li><router-link :to="{name: 'dashboard'}">Dashboard</router-link></li>
          <li><router-link :to="{name: 'produk'}">Produk</router-link></li>
          <li class="active">Edit Produk</li>
        </ul>
      </md-card> 

      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white">dns</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 0px">
              <div class="header-title md-toolbar-section-start">Produk</div>
            </div>
          </md-card-header-text>
        </md-card-header>

        <md-card-content>
          <md-field>
            <label for="nama_produk">Nama Produk</label>
            <md-input style="text-transform: capitalize" name="nama_produk" id="nama_produk" v-model="produk.nama_produk" ref="nama_produk"/>
            <span-error v-if="errors.nama_produk" class="label-danger">{{errors.nama_produk[0]}}</span-error>
          </md-field>
          <md-field>
            <label for="harga_coret">Harga Coret</label>
            <md-input type="number" name="harga_coret" id="harga_coret" v-model="produk.harga_coret" />
            <span-error v-if="errors.harga_coret" class="label-danger">{{errors.harga_coret[0]}}</span-error>
          </md-field>
          <md-field>
            <label for="harga_jual">Harga Jual</label>
            <md-input type="number" name="harga_jual" id="harga_jual" v-model="produk.harga_jual" />
            <span-error v-if="errors.harga_jual" class="label-danger">{{errors.harga_jual[0]}}</span-error>
          </md-field>
          <md-field>
            <label>Deskripsi</label>
            <md-textarea v-model="produk.deskripsi_produk"></md-textarea>
          </md-field>
          <md-switch id="stok" v-model="produk.stok">Stok {{ !produk.stok ? 'Tidak Tersedia' : 'Tersedia' }}</md-switch>
          <md-field>
            <label>Foto Produk</label>
            <md-file v-model="produk.foto" id="foto" accept="image/*" @change="onFileChange" />
          </md-field>

          <md-card class="thumbnail-foto" v-if="produk.foto != null">
            <md-card-media-cover md-text-scrim>
                <md-card-media md-ratio="16:9">
                  <img :src="url_picture + '/' + produk.foto" alt="Foto Produk">
                  <img :src="previewFoto" alt="Foto Produk" v-if="previewFoto != ''">
                </md-card-media>

                <md-card-area>
                  <md-card-actions>
                    <md-button @click="removeImage">Hapus Foto</md-button>
                  </md-card-actions>
                </md-card-area>
              </md-card-media-cover>
          </md-card>

          <md-progress-bar v-if="submitted" md-mode="indeterminate"></md-progress-bar>
          <md-button v-else @click="editProduk" class="md-dense md-raised" style="background-color: #d44723; color: white">
            Simpan
          </md-button>

          <!-- Snackbar for success alert -->
          <md-snackbar md-position="center" :md-duration="1500" :md-active.sync="notifSuccess" @md-closed="redirectToProduk">
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
    	url: window.location.origin + (window.location.pathname + 'produk'),
      url_picture : window.location.origin + (window.location.pathname) + "image_produks/",
      errors: [],
      produkId: null,
      produk: {
        nama_produk: '',
        harga_coret: 0,
        harga_jual: 0,
        stok: true,
        deskripsi_produk: '',
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
      this.produkId = id;
      this.getProduk(id);
    },
    methods: {
      getProduk(id){
        axios.get(this.url + "/" + id)
        .then(resp => {
          this.produk = resp.data;
          this.produk.id = id;
          resp.data.stok === 1 ? this.produk.stok = true : this.produk.stok = false;
        })
        .catch(resp => {
          console.log('catch getProduk:', resp);
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
        let app = this;

        reader.onload = (e) => {
          app.previewFoto = e.target.result;
        };
        reader.readAsDataURL(file);
      },
      removeImage() {
        this.produk.foto = null;
      },
      editProduk() {
  			let dataProduk = this.inputData();
        this.submitted = true;

        axios.post(this.url + "/" + this.produkId, dataProduk)
        .then(resp => {
          this.notifMessage = `Berhasil Mengubah Produk ${this.produk.nama_produk}`
          this.notifSuccess = true;
          this.submitted = false;
        })
        .catch(resp => {
          console.log('catch editProduk:', resp);
  				this.errors = resp.response.data;
          this.submitted = false;
        });
      },
  		inputData() {
  			let dataProduk = new FormData();
          if (document.getElementById('foto').files[0] != undefined) {
            dataProduk.append('foto', document.getElementById('foto').files[0]);
          }

          dataProduk.append('nama_produk', this.produk.nama_produk);
    			dataProduk.append('harga_coret', this.produk.harga_coret);
    			dataProduk.append('harga_jual', this.produk.harga_jual);
    			dataProduk.append('stok', this.produk.stok);
    			dataProduk.append('deskripsi_produk', this.produk.deskripsi_produk);

  			return dataProduk;
  		},
      redirectToProduk() {
        this.$router.replace('/produk');
      }
    }
  }

</script>