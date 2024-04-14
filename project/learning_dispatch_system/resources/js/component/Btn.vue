<script setup>
	const props = defineProps({
		color: String,
		type: String,
		block: Boolean

	});	
</script>

<template>
	<v-btn
		:color="color"
		:type="type"
		:block="block"
	>
		<slot></slot>
	</v-btn>
</template>

<style scoped>
	
</style>