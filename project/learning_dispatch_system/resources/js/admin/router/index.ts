import { createRouter, createWebHistory } from 'vue-router';
import * as path from '../consts/routerPath.ts';
import axios from 'axios';
import { route } from 'ziggy-js';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    // {
    //    path: '/todo',
    //    name: 'todo',
    //    component: TodoView
    // }
    {
      path: path.common,
      name: 'admin',
      component: () => import('../views/login/index.vue'),
    },
    {
      path: path.login,
      name: 'login',
      component: () => import('../views/login/index.vue'),
    },
    {
      path: path.loginForget,
      name: 'login.forget',
      component: () => import('../views/login/forget.vue'),
    },
    {
      path: path.passwordReset,
      name: 'password.reset',
      component: () => import('../views/login/passwordReset.vue'),
      beforeEnter: (to, from, next) => {
        const token: string = to.params.token as string;
        axios
          .get(route('admin.password.reset.accurate.token', token))
          .then((response) => {
            if (response.data.judge === false) {
              throw new Error('無効なトークンです。');
            }
            next();
          })
          .catch(() => {
            router.push({ name: 'not-found' });
          });
      },
    },
    {
      path: path.top,
      name: 'top',
      component: () => import('../views/top/index.vue'),
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: () => import('../views/errors/NotFound.vue'),
    },
  ],
});

// router.beforeEach( async (to, from, next) => {
//   console.log(to.meta)
//   next()
// })

// router.afterEach((to, from) => {
//   console.log(to, from)
// })

export default router;
