import Dashboard from '../components/dashboard'
import Home from '../components/home'
import UserIndex from '../components/User/UserIndex'
import UserEdit from '../components/User/UserEdit'

// PRODUK
import ProdukIndex from '../components/produk/ProdukIndex'
import ProdukCreate from '../components/produk/ProdukCreate'
import ProdukEdit from '../components/produk/ProdukEdit'

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
          path : '/produk',
          name : 'produk',
          component : ProdukIndex
        },
        {
          path : '/produk/create',
          name : 'createProduk',
          component : ProdukCreate
        },
        {
          path : '/produk/edit/:id',
          name : 'editProduk',
          component : ProdukEdit
        },
]

export default routes
