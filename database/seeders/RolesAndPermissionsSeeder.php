<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Constants\PermissionConstants;
use App\Constants\RoleConstants;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        /*
            TODO: Todos los permisos 
         */
        $permisosTodos = [
            //? Permisos para crear y gestionar usuarios
            PermissionConstants::CREATE_USER,
            PermissionConstants::MODIFY_USER,
            PermissionConstants::SUSPEND_USER,
            PermissionConstants::DELETE_USER,

            //? Permisos para gestionar los estudiantes
            PermissionConstants::REGISTER_STUDENT,
            PermissionConstants::MODIFY_STUDENT,
            PermissionConstants::DELETE_STUDENT,

            //? Permisos para crear y modificar Matriculas
            PermissionConstants::CREATE_ENROLLMENT,
            PermissionConstants::MODIFY_ENROLLMENT,

            //? Permisos para Habilitar la creación de Proyectos de Aprendizaje y Boletas.
            PermissionConstants::ENABLE_PROJECT_CREATION,
            PermissionConstants::ENABLE_REPORT_CARD_CREATION,

            //? Permisos para gestionar los proyectos de aprendizaje
            PermissionConstants::CREATE_PROJECT,
            PermissionConstants::MODIFY_PROJECT,
            PermissionConstants::READ_PROJECT,
            PermissionConstants::DELETE_PROJECT,

            // ? Permisos para evaluar a los estudiantes
            PermissionConstants::REGISTER_GRADE,
            PermissionConstants::MODIFY_GRADE,
            PermissionConstants::READ_GRADE,
            PermissionConstants::DELETE_GRADE,

            //? Permisos para gestionar Boletas
            PermissionConstants::CREATE_REPORT_CARD,
            PermissionConstants::MODIFY_REPORT_CARD,
            PermissionConstants::READ_REPORT_CARD,
            PermissionConstants::DELETE_REPORT_CARD,

            //? Permisos para la aprobación de Proyectos de aprendizaje y Boletas
            PermissionConstants::APPROVE_REPORT_CARD,
            PermissionConstants::APPROVE_PROJECT,

            //? Permisos para habilitar la exportación e importación de reportes
            PermissionConstants::ENABLE_REPORT_EXPORT,
            PermissionConstants::ENABLE_REPORT_PRINT,

            //? Permisos para imprimir y exportar reportes
            PermissionConstants::PRINT_REPORT,
            PermissionConstants::EXPORT_REPORT
        ];

        foreach (array_unique($permisosTodos) as $permiso) {
            Permission::findOrCreate($permiso);
        }




        /*
            TODO: Los permisos para el rol Profesor 
        */
        $permisosProfesor = [ 

            //? Permisos para gestionar los proyectos de aprendizaje
            PermissionConstants::CREATE_PROJECT,
            PermissionConstants::MODIFY_PROJECT,
            PermissionConstants::READ_PROJECT,
            PermissionConstants::DELETE_PROJECT,

            //? Permisos para evaluar
            PermissionConstants::REGISTER_GRADE,
            PermissionConstants::MODIFY_GRADE,
            PermissionConstants::READ_GRADE,
            PermissionConstants::DELETE_GRADE,

            //? Permisos para gestionar Boletas
            PermissionConstants::CREATE_REPORT_CARD,
            PermissionConstants::MODIFY_REPORT_CARD,
            PermissionConstants::READ_REPORT_CARD,
            PermissionConstants::DELETE_REPORT_CARD,

            //? Permisos para imprimir y exportar reportes
            PermissionConstants::PRINT_REPORT,
            PermissionConstants::EXPORT_REPORT
        ];





        /*
            TODO: Permisos para el rol Supervisor
        */
        $permisosSupervisor = [

            //? Permisos para la revisión de Proyectos de aprendizaje y Boletas.
            PermissionConstants::READ_PROJECT,
            PermissionConstants::READ_REPORT_CARD,

            //? Permisos para la aprobación de Proyectos de aprendizaje y Boletas
            PermissionConstants::APPROVE_REPORT_CARD,
            PermissionConstants::APPROVE_PROJECT,

            //? Permisos para imprimir y exportar reportes
            PermissionConstants::PRINT_REPORT,
            PermissionConstants::EXPORT_REPORT
        ];





        /*
            TODO: Los permisos del rol SubDireccion
         */
        $permisosSubDireccion = [

            //? Permisos para gestionar los estudiantes
            PermissionConstants::REGISTER_STUDENT,
            PermissionConstants::MODIFY_STUDENT,
            PermissionConstants::DELETE_STUDENT,

            //? Permisos para crear y modificar Matriculas
            PermissionConstants::CREATE_ENROLLMENT,
            PermissionConstants::MODIFY_ENROLLMENT
        ];





        /*
            TODO: Los permisos del rol Administrador
         */
        $permisosAdministrador = [

            //? Permisos para crear y gestionar usuarios
            PermissionConstants::CREATE_USER,
            PermissionConstants::MODIFY_USER,
            PermissionConstants::SUSPEND_USER,
            PermissionConstants::DELETE_USER,

            //? Permisos para habilitar la exportación e importación de reportes
            PermissionConstants::ENABLE_REPORT_EXPORT,
            PermissionConstants::ENABLE_REPORT_PRINT,

            //? Permisos para Habilitar la creación de Proyectos de Aprendizaje y Boletas.
            PermissionConstants::ENABLE_PROJECT_CREATION,
            PermissionConstants::ENABLE_REPORT_CARD_CREATION,

            //? Permisos para la revisión de Proyectos de aprendizaje y Boletas.
            PermissionConstants::READ_PROJECT,
            PermissionConstants::READ_REPORT_CARD,

            //? Permisos para la aprobación de Proyectos de aprendizaje y Boletas
            PermissionConstants::APPROVE_REPORT_CARD,
            PermissionConstants::APPROVE_PROJECT,

            //? Permisos para imprimir y exportar reportes
            PermissionConstants::PRINT_REPORT,
            PermissionConstants::EXPORT_REPORT
        ];


        $roles = [
            RoleConstants::ADMINISTRADOR,
            RoleConstants::SUBDIRECTOR,
            RoleConstants::SUPERVISOR,
            RoleConstants::PROFESOR
        ];

        $Administrador = Role::create(['name' => RoleConstants::ADMINISTRADOR]);
        $SubDirector = Role::create(['name' => RoleConstants::SUBDIRECTOR]);
        $Supervisor = Role::create(['name' => RoleConstants::SUPERVISOR]);
        $Profesor = Role::create(['name' => RoleConstants::PROFESOR]);

        $Administrador->givePermissionTo($permisosAdministrador);
        $SubDirector->givePermissionTo($permisosSubDireccion);
        $Supervisor->givePermissionTo($permisosSupervisor);
        $Profesor->givePermissionTo($permisosProfesor);
    }
}
