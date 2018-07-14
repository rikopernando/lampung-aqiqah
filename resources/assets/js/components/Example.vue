<template>
    <div class="container">
       <md-button class="md-raised md-primary">Primary</md-button>
			<login></login>
    </div>
</template>

<script>
    import Register from './auth/register'
    import Login from './auth'
    export default {
        components : {
          Register,Login
        },
        mounted() {
            console.log('Component mounted.')
            console.log('Component mounted.')
        }
    }
</script>
