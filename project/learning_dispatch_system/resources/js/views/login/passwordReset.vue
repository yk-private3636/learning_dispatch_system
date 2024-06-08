<script setup>
import { reactive, computed } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import SuccessSnackbar from "../../component/SuccessSnackbar.vue";
import Snackbar from "../../component/Snackbar.vue";
import Title from "../../component/Title.vue";
import Btn from "../../component/Btn.vue";
import * as text from "../../consts/text.js";
import * as label from "../../consts/label.js";
import * as button from "../../consts/button.js";
import * as validate from "../../consts/validate.js";
import { blank } from "../../consts/StrLib.js";
import BackGround from "../../component/BackGround.vue";
import { route } from "ziggy-js";

defineOptions({ layout: [BackGround] });

const props = defineProps({
  token: { type: String, default: "" },
});

const form = useForm({
  password: "",
  confirmPassword: "",
});

const page = usePage();

const successAlert = reactive({
  show: false,
  msg: "",
});

const errorAlert = reactive({
  show: false,
  msg: "",
});

const btnDisabled = computed(() => {
  const disabled = blank(form.password) || blank(form.confirmPassword);
  return disabled;
});

const submit = () => {
  successAlert.show = false;
  errorAlert.show = false;

  form
    .transform((data) => ({
      ...data,
      token: props.token,
    }))
    .put(route("password.reset"), {
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
  <Title>{{ text.reconfigure }}</Title>
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
          id="password"
          v-model="form.password"
          type="password"
          :label="label.newPassword"
          :rules="[validate.required]"
          :error-messages="form.errors.password ?? ''"
        />
        <br />
        <v-text-field
          id="confirm-password"
          v-model="form.confirmPassword"
          type="password"
          :label="label.confirmPassword"
          :rules="[validate.required]"
          :error-messages="form.errors.confirmPassword ?? ''"
        />
        <br />
        <Btn :block="true" :disabled="btnDisabled || form.processing">
          {{ button.passwordReset }}
        </Btn>
      </v-card>
    </v-container>
  </form>
</template>

<style></style>
