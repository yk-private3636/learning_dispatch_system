<script setup>
	import { Link } from '@inertiajs/vue3';
	import { 
		mdiWidgets,
		mdiLogin,
		mdiLogout,
		mdiAccountPlus 
	} from '@mdi/js'

	const pr = defineProps({
		auth: Object
	})
</script>

<template>
	<v-card class="mx-auto" color="grey-lighten-3" max-width="448">
		<v-layout>
			<v-row v-if="pr.auth !== null">
				<v-app-bar
		        	color="indigo-darken-1"
		      	>
					<v-row class="justify-end"/>
			        <v-btn icon>
	          			<v-icon>{{ mdiWidgets }}</v-icon>
	        		</v-btn>
 					<Link :href="route('logout')" method="get" as="button" type="button">
		        		<v-btn icon>
		          			<v-icon
		          			>{{ mdiLogout }}</v-icon>
		        		</v-btn>
 					</Link>
					<v-card
						class="cursor-pointer"
			            density="compact"
			            :prepend-avatar="pr.auth.profile_picture_pass ? pr.auth.profile_picture_pass : 'https://randomuser.me/api/portraits/women/10.jpg'"
			            :title="pr.auth.user_id"
			            :subtitle="pr.auth.family_name + ' ' + pr.auth.name"
			            variant="text"
			          >
			         </v-card>
		      	</v-app-bar>
			</v-row>
			<v-row v-else>
				<v-app-bar
		        	color="indigo-darken-1"
		      	>
					<v-row class="justify-end"/>
			        <v-btn icon>
	          			<v-icon>{{ mdiWidgets }}</v-icon>
	        		</v-btn>
 					<Link :href="route('general.login')" method="get" as="button" type="button">
		        		<v-btn icon>
		          			<v-icon>{{ mdiLogin }}</v-icon>
		        		</v-btn>
 					</Link>
 					<Link :href="route('user.create')" method="get" as="button" type="button">
		        		<v-btn icon>
		          			<v-icon>{{ mdiAccountPlus }}</v-icon>
		        		</v-btn>
 					</Link>
		      	</v-app-bar>
			</v-row>
    	</v-layout>
    </v-card>

    <v-container>
    	<slot></slot>
    </v-container>
</template>

<style scoped>
	
</style>