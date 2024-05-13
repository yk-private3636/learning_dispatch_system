export function blank(str)
{
	return str === '' || str === null || str === undefined
}

export function filled(str)
{
	return str !== '' && str !== null && str !== undefined
}