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
    color: black;
  }
  li a {
    cursor: pointer;
  }
</style>

<template>
  <div class="container">
    <ul class="pagination justify-content-center">
      <li class="pull-left" v-bind:class="{'disabled': pagination.currentPage == pagination.items[0] || pagination.items.length == 0}">
        <a v-on:click="selectPage(pagination.items[0])">
          &#8676;
        </a>
      </li>
      <li v-bind:class="{'disabled': pagination.currentPage == pagination.items[0] || pagination.items.length == 0}">
        <a v-on:click="selectPage(pagination.currentPage - 1)">&#8678;</a>
      </li>
      <li v-bind:class="{'active': item == pagination.currentPage}" v-for="item in pagination.filteredItems">
        <a v-on:click="selectPage(item)">{{item}}</a>
      </li>
      <li v-bind:class="{'disabled': pagination.currentPage==pagination.items[pagination.items.length - 1] || pagination.items.length == 0}">
        <a v-on:click="selectPage(pagination.currentPage + 1)">&#8680;</a>
      </li>
      <li class="pull-right" v-bind:class="{'disabled': pagination.currentPage == pagination.items[pagination.items.length - 1] || pagination.items.length == 0}">
        <a v-on:click="selectPage(pagination.items[pagination.items.length - 1])">
          &#8677;
        </a>
      </li>
    </ul>
  </div>
</template>

<script>

const toLower = text => {
  return text.toString().toLowerCase();
};

export default {
  props: ['dataPaging', 'range', 'itemPerPage', 'search'],
  data: () => ({
    filteredItems: [],
    paginatedItems: [],
    pagination: {
      range: 5,
      currentPage: 1,
      itemPerPage: 5,
      items: [],
      filteredItems: [],
    },
  }),
  watch: {
    dataPaging(data) {
      this.filteredItems = data;
      this.buildPagination();
      this.selectPage(1);
      console.log('data', data)
    },
    paginatedItems(data) {
      this.sendPaginatedItems(data);
    },
    search(term) {
      let searchResult = this.dataPaging.filter(item => toLower(item.nama_pelanggan).includes(toLower(term)));
      this.filteredItems = searchResult;
      this.buildPagination();
      this.selectPage(1);
    }
  },
  mounted() {
    if (_.isUndefined(this.dataPaging)) {
      console.error('Properti dataPaging harus diisi!');
    } else {
      this.filteredItems = this.dataPaging;
      if (!_.isUndefined(this.range)) this.pagination.range = this.range;
      if (!_.isUndefined(this.itemPerPage)) this.pagination.itemPerPage = this.itemPerPage;
      this.buildPagination();
      this.selectPage(1);
    }
  },
  methods: {
    sendPaginatedItems(filteredItems) {
      this.$emit('paginatedItems', filteredItems);
    },
    buildPagination(){
      let numberOfPage = Math.ceil(this.filteredItems.length / this.pagination.itemPerPage)
      this.pagination.items = [];
      for (var i = 0; i < numberOfPage; i++) {
        this.pagination.items.push(i+1);
      }
    },
    selectPage(item) {
      console.log(this.paginatedItems)

      this.pagination.currentPage = item
      
      let start = 0
      let end = 0
      if(this.pagination.currentPage < this.pagination.range-2){
        start = 1
        end = start+this.pagination.range-1
      }
      else if(this.pagination.currentPage <= this.pagination.items.length && this.pagination.currentPage > this.pagination.items.length - this.pagination.range + 2){
        start = this.pagination.items.length-this.pagination.range+1
        end = this.pagination.items.length
      }
      else{
        start = this.pagination.currentPage-2
        end = this.pagination.currentPage+2
      }
      if(start<1){
        start = 1
      }
      if(end>this.pagination.items.length){
        end = this.pagination.items.length
      }
      
      this.pagination.filteredItems = []
      for(var i=start; i<=end; i++){
        this.pagination.filteredItems.push(i);
      }

      this.paginatedItems = this.filteredItems.filter((v, k) => {
        return Math.ceil((k+1) / this.pagination.itemPerPage) == this.pagination.currentPage
      })
    }
  }
}

</script>