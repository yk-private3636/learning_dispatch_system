<script setup lang="ts">
const props = defineProps({
  id: { type: String, default: "" },
  name: { type: String, default: "" },
  type: { type: String, default: "" },
  autocomplete: { type: String, default: "" },
  required: { type: Boolean, default: false },
  modelValue: { type: String, default: "" },
});

const emits = defineEmits(["update:modelValue"]);

// const text = computed({
// 	get: () => props.modelValue,
// 	set: (value) => { // 値に変更があると呼ばれるsetter
// 		emit('update:modelValue', value);
// 	},
// });

const onInputText = (e: Event) => {
  emits("update:modelValue", (e.target as HTMLInputElement).value);
};

// defineExpose({
//   [props.name]: input.value,
//   test: 'hosono'
// });
</script>

<template>
  <input
    v-if="props.required"
    :id="props.id || props.name"
    :name="props.name"
    :type="props.type"
    :autocomplete="props.autocomplete"
    required
    class="block w-full rounded-md border-0 px-1.5 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
    @input="onInputText"
  />
  <input
    v-else
    :id="props.id || props.name"
    :name="props.name"
    :type="props.type"
    :autocomplete="props.autocomplete"
    class="block w-full rounded-md border-0 px-1.5 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
    @input="onInputText"
  />
</template>

<style scoped></style>
