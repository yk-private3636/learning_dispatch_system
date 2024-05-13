<script setup>
	import { ref, reactive, computed } from 'vue';
	import { useForm, usePage, router, Link } from '@inertiajs/vue3';
	import axios from 'axios'
	import BackGround from '../../component/BackGround.vue'
	import Title from '../../component/Title.vue'
	import Btn from '../../component/Btn.vue'
	import SuccessSnackbar from '../../component/SuccessSnackbar.vue';
	import Snackbar from '../../component/Snackbar.vue';
	import * as text from '../../consts/text.js'
	import * as label from '../../consts/label.js'
	import * as button from '../../consts/button.js'
	import * as valid from '../../consts/validate.js'
	import * as message from '../../consts/message.js'
	import { designationFilled } from '../../consts/ObjLib.js'

	const form = useForm({
		email: '',
		user_id: '',
		password: '',
		family_name: '',
		name: '',
	})

	const page = usePage()

	const autoBtn = ref(false)
	
	const successAlert = reactive({
		show: false,
		msg: ''
	})

	const errorAlert = reactive({
		show: false,
		msg: ''
	})

	const btnDisabled = computed(() => {
		const disabled = designationFilled(form, [
			'email',
			'user_id',
			'password',
			'family_name',
			'name'
		])

		return !disabled
	})

	const userIdRef = () => {
		autoBtn.value = true
		router.visit(route('general.user.id.create'), {
			method: 'get',
			only: ['user_id'],
			preserveScroll: true,
			preserveState: true,
			onSuccess: (res) => {
				form.user_id = res.props.user_id
			},
    		onError: (err) => {
    			errorAlert.show = false
    			errorAlert.msg = message.err.system
    		},
    		onFinish: () => {
    			autoBtn.value = false
    		}
		})
	}

	const submit = () => {
		form.post(route('user.store'), {
			onSuccess: () => {

			},
			onError: () => {

			}
		})
	}

</script>

<template>
	<BackGround>
		<SuccessSnackbar v-if="successAlert.show" v-model="successAlert.show" :text="successAlert.msg"></SuccessSnackbar>
		<Snackbar v-if="errorAlert.show" v-model="errorAlert.show" :text="errorAlert.msg"></Snackbar>
		<Title>{{ text.membersipRegist }}</Title>
		<form @submit.prevent="submit">
	 		<v-container class="mt-5 mb-5">
				<v-card class="mx-auto px-6 py-12" max-width="344">
					<v-text-field
						v-model="form.email"
						id="email"
						type="email"
						:label="label.email"
						:rules="[valid.required]"
						:error-messages="form.errors.email ?? null"
						autocomplete="new-password"
					></v-text-field>
					<v-text-field
						v-model="form.user_id" 
						id="user_id"
						type="text"
						:label="label.user_id"
						:rules="[valid.required]"
						:error-messages="form.errors.user_id ?? null"
						autocomplete="new-password"
					>
						<template v-slot:append-inner>
							<Btn @click="userIdRef" :disabled="autoBtn">{{ button.auto }}</Btn>
						</template>
					</v-text-field>
					<v-text-field
						v-model="form.password" 
						id="password"
						type="password"
						:label="label.password"
						:rules="[valid.required]"
						:error-messages="form.errors.password ?? null"
						autocomplete="new-password"
					></v-text-field>
					<v-text-field
						v-model="form.family_name" 
						id="family_name"
						type="text"
						:label="label.familyName"
						:rules="[valid.required]"
						:error-messages="form.errors.family_name ?? null"
					></v-text-field>
					<v-text-field
						v-model="form.name"
						id="name"
						type="text"
						:label="label.name"
						:rules="[valid.required]"
						:error-messages="form.errors.name ?? null"
					></v-text-field>
					<br>
					<Btn
						type="submit"
						:block="true"
						:disabled="btnDisabled || form.processing"
					>
						{{ button.create }}
					</Btn>
				</v-card>
			</v-container>
	 		<v-container class="mt-5 mb-5">
	 			<v-row no-gutters justify="center">
	 				<Link :href="route('general.login')" method="get" as="button" type="button">{{ text.loginViewTo }}</Link>
	 				<div class="mx-3">
	 					/
	 				</div>
	 				<Link :href="route('login.forget.show')" method="get" as="button" type="button">{{ text.passForgetGuide }}</Link>
	 			</v-row>
	 		</v-container>
		</form>
	</BackGround>
</template>

<style scoped>
	
</style>