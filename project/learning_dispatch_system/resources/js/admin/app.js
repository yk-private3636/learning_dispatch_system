import { createApp } from 'vue'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import App from './App.vue'
import router from './router'
import '../../css/app.css'
import { authGuard } from './guards/authGuard.js'
import { useLoginState } from './stores/LoginState.js'

const app = createApp(App)
const pinia = createPinia()

app.use(router)
app.use(pinia)
pinia.use(piniaPluginPersistedstate)
authGuard(router)

// app.config.errorHandler = (error, instance, info) => {
//   console.log("エラーが発生しました2。");

//   // (例)エラー画面に遷移
//   router.push("/error");
// };

// window.addEventListener("error", (event) => {
//   console.log("エラーハンドラでエラーをキャッチ");
//   console.log(event.error)
  
//   // エラー画面に遷移
//   router.push("/error");
// })

window.addEventListener("unhandledrejection", (event) => {
  const statusCode = event.reason.response.status;
  const loginState = useLoginState();

  if(statusCode === 401){
	loginState.setLogout();  	
  	router.push({name: 'login'});
  }

})

app.mount('#app')