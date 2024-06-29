import { Router, RouteLocationNormalized } from 'vue-router';
import { useLoginState } from '../stores/LoginState.ts';
import { useValidState } from '../stores/validState.ts';
import { routeNames } from '../consts/exclusionRouteNames.ts';
// import axios from 'axios';
// import { route } from 'ziggy-js';

export const authGuard = async (router: Router) => {
  const loginState = useLoginState();
  const validState = useValidState();
  router.beforeEach(async (to: RouteLocationNormalized) => {
    const exclusionJudge: boolean = routeNames.includes(to.name as string);
    validState.init();
    // await axios(route('admin.authenticating')).then((response) => {
    //   if (response.data.judge) {
    //     loginState.setLogin();
    //   } else {
    //     loginState.setLogout();
    //   }
    // });

    if (exclusionJudge && loginState.login) {
      return { name: 'top' };
    }

    if (exclusionJudge || loginState.login) {
      return true;
    }

    return { name: 'login' };
  });
};
