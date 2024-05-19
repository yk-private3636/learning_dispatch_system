<script setup>
	import { ref, computed } from 'vue'

	const props = defineProps({
		id: String,
		name: String,
		type: String,
		autocomplete: String,
		required: Boolean,
		modelValue: String
	})

	const emits = defineEmits('update:modelValue')

	// const text = computed({
  	// 	get: () => props.modelValue,
  	// 	set: (value) => { // 値に変更があると呼ばれるsetter
    // 		emit('update:modelValue', value);
  	// 	},
	// });

	const onInputText = (e) =>{
		emits('update:modelValue', e.target.value)
	} 

	// defineExpose({
	//   [props.name]: input.value,
	//   test: 'hosono'
	// });
</script>

<template>
	<input v-if="props.required" :id="props.id || props.name" :name="props.name" :type="props.type" :autocomplete="props.autocomplete" required class="block w-full rounded-md border-0 px-1.5 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" @input="onInputText">
	<input v-else v-model="test" :id="props.id || props.name" :name="props.name" :type="props.type" :autocomplete="props.autocomplete" class="block w-full rounded-md border-0 px-1.5 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" @input="onInputText">

</template>

<style scoped>
	
</style>