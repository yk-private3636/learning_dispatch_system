<script setup lang="ts">
// import { RouterLink, RouterView } from 'vue-router'
import { useLoginState } from './stores/LoginState.ts';
import Layout from './views/component/Layout.vue';
import { RouterView } from 'vue-router';

const loginState = useLoginState();
</script>

<template>
  <Layout v-if="loginState.login" />
  <div class="flex-1 p-4">
    <RouterView />
  </div>
</template>

<style scoped></style>
