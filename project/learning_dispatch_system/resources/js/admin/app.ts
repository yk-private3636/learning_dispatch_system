import { createApp } from 'vue';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import App from './App.vue';
import router from './router/index.ts';
import '../../css/app.css';
import { useLoginState } from './stores/LoginState.ts';
import { authGuard } from './guards/authGuard.ts';
import { useFlashMsgState } from './stores/flashMsgState.ts';
import { err } from './consts/message.ts';

const app = createApp(App);
const pinia = createPinia();

app.use(router);
app.use(pinia);
pinia.use(piniaPluginPersistedstate);
authGuard(router);

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

// window.addEventListener("error", (event: ErrorEvent) => {
//   console.log("エラーハンドラでエラーをキャッチ");
//   console.log(event.error)

//   // エラー画面に遷移
//   router.push("/error");
// })

window.addEventListener('unhandledrejection', (event) => {
  const statusCode = event.reason?.response?.status;
  const loginState = useLoginState();
  const flashMsgState = useFlashMsgState();

  if (statusCode === 401) {
    loginState.setLogout();
    router.push({ name: 'login' });
    return;
  }

  if (statusCode === 500) {
    flashMsgState.setShowMsg(err.system, 'error');
    router.push({ name: 'top' });
  }
});

app.mount('#app');
