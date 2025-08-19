<?php


namespace App\Repositories;

use App\DTOs\Summary\RepresentativeDTO;
use App\Exceptions\Representative\RepresentativeNotExistException;
use App\Exceptions\Representative\RepresentativeNotFindException;
use App\Exceptions\Representative\RepresentativeNotUpdateException;
use App\Models\Representative;
use App\Repositories\Interfaces\RepresentativeInterface;
use App\Repositories\TransformDTOs\TransformDTOs;
use App\DTOs\Summary\DTOSummary;
use App\Exceptions\Student\StudentNotExistException;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class RepresentativeRepository extends TransformDTOs implements RepresentativeInterface
{

    public function createRepresentative(RepresentativeDTO $representative): RepresentativeDTO
    {
        try {
            $representativeModel = Representative::create([
                'idcard' => $representative->idcard,
                'phone' => $representative->phone,
                'name' => $representative->name,
                'surname' => $representative->surname,
                'direction' => $representative->direction
            ]);

            if (!$representativeModel) {
                throw new RepresentativeNotFindException();
            }

            return $this->transformToDTO($representativeModel);
        } catch (\Throwable $th) {
            throw new RepresentativeNotFindException();
        }
    }



    public function findRepresentativeById(int $id): RepresentativeDTO
    {
        try {
            $representativeModel = Representative::find($id);
            if (!$representativeModel) {
                throw new RepresentativeNotFindException();
            }

            return $this->transformToDTO($representativeModel);
        } catch (\Throwable $th) {
            throw new RepresentativeNotFindException();
        }
    }



    public function findRepresentativeByIdcard(int $idcard): RepresentativeDTO
    {
        $representativeModel = Representative::where('idcard', $idcard)->first();

        if(!$representativeModel){
            throw new RepresentativeNotFindException('No se encontro ningun representante con esa cedula', 404);
        }

        return $this->transformToDTO($representativeModel);
    }



    public function findAllRepresentative(): array
    {
        try {
            $representativeModels = Representative::all();
            if (!$representativeModels) {
                throw new RepresentativeNotFindException();
            }
            return $this->transformListDTO($representativeModels);
        } catch (\Throwable $th) {
            throw new RepresentativeNotFindException();
        }
    }



    public function findRepresentativeByStudent(int $student_id): RepresentativeDTO
    {
        $student = Student::find($student_id);

        if (!$student) {
            throw new StudentNotExistException();
        }

        $representative = $student->representative;

        if(!$representative){
            throw new RepresentativeNotFindException("No se encontro el representante", 404);
        }

        return $this->transformToDTO($representative);
    }



    public function findRepresentativeByName(string $name): array
    {
        try {
            $representativeModel = Representative::where('name', 'like', '%' . $name . '%')->get();
            if ($representativeModel->isEmpty()) {
                throw new RepresentativeNotFindException();
            }
            return $this->transformListDTO($representativeModel->toArray());
        } catch (\Throwable $th) {
            throw new RepresentativeNotFindException();
        }
    }



    public function findRepresentativeByEnrollment(int $enrollment_id): array
    {
        $representativeModel = Representative::whereHas('students',
        function ($student) use ($enrollment_id){
            $student->whereHas('enrollments', function ($query) use ($enrollment_id){
                $query->where('id', $enrollment_id);
            });
        })->get();

        return $this->transformListDTO($representativeModel);
    }



    public function updateRepresentative(RepresentativeDTO $representative): RepresentativeDTO
    {
        try {
            $representativeModel = Representative::find($representative->id);
            if (!$representativeModel) {
                throw new RepresentativeNotFindException();
            }

            $representativeModel->idcard = $representative->idcard;
            $representativeModel->phone = $representative->phone;
            $representativeModel->name = $representative->name;
            $representativeModel->surname = $representative->surname;
            $representativeModel->direction = $representative->direction;

            return $representativeModel->save();
        } catch (\Throwable $th) {
            throw new RepresentativeNotUpdateException();
        }
    }



    public function deleteRepresentative(int $id): void
    {
        try {
            $representativeModel = Representative::find($id);

            if (!$representativeModel) {
                throw new RepresentativeNotExistException();
            }
            $representativeModel->delete();
        } catch (\Throwable $th) {
            throw new RepresentativeNotExistException();
        }
    }



    protected function transformToDTO(Model $model): DTOSummary
    {
        return new RepresentativeDTO(
            id: $model->id,
            idcard: $model->idcard,
            phone: $model->phone,
            name: $model->name,
            surname: $model->surname,
            direction: $model->direction
        );
    }
}
