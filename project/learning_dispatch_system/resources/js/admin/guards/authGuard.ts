import { Router, RouteLocationNormalized } from 'vue-router';
import { useLoginState } from '../stores/LoginState.js';
import { routeNames } from '../consts/exclusionRouteNames.ts';
import axios from 'axios';
import { route } from 'ziggy-js';

export const authGuard = async (router: Router) => {
  const loginState = useLoginState();
  router.beforeEach(async (to: RouteLocationNormalized) => {
    const exclusionJudge = routeNames.includes(to.name as string);

    await axios(route('admin.authenticating')).then((response) => {
      if (response.data.judge) {
        loginState.setLogin();
      } else {
        loginState.setLogout();
      }
    });

    if (exclusionJudge && loginState.login) {
      return { name: 'top' };
    }

    if (exclusionJudge || loginState.login) {
      return true;
    }

    return { name: 'login' };
  });
};
