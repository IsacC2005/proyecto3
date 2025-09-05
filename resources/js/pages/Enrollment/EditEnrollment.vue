<template>
    <div class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow-xl">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Modificar Matrícula</h2>

        <form @submit.prevent="submitForm">
            <div class="mb-4">
                <label for="schoolYear" class="block text-gray-700 font-semibold mb-2">Año Escolar</label>
                <input type="text" id="schoolYear" v-model="matriculaForm.schoolYear"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div class="mb-4">
                <label for="schoolMoment" class="block text-gray-700 font-semibold mb-2">Momento Escolar</label>
                <input type="number" id="schoolMoment" v-model.number="matriculaForm.schoolMoment"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div class="mb-4">
                <label for="grade" class="block text-gray-700 font-semibold mb-2">Grado</label>
                <input type="number" id="grade" v-model.number="matriculaForm.grade"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div class="mb-4">
                <label for="section" class="block text-gray-700 font-semibold mb-2">Sección</label>
                <input type="text" id="section" v-model="matriculaForm.section"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div class="mb-4">
                <label for="teacherId" class="block text-gray-700 font-semibold mb-2">ID del Profesor</label>
                <input type="number" id="teacherId" v-model.number="matriculaForm.teacherId"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                <button type="button" @click="cancelEdit"
                    class="px-6 py-2 border rounded-lg text-gray-700 font-semibold hover:bg-gray-100 transition duration-300">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition duration-300">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';

// Define las propiedades que la vista recibirá, por ejemplo, el ID de la matrícula
// y una función para obtener los datos.
const props = defineProps({
    matriculaId: {
        type: Number,
        required: true,
    },
});

// Define la estructura inicial del formulario.
const matriculaForm = ref({
    id: null,
    schoolYear: '',
    schoolMoment: null,
    grade: null,
    section: '',
    classroom: null,
    teacherId: null,
    learningProjectId: null,
});

// Simula la llamada a la API para obtener los datos de la matrícula.
// En una aplicación real, aquí harías una llamada HTTP (e.g., con Axios o Fetch)
// a tu endpoint de API.
const fetchMatriculaData = async (id) => {
    // Simulación de los datos del JSON que proporcionaste.
    const data = {
        id: id,
        schoolYear: '2025-2026',
        schoolMoment: 1,
        grade: 1,
        section: 'a',
        classroom: 0,
        teacherId: 1,
        learningProjectId: null
    };

    // Asigna los datos recibidos a la variable del formulario.
    matriculaForm.value = data;
};

// Se ejecuta cuando el componente está montado y listo.
onMounted(() => {
    fetchMatriculaData(props.matriculaId);
});

// Método para manejar el envío del formulario.
const submitForm = async () => {
    console.log("Datos a enviar:", matriculaForm.value);
    // Aquí harías la llamada a tu API para actualizar el registro.
    // Por ejemplo, con una solicitud PUT o PATCH.
    // try {
    //   await axios.put(`/api/matriculas/${matriculaForm.value.id}`, matriculaForm.value);
    //   alert('Matrícula actualizada exitosamente.');
    //   // Redirigir al usuario o hacer algo más
    // } catch (error) {
    //   console.error("Error al actualizar la matrícula:", error);
    //   alert('Hubo un error al actualizar la matrícula.');
    // }
};

// Método para cancelar la edición y volver a la vista anterior.
const cancelEdit = () => {
    // Aquí puedes usar vue-router para navegar hacia atrás o a otra ruta.
    // router.back(); o router.push({ name: 'MatriculasList' });
    console.log("Edición cancelada.");
};
</script>
