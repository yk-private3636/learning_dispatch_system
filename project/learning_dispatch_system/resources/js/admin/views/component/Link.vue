<script setup>
	const props = defineProps({
		to: Object,
	})
</script>

<template>
	<router-link :to="props.to" class="font-semibold text-indigo-600 hover:text-indigo-500 cursor-pointer">
		<slot></slot>
	</router-link>
</template>

<style scoped>
	
</style>