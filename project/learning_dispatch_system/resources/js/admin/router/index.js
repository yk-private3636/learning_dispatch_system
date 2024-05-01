import { createRouter, createWebHistory } from 'vue-router'
import { useLoginState } from '../stores/LoginState.js'
import { prefix } from '../consts/common.js'
import axios from 'axios'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    // {
    //    path: '/todo',
    //    name: 'todo',
    //    component: TodoView
    // }
  	{
      path: prefix,
      name: 'admin',
      component: () => import('../views/login/index.vue')
    },
    {
      path: prefix + '/login',
      name: 'login',
      component: () => import('../views/login/index.vue')
    },
    {
      path: prefix + '/top',
      name: 'top',
      component: () => import('../views/top/index.vue')
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: () => import('../views/errors/NotFound.vue')
    }
  ]
})

// router.beforeEach( async (to, from, next) => {
  
//   const loginState = useLoginState();
//   const loginViewJudge = to.name === 'admin' || to.name  === 'login';

//   await axios.get(route('admin.authenticating'))
//   .then(response => {
//       if(response.data.judge){
//           loginState.setLogin();
//       }
//       else{
//           loginState.setLogout();
//       }
//   })

//   if(loginState?.login == false){
//     next({
//       path: '/admin/login',
//       query: { redirect: to.fullPath }
//     })
//   }

//   if(loginViewJudge && loginState?.login === true){
//     router.go(-1)
//   }

//   next()
// })

// router.afterEach((to, from) => {
//   console.log(to, from)
// })

export default router