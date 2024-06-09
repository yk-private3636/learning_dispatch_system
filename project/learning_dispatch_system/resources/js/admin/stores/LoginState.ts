import { defineStore } from 'pinia';
import { useUserState } from './UserState.ts';
import axios, { AxiosResponse } from 'axios';
import { User, UserApi } from '../consts/interface.ts';
import { route } from 'ziggy-js';

export const useLoginState = defineStore('loginState', {
  state: () => ({
    login: false as boolean,
  }),
  actions: {
    setLogin(): void {
      const userState = useUserState();
      axios
        .get(route('admin.authenticating'))
        .then((response: AxiosResponse<UserApi>) => {
          const user: User = response.data.user;
          userState.setUser(user);
        });
      this.login = true;
    },
    setLogout(): void {
      const userState = useUserState();
      this.login = false;
      userState.setUser(null);
    },
  },
  persist: true,
  // persist: {
  // 	storage: persistedState.sessionStorage
  // }
});
