import { defineStore } from 'pinia';

export const useLoginState = defineStore('loginState', {
	state:() => ({
		login: false
	}),
	actions: {
		setLogin(){
			this.login = true;
		},
		setLogout(){
			this.login = false;
		}
	},
	persist: true,
	// persist: {
	// 	storage: persistedState.sessionStorage
    // }
});

