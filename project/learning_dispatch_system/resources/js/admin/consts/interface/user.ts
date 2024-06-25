export interface User {
  email: string;
  family_name: string;
  name: string;
}

export interface UserList {
  id: number;
  email: string;
  name: string;
  usage_status: number;
}

export interface UserListPager {
  users: {
    current_page: number;
    last_page: number;
    data: UserList[];
  };
}
