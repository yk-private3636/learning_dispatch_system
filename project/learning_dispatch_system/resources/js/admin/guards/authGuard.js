import { useRouter } from 'vue-router'
import { useLoginState } from '../stores/LoginState.js'
import { prefix } from '../consts/common.js'
import axios from 'axios'

export const authGuard = async (router) => {
    const loginState = useLoginState();
    router.beforeEach( async (to) => {

    	const loginViewJudge = to.name === 'admin' || to.name  === 'login';
        
        await axios(route('admin.authenticating'))
        .then(response => {
            if(response.data.judge){
                loginState.setLogin();
            }
            else{
                loginState.setLogout();
            }
        })

    	if(loginViewJudge && loginState.login){
            return {name: 'top'}
    	}

    	if(loginViewJudge || loginState.login) {
            return true;
    	}

        return {name: 'login'};
    });
};