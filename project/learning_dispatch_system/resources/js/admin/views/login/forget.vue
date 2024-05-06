<script setup>
	import { ref, reactive } from 'vue'
	import axios from 'axios'
	import Btn from '../component/Btn.vue'
	import Title from '../component/Title.vue'
	import Label from '../component/Label.vue'
	import InputText from '../component/InputText.vue'
	import ErrMsg from '../component/ErrMsg.vue'
	import * as button from '../../consts/button.js'
	import * as label from '../../consts/label.js'
	import * as text from '../../consts/text.js'

	const email = ref('')

	const valid = reactive({
		email: {
			fails: false,
			msg: ''
		}
	});

	const passwordProcedureReset = () => {
		axios.get('/sanctum/csrf-cookie').then(response => {
			axios.post(route('admin.password.procedure.reset'),{
				email: email.value
			})
			.then(response => {

			})
			.catch(err => {
    			const errors = err.response.data?.errors;
				valid.email.fails = false;

				if(errors.email !== undefined && errors.email.length === 1){	
    				valid.email.fails = true;
    				valid.email.msg = errors.email.shift();
    			}
			})
		})

	}
</script>

<template>
	<div class="flex min-h-full flex-col justify-center px-6 py-20 lg:px-8">
		<div class="text-center mb-5">
			<Title>{{ text.password.forgetTo }}</Title>
		</div>
		<div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
			<div>
	        	<Label :label="label.email"></Label>
		        <div class="mt-2">
		        	<InputText v-model="email" name="email" type="email" autocomplete="email" :required="true"></InputText>
		        	<ErrMsg v-if="valid.email.fails">{{ valid.email.msg }}</ErrMsg>
		        </div>
		    </div>
			<div class="my-8">
				<Btn class="flex w-full justify-center" @click="passwordProcedureReset">
					{{ button.passwordReset }}
				</Btn>
			</div>
      	</div>
	</div>
</template>

<style scoped>
	
</style>