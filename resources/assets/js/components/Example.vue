<template>
    <div class="container">
       <md-button class="md-raised md-primary">Primary</md-button>
       <register>
       </register>
    </div>
</template>

<script>
    import Register from './auth/register'
    export default {
        components : {
          Register
        },
        mounted() {
            console.log('Component mounted.')
            console.log('Component mounted.')
        }
    }
</script>
