<template>
    <div class="container">
			 <login></login>
    </div>
</template>

<script>
    import Login from './auth'
    export default {
        components : {
          Login
        },
        mounted() {
            console.log('Component mounted.')
            console.log('Component mounted.')
        }
    }
</script>
