import type { Genre } from './Genre'

export interface Movie {
  id: number
  tmdb_id?: number
  title: string
  overview: string
  poster_path: string | null
  release_date: string
  vote_average: number
  genres: Genre[]
  trailer_url?: string
  runtime?: number
  original_language?: string
  budget?: number
  revenue?: number
  production_companies?: ProductionCompany[]
  production_countries?: ProductionCountry[]
}

export interface ProductionCompany {
  id: number
  name: string
  logo_path?: string
  origin_country?: string
}

export interface ProductionCountry {
  iso_3166_1: string
  name: string
}
