<script setup>
	import { reactive, computed } from 'vue';
	import { useForm, usePage, Link } from '@inertiajs/vue3';
	import Btn from '../../component/Btn.vue';
	import SuccessSnackbar from '../../component/SuccessSnackbar.vue';
	import Snackbar from '../../component/Snackbar.vue';
	import * as label from '../../consts/label.js';
	import * as button from '../../consts/button.js';
	import * as message from '../../consts/message.js';
	import * as text from '../../consts/text.js';
	import * as valid from '../../consts/validate.js';
	import { blank } from '../../consts/StrLib.js';

	const form = useForm({
		user_id: null,
		password: null
	});

	const page = usePage();

	const successAlert = reactive({
		show: page.props.success.msg ? true : false,
		msg: page.props.success.msg
	})

	const errorAlert = reactive({
		show: false,
		msg: ''
	})

	const btnDisabled = computed(() => {
		const disabled = blank(form.user_id) || blank(form.password)
		return disabled;
	})

	const submit = () => {
		form.post(route('general.auth'), {
			onSuccess: () => {
				successAlert.show = true
				successAlert.msg = page.props.success.msg
			},
			onError: () => {
				if(blank(page.props.errors.msg)){
					return
				}

				errorAlert.show = true
				errorAlert.msg = page.props.errors.msg
			}
		})
	}
</script>

<template>
	<SuccessSnackbar v-if="successAlert.show" v-model="successAlert.show" :text="successAlert.msg"></SuccessSnackbar>
	<Snackbar v-if="errorAlert.show" v-model="errorAlert.show" :text="errorAlert.msg"></Snackbar>
	<form @submit.prevent="submit">
		<v-sheet class="bg-blue-grey-lighten-5 pa-12" height="100vh" rounded>
	 		<v-container class="mt-5 mb-5">
				<v-card class="py-3">
					<v-card-title class="text-center">{{ text.title }}</v-card-title>
				</v-card>
			</v-container>
	        
	 		<v-container class="mt-5 mb-5">
				<v-card class="mx-auto px-6 py-12" max-width="344">
					<v-text-field
						v-model="form.user_id"
						id="user_id"
						type="text"
						:label="label.user_id"
						:rules="[valid.required]"
						:error-messages="form.errors.user_id ?? null"
					></v-text-field>
					<v-text-field
						v-model="form.password" 
						id="password"
						type="password"
						:label="label.password"
						:rules="[valid.required]"
						:error-messages="form.errors.password ?? null"
					></v-text-field>
					<br>
					<Btn
						type="submit"
						:block="true"
						:disabled="btnDisabled || form.processing"
					>
						{{ button.login }}
					</Btn>
				</v-card>
			</v-container>
	 		<v-container class="mt-5 mb-5">
	 			<v-row no-gutters justify="center">
	 				<Link :href="route('login.forget.show')" method="get" as="button" type="button">{{ text.passForgetGuide }}</Link>
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