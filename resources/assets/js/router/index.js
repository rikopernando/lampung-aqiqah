import Example from '../components/Example'
import Header from '../components/header/HeaderIndex.vue';

const routes = [
        {
          path : '/',
          name : 'home',
          component : Example
        },
        {
          path : '/header',
          name : 'header',
          component : Header
        }
    ]

export default routes
