<script setup>
	import { ref } from 'vue';
	import { useForm, Link } from '@inertiajs/vue3';
	import InputText from '../../component/InputText.vue';
	import Btn from '../../component/Btn.vue';
	import * as label from '../../consts/label.js';
	import * as button from '../../consts/button.js';
	import * as message from '../../consts/message.js';
	import * as text from '../../consts/text.js';

	// const pr = defineProps({
	// 	errors: Object,
	// });

	const btnDisabled = ref(false);
	const form = useForm({
		user_id: null,
		password: null
	});

	const required = (input) => {
		if(!!input === false){
			btnDisabled.value = true;
			return message.valid.required;
		}

		if((form.user_id && form.password)?.length >= 1){
			btnDisabled.value = false;
			return;
		}
	}

	const setInput = (input, id) => {
    	switch (id) {
    		case 'user_id':
    			form.user_id = input;
    			break;
    		case 'password': 
    			form.password = input
    			break;
    	}
	};

	const submit = () => {
		form.post(route('generalUserAuth'), {
			user_id: form.user_id,
			password: form.password
		}
	)}

</script>

<template>
	<div v-if="form.hasErrors && form.errors.auth">
		<v-snackbar
			v-model="form.hasErrors"
			:text="form.errors.auth"
			timeout="2000"
			location="top"
		>
			<template v-slot:actions>
	        	<v-btn
		          	color="pink"
		          	variant="text"
		          	@click="form.hasErrors = false"
	        	>
	          	×
	        	</v-btn>
	        </template>
		</v-snackbar>
	</div>
	<form @submit.prevent="submit">
		<v-sheet class="bg-blue-grey-lighten-5 pa-12" height="100vh" rounded>
	 		<v-container class="mt-5 mb-5">
                <v-card class="py-3">
                  <v-card-title class="text-center">{{ text.title }}</v-card-title>
                </v-card>
          	</v-container>
	        
	 		<v-container class="mt-5 mb-5">
				<v-card class="mx-auto px-6 py-12" max-width="344">
					<InputText
						:model="form.user_id"
						id="user_id"
						type="text"
						:label="label.user_id"
						:rules="[required]"
						:error-messages="form.errors.user_id ?? null"
						@setInput="setInput"
					></InputText>
					<InputText
						:model="form.password" 
						id="password"
						type="password"
						:label="label.password"
						:rules="[required]"
						:error-messages="form.errors.password ?? null"
						@setInput="setInput"
					></InputText>
					<br>
					<Btn
						color="indigo-darken-1"
						type="submit"
						:block="true"
						:disabled="btnDisabled"
					>
						{{ button.login }}
					</Btn>
				</v-card>
			</v-container>
	 		<v-container class="mt-5 mb-5">
	 			<v-row no-gutters justify="center">
	 				<Link href="/test" method="get" as="button" type="button">{{ text.passForgetGuide }}</Link>
	 				<div class="mx-3">
	 					/
	 				</div>
	 				<Link href="/test2" method="get" as="button" type="button">{{ text.accountNotHave }}</Link> 
	 			</v-row>
	 		</v-container>
		</v-sheet>
	</form>
</template>

<style scoped>
	
</style>