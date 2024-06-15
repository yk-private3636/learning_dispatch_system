export interface BasicRes {
  success: boolean;
  msg: string;
}

export interface BasicErr {
  status: number;
  msg: string;
}

export interface User {
  email: string;
  family_name: string;
  name: string;
}

export interface UserApi {
  user: User;
}
