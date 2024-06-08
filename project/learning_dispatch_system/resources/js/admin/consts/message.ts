interface Err {
  system: string;
  authentication: string;
}

export const err: Err = {
  system: 'システムエラーが発生しました。',
  authentication: '認証に失敗しました。',
};
