<script setup lang="ts">
//import { onMounted } from 'vue'

const props = defineProps({
  type: { type: String, default: 'submit' },
});
</script>

<template>
  <button
    :type="props.type === 'submit' ? 'submit' : 'button'"
    class="rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
  >
    <slot />
  </button>
</template>

<style scoped></style>
