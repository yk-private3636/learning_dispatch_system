import { createRouter, createWebHistory } from 'vue-router'
import { prefix } from '../consts/common.js'

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

// router.beforeEach((to, from, next) => {
  
//   // if(to.name !== prefix || to.name !== 'login') {
//   // console.log('test')
//   //   next();
//   // }
// })

// router.afterEach((to, from) => {
//   console.log(to, from)
// })

export default router