<script setup lang="ts">
import { ref, Ref, reactive, onMounted, provide } from 'vue';
import { useRouter, Router } from 'vue-router';
import axios, { AxiosResponse, AxiosError } from 'axios';
import AdminUserList from '../component/AdminUserList.vue';
import ErrMsg from '../component/ErrMsg.vue';
import InputText from '../component/InputText.vue';
import Label from '../component/Label.vue';
import Select from '../component/Select.vue';
import * as label from '../../consts/label.ts';
import { UsageStatus } from '../../consts/interface/select.ts';
import { UserSearch } from '../../consts/interface/validResponse.ts';
import { err } from '../../consts/message.ts';
import { useFlashMsgState } from '../../stores/flashMsgState.ts';
import { useValidState } from '../../stores/validState.ts';
import { filled } from '../../utils/Str.ts';
import { UserListPager } from '../../consts/interface/user.ts';
import { route } from 'ziggy-js';

const statuses: Ref<UsageStatus[]> = ref([]);
const router: Router = useRouter();
const flashMsgState = useFlashMsgState();
const validState = useValidState();
const email: Ref<string> = ref('');
const name: Ref<string> = ref('');
const usageStatus: Ref<number | null> = ref(null);
const pageNum: Ref<number> = ref(1);
const pager = reactive<UserListPager>({
  users: {
    current_page: 0,
    last_page: 0,
    data: [],
  },
});

onMounted(() => {
  axios
    .get(route('admin.partsData.usageStatus'))
    .then((response: AxiosResponse<UsageStatus[]>) => {
      statuses.value = response.data;
    });
});

const search = () => {
  let reqUrl: string = route('admin.userList.index') + `?page=${pageNum.value}`;

  if (filled(email?.value)) {
    reqUrl += `&email=${email?.value}`;
  }

  if (filled(name?.value)) {
    reqUrl += `&name=${name?.value}`;
  }

  if (filled(usageStatus?.value)) {
    reqUrl += `&usageStatus=${usageStatus?.value}`;
  }

  validState.init();
  axios
    .get(reqUrl)
    .then((response: AxiosResponse<UserListPager>) => {
      pager.users = response.data.users;
    })
    .catch((errors: AxiosError<UserSearch>) => {
      const statusCode: number | undefined = errors.response?.status;

      if (statusCode === 401) return;

      if (statusCode !== 422) {
        flashMsgState.setShowMsg(err.system, 'error');
        router.push({ name: 'top' });
      }

      const validErros: { [key: string]: string[] } | undefined =
        errors.response?.data.errors;

      for (const key in validErros) {
        validState.setValid(key, {
          fails: true,
          msg: validErros[key].shift() as string,
        });
      }
    });
};

const setPageNum = (page: number) => {
  pageNum.value = page;
};

provide<Ref<string>>('email', email);
provide<Ref<string>>('name', name);
provide<Ref<number | null>>('status', usageStatus);
</script>

<template>
  <div class="flex flex-col items-center">
    <div class="flex justify-between w-full max-w-4xl mt-4">
      <div class="flex flex-col items-center w-1/3 px-2">
        <Label :label="label.email" />
        <InputText v-model="email" @input="search" />
        <ErrMsg v-if="validState.validate.email?.fails">
          {{ validState.validate.email.msg }}
        </ErrMsg>
      </div>
      <div class="flex flex-col items-center w-1/3 px-2">
        <Label :label="label.name" />
        <InputText v-model="name" @input="search" />
        <ErrMsg v-if="validState.validate.name?.fails">
          {{ validState.validate.name.msg }}
        </ErrMsg>
      </div>
      <div class="flex flex-col items-center w-1/3 px-2">
        <Label :label="label.usageStatus" />
        <Select v-model="usageStatus" :statuses="statuses" @change="search" />
        <ErrMsg v-if="validState.validate.usageStatus?.fails">
          {{ validState.validate.usageStatus.msg }}
        </ErrMsg>
      </div>
    </div>
  </div>
  <div class="flex items-center justify-center ml-5 pl-5">
    <AdminUserList :users="pager.users" @cooperation="setPageNum" />
  </div>
</template>

<style scoped></style>
