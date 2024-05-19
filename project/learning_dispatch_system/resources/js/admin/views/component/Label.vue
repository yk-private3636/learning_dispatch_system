<script setup>
	const props = defineProps({
		label: String,
		for: String
	})
</script>

<template>
	<label for="{{ props.for }}" class="block text-sm font-medium leading-6 text-gray-900">{{ props.label }}</label>
</template>

<style scoped>
	
</style>