<script setup>
import { reactive } from "vue";
import { usePage } from "@inertiajs/vue3";
import Header from "./Header.vue";
import SuccessSnackbar from "./SuccessSnackbar.vue";

const page = usePage();

const successAlert = reactive({
  show: page.props.success.msg ? true : false,
  msg: page.props.success.msg,
});

const pr = defineProps({
  auth: { type: Object, default: null },
});
</script>

<template>
  <SuccessSnackbar
    v-if="successAlert.show"
    v-model="successAlert.show"
    :text="successAlert.msg"
  />
  <v-container class="bg-blue-grey-lighten-5 mt-8">
    <Header :auth="pr.auth" />
    <v-sheet class="pa-12" height="auto" rounded>
      <slot />
    </v-sheet>
  </v-container>
</template>

<style scoped></style>
