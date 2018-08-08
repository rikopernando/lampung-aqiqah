<template>
  <div>
    <md-card>
      <md-card-content>
        <HistoryOrder
          :orders="orders" :searched="searched"
          :search="search" :searchBy="searchBy"
          :loading="loading"
        />
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
  import HistoryOrder from './history-order'

  export default{
    props: ["orders", "searched"],
    data: () => ({      
      search: null,
      loading: false,
      searchBy: 'nama_peserta',
    }),
    components: {
      HistoryOrder
    }
  }
</script>
