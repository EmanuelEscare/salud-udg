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

  // Calculate SOM indicator
  const somItems = [1, 4, 12, 27, 40, 42, 48, 49, 52, 53, 56, 58];
  const somScore = testResults.reduce((accumulator, item) => {
    if (somItems.includes(item.index)) {
      return accumulator + item.value;
    }
    return accumulator;
  }, 0);
  const som = { indicator: 'SOM', result: somScore/somItems.length };

  // Calculate OBSERVACIONES indicator
  const obsItems = [3, 9, 10, 28, 38, 45, 46, 51, 55, 65];
  const obsScore = testResults.reduce((accumulator, item) => {
    if (obsItems.includes(item.index)) {
      return accumulator + item.value;
    }
    return accumulator;
  }, 0);
  const obs = { indicator: 'OBS', result: obsScore/obsItems.length };

  // Calculate SÍNTOMAS INESPECÍFICOS (SI) indicator
  const siItems = [6,21,34,36,37,41,61,69,73];
  const siScore = testResults.reduce((accumulator, item) => {
    if (siItems.includes(item.index)) {
      return accumulator + item.value;
    }
    return accumulator;
  }, 0);
  const si = { indicator: 'SI', result: siScore/siItems.length };

  // Calculate DEPRESIÓN (DEP) indicator
  const depItems = [5,14,15,20,22,26,29,30,31,32,54,71,79];
  const depScore = testResults.reduce((accumulator, item) => {
    if (depItems.includes(item.index)) {
      return accumulator + item.value;
    }
    return accumulator;
  }, 0);
  const dep = { indicator: 'DEP', result: depScore/depItems.length };

  // Calculate ANSIETY (ANS) indicator
  const ansItems = [2,17,23,33,39,57,72,78,80,86];
  const ansScore = testResults.reduce((accumulator, item) => {
    if (ansItems.includes(item.index)) {
      return accumulator + item.value;
    }
    return accumulator;
  }, 0);
  const ans = { indicator: 'ANS', result: ansScore/ansItems.length };

  // Calculate HOSTILIDAD (HOS) indicator
  const hosItems = [11,24,63,67,74,81];
  const hosScore = testResults.reduce((accumulator, item) => {
    if (hosItems.includes(item.index)) {
      return accumulator + item.value;
    }
    return accumulator;
  }, 0);
  const hos = { indicator: 'HOS', result: hosScore/hosItems.length };

  // Calculate FOBIA (FOB) indicator
  const fobItems = [13,25,47,50,70,75,82];
  const fobScore = testResults.reduce((accumulator, item) => {
    if (fobItems.includes(item.index)) {
      return accumulator + item.value;
    }
    return accumulator;
  }, 0);
  const fob = { indicator: 'FOB', result: fobScore/fobItems.length };

  // Calculate PARANOIA (PAR) indicator
  const parItems = [8,18,43,68,76,83];
  const parScore = testResults.reduce((accumulator, item) => {
    if (parItems.includes(item.index)) {
      return accumulator + item.value;
    }
    return accumulator;
  }, 0);
  const par = { indicator: 'PAR', result: parScore/parItems.length };

  // Calculate PSICOTICISMO (PSIC) indicator
  const psicItems = [7,16,35,62,77,84,85,87,88,90];
  const psicScore = testResults.reduce((accumulator, item) => {
    if (psicItems.includes(item.index)) {
      return accumulator + item.value;
    }
    return accumulator;
  }, 0);
  const psic = { indicator: 'PSIC', result: psicScore/psicItems.length };


  const igs = { indicator: 'IGS', result: score / questions }
  const tsp = { indicator: 'TSP', result: questions - nonPositive }
  const imsp = { indicator: 'IMSP', result: score / tsp.result }


  const indicators = Object.entries(grouped).map((group) => {
    const element = group[1]
    return {
      indicator: element.indicator,
      result: element.valueSum / element.questions
    }
  }).concat([som, obs, si, dep, ans, hos, fob, par, psic, igs, tsp, imsp])

  return indicators
}

export const beckAnxietyInventory = ({ score }) => {
  if (score <= 5) return 'Ansiedad mínima'
  if (score > 5 && score <= 15) return 'Ansiedad leve'
  if (score > 15 && score <= 30) return 'Ansiedad moderada'
  if (score > 30 && score <= 63) return 'Ansiedad severa'
}

export const PerceivedStressScale = ({ score }) => {
  if (score >= 0 && score <= 13)  return "Nivel de estrés: Bajo estrés percibido.";
   if (score >= 14 && score <= 26)  return "Nivel de estrés: Estrés percibido moderado.";
   if (score >= 27 && score <= 40)  return "Nivel de estrés: Estrés percibido alto.";
   if (score >= 41 && score <= 56)  return "Nivel de estrés: Muy alto estrés percibido.";
}

export const HamiltonAnxietyScale = ({ score }) => {
  if (score <= 17) return 'Ansiedad Leve'
  if (score >= 18 && score <= 24) return 'Ansiedad Moderada'
  if (score >= 25 && score <= 30) return 'Ansiedad Moderadamente Severa'
  if (score >= 31) return 'Ansiedad Severa'
}

export const qualificatorsService = {
  beckDepressionInventory,
  derogatisSymptomsInventory,
  beckAnxietyInventory,
  PerceivedStressScale,
  HamiltonAnxietyScale
}
