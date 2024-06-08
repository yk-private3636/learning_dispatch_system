import { defineStore } from "pinia";

export const useLoginState = defineStore("loginState", {
  state: () => ({
    login: false as boolean,
  }),
  actions: {
    setLogin(): void {
      this.login = true;
    },
    setLogout(): void {
      this.login = false;
    },
  },
  persist: true,
  // persist: {
  // 	storage: persistedState.sessionStorage
  // }
});
