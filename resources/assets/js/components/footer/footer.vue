<template>
  <div class="row footer">
	  <div class="container">
    	<div class="md-layout md-gutter">
  	    <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">
  	    	<div class="head">
  	        <span class="md-title">Download Katalog</span>
  	    	</div>
  	      <div>
            <form novalidate v-on:submit.prevent="validateKatalog">
              <md-field :class="getValidationClass('nama')">
                <label for="nama">Nama Lengkap</label>
                <md-input name="nama" id="nama" v-model="dataKatalog.nama" ref="nama"/>
                <span class="md-error" v-if="!$v.dataKatalog.nama.required">{{error.nama}}</span>
              </md-field>
              <md-field :class="getValidationClass('email')">
                <label for="email">Email</label>
                <md-input name="email" id="email" v-model="dataKatalog.email" ref="email"/>
                <span class="md-error" v-if="!$v.dataKatalog.email.required">{{error.email}}</span>
                <span class="md-error" v-else-if="!$v.dataKatalog.email.email">Format Email Salah !</span>
              </md-field>
              <md-field :class="getValidationClass('telpon')">
                <label for="telpon">No. Telpon</label>
                <md-input name="telpon" id="telpon" v-model="dataKatalog.telpon" ref="telpon"/>
                <span class="md-error" v-if="!$v.dataKatalog.telpon.required">{{error.telpon}}</span>
              </md-field>
              <div style="text-align: center;">
    				    <md-button type="submit" class="md-primary">Download</md-button>
    			    </div>
            </form>
  				</div>
	    </div>

	    <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">
	    	<div class="head">
	        <span class="md-title">Alamat</span>
	    	</div>
	      <div>
					<p>Alamat: {{ setting_perusahaan.alamat }}</p>
					<p>Telp/Whatsapp {{ setting_perusahaan.no_telp }}</p>
				</div>
	    </div>

	    <div class="md-layout-item md-medium-size-33 md-small-size-50 md-xsmall-size-100">
	    	<div class="head">
	        <span class="md-title">Lainnya</span>
	    	</div>
	    </div>
	  </div>
	  <p class="copyright">
	  	Copyright © {{ tahun }} Mulia Jaya Indofarm
	  </p>
  </div>
</div>
</template>

<script>
  import { mapState } from 'vuex'
  import { validationMixin } from 'vuelidate'
  import { required, email } from 'vuelidate/lib/validators'
 
  export default {
    mixins: [validationMixin],
    data: () => ({
    	urlKatalog: window.location.origin + (window.location.pathname + 'download-katalog'),
      tahun: new Date().getFullYear(),
      error: {
        nama: '',
        email: '',
        telpon: ''
      },
      dataKatalog: {
        nama: '',
        email: '',
        telpon: ''
      }
    }),
    validations: {
      dataKatalog: {
        nama: {
          required,
        },
        email: {
          required,
          email
        },
        telpon: {
          required,
        }
      }
    },
    computed : mapState ({
      setting_perusahaan() {
        return this.$store.state.setting_perusahaan.data
      },
    }),
    watch : {
      setting_perusahaan() {
        if(Object.keys(this.setting_perusahaan).length) {
          this.kritikSaran(this.setting_perusahaan)
        }
      }
    },
    methods: {
      getValidationClass (fieldName) {
        const field = this.$v.dataKatalog[fieldName]

        if (field) {
          this.error.nama = "Nama Lengkap Harus Diisi !";
          this.error.email = "Email Harus Diisi !";
          this.error.telpon = "No Telpon Harus Diisi !";
          return {
            'md-invalid': field.$invalid && field.$dirty
          }
        }
      },
      validateKatalog() {
        this.$v.$touch()

        if (!this.$v.$invalid) {
          this.downloadKatalog()
        }
      },
      downloadKatalog() {
        window.open(this.urlKatalog, '_blank')
      },
			kritikSaran(data) {
				(function () {
		      var options = {
	          whatsapp: data.no_telp, // WhatsApp number
	          call: data.no_telp, // Call phone number
	          call_to_action: "Hubungi Kami", // Call to action
	          button_color: "#FF6550", // Color of button
	          position: "right", // Position may be 'right' or 'left'
	          order: "whatsapp,call", // Order of buttons
		      };

		      var proto = document.location.protocol;
          var host = "whatshelp.io";
          var url = proto + "//static." + host;
		      var s = document.createElement('script');
          s.type = 'text/javascript';
          s.async = true; 
          s.src = url + '/widget-send-button/js/init.js';
		      s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
		      var x = document.getElementsByTagName('script')[0];
          x.parentNode.insertBefore(s, x);
			  })();
			}
    }
  }
</script>
<style scoped>
  .row {
  	padding: 10px;
  }
  .footer {
  	background: #f5f5fc;
  	border-top: 1px solid #e0e0f7;
  	margin-top: 0px;
  	padding: 30px;
  }
  .copyright {
  	margin-top: 20px;
  	font-weight: bold;
  	text-align: center;
  }
  .head {
  	margin-bottom: 10px;
  }
</style>
