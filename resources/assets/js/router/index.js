import Dashboard from '../components/dashboard'
import Home from '../components/home'
import UserIndex from '../components/User/UserIndex'
import UserEdit from '../components/User/UserEdit'
import BankIndex from '../components/bank/BankIndex'
import BankCreate from '../components/bank/BankCreate'

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
        },
        {
          path : '/bank',
          name : 'bank',
          component : BankIndex
        },
        {
          path : '/bank-create',
          name : 'bankCreate',
          component : BankCreate
        },
]

export default routes
