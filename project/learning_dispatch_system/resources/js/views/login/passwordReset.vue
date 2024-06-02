<script setup>
	import { reactive, computed } from 'vue';
	import { useForm, usePage } from '@inertiajs/vue3';
	import SuccessSnackbar from '../../component/SuccessSnackbar.vue'
	import Snackbar from '../../component/Snackbar.vue'
	import Title from '../../component/Title.vue'
	import Btn from '../../component/Btn.vue';
	import * as text from '../../consts/text.js'
	import * as label from '../../consts/label.js'
	import * as button from '../../consts/button.js'
	import * as validate from '../../consts/validate.js'
	import { blank } from '../../consts/StrLib.js'
	import BackGround from '../../component/BackGround.vue';

	defineOptions({ layout: [BackGround] })
	
	const props = defineProps({
		token: String
	})

	const form = useForm({
		password: '',
		confirmPassword: ''
	})

	const page = usePage();

	const successAlert = reactive({
		show: false,
		msg: '',
	})

	const errorAlert = reactive({
		show: false,
		msg: ''
	})

	const btnDisabled = computed(() => {
		const disabled = blank(form.password) || blank(form.confirmPassword)
		return disabled
	})

	const submit = () => {
		successAlert.show = false
		errorAlert.show = false

		form.transform((data) => ({
			...data,
			token: props.token
		}))
		.put(route('password.reset'), {
			onSuccess: () => {
				successAlert.show = true
				successAlert.msg = page.props.success.msg
			},
			onError: () => {
				if(blank(page.props.errors.msg)){
					return;
				}

				errorAlert.show = true
				errorAlert.msg = page.props.errors.msg
			}
		})
	}

</script>

<template>
	<Title>{{ text.reconfigure }}</Title>
	<SuccessSnackbar v-if="successAlert.show" v-model="successAlert.show" :text="successAlert.msg"/>
	<Snackbar v-if="errorAlert.show" v-model="errorAlert.show" :text="errorAlert.msg"/>
	<form @submit.prevent="submit">
		<v-container class="mt-5 mb-3">
			<v-card class="mx-auto px-4 py-12" max-width="344">
				<v-text-field 
					v-model="form.password" 
					id="password"
					type="password"
					:label="label.newPassword"
					:rules="[validate.required]"
					:error-messages="form.errors.password ?? ''"
				></v-text-field>
				<br>
				<v-text-field 
					v-model="form.confirmPassword" 
					id="confirm-password"
					type="password"
					:label="label.confirmPassword"
					:rules="[validate.required]"
					:error-messages="form.errors.confirmPassword ?? ''"
				></v-text-field>
				<br>
				<Btn :block="true" :disabled="btnDisabled || form.processing">{{ button.passwordReset }}</Btn>
			</v-card>
		</v-container>
	</form>
</template>

<style>
	
</style>