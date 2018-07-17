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
          component : Dashboard
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
