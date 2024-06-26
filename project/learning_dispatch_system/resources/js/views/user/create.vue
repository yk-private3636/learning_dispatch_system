<script setup>
import { ref, reactive, computed } from 'vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import { mdiEye, mdiEyeOff } from '@mdi/js';
import axios from 'axios';
import Title from '../../component/Title.vue';
import Btn from '../../component/Btn.vue';
import SuccessSnackbar from '../../component/SuccessSnackbar.vue';
import Snackbar from '../../component/Snackbar.vue';
import * as text from '../../consts/text.js';
import * as label from '../../consts/label.js';
import * as button from '../../consts/button.js';
import * as valid from '../../consts/validate.js';
import * as message from '../../consts/message.js';
import { blank } from '../../consts/StrLib.js';
import { designationFilled } from '../../consts/ObjLib.js';
import BackGround from '../../component/BackGround.vue';
import { route } from 'ziggy-js';

defineOptions({ layout: [BackGround] });

const form = useForm({
  email: '',
  user_id: '',
  password: '',
  family_name: '',
  name: '',
});

const page = usePage();

const control = ref(false);
const show = ref(false);

const successAlert = reactive({
  show: false,
  msg: '',
});

const errorAlert = reactive({
  show: false,
  msg: '',
});

const btnDisabled = computed(() => {
  const disabled = designationFilled(form, [
    'email',
    'user_id',
    'password',
    'family_name',
    'name',
  ]);

  return !disabled;
});

const userIdRef = () => {
  control.value = true;
  axios
    .get(route('general.user.id.create'))
    .then((res) => {
      form.user_id = res.data.user_id;
    })
    .catch(() => {
      errorAlert.show = false;
      errorAlert.msg = message.err.system;
    });

  control.value = false;

  // router.visit(route('general.user.id.create'), {
  // 	method: 'get',
  // 	only: ['user_id'],
  // 	preserveScroll: true,
  // 	preserveState: true,
  // 	onSuccess: (res) => {
  // 		form.user_id = res.props.user_id
  // 	},
  // 	onError: (err) => {
  // 		errorAlert.show = false
  // 		errorAlert.msg = message.err.system
  // 	},
  // 	onFinish: () => {
  // 		autoBtn.value = false
  // 	}
  // })
};

const submit = () => {
  successAlert.show = false;
  errorAlert.show = false;

  form.post(route('user.store'), {
    onSuccess: () => {
      successAlert.show = true;
      successAlert.msg = page.props.success.msg;
    },
    onError: () => {
      if (blank(page.props.errors.msg)) {
        return;
      }

      errorAlert.show = true;
      errorAlert.msg = page.props.errors.msg;
    },
  });
};
</script>

<template>
  <SuccessSnackbar
    v-if="successAlert.show"
    v-model="successAlert.show"
    :text="successAlert.msg"
  />
  <Snackbar
    v-if="errorAlert.show"
    v-model="errorAlert.show"
    :text="errorAlert.msg"
  />
  <Title>{{ text.membersipRegist }}</Title>
  <form @submit.prevent="submit">
    <v-container class="mt-5 mb-3">
      <v-card class="mx-auto px-6 py-12" max-width="344">
        <v-text-field
          id="email"
          v-model="form.email"
          type="email"
          :label="label.email"
          maxlength="255"
          :rules="[valid.required]"
          :error-messages="form.errors.email ?? null"
        />
        <v-text-field
          id="user_id"
          v-model="form.user_id"
          type="text"
          :label="label.user_id"
          autocomplete="new-password"
          :disabled="control"
          maxlength="18"
          :rules="[valid.required]"
          :error-messages="form.errors.user_id ?? null"
        >
          <template #append-inner>
            <Btn type="button" :disabled="control" @click="userIdRef">
              {{ button.auto }}
            </Btn>
          </template>
        </v-text-field>
        <v-text-field
          id="password"
          v-model="form.password"
          :type="show ? 'text' : 'password'"
          :label="label.password"
          :rules="[valid.required]"
          :error-messages="form.errors.password ?? null"
          autocomplete="new-password"
          :append-inner-icon="show ? mdiEyeOff : mdiEye"
          @click:append-inner="show = !show"
        />
        <v-text-field
          id="family_name"
          v-model="form.family_name"
          type="text"
          :label="label.familyName"
          maxlength="30"
          :rules="[valid.required]"
          :error-messages="form.errors.family_name ?? null"
        />
        <v-text-field
          id="name"
          v-model="form.name"
          type="text"
          :label="label.name"
          maxlength="30"
          :rules="[valid.required]"
          :error-messages="form.errors.name ?? null"
        />
        <br />
        <Btn
          type="submit"
          :block="true"
          :disabled="btnDisabled || form.processing"
        >
          {{ button.create }}
        </Btn>
      </v-card>
    </v-container>
    <v-container class="mt-4 mb-5">
      <v-row no-gutters justify="center">
        <Link
          :href="route('general.login')"
          method="get"
          as="button"
          type="button"
        >
          {{ text.loginViewTo }}
        </Link>
        <div class="mx-3">/</div>
        <Link
          :href="route('login.forget.show')"
          method="get"
          as="button"
          type="button"
        >
          {{ text.passForgetGuide }}
        </Link>
      </v-row>
    </v-container>
  </form>
</template>

<style scoped></style>
