<?php

namespace App\Repositories;

use App\DTOs\TeacherDTO;
use App\Models\Teacher;
use App\Models\User;
use App\Repositories\Interfaces\TeacherInterface;
use App\Repositories\Traits\TeacherTrait;

class TeacherRepository implements TeacherInterface
{

    use TeacherTrait;


	public function create(TeacherDTO $teacher): bool 
    {
        $teacherModel = Teacher::create([
            'name' => $teacher->name,
            'surname' => $teacher->surname,
            'phone' => $teacher->phone,
        ]);

        $user = User::find($teacher->user_id);
        if (!$user) {
            return false;
        }

        $teacherModel->user()->save($user);
        return true;
    }



    public function find($id): TeacherDTO | null 
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return null;
        }

        return $this->transformToDTO($teacher);
    }



    public function findAll(): array
    {
        $teachers = Teacher::all();
        return $this->transformListDTO($teachers->toArray());
    }



    public function findByEmail($email): TeacherDTO | null
    {
        $teacher = Teacher::where('email', $email)->first();
        if (!$teacher) {
            return null;
        }

        return $this->transformToDTO($teacher);
    }



	public function findByName($name): array 
    {
        $teachers = Teacher::where('name', 'like', "%$name%")->get();
        return $this->transformListDTO($teachers->toArray());
    }



    public function update(TeacherDTO $teacher): bool 
    {
        $teacherModel = Teacher::find($teacher->id);
        if (!$teacherModel) {
            return false;
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

        return $teacherModel->save();
    }



    public function delete($id): bool 
    {
        $teacher = Teacher::find($id);
        if (!$teacher) {
            return false;
        }
        return $teacher->delete();
    }
}
?>