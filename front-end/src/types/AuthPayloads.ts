export interface LoginPayload {
  email: string
  password: string
}

export interface RegisterPayload {
  name: string
  email: string
  password: string
  password_confirmation: string
}

export interface UpdateUserPayload {
  name: string
  email: string
  password?: string
  new_password?: string
  new_password_confirmation?: string
}

