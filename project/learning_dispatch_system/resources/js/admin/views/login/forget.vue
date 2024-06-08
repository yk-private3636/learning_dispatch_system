<script setup lang="ts">
import { ref, reactive } from "vue";
import axios from "axios";
import Btn from "../component/Btn.vue";
import Title from "../component/Title.vue";
import Label from "../component/Label.vue";
import AlertLabel from "../component/AlertLabel.vue";
import SuccessAlertLabel from "../component/SuccessAlertLabel.vue";
import InputText from "../component/InputText.vue";
import ErrMsg from "../component/ErrMsg.vue";
import * as button from "../../consts/button.ts";
import * as label from "../../consts/label.ts";
import * as text from "../../consts/text.ts";
import { route } from "ziggy-js";

const email = ref("");

const valid = reactive({
  email: {
    fails: false,
    msg: "",
  },
});
const alertLabel = reactive({
  show: false,
  msg: "",
});
const successAlertLabel = reactive({
  show: false,
  msg: "",
});

const passwordProcedureReset = () => {
  axios.get("/sanctum/csrf-cookie").then(() => {
    axios
      .post(route("admin.procedure.password.reset"), {
        email: email.value,
      })
      .then((response) => {
        successAlertLabel.msg = response.data.msg;
        successAlertLabel.show = true;
      })
      .catch((err) => {
        const errors = err.response.data?.errors;
        alertLabel.show = false;
        successAlertLabel.show = false;
        valid.email.fails = false;

        if (err.response.status === 500) {
          alertLabel.msg = err.response.data.msg;
          alertLabel.show = true;
          return;
        }

        if (errors.email !== undefined && errors.email.length === 1) {
          valid.email.fails = true;
          valid.email.msg = errors.email.shift();
        }
      });
  });
};
</script>

<template>
  <div class="flex min-h-full flex-col justify-center px-6 py-20 lg:px-8">
    <AlertLabel v-show="alertLabel.show" v-model="alertLabel.show">
      {{ alertLabel.msg }}
    </AlertLabel>
    <SuccessAlertLabel
      v-show="successAlertLabel.show"
      v-model="successAlertLabel.show"
    >
      {{ successAlertLabel.msg }}
    </SuccessAlertLabel>
    <div class="text-center mb-5">
      <Title>{{ text.password.forgetTo }}</Title>
    </div>
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
      <div class="my-8">
        <Btn class="flex w-full justify-center" @click="passwordProcedureReset">
          {{ button.passwordReset }}
        </Btn>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
