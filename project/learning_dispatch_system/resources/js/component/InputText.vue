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
		errorMessages: String
	});

	const input = ref(props.model);
	const emit = defineEmits(['setInput']);
	const inputText = (id) => {
		emit('setInput', input.value, id);
	};

</script>

<template>
	<v-text-field 
		v-model="input"
		:id="id"
		:type="type"
		:label="label"
		:placeholder="placeholder"
		:class="class" 
		:disabled="disabled"
		:rules="rules"
		:error-messages="errorMessages"
		@input="inputText(id)"
	></v-text-field>
</template>

<style scoped>

</style>