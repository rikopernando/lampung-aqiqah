<template>
  <sidebar>
    <div class="col-md-12" style="padding: 0">

     	<md-card>
      	<ul class="breadcrumb">
        	<li><router-link :to="{name: 'home'}">Home</router-link></li>
        	<li class="active">Setting Perusahaan</li>
      	</ul>
      </md-card>
 
      <md-card>
        <md-card-header>
          <div class="header-card">
            <md-icon style="color: white">group</md-icon>
          </div>
          <md-card-header-text>
            <div class="md-toolbar" style="margin-top: -20px; padding: 4px">
              <div class="header-title md-toolbar-section-start" style="padding-right:10px">Setting Perusahaan</div>
              </div>
          </md-card-header-text>
        </md-card-header>

        <md-card-content>
					<center v-if="loading"><md-progress-spinner md-mode="indeterminate"></md-progress-spinner></center>
				 	<md-table v-else>
						<md-table-row>
							<md-table-head>Nama</md-table-head>
							<md-table-head>Email</md-table-head>
							<md-table-head>No. Telepon</md-table-head>
							<md-table-head>Alamat</md-table-head>
							<md-table-head>Edit</md-table-head>
						</md-table-row>

						<md-table-row>
							<md-table-cell>{{ setting_perusahaan.name }}</md-table-cell>
							<md-table-cell>{{ setting_perusahaan.email }}</md-table-cell>
							<md-table-cell>{{ setting_perusahaan.no_telp }}</md-table-cell>
							<md-table-cell>{{ setting_perusahaan.alamat }}</md-table-cell>
              <md-table-cell>
                <md-button :to="`/setting-perusahaan/edit/${setting_perusahaan.id}`" class="md-fab md-dense md-primary">
                  <md-icon>edit</md-icon>
                  <md-tooltip md-direction="top">Edit</md-tooltip>
                </md-button>
              </md-table-cell>
						</md-table-row>
					</md-table>

        </md-card-content>
      </md-card>

    </div>
  </sidebar>
</template>

<script>
  
  export default {
    data : () => ({
        url: window.location.origin + (window.location.pathname + 'setting-perusahaan'),
        setting_perusahaan: {},
        loading: true
    }),
    created() {
      	this.getSettingPerusahaanData();
    },
    methods: {
      getSettingPerusahaanData() {
        axios.get(this.url)
         .then(resp => {
          this.setting_perusahaan = resp.data;
          this.loading = false;
        })
        .catch(resp => {
          alert('Terjadi Kesalahan')
          console.log(resp);
        });
      },
    }
  }

</script>

<style scoped>
  @media (max-width: 620px) {
    .media-screen-medium-hide {
      display: block;
    }
    .media-screen-xsmall-hide {
      display: none
    }
  }
  @media (min-width: 621px) {
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
  .md-table-cell {
    background:#f7e1e1 !important;
    padding:8px !important;
  }
</style>
