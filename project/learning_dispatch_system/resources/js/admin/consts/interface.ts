import { User } from './interface/user.ts';

export interface BasicRes {
  success: boolean;
  msg: string;
}

export interface BasicErr {
  status: number;
  msg: string;
}

export interface UserApi {
  user: User;
}
