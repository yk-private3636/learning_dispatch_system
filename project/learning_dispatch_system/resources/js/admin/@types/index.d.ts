import { Config } from 'ziggy-js';

declare global {
  function route(
    name: string,
    params?: string | number,
    absolute?: boolean,
    config?: Config
  ): string;
}
