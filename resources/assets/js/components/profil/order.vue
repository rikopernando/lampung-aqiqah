<template>
  <div>
    <md-card>
      <md-card-content>
        <HistoryOrder :orders="orders" :searched="searched" />
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
  import HistoryOrder from './history-order'

  export default{
    props: ["orders", "searched"],
    components: {
      HistoryOrder
    }
  }
</script>
