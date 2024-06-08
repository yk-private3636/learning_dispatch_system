<script setup lang="ts">
const props = defineProps({
  to: { type: Object, default: null },
});
</script>

<template>
  <router-link
    :to="props.to"
    class="font-semibold text-indigo-600 hover:text-indigo-500 cursor-pointer"
  >
    <slot />
  </router-link>
</template>

<style scoped></style>
