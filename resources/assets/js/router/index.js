import Example from '../components/Example'
import PaketAqiqah from '../components/home/produk'
import Slider from '../components/home/slider'
import Footer from '../components/Footer/Footer'
import indexHome from '../components/home/indexHome'
import Dashboard from '../components/dashboard'
import Header from '../components/header/HeaderIndex.vue'
import Tes from '../components/tes'


const routes = [
        {
          path : '/',
          name : 'home',
          component : Example
        },{
          path : '/paket',
          name : 'paket',
          component : PaketAqiqah
        },
        { path : '/slider',
          name : 'slider',
          component : Slider
        },
        {
          path : '/footer',
          name : 'footer',
          component : Footer
        },
        {
          path : '/indexHome',
          name : 'indexHome',
          component : indexHome
        },
        {
          path : '/dashboard',
          name : 'dashboard',
          component : Dashboard
        },
        {
          path : '/header',
          name : 'header',
          component : Header
        },
        {
          path : '/tes',
          component : Tes
        }

    ]

export default routes
