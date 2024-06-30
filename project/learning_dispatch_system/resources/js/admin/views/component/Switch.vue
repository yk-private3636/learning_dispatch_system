<script setup lang="ts">
import { ref, Ref, watch } from 'vue';
import { UserEnumArray } from '../../consts/type/elementArr.ts';

const pr = defineProps<{ userEnumsText: UserEnumArray<string> }>();
const em = defineEmits<{ contentExchange: [idx: number] }>();
const selectText: Ref<string> = ref(pr.userEnumsText[0]);
const mvClass: Ref<string> = ref('letf-2');

watch(
  () => pr.userEnumsText,
  () => {
    selectText.value = pr.userEnumsText[0];
    mvClass.value = 'left-2';
  }
);

const tabClick = (text: string, idx: number) => {
  selectText.value = text;
  em('contentExchange', idx);
  if (idx === 0) {
    mvClass.value = 'left-2';
  } else {
    mvClass.value = 'left-[155px]';
  }
};
</script>

<template>
  <div class="w-full max-w-sm rounded bg-white h-20 m-auto">
    <div
      class="mx-8 shadow rounded-full h-10 mt-4 flex p-1 relative items-center"
    >
      <div
        v-for="(userEnumText, index) in pr.userEnumsText"
        :key="index"
        class="w-full flex justify-center"
      >
        <button @click="tabClick(userEnumText, index)">
          {{ userEnumText }}
        </button>
      </div>
      <span
        :class="
          'bg-indigo-600 text-white flex items-center justify-center w-1/2 rounded-full h-8 transition-all top-[4px] absolute ' +
          mvClass
        "
      >
        {{ selectText }}
      </span>
    </div>
  </div>
</template>

<style scoped></style>
