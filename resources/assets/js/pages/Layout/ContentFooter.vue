<template>
  <footer class="footer">
    <div class="container">
        <nav>
            <ul>
              <li>
                <router-link :to="{path:'/dashboard'}">Dashboard</router-link>
              </li>
                <li>
                    <a href="#">
                        Perusahaan
                    </a>
                </li>
                <li>
                    <a href="#">
                        Portfolio
                    </a>
                </li>
                <li>
                    <a href="#">
                        Blog
                    </a>
                </li>
            </ul>
        </nav>
        <div class="copyright text-center">
          Copyright &copy; {{ new Date().getFullYear() }} <a href="http://andaglos.id/" target="_blank">PT. Andaglos Global Teknologi</a>
        </div>
    </div>
  </footer>

</template>
<script>
export default {}

</script>
<style>

</style>
