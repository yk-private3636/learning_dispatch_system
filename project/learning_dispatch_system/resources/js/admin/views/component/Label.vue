<script setup lang="ts">
const props = defineProps({
  label: { type: String, default: "" },
  for: { type: String, default: "" },
});
</script>

<template>
  <label
    for="{{ props.for }}"
    class="block text-sm font-medium leading-6 text-gray-900"
  >
    {{ props.label }}
  </label>
</template>

<style scoped></style>
