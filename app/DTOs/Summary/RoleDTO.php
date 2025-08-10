<?php 

namespace App\DTOs\Summary;

class RoleDTO  implements DTOSummary{
    private $permisions = [];
    public function __construct(
        public int $id,
        public String $name,
    ){}



    public function addPermision(int... $ids): void{
        foreach($ids as $id){
            $this->permisions[] = $id;
        }
    }



    public function removePermision(int $id): void {
        $key = array_search($id, $this->permisions);

        if($key !== false){
            unset($this->permisions[$key]);
            $this->permisions = array_values($this->permisions);
        }
    }



    public function getPermisions (): array{
        return $this->permisions;
    }
}