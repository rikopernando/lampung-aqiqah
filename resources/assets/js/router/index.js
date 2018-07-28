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

import Checkout from '../components/checkout'
import OrderReceived from '../components/checkout/OrderReceived'

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
          component : UserEdit,
          meta : {
            requiresAuth : true,
            is_admin : true
          }
        },
        {
          path : '/user/create',
          name : 'createUser',
          component : UserCreate,
          meta : {
            requiresAuth : true,
            is_admin : true
          }
        },
        {
          path : '/bank',
          name : 'bank',
          component : BankIndex,
          meta : {
            requiresAuth : true,
            is_admin : true
          }
        },
        {
          path : '/bank-create',
          name : 'bankCreate',
          component : BankCreate,
          meta : {
            requiresAuth : true,
            is_admin : true
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
          component : ProdukList,
        },
        {
          path : '/produk',
          name : 'produk',
          component : ProdukIndex,
          meta : {
            requiresAuth : true,
            is_admin : true
          }
        },
        {
          path : '/produk/create',
          name : 'createProduk',
          component : ProdukCreate,
          meta : {
            requiresAuth : true,
            is_admin : true
          }
        },
        {
          path : '/produk/edit/:id',
          name : 'editProduk',
          component : ProdukEdit,
          meta : {
            requiresAuth : true,
            is_admin : true
          }
        },
        {
          path : '/checkout',
          name : 'checkout',
          component : Checkout
        },
        {
          path : '/checkout/order-received',
          name : 'receivedOrder',
          component : OrderReceived
        },
        {
          path : '/keranjang-belanja',
          name : 'keranjangBelanja',
          component : KeranjangBelanja
        }
]

export default routes
