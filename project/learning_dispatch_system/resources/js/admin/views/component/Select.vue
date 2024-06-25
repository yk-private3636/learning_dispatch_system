<script setup lang="ts">
import { UsageStatuses } from '../../consts/interface/select.ts';
const props = defineProps<UsageStatuses>();
const emits = defineEmits(['update:modelValue']);

const onChange = (e: Event) => {
  emits('update:modelValue', (e.target as HTMLInputElement).value);
};
</script>

<template>
  <select
    id=""
    class="block w-full border border-gray-300 rounded h-9"
    @change="onChange"
  >
    <option
      v-for="(status, idx) in props.statuses"
      :key="idx"
      :value="status.value"
    >
      {{ status.text }}
    </option>
  </select>
</template>

<style scoped></style>
