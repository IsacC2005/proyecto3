<?php

namespace App\Repositories;

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
use App\Repositories\Traits\TeacherTrait;

class TeacherRepository implements TeacherInterface
{

    use TeacherTrait;


	public function create(TeacherDTO $teacher): TeacherDTO 
    {
        try {
            $teacherModel = Teacher::create([
                'name' => $teacher->name,
                'surname' => $teacher->surname,
                'phone' => $teacher->phone,
            ]);

            $user = User::find($teacher->user_id);
            if (!$user) {
                throw new UserNotExistException();
            }

            $teacherModel->user()->save($user);
            return $this->transformToDTO($teacherModel);
        } catch (\Throwable $th) {
            throw new TeacherNotCreateException();
        }
        
    }



    public function find($id): TeacherDTO
    {
        try {
            $teacherModel = Teacher::find($id);
            if (!$teacherModel) {
                throw new TeacherNotFindException();
            }

            return $this->transformToDTO($teacherModel);
        } catch (\Throwable $th) {
            throw new TeacherNotFindException();
        }
    }



    public function findAll(): array
    {
        $teacherModels = Teacher::all();
        return $this->transformListDTO($teacherModels->toArray());
    }



    public function findByEmail($email): TeacherDTO
    {
        try {
            $teacherModel = Teacher::whereHas('users', function($query) use ($email) {
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
}
?>