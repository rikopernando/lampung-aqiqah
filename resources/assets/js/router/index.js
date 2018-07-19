import Dashboard from '../components/dashboard'
import Home from '../components/home'
import UserIndex from '../components/User/UserIndex'
import UserEdit from '../components/User/UserEdit'

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
        },
        {
          path : '/user',
          name : 'user',
          component : UserIndex,
          meta : {
            requiresAuth : true
          }
        },
        {
          path : '/user/edit/:id',
          name : 'editUser',
          component : UserEdit,
          meta : {
            requiresAuth : true
          }
        }
]

export default routes

