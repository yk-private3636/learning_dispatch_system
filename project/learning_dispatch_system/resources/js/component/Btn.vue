<script setup>
	const props = defineProps({
		type: String,
		block: Boolean

	});	
</script>

<template>
	<v-btn
		color="indigo-darken-1"
		:type="type"
		:block="block"
	>
		<slot></slot>
	</v-btn>
</template>

<style scoped>
	
</style>