import { useLoginState } from '../stores/LoginState.js'
import { prefix } from '../consts/common.js'

export const authGuard = (router) => {
    const loginState = useLoginState();
    router.beforeEach((to) => {

    	console.log(loginState.login)
    	const loginViewJudge = to.name === 'admin' || to.name  === 'login';

    	if(loginViewJudge && loginState.login){
    		return {name: 'top'}
    	}

    	if(loginViewJudge || loginState.login) {
    		return true;
    	}
        
        return {name: 'login'};
    });
};