import * as message from '../consts/message.js';
import { blank } from '../consts/StrLib.js';

export const required = (input) => {
  const judge = blank(input);

  if (judge) {
    return message.valid.required;
  }

  return true;
};
