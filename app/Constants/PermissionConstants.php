<?php

namespace App\Constants;

class PermissionConstants
{
    // Permisos de Usuario
    const CREATE_USER = 'Crear Usuario';
    const MODIFY_USER = 'Modificar Usuario';
    const SUSPEND_USER = 'Suspender Usuario';
    const DELETE_USER = 'Eliminar Usuario';

    // Permisos de Estudiante
    const REGISTER_STUDENT = 'Registrar Estudiante';
    const MODIFY_STUDENT = 'Modificar Estudiante';
    const DELETE_STUDENT = 'Eliminar Estudiante';

    // Permisos de Matrícula
    const CREATE_ENROLLMENT = 'Crear Matricula';
    const MODIFY_ENROLLMENT = 'Modificar Matricula';

    // Permisos de Habilitación (Global)
    const ENABLE_PROJECT_CREATION = 'Habilitar Creacion De Proyecto';
    const ENABLE_REPORT_CARD_CREATION = 'Habilitar Creacion De Boletas';
    const ENABLE_REPORT_EXPORT = 'Habilitar Exportacion De Boletines';
    const ENABLE_REPORT_PRINT = 'Habilitar Impresion De Boletines';

    // Permisos de Proyecto de Aprendizaje
    const CREATE_PROJECT = 'Crear Proyecto';
    const MODIFY_PROJECT = 'Modificar Proyecto';
    const READ_PROJECT = 'Leer Proyecto';
    const DELETE_PROJECT = 'Eliminar Proyecto';
    const APPROVE_PROJECT = 'Aprobar Proyecto';

    // Permisos de Calificación
    const REGISTER_GRADE = 'Registrar Calificacion';
    const MODIFY_GRADE = 'Modificar Calificacion';
    const READ_GRADE = 'Leer Calificacion';
    const DELETE_GRADE = 'Eliminar Calificacion';

    // Permisos de Boleta
    const CREATE_REPORT_CARD = 'Crear Boleta';
    const MODIFY_REPORT_CARD = 'Modificar Boleta';
    const READ_REPORT_CARD = 'Leer Boleta';
    const DELETE_REPORT_CARD = 'Eliminar Boleta';
    const APPROVE_REPORT_CARD = 'Aprobar Boleta';

    // Permisos de Reporte (Impresión/Exportación)
    const PRINT_REPORT = 'Imprimir Reporte';
    const EXPORT_REPORT = 'Exportar Reporte';
}
