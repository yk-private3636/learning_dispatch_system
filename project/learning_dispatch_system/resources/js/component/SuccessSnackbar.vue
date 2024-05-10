<script setup>
	const props = defineProps({
		text: String,
		modelValue: Boolean
	})

	const emits = defineEmits('update:modelValue');

	const erase = () => {
		emits('update:modelValue', false)
	}

	setTimeout(() => {
		emits('update:modelValue', false)
	}, 2500)
</script>

<template>
	<v-snackbar
		v-model="props.modelValue"
		:text="props.text"
		color="green-lighten-5"
		location="top"
	>
		<template v-slot:actions>
			<v-btn
				color="pink"
				variant="text"
				@click="erase"
			>
				×
			</v-btn>
		</template>
	</v-snackbar>
</template>

<style scoped>
	
</style>