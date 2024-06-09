import { defineStore } from 'pinia';
import { User } from '../consts/interface.ts';

export const useUserState = defineStore('userState', {
  state: () => ({
    user: null as User | unknown,
  }),
  actions: {
    setUser(user: User | unknown): void {
      this.user = user;
    },
  },
  persist: true,
  // persist: {
  // 	storage: persistedState.sessionStorage
  // }
});
