<style scoped>
  li.active a {
    color: white !important;
    pointer-events: none;
    cursor: default;
  }
  li.disabled a {
    pointer-events: none;
    cursor: default;
    text-decoration: none;
    color: grey;
  }
  li a {
    cursor: pointer;
  }
  ul.pagination {
  	margin: 2.5px 0px 20px 0px;
  }
</style>

<template>
  <div class="container" style="margin-top: 10px;">
    <div v-if="doSearch" class="text-center">
      <small> Terdapat {{ items.length }} hasil pencarian ditemukan </small>
    </div>
    <div v-else-if="!doSearch && items.length == 0">
    	<!-- kosongkan -->
    </div>
    <div v-else class="text-center">
    	<small> Terdapat {{ items.length }} data tersedia </small>
    </div>
    <ul v-if="items.length > itemPerPage" class="pagination justify-content-center">
      <li class="pull-left" v-bind:class="{'disabled': pagination.currentPage == pagination.items[0] || pagination.items.length == 0}">
        <md-tooltip md-direction="top"> Halaman Pertama </md-tooltip>
        <a v-on:click="selectPage(pagination.items[0])">
          &#8676;
        </a>
      </li>
      <li v-bind:class="{'disabled': pagination.currentPage == pagination.items[0] || pagination.items.length == 0}">
        <md-tooltip md-direction="top"> Halaman Sebelumnya </md-tooltip>
        <a v-on:click="selectPage(pagination.currentPage - 1)">&#8678;</a>
      </li>
      <li v-bind:class="{'active': item == pagination.currentPage}" v-for="item in pagination.filteredItems">
        <a v-on:click="selectPage(item)">{{item}}</a>
      </li>
      <li v-bind:class="{'disabled': pagination.currentPage==pagination.items[pagination.items.length - 1] || pagination.items.length == 0}">
        <md-tooltip md-direction="top"> Halaman Selanjutnya </md-tooltip>
        <a v-on:click="selectPage(pagination.currentPage + 1)">&#8680;</a>
      </li>
      <li class="pull-right" v-bind:class="{'disabled': pagination.currentPage == pagination.items[pagination.items.length - 1] || pagination.items.length == 0}">
        <md-tooltip md-direction="top"> Halaman Terakhir </md-tooltip>
        <a v-on:click="selectPage(pagination.items[pagination.items.length - 1])">
          &#8677;
        </a>
      </li>
    </ul>
    <div v-else style="margin-bottom: 20px;"></div>
  </div>
</template>

<script>

const toLower = text => {
  return text.toString().toLowerCase();
};

export default {
  props: ['dataPaging', 'range', 'itemPerPage', 'search'],
  data: () => ({
    items: [],
    paginatedItems: [],
    pagination: {
      range: 5,
      currentPage: 1,
      itemPerPage: 5,
      items: [],
      filteredItems: [],
    },
    doSearch: false
  }),
  watch: {
    dataPaging(data) {
    	this.doSearch = false;
      this.items = data;
      this.buildPagination();
      this.selectPage(1);
    },
    paginatedItems(data) {
      this.sendPaginatedItems(data);
    },
    search(searchResult) {
    	if (searchResult.length == 0)
    		this.doSearch = false;
    	else if (searchResult.length > 0 && searchResult.length == this.dataPaging.length)
	    	this.doSearch = false;
	    else 
	    	this.doSearch = true;

      this.items = searchResult;
      this.buildPagination();
      this.selectPage(1);
    }
  },
  mounted() {
    if (_.isUndefined(this.dataPaging)) {
      console.error('Properti dataPaging harus diisi!');
    } else {
      this.items = this.dataPaging;
      if (!_.isUndefined(this.range)) this.pagination.range = this.range;
      if (!_.isUndefined(this.itemPerPage)) this.pagination.itemPerPage = this.itemPerPage;
      this.buildPagination();
      this.selectPage(1);
    }
  },
  methods: {
    sendPaginatedItems(items) {
      this.$emit('paginatedItems', items);
    },
    buildPagination() {
      let numberOfPage = Math.ceil(this.items.length / this.pagination.itemPerPage);
      this.pagination.items = [];
      for (var i = 0; i < numberOfPage; i++) {
        this.pagination.items.push(i + 1);
      }
    },
    selectPage(item) {
      this.pagination.currentPage = item;
      let start = 0;
      let end = 0;

      if(this.pagination.currentPage < this.pagination.range - 2) {
        start = 1;
        end = start + this.pagination.range - 1;
      } else if (this.pagination.currentPage <= this.pagination.items.length && this.pagination.currentPage > this.pagination.items.length - this.pagination.range + 2) {
        start = this.pagination.items.length - this.pagination.range + 1;
        end = this.pagination.items.length;
      } else {
        start = this.pagination.currentPage - 2;
        end = this.pagination.currentPage + 2;
      }
      
      if (start < 1) {
        start = 1;
      }
      
      if (end > this.pagination.items.length) {
        end = this.pagination.items.length;
      }
      
      this.pagination.filteredItems = [];
      for (var i = start; i<=end; i++) {
        this.pagination.filteredItems.push(i);
      }

      this.paginatedItems = this.items.filter((v, k) => {
        return Math.ceil((k + 1) / this.pagination.itemPerPage) == this.pagination.currentPage;
      });
    }
  }
}

</script>