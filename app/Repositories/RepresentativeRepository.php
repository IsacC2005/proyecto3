<?php


namespace App\Repositories;

use App\DTOs\RepresentativeDTO;
use App\DTOs\StudentDTO;
use App\Models\Representative;
use App\Repositories\Interfaces\RepresentativeInterface;
use App\Repositories\Traits\RepresentativeTrait;

class RepresentativeRepository implements RepresentativeInterface
{


    use RepresentativeTrait;


    public function create(RepresentativeDTO $representative): bool
    {
        $representativeModel = Representative::create([
            'idcard' => $representative->idcard,
            'phone' => $representative->phone,
            'name' => $representative->name,
            'surname' => $representative->surname,
            'direction' => $representative->direction
        ]);

        if (!$representativeModel) {
            return false;
        }

        return true;
    }



    public function find($id): RepresentativeDTO | null
    {
        $representative = Representative::find($id);
        if (!$representative) {
            return null;
        }

        return $this->transformToDTO($representative);
    }



    public function findAll(): array
    {
        $representatives = Representative::all();
        return $this->transformListDTO($representatives->toArray());
    }



    public function findByStudent(int $student_id): array
    {
        $representative = Representative::whereHas('students', function ($query) use ($student_id) {
            $query->where('id', $student_id);
        })->get();

        if ($representative->isEmpty()) {
            return [];
        }

        return $this->transformListDTO($representative->toArray());
    }

    public function findByName($name): array
    {
        $representativeModel = Representative::where('name', 'like', '%' . $name . '%')->get();
        if ($representativeModel->isEmpty()) {
            return [];
        }
        return $this->transformListDTO($representativeModel->toArray());
    }

    public function update(RepresentativeDTO $representative): bool
    {
        $representativeModel = Representative::find($representative->id);
        if (!$representativeModel) {
            return false;
        }

        $representativeModel->idcard = $representative->idcard;
        $representativeModel->phone = $representative->phone;
        $representativeModel->name = $representative->name;
        $representativeModel->surname = $representative->surname;
        $representativeModel->direction = $representative->direction;

        return $representativeModel->save();
    }

    public function delete($id): bool
    {
        $representativeModel = Representative::find($id);

        if (!$representativeModel) {
            return false;
        }
        return $representativeModel->delete();
    }
}
