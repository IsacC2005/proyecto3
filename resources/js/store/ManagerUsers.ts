import { useForm } from "@inertiajs/vue3";
import { defineStore } from "pinia";
import { ref } from "vue";
import { Role, User } from "@/types/dtos";
import { useAlertData } from "./ModalStore";

export const useManagerUsers = defineStore("managerUsers", () => {

    const alertData = useAlertData();

    type UserBaseForm = Omit<User, 'password' | 'roles'>;

    interface userForm extends UserBaseForm {
        roles: number[]
        [key: string]: any
    }

    const form = useForm<userForm>({
        id: 0,
        name: '',
        email: '',
        roles: []
    });

    const UpdateUser = () => {

        form.put(route('manager.user.update', form.id), {
            preserveScroll: true,
            preserveState: true,
            replace: true,
            onSuccess: () => {

                alertData.showAlert({
                    isOpen: true,
                    title: 'Exito',
                    description: 'Usuario actualizado',
                    message: 'Los datos del usuario se han actualizado correctamente.',
                    code: 0
                });
            }
        })
    }



    const allRoles = ref([] as Role[]);



    const formResetPassword = useForm({
        password: '',
        password_confirmation: ''
    })

    const resetPassword = () => {

        if (formResetPassword.password !== formResetPassword.password_confirmation) {
            alertData.showAlert({
                isOpen: true,
                title: 'Error',
                description: 'Las contraseñas no coinciden',
                message: 'Por favor, asegúrate de que ambas contraseñas sean iguales.',
                code: 400
            });
            return;
        }

        formResetPassword.put(route('manager.user.reset-password', form.id), {
            preserveScroll: true,
            onSuccess: () => {
                formResetPassword.reset();
                alertData.showAlert({
                    isOpen: true,
                    title: 'Exito',
                    description: 'Contraseña actualizada',
                    message: 'La contraseña del usuario se ha actualizado correctamente.',
                    code: 0
                });
            },
            onError: (e) => {
                console.error(e);
            },
        });
    }


    return { form, UpdateUser, allRoles, formResetPassword, resetPassword };
});