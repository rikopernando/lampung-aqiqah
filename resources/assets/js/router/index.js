import Example from '../components/Example'
import Slider from '../components/home/slider'
import Footer from '../components/Footer/Footer'

const routes = [
        {
          path : '/',
          name : 'home',
          component : Example
        },{
          path : '/slider',
          name : 'slider',
          component : Slider
        },
        {
          path : '/footer',
          name : 'footer',
          component : Footer
        }
    ]

export default routes


