import dayjs from "dayjs"

const romanNumbers = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII']

Vue.filter('romanize', function(date) {
  if (!date) return ''

  const parsedDate = dayjs(date)
  return parsedDate.format(`D. [${romanNumbers[parsedDate.month()]}]. YYYY`)
})
