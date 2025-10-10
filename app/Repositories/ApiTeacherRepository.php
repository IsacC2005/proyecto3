<?php

namespace App\Repositories;

use App\Constants\TDTO;
use App\Repositories\Interfaces\TeacherInterface;
use App\DTOs\Summary\TeacherDTO;
use App\DTOs\PaginationDTO;
use App\Repositories\TransformDTOs\TransformDTOs;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\DTOs\Summary\DTOSummary;
use App\DTOs\Details\DTODetail;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiTeacherRepository extends TransformDTOs implements TeacherInterface
{
    public function createTeacher(TeacherDTO $teacher): TeacherDTO
    {
        // TODO
    }

    public function existTeacher(int $id): bool
    {

        $japecoUrl = env('JAPECO_URL');
        $response = Http::get("$japecoUrl/api/teacher/exist/$id");

        if (!$response->successful()) {
            throw new \Exception("Error al conectar con la API: {$response->status()}");
        }

        $apiData = $response->json();

        return $apiData['data'];
    }

    public function find(int $id): TeacherDTO
    {
        $japecoUrl = env('JAPECO_URL');
        $response = Http::get("$japecoUrl/api/teacher/show/$id");

        if (!$response->successful()) {
            throw new \Exception("Error al conectar con la API: {$response->status()}");
        }

        $apiData = $response->json();

        return $this->transformToDTO($apiData['data']);
    }

    public function findByEmail(string $email): TeacherDTO
    {
        // TODO
    }

    public function findAll(?string $fn = TDTO::SUMMARY): PaginationDTO
    {
        $japecoUrl = env('JAPECO_URL');
        $response = Http::get("$japecoUrl/api/teacher/index");

        if (!$response->successful()) {
            throw new \Exception("Error al conectar con la API: {$response->status()}");
        }
        $apiData = $response->json();

        $teacherDataCollection = collect($apiData['data'] ?? []);

        $perPage = 1; // Un valor fijo, ya que no hay paginación real
        $currentPage = 1; // Siempre la primera página
        $total = $teacherDataCollection->count(); // El total de elementos es el tamaño del array
        $items = $teacherDataCollection;

        // Crea la instancia del Paginador
        $teacherModelsPaginator = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            []
        );

        // 4. Transformar los datos de la Colección del Paginador
        // Usamos getCollection() para acceder a los items que acabamos de pasarle.
        $data = $this->transformListDTO($teacherModelsPaginator->getCollection());

        // 5. Crear e inicializar el DTO final.
        // EL DTO necesita el objeto Paginator completo.
        $paginationDTO = new PaginationDTO($teacherModelsPaginator);


        // Reemplazamos la colección de datos dentro del DTO (la colección transformada)
        $paginationDTO->data = $data;

        return $paginationDTO;
    }

    public function findAllNotEnrollmentAssign(string $schoolYear, int $schoolMoment): PaginationDTO
    {
        // TODO
    }

    public function findByName(string $name): array
    {
        // TODO
    }

    public function update(TeacherDTO $teacher): TeacherDTO
    {
        // TODO
    }

    public function delete(int $id): void
    {
        // TODO
    }

    protected function transformToDTO($data): TeacherDTO
    {
        return new TeacherDTO(
            id: $data["id"],
            name: $data['name'],
            surname: $data['surname'],
            phone: $data['phone']
        );
    }

    protected function transformToDetailDTO(Model $model): DTODetail
    {
        // TODO
    }
}
