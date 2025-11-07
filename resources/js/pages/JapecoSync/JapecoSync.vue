<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import ContentPage from '@/components/ContentPage.vue';
import LastUpdate from './components/LastUpdate.vue';
import Progress from './components/Progress.vue';
import ButtonSync from './components/ButtonSync.vue';
import ButtonTest from './components/ButtonTest.vue';
import { ref, computed, onUnmounted } from 'vue';
import axios from 'axios';
import { router } from '@inertiajs/vue3';
import ConnectionStatus from './components/ConnectionStatus.vue';

const props = defineProps({
    lastSyncedAt: {
        type: String,
        required: true,
    },
});

// Estado local para la interfaz de usuario
const isSyncing = ref(false);
const syncProgress = ref(0);
const connectionStatus = ref('idle');
const lastUpdate = ref(props.lastSyncedAt);

const syncInterval = ref<number | null>(null);
const syncMessage = ref('Esperando inicio de sincronización.');

const connectionMessage = computed(() => {
    switch (connectionStatus.value) {
        case 'testing':
            return 'Probando conexión...';
        case 'success':
            return 'Conexión API exitosa!';
        case 'error':
            return 'Error de conexión API. Revisa las credenciales.';
        default:
            return 'Estado de conexión en espera.';
    }
});

/**
 * Detiene el polling si está activo.
 */
const stopPolling = () => {
    if (syncInterval.value) {
        clearInterval(syncInterval.value);
        syncInterval.value = null;
    }
};

/**
 * Obtiene el estado actual de la sincronización desde el cache de Laravel (vía API).
 */
const fetchProgress = async () => {
    try {
        const response = await axios.get('/japeco-sync/progress');
        const data = response.data;
        console.log(data);

        syncProgress.value = data.percentage;
        syncMessage.value = data.message;

        if (data.finished === true) {
            stopPolling();
            isSyncing.value = false;
            router.reload({ only: ['lastSyncedAt'] });

            if (data.percentage === 100) {
                syncMessage.value = '¡Sincronización completa con éxito!';
            } else {
                syncMessage.value = data.message || 'La sincronización terminó con errores.';
            }
        }

    } catch (error) {
        console.error("Error al obtener el progreso:", error);
        stopPolling();
        isSyncing.value = false;
        syncMessage.value = 'ERROR: No se pudo obtener el progreso. Revisa los logs.';
    }
};


/**
 * Inicia el proceso de sincronización manual y comienza el polling.
 */
const handleSync = async () => {
    if (isSyncing.value) return;

    // Reiniciar estados
    isSyncing.value = true;
    syncProgress.value = 0;
    syncMessage.value = 'Enviando petición de inicio a la cola...';
    stopPolling();

    try {
        const response = await axios.post('/japeco-sync');

        syncMessage.value = response.data.message || 'Sincronización enviada a la cola. Esperando progreso...';

        syncInterval.value = window.setInterval(fetchProgress, 6000) as unknown as number;

    } catch (error) {
        console.error("Error al iniciar la sincronización:", error);
        isSyncing.value = false;
        syncMessage.value = 'ERROR al iniciar: Verifica la conexión del servidor.';
    }
};


const testConnection = async () => {
    connectionStatus.value = 'testing';

    try {
        const response = await axios.post('/japeco-test-conection');

        console.log(response.data)
        if (response.data.status === 'success') {
            connectionStatus.value = 'success';
        } else {
            connectionStatus.value = 'error';
        }
    } catch (error) {
        connectionStatus.value = 'error';
        const message = error.response?.data?.message || 'Error de red o API desconocido.';
        console.error("Error en testConnection:", message);
    } finally {
        setTimeout(() => {
            if (connectionStatus.value === 'testing') {
                connectionStatus.value = 'idle';
            }
        }, 1500);
    }
};

onUnmounted(() => {
    stopPolling();
});

</script>

<template>
    <AppLayout>
        <Heading title="Panel de Sincronización de Datos"
            description="Algunos datos importantes como profesores, estudiantes y matriculas, provienen de japeco estos datos se sincronizan cada 15 dias, pero si es necesario puedes sincronizarlos ahora mismo" />
        <ContentPage>
            <LastUpdate :lastUpdate="lastUpdate" />
            <Progress :isSyncing="isSyncing" :syncProgress="syncProgress" :syncMessage="syncMessage" />
            <div class="flex flex-col md:flex-row gap-4">
                <ButtonSync @click="handleSync" :isSyncing="isSyncing" />
                <ButtonTest @click="testConnection" :connectionStatus="connectionStatus" />
            </div>
            <ConnectionStatus :connectionMessage="connectionMessage" :connectionStatus="connectionStatus" />
        </ContentPage>
    </AppLayout>
</template>
