import { useRouter } from 'vue-router'
import { useLoginState } from '../stores/LoginState.js'
import { prefix } from '../consts/common.js'
import { routeNames } from '../consts/exclusionRouteNames.js'
import axios from 'axios'

export const authGuard = async (router) => {
    const loginState = useLoginState();
    router.beforeEach( async (to) => {

    	const exclusionJudge = routeNames.includes(to.name);

        await axios(route('admin.authenticating'))
        .then(response => {
            if(response.data.judge){
                loginState.setLogin();
            }
            else{
                loginState.setLogout();
            }
        })

    	if(exclusionJudge && loginState.login){
            return {name: 'top'}
    	}

    	if(exclusionJudge || loginState.login) {
            return true;
    	}

        return {name: 'login'};
    });
};