<script setup lang="ts">
import { ref, Ref, onMounted, inject, watch } from 'vue';
import axios, { AxiosResponse } from 'axios';
import { route } from 'ziggy-js';
import paginate from 'vuejs-paginate-next';
import * as label from '../../consts/label.ts';
import { UserList, UserListPager } from '../../consts/interface/user.ts';
import { filled } from '../../utils/Str.ts';

const loading: Ref<boolean> = ref(false);
const currentPage: Ref<number> = ref(0);
const lasetPage: Ref<number> = ref(0);
const userList: Ref<UserList[]> = ref([]);

const email = inject<Ref<string>>('email');
const name = inject<Ref<string>>('name');
const usageStatus = inject<Ref<number>>('status');

const props = defineProps<UserListPager>();
const emit = defineEmits(['cooperation']);

onMounted(() => {
  axios
    .get(route('admin.userList.index'))
    .then((response: AxiosResponse<UserListPager>) => {
      const users = response.data.users;
      currentPage.value = users.current_page;
      lasetPage.value = users.last_page;
      userList.value = users.data;
      loading.value = true;
    });
});

watch(
  () => props.users,
  () => {
    if (props.users.current_page !== 0 && props.users.last_page !== 0) {
      userList.value = props.users.data;
      currentPage.value = props.users.current_page;
      lasetPage.value = props.users.last_page;
    }
  }
);

const extract = (pageNum: number) => {
  emit('cooperation', pageNum);
  let reqUrl: string = route('admin.userList.index') + `?page=${pageNum}`;

  if (filled(email?.value)) {
    reqUrl += `&email=${email?.value}`;
  }

  if (filled(name?.value)) {
    reqUrl += `&name=${name?.value}`;
  }

  if (filled(usageStatus?.value)) {
    reqUrl += `&usageStatus=${usageStatus?.value}`;
  }

  axios.get(reqUrl).then((response: AxiosResponse<UserListPager>) => {
    const users = response.data.users;
    currentPage.value = users.current_page;
    lasetPage.value = users.last_page;
    userList.value = users.data;
  });
};
</script>

<template>
  <div v-if="loading" class="overflow-x-auto">
    <table class="bg-white shadow-md rounded my-6">
      <thead class="bg-gray-200">
        <tr>
          <th class="border px-4 py-2">{{ label.id }}</th>
          <th class="border px-4 py-2">{{ label.email }}</th>
          <th class="border px-4 py-2">{{ label.name }}</th>
          <th class="border px-4 py-2">{{ label.usageStatus }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(user, idx) in userList" :key="idx">
          <td class="border px-4 py-2">{{ user.id }}</td>
          <td class="border px-4 py-2">{{ user.email }}</td>
          <td class="border px-4 py-2">{{ user.name }}</td>
          <td class="border px-4 py-2">{{ user.usage_status }}</td>
        </tr>
      </tbody>
    </table>
    <div class="flex justify-center items-center">
      <paginate
        v-model="currentPage"
        :page-count="lasetPage"
        page-range="5"
        :prev-text="'<'"
        :next-text="'>'"
        :container-class="'flex items-center space-x-2'"
        :prev-class="'px-3 py-1 bg-gray-200 rounded cursor-pointer'"
        :next-class="'px-3 py-1 bg-gray-200 rounded cursor-pointer'"
        :page-class="'px-3 py-1 bg-gray-200 rounded cursor-pointer'"
        :active-class="'bg-blue-500 text-white'"
        :click-handler="extract"
      />
    </div>
  </div>
</template>

<style scoped></style>
