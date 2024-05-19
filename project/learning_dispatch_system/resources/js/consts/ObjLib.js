import { blank } from './StrLib.js'

export const designationFilled = (obj, useKeys) => {
	const judge = useKeys.every((key) => {
		
		return blank(obj[key]) === false
	})

	return judge
}