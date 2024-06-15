<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import Btn from '../component/Btn.vue';
import Label from '../component/Label.vue';
import Link from '../component/Link.vue';
import InputText from '../component/InputText.vue';
import ErrMsg from '../component/ErrMsg.vue';
import AlertLabel from '../component/AlertLabel.vue';
import SuccessLabel from '../component/SuccessAlertLabel.vue';
import { useLoginState } from '../../stores/LoginState.ts';
import * as button from '../../consts/button.ts';
import * as label from '../../consts/label.ts';
import * as text from '../../consts/text.ts';
import { route } from 'ziggy-js';
import { useFlashMsgState } from '../../stores/flashMsgState.ts';

const email = ref('');
const password = ref('');
const alertLabel = reactive({
  show: false,
  msg: '',
});
const successLabel = reactive({
  show: false,
  msg: '',
});

const valid = reactive({
  email: {
    fails: false,
    msg: '',
  },
  password: {
    fails: false,
    msg: '',
  },
});

onMounted(() => {
  if (flashMsgState.type === 'success' && flashMsgState.show) {
    successLabel.show = flashMsgState.show;
    successLabel.msg = flashMsgState.msg;
  }
});

const router = useRouter();
const loginState = useLoginState();
const flashMsgState = useFlashMsgState();

const authentication = () => {
  axios.get('/sanctum/csrf-cookie').then(() => {
    axios
      .post(route('admin.authentication'), {
        email: email.value,
        password: password.value,
      })
      .then(() => {
        loginState.setLogin();
        router.push({ name: 'top' });
      })
      .catch((err) => {
        const statusCode = err.response?.status;
        const errors = err.response.data?.errors;
        const errMsg = err.response.data?.err_msg;
        valid.email.fails = false;
        valid.password.fails = false;
        successLabel.show = false;

        if (statusCode === 401) {
          alertLabel.show = true;
          alertLabel.msg = errMsg;
          return;
        }

        if (statusCode !== 422 || errors === null) {
          alertLabel.show = true;
          alertLabel.msg = errMsg;
          return;
        }

        alertLabel.show = false;

        if (errors.email !== undefined && errors.email.length === 1) {
          valid.email.fails = true;
          valid.email.msg = errors.email.shift();
        }

        if (errors.password !== undefined && errors.password.length === 1) {
          valid.password.fails = true;
          valid.password.msg = errors.password.shift();
        }
      });
  });
};
</script>

<template>
  <div class="flex min-h-full flex-col justify-center px-6 py-20 lg:px-8">
    <SuccessLabel v-show="successLabel.show" v-model="successLabel.show">
      {{ successLabel.msg }}
    </SuccessLabel>
    <AlertLabel v-show="alertLabel.show" v-model="alertLabel.show">
      {{ alertLabel.msg }}
    </AlertLabel>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <div>
        <Label :label="label.email" />
        <div class="mt-2">
          <InputText
            v-model="email"
            name="email"
            type="email"
            autocomplete="email"
            :required="true"
          />
          <ErrMsg v-if="valid.email.fails">
            {{ valid.email.msg }}
          </ErrMsg>
        </div>
      </div>
      <div>
        <div class="flex items-center justify-between mt-2">
          <Label :label="label.password" />
          <div class="text-sm">
            <Link :to="{ name: 'login.forget' }">
              {{ text.password.forget }}
            </Link>
          </div>
        </div>
        <div class="mt-2">
          <InputText
            v-model="password"
            name="password"
            type="password"
            autocomplete="current-password"
            :required="true"
          />
          <ErrMsg v-if="valid.password.fails">
            {{ valid.password.msg }}
          </ErrMsg>
        </div>
      </div>
      <div class="my-8">
        <Btn class="flex w-full justify-center" @click="authentication">
          {{ button.login }}
        </Btn>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
