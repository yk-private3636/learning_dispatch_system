<script setup>
import { reactive } from "vue";
import { usePage } from "@inertiajs/vue3";
import SuccessSnackbar from "./SuccessSnackbar.vue";

const page = usePage();

const successAlert = reactive({
  show: page.props.success.msg ? true : false,
  msg: page.props.success.msg,
});
</script>

<template>
  <SuccessSnackbar
    v-if="successAlert.show"
    v-model="successAlert.show"
    :text="successAlert.msg"
  />
  <v-container class="bg-blue-grey-lighten-5">
    <v-sheet class="pa-12" height="auto" rounded>
      <slot />
    </v-sheet>
  </v-container>
</template>

<style scoped></style>
