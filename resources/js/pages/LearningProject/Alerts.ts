import { Alert } from "@/types";

export const ContentVeryLong: Alert = {
    isOpen: true,
    title: '¡Error!',
    description: 'Contenido demaciado largo',
    message: 'El contenido debe de ser menor a 1000 caracteres.',
    code: 400
}