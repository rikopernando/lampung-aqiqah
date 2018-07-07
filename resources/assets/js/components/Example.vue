<template>
    <div>
      <small>Raised</small>
       <md-button class="md-raised">Default</md-button>
       <md-button class="md-raised" :md-ripple="false">Ripple Off</md-button>
       <md-button class="md-raised md-primary">Primary</md-button>
       <md-button class="md-raised md-accent">Accent</md-button>
       <md-button class="md-raised" disabled>Disabled</md-button>
       <md-button class="md-icon-button">
       <md-icon>home</md-icon>
       </md-button>

    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
