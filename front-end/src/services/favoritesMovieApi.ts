
import axios from 'axios'

const favoritesMovieApi = axios.create({
  baseURL: import.meta.env.VITE_API_URL, // Laravel
})

export default favoritesMovieApi
