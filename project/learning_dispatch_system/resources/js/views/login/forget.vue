<script setup>
import { reactive, computed } from 'vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import SuccessSnackbar from '../../component/SuccessSnackbar.vue';
import Snackbar from '../../component/Snackbar.vue';
import Title from '../../component/Title.vue';
import Btn from '../../component/Btn.vue';
import * as text from '../../consts/text.js';
import * as label from '../../consts/label.js';
import * as button from '../../consts/button.js';
import * as validate from '../../consts/validate.js';
import { blank } from '../../consts/StrLib.js';
import BackGround from '../../component/BackGround.vue';
import { route } from 'ziggy-js';

defineOptions({ layout: [BackGround] });

const form = useForm({
  email: '',
});

const page = usePage();

const successAlert = reactive({
  show: false,
  msg: '',
});

const errorAlert = reactive({
  show: false,
  msg: '',
});

const btnDisabled = computed(() => {
  const disabled = blank(form.email);
  return disabled;
});

const submit = () => {
  successAlert.show = false;
  errorAlert.show = false;

  form.post(route('procedure.password.reset'), {
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
  <Title>{{ text.forgetTo }}</Title>
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
  <form @submit.prevent="submit">
    <v-container class="mt-5 mb-3">
      <v-card class="mx-auto px-4 py-12" max-width="344">
        <v-text-field
          id="email"
          v-model="form.email"
          type="email"
          :label="label.email"
          :rules="[validate.required]"
          :error-messages="form.errors.email ?? ''"
        />
        <br />
        <Btn :block="true" :disabled="btnDisabled || form.processing">
          {{ button.send }}
        </Btn>
      </v-card>
    </v-container>
  </form>
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
      <Link :href="route('user.create')" method="get" as="button" type="button">
        {{ text.accountNotHave }}
      </Link>
    </v-row>
  </v-container>
</template>

<style scoped></style>
