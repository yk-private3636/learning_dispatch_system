<script setup>
	const props = defineProps({
		href: String,
		text: String
	})
</script>

<template>
	<a :href="props.href" class="font-semibold text-indigo-600 hover:text-indigo-500 cursor-pointer">{{ props.text }}</a>
</template>

<style scoped>
	
</style>