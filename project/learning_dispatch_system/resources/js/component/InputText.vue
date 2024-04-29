<script setup>
	import { ref } from 'vue';

	const props = defineProps({
		model: String,
		id: String,
		type: String,
		label: String,
		placeholder: String,
		class: String,
		disabled: Boolean,
		rules: Array,
		errorMessages: String,
		modelValue: String
	});

	const emit = defineEmits(['update:modelValue']);
	const inputText = (e) => {
		emit('update:modelValue', e.target.value);
	};

</script>

<template>
	<v-text-field 
		:id="id"
		:type="type"
		:label="label"
		:placeholder="placeholder"
		:class="class" 
		:disabled="disabled"
		:rules="rules"
		:error-messages="errorMessages"
		@input="inputText"
	></v-text-field>
</template>

<style scoped>

</style>