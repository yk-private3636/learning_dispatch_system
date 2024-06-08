<script setup>
const props = defineProps({
  type: { type: String, default: 'submit' },
  block: { type: Boolean, default: false },
});
</script>

<template>
  <v-btn color="indigo-darken-1" :type="props.type" :block="props.block">
    <slot />
  </v-btn>
</template>

<style scoped></style>
