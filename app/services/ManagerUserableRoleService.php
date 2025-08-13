<?php 

namespace App\Services;

use App\DTOs\TeacherDTO;
use App\DTOs\UserableAbstract\Userable;
use App\DTOs\UserDTO;
use App\Repositories\interfaces\TeacherInterface;

class ManagerUserableRoleService{
    public function __construct(
        private TeacherInterface $teacherRepository,
    ){}

    public function create(UserDTO $user, Userable $userable){
        if($userable instanceof TeacherDTO){   
            $this->teacherRepository->create(new TeacherDTO(
                id: -1,
                name: $userable->name,
                surname: $userable->surname,
                phone: $userable->phone,
                user_id: $user->id
            ));
        }
    }
}