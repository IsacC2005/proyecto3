<?php


namespace App\Repositories;

use App\DTOs\RepresentativeDTO;
use App\DTOs\StudentDTO;
use App\Exceptions\Representative\RepresentativeNotExistException;
use App\Exceptions\Representative\RepresentativeNotFindException;
use App\Exceptions\Representative\RepresentativeNotUpdateException;
use App\Models\Representative;
use App\Repositories\Interfaces\RepresentativeInterface;
use App\Repositories\Traits\RepresentativeTrait;

class RepresentativeRepository implements RepresentativeInterface
{


    use RepresentativeTrait;


    public function create(RepresentativeDTO $representative): RepresentativeDTO
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



    public function find($id): RepresentativeDTO
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



    public function findAll(): array
    {
        try {
            $representativeModels = Representative::all();
            if (!$representativeModels) {
                throw new RepresentativeNotFindException();
            }
            return $this->transformListDTO($representativeModels->toArray());
        } catch (\Throwable $th) {
            throw new RepresentativeNotFindException();
        }
    }



    public function findByStudent(int $student_id): array
    {
        try {
            $representative = Representative::whereHas('students', function ($query) use ($student_id) {
                $query->where('id', $student_id);
            })->get();

            if ($representative->isEmpty()) {
                throw new RepresentativeNotFindException();
            }

            return $this->transformListDTO($representative->toArray());
        } catch (\Throwable $th) {
            throw new RepresentativeNotFindException();
        }
    }



    public function findByName($name): array
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



    public function update(RepresentativeDTO $representative): RepresentativeDTO
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



    public function delete($id): void
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
}
