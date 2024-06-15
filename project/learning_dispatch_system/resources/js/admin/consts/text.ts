interface Password {
  forget: string;
  forgetTo: string;
  reconfigure: string;
}
export const password: Password = {
  forget: 'パスワードをお忘れですか?',
  forgetTo: 'パスワードを忘れた方',
  reconfigure: 'パスワード再設定',
};

export const home: string = 'ホーム';
export const userList: string = 'ユーザー一覧';
export const contact: string = 'お問い合わせ';
export const config: string = '設定';
export const logout: string = 'ログアウト';
