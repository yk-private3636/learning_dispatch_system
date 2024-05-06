<script setup>
	import { ref, reactive } from 'vue';
	import { useRoute, useRouter } from "vue-router";
	import axios from 'axios'
	import Btn from '../component/Btn.vue'
	import Title from '../component/Title.vue'
	import Label from '../component/Label.vue'
	import InputText from '../component/InputText.vue'
	import AlertLabel from '../component/AlertLabel.vue'
	import SuccessAlertLabel from '../component/SuccessAlertLabel.vue'
	import ErrMsg from '../component/ErrMsg.vue'
	import * as button from '../../consts/button.js'
	import * as label from '../../consts/label.js'
	import * as text from '../../consts/text.js'

	const routeObj = useRoute();
	const router = useRouter();
	const password = ref('');
	const confirmPassword = ref('');
	const alertLabel = reactive({
		show: false,
		msg: ''
	});
	const successAlertLabel = reactive({
		show: false,
		msg: ''
	});
	const valid = reactive({
		password: {
			fails: false,
			msg: ''
		},
		confirmPassword: {
			fails: false,
			msg: ''
		}
	});

	const passwordReset = () => {
		axios.put(route('admin.password.reset'), {
			password: password.value,
			confirmPassword: confirmPassword.value,
			token: routeObj.params.token
		})
		.then(response => {
			successAlertLabel.msg = response.data.msg
			successAlertLabel.show = true
			setTimeout(() => {
  				router.push({name: 'login'})
			}, 2500)
		})
		.catch(err => {
			const errors = err.response.data?.errors;
			valid.password.fails = false;
			valid.confirmPassword.fails = false;
			alertLabel.show = false;

			if(errors.password !== undefined && errors.password.length === 1){	
				valid.password.fails = true;
				valid.password.msg = errors.password.shift();
			}

			if(errors.confirmPassword !== undefined && errors.confirmPassword.length === 1){	
				valid.confirmPassword.fails = true;
				valid.confirmPassword.msg = errors.confirmPassword.shift();
			}

			if(errors.token !== undefined && errors.token.length === 1){	
				alertLabel.show = true
				alertLabel.msg = errors.token.shift()
			}
		})
	}
</script>

<template>
	<div class="flex min-h-full flex-col justify-center px-6 py-20 lg:px-8">
		<div class="text-center mb-5">
			<Title>{{ text.password.reconfigure }}</Title>
		</div>
		<AlertLabel v-show="alertLabel.show" v-model="alertLabel.show">{{ alertLabel.msg }}</AlertLabel>
		<SuccessAlertLabel v-show="successAlertLabel.show" v-model="successAlertLabel.show">{{ successAlertLabel.msg }}</SuccessAlertLabel>
		<div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
			<div>
	        	<Label :label="label.password"></Label>
		        <div class="mt-2">
		        	<InputText v-model="password" name="password" type="password" autocomplete="password" :required="true"></InputText>
		        	<ErrMsg v-if="valid.password.fails">{{ valid.password.msg }}</ErrMsg>
		        </div>
		    </div>
		    <div class="mt-2">
	        	<Label :label="label.confirm_password"></Label>
		        <div class="mt-2">
		        	<InputText v-model="confirmPassword" name="confirm_password" type="password" autocomplete="password" :required="true"></InputText>
		        	<ErrMsg v-if="valid.confirmPassword.fails">{{ valid.confirmPassword.msg }}</ErrMsg>
		        </div>
		    </div>
			<div class="my-8">
				<Btn class="flex w-full justify-center" @click="passwordReset">
					{{ button.passwordReset }}
				</Btn>
			</div>
      	</div>
	</div>
</template>

<style scoped>
	
</style>