import { defineStore } from 'pinia';

export const useFlashMsgState = defineStore('flishMsgState', {
  state: () => ({
    msg: '' as string,
    type: '' as string,
    show: false as boolean,
  }),
  actions: {
    setShowMsg(msg: string, type: string): void {
      this.msg = msg;
      this.type = type;
      this.show = true;
    },
  },
});
