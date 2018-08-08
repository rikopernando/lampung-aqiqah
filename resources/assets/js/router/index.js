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

import Checkout from '../components/checkout'
import OrderReceived from '../components/checkout/OrderReceived'

// PROFIL
import AkunIndex from '../components/profil'

import Dashboard from '../components/dashboard/index'

import Logout from '../components/logout/index'

// LAPORAN
import LaporanOrder from '../components/laporan_order/index'

const routes = [
  {
    path : '/',
    name : 'home',
    component : Home
  },

  // Dashboard
  {
    path : '/dashboard',
    name : 'dashboard',
    component : Dashboard
  },

  // User
  {
    path : '/user',
    name : 'user',
    component : UserIndex,
    meta : {
      requiresAuth : true,
      is_admin : true
    }
  },{
    path : '/user/edit/:id',
    name : 'editUser',
    component : UserEdit,
    meta : {
      requiresAuth : true,
      is_admin : true
    }
  },{
    path : '/user/create',
    name : 'createUser',
    component : UserCreate,
    meta : {
      requiresAuth : true,
      is_admin : true
    }
  },

  // Bank
  {
    path : '/bank',
    name : 'bank',
    component : BankIndex,
    meta : {
      requiresAuth : true,
      is_admin : true
    }
  },{
    path : '/bank/create',
    name : 'bankCreate',
    component : BankCreate,
    meta : {
      requiresAuth : true,
      is_admin : true
    }
  },{
    path : '/bank/edit/:id',
    name : 'bankEdit',
    component : BankEdit,
    meta : {
      requiresAuth : true,
      is_admin : true
    }
  },

  // Produk
  {
    path : '/detail-produk',
    name : 'DetailProduk',
    component : DetailProduk,
  },{
    path : '/list-produk',
    name : 'listProduk',
    component : ProdukList
  },{
    path : '/produk',
    name : 'produk',
    component : ProdukIndex,
    meta : {
      requiresAuth : true,
      is_admin : true
    }
  },{
    path : '/produk/create',
    name : 'createProduk',
    component : ProdukCreate,
    meta : {
      requiresAuth : true,
      is_admin : true
    }
  },{
    path : '/produk/edit/:id',
    name : 'editProduk',
    component : ProdukEdit,
    meta : {
      requiresAuth : true,
      is_admin : true
    }
  },{
    path : '/checkout',
    name : 'checkout',
    component : Checkout
  },{
    path : '/checkout/order-received',
    name : 'receivedOrder',
    component : OrderReceived
  },{ 
    path : '/keranjang-belanja', 
    name : 'keranjangBelanja', 
    component : KeranjangBelanja 
  },{
    path : '/akun',
    name : 'indexAkun',
    component : AkunIndex,
    meta : {
      requiresAuth : false,
    }
  },{
    path : '/logout',
    name : 'logout',
    component : Logout
  },

  // Laporan
  {
    path : '/laporan-order',
    name : 'laporanOrder',
    component : LaporanOrder
  }
]

export default routes
