export const handleError = (error: any, fallbackMessage = 'Erro inesperado'): string => {
  const message = error?.response?.data?.message || fallbackMessage
  console.error('[API ERROR]', message)
  return message
}