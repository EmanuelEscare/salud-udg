const beckDepressionInventory = ({ score }) => {
  if (score <= 13) return 'Depresión mínima'
  if (score > 13 && score <= 19) return 'Depresión leve'
  if (score > 19 && score <= 28) return 'Depresión moderada'
  if (score > 28 && score <= 63) return 'Depresión grave'
}

const derogatisSymptomsInventory = ({ score, testResults }) => {
  const grouped = testResults.reduce((acc, obj) => {
    const key = obj.section
    if (!acc[key]) {
      acc[key] = { questions: 0, valueSum: 0, indicator: key, nonPositive: 0 }
    }
    acc[key].questions++
    acc[key].valueSum += obj.value
    if (obj.value < 1) acc[key].nonPositive++
    return acc
  }, {})

  const nonPositive = Object.values(grouped).reduce((acc, curr) => {
    acc += curr.nonPositive
    return acc
  }, 0)

  const questions = 90
  const igs = { indicator: 'IGS', result: score / questions }
  const tsp = { indicator: 'TSP', result: questions - nonPositive }
  const imsp = { indicator: 'IMSP', result: score / tsp.result }

  const indicators = Object.entries(grouped).map((group) => {
    const element = group[1]
    return {
      indicator: element.indicator,
      result: element.valueSum / element.questions
    }
  }).concat([igs, tsp, imsp])

  return indicators
}

export const beckAnxietyInventory = ({ score }) => {
  if (score <= 5) return 'Ansiedad mínima'
  if (score > 5 && score <= 15) return 'Ansiedad leve'
  if (score > 15 && score <= 30) return 'Ansiedad moderada'
  if (score > 30 && score <= 63) return 'Ansiedad severa'
}

export const qualificatorsService = {
  beckDepressionInventory,
  derogatisSymptomsInventory,
  beckAnxietyInventory
}
