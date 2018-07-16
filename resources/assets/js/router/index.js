import Example from '../components/Example'
import PaketAqiqah from '../components/home/produk'
import Slider from '../components/home/slider'
import Footer from '../components/Footer/Footer'
import indexHome from '../components/home/indexHome'
import Dashboard from '../components/dashboard'
import Header from '../components/header/HeaderIndex.vue'



const routes = [
        {
          path : '/',
          name : 'indexHome',
          component : indexHome
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
        }

    ]

export default routes
