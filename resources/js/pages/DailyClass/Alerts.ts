import { Alert } from "@/types";

export const alertInidicatorsPart: Alert = {
    isOpen: true,
    title: '🚫¡Error!',
    description: 'La cantidad de indicadores es par',
    message: 'No puedes usar una canditdad par de indicadores para un referente teorico',
    code: 0
}

export const alertReferentUpdate: Alert = {
    isOpen: true,
    title: '✔️¡Exito!',
    description: 'El referente teorico se actualizo',
    message: 'Referente Teorico actualizado, recuerda que cuando evalues este referente no lo podras modificar',
    code: 0
}