import Example from '../components/Example'
import PaketAqiqah from '../components/home/produk'
import Slider from '../components/home/slider'
import Footer from '../components/Footer/Footer'
import Dashboard from '../components/dashboard'

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
          path : '/dashboard',
          name : 'dashboard',
          component : Dashboard
        }

    ]

export default routes


