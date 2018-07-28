import store from './store'
import axios from 'axios'
import { LOGIN } from './store/user/mutations'

const url = window.location.origin + window.location.pathname 

axios.get(url+'auth')
.then((resp) => {
   if(resp.data) {
    store.commit(`user/${LOGIN}`,resp.data)
   }else{
    console.log(false)
   }
})
.catch((err) => {
  console.log(err)
})
