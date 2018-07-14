import Example from '../components/Example'
import PaketAqiqah from '../components/home/produk'
import Slider from '../components/home/slider'
import Footer from '../components/Footer/Footer'
import UserIndex from '../components/User/UserIndex'
import UserEdit from '../components/User/UserEdit'

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
          path : '/user',
          name : 'user',
          component : UserIndex
        },
        {
          path : '/user/edit/:id',
          name : 'editUser',
          component : UserEdit
        }
    ]

export default routes
