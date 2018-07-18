import Dashboard from '../components/dashboard'
import Home from '../components/home'

const routes = [
        {
          path : '/',
          name : 'home',
          component : Home
        },
        {
          path : '/dashboard',
          name : 'dashboard',
          component : Dashboard,
          meta : {
            requiresAuth : true
          }
        }
]

export default routes

