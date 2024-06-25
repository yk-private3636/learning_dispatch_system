export function blank(str: string | unknown): boolean {
  return str === '' || str === null || str === undefined;
}

export function filled(str: string | unknown): boolean {
  return str !== '' && str !== null && str !== undefined;
}
