<?php

namespace App\Repositories;

use App\DTOs\PaginationDTO;
use App\DTOs\Summary\TeacherDTO;
use App\Exceptions\Teacher\TeacherNotDeleteException;
use App\Exceptions\Teacher\TeacherNotExistException;
use App\Exceptions\Teacher\TeacherNotFindException;
use App\Exceptions\Teacher\TeacherNotUpdateException;
use App\Exceptions\TeacherNotCreateException;
use App\Exceptions\User\UserNotExistException;
use App\Models\Teacher;
use App\Models\User;
use App\Repositories\Interfaces\TeacherInterface;
use App\Repositories\TransformDTOs\TransformDTOs;
use App\DTOs\Summary\DTOSummary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\DTOs\Details\DTODetail;
use App\DTOs\Details\TeacherDetailDTO;
use App\DTOs\Details\UserDetailDTO;
use App\DTOs\Searches\DTOSearch;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class TeacherRepository extends TransformDTOs implements TeacherInterface
{

    public function __construct(
        public UserRepository $userRepository
    ) {}

    public function createTeacher(TeacherDTO $teacher): TeacherDTO
    {
        $teacherModel = Teacher::create([
            'name' => $teacher->name,
            'surname' => $teacher->surname,
            'phone' => $teacher->phone,
        ]);

        $userModel = User::find($teacher->user_id);

        if (!$userModel) {
            throw new UserNotExistException();
        }

        $userModel->save();

        $teacherModel->user()->save($userModel);

        return $this->transformToDTO($teacherModel);
    }



    public function find($id): TeacherDTO
    {
        try {
            $teacherModel = Teacher::find($id);

            if (!$teacherModel) {
                throw new TeacherNotFindException();
            }

            $userModel = $teacherModel->user;

            return $this->transformToDTO($teacherModel);
        } catch (\Throwable $th) {
            throw new TeacherNotFindException();
        }
    }



    public function findAll(): PaginationDTO
    {
        $teacherModels = Teacher::orderBy('created_at', 'desc')->paginate(10);

        $paginationDTO = new PaginationDTO($teacherModels);

        $data = $this->transformListDTO($teacherModels->getCollection());

        $paginationDTO->data = $data;

        return $paginationDTO;
    }



    public function findByEmail($email): TeacherDTO
    {
        try {
            $teacherModel = Teacher::whereHas('users', function ($query) use ($email) {
                $query->where('email', $email);
            })->first();
            if (!$teacherModel) {
                throw new TeacherNotFindException();
            }
            return $this->transformToDTO($teacherModel);
        } catch (\Throwable $th) {
            throw new TeacherNotFindException();
        }
    }



    public function findByName($name): array
    {
        $teacherModels = Teacher::where('name', 'like', "%$name%")->get();
        return $this->transformListDTO($teacherModels->toArray());
    }



    public function update(TeacherDTO $teacher): TeacherDTO
    {
        try {
            $teacherModel = Teacher::find($teacher->id);
            if (!$teacherModel) {
                throw new TeacherNotExistException();
            }

            $teacherModel->name = $teacher->name;
            $teacherModel->surname = $teacher->surname;
            $teacherModel->phone = $teacher->phone;

            if ($teacher->user_id) {
                $user = User::find($teacher->user_id);
                if ($user) {
                    $teacherModel->user()->associate($user);
                }
            }
            $teacherModel->save();
            return $this->transformToDTO($teacherModel);
        } catch (\Throwable $th) {
            throw new TeacherNotUpdateException();
        }
    }



    public function delete($id): void
    {
        try {
            $teacher = Teacher::find($id);
            if (!$teacher) {
                throw new TeacherNotExistException();
            }
            $teacher->delete();
        } catch (\Throwable $th) {
            throw new TeacherNotDeleteException();
        }
    }



    protected function transformToDTO(Model $model): DTOSummary
    {
        return new TeacherDTO(
            id: $model->id,
            name: $model->name,
            surname: $model->surname,
            phone: $model->phone,
            //user_id: $model->user?->id ?? null
        );
    }

	protected function transformToDetailDTO(Model $model): DTODetail
    {
        return new TeacherDetailDTO(
            id: $model->id,
            name: $model->name,
            surname: $model->surname,
            phone: $model->phone,
            user: null
        );
    }

	protected function transformToSearchDTO(Model $model): DTOSearch
    {
        // TODO
    }
}
