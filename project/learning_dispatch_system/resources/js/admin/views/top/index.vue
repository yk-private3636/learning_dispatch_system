<script setup lang="ts">
import { useFlashMsgState } from '../../stores/flashMsgState.ts';
import AlertLabel from '../component/AlertLabel.vue';

const flashMsgState = useFlashMsgState();
</script>

<template>
  <div class="flex items-center justify-center ml-5 pl-5">
    <AlertLabel
      v-if="flashMsgState.type === 'error' && flashMsgState.show"
      v-model="flashMsgState.show"
    >
      {{ flashMsgState.msg }}
    </AlertLabel>
  </div>
</template>

<style scoped></style>
