import { defineStore } from 'pinia';
import { Alert } from '@/types';

export const useAlertData = defineStore('modal-data', {
    state: (): Alert => ({
        isOpen: false,
        title: 'Esta es una prueba',
        description: 'descripcion de la prueba',
        message: 'y el poderosicimo mensaje de la prueba xd',
        code: 0
    }),
    actions: {
        showAlert(data: Alert) {
            this.isOpen = true;
            this.title = data.title;
            this.description = data.description;
            this.message = data.message;
            this.code = data.code
        },
        closeAlert() {
            this.isOpen = false;
            this.title = '';
            this.description = '';
            this.message = '';
            this.code = 0
        }
    }
})