import Dashboard from '../components/dashboard'
import Home from '../components/home'
import UserIndex from '../components/user/index'
import UserEdit from '../components/user/edit'
import UserCreate from '../components/user/create'
import BankIndex from '../components/bank/BankIndex'
import BankCreate from '../components/bank/BankCreate'
import BankEdit from '../components/bank/BankEdit'


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
            requiresAuth : true,
            is_admin : true
          }
        },
        {
          path : '/user',
          name : 'user',
          component : UserIndex,
          meta : {
            requiresAuth : true,
            is_admin : true
          }
        },
        {
          path : '/user/edit/:id',
          name : 'editUser',
          component : UserEdit
        },
        {
          path : '/user/create',
          name : 'createUser',
          component : UserCreate
        },
        {
          path : '/bank',
          name : 'bank',
          component : BankIndex,
          meta : {
            requiresAuth : true
          }
        },
        {
          path : '/bank-create',
          name : 'bankCreate',
          component : BankCreate,
          meta : {
            requiresAuth : true
          }
        },
        {
          path : '/bank/edit/:id',
          name : 'bankEdit',
          component : BankEdit,
          meta : {
            requiresAuth : true,
            is_admin : true
          }
        }
]

export default routes

