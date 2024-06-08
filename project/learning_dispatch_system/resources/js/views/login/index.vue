<script setup>
import { reactive, computed } from 'vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import { mdiGithub } from '@mdi/js';
import Title from '../../component/Title.vue';
import Btn from '../../component/Btn.vue';
import Snackbar from '../../component/Snackbar.vue';
import * as label from '../../consts/label.js';
import * as button from '../../consts/button.js';
import * as text from '../../consts/text.js';
import * as valid from '../../consts/validate.js';
import { blank } from '../../consts/StrLib.js';
import BackGround from '../../component/BackGround.vue';
import { route } from 'ziggy-js';

defineOptions({ layout: [BackGround] });

const form = useForm({
  user_id: null,
  password: null,
});

const page = usePage();

const errorAlert = reactive({
  show: false,
  msg: '',
});

const btnDisabled = computed(() => {
  const disabled = blank(form.user_id) || blank(form.password);
  return disabled;
});

const submit = () => {
  form.post(route('general.auth'), {
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
  <Snackbar
    v-if="errorAlert.show"
    v-model="errorAlert.show"
    :text="errorAlert.msg"
  />
  <Title>{{ text.title }}</Title>
  <form @submit.prevent="submit">
    <v-container class="mt-5 mb-3">
      <v-card class="mx-auto px-4 py-12" max-width="344">
        <v-text-field
          id="user_id"
          v-model="form.user_id"
          type="text"
          :label="label.user_id"
          :rules="[valid.required]"
          :error-messages="form.errors.user_id ?? null"
          autocomplete="new-password"
        />
        <v-text-field
          id="password"
          v-model="form.password"
          type="password"
          :label="label.password"
          :rules="[valid.required]"
          :error-messages="form.errors.password ?? null"
          autocomplete="new-password"
        />
        <br />
        <Btn
          type="submit"
          :block="true"
          :disabled="btnDisabled || form.processing"
        >
          {{ button.login }}
        </Btn>
      </v-card>
    </v-container>
    <v-container>
      <v-row justify="center">
        <v-btn
          class="text-none"
          max-width="344"
          min-width="344"
          :prepend-icon="mdiGithub"
          :href="route('general.login.oAuth', 'github')"
        >
          {{ button.githubLogin }}
        </v-btn>
      </v-row>
    </v-container>
    <v-container class="mt-4 mb-5">
      <v-row no-gutters justify="center">
        <Link
          :href="route('login.forget.show')"
          method="get"
          as="button"
          type="button"
        >
          {{ text.passForgetGuide }}
        </Link>
        <div class="mx-3">/</div>
        <Link
          :href="route('user.create')"
          method="get"
          as="button"
          type="button"
        >
          {{ text.accountNotHave }}
        </Link>
      </v-row>
    </v-container>
  </form>
</template>

<style scoped></style>
