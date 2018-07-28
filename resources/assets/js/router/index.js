import Home from '../components/home'

// USER
import UserIndex from '../components/user/index'
import UserEdit from '../components/user/edit'
import UserCreate from '../components/user/create'

// BANK
import BankIndex from '../components/bank/BankIndex'
import BankCreate from '../components/bank/BankCreate'
import BankEdit from '../components/bank/BankEdit'
import KeranjangBelanja from '../components/keranjangbelanja/KeranjangBelanja'


// PRODUK
import ProdukIndex from '../components/produk/ProdukIndex'
import ProdukCreate from '../components/produk/ProdukCreate'
import ProdukEdit from '../components/produk/ProdukEdit'
import DetailProduk from '../components/list-produk/detail_produk'
import ProdukList from '../components/home/ListProduk'

// MATERIAL TEMPLATE ROUTES
import DashboardLayout from '../pages/Layout/DashboardLayout.vue'
import Dashboard from '../pages/Dashboard.vue'
import UserProfile from '../pages/UserProfile.vue'
import TableList from '../pages/TableList.vue'
import Typography from '../pages/Typography.vue'
import Icons from '../pages/Icons.vue'
import Notifications from '../pages/Notifications.vue'

const routes = [
{
    path : '/',
    name : 'home',
    component : Home
  },
  {
          path : '/keranjang-belanja',
          name : 'keranjangBelanja',
          component : KeranjangBelanja
  },
  {
    path: '/dashboard',
    component: DashboardLayout,
    children: [
      {
        path: 'dashboard',
        name: 'Dashboard',
        component: Dashboard
      },
      {
        path: 'user-profile',
        name: 'User Profile',
        component: UserProfile
      },
      {
        path: 'table',
        name: 'Table List',
        component: TableList
      },
      {
        path: 'typography',
        name: 'Typography',
        component: Typography
      },
      {
        path: 'icons',
        name: 'Icons',
        component: Icons
      },
      {
        path: 'notifications',
        name: 'Notifications',
        component: Notifications
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
      },
      {
        path : '/detail-produk',
        name : 'DetailProduk',
        component : DetailProduk,
      },
      {
        path : '/list-produk',
        name : 'listProduk',
        component : ProdukList
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
      }
    ]
  }
]

export default routes

