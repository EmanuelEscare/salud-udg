import axios from 'axios'

const baseUrl = '/api'

const getCount = (filter) => {
  return axios.post(`${baseUrl}/getCount`, filter)
}

const getAll = (filter) => {
  return axios.post(`${baseUrl}/getAll`, filter)
}

const getFiltered = (filter) => {
  return axios.post(`${baseUrl}/getFiltered`, filter)
}

const createResult = newResult => {
  return axios.post(`${baseUrl}/newResult`, newResult)
}

export const resultsService = {
  getCount,
  getAll,
  getFiltered,
  createResult
}
