import axios from 'axios'

export const getGenres = async () => {
  return axios.get(`${import.meta.env.VITE_API_URL}/movies/genres`)
}
