import { defineStore } from 'pinia';

interface ValidationItem {
  fails: boolean;
  msg: string;
}

export const useValidState = defineStore('validState', {
  state: () => ({
    validate: {} as Record<string, ValidationItem>,
  }),
  actions: {
    setValid(key: string, valid: ValidationItem): void {
      this.validate[key] = valid;
    },
    init(): void {
      this.validate = {};
    },
  },
});
