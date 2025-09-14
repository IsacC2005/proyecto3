<?php

namespace App\DTOs\Details;

use App\DTOs\Summary\DailyClassDTO;

class NotesDetailDTO
{
    private $projectId = 0;
    private $classes = [];
    private $allNotes = [];

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->projectId;
    }

    /**
     * @param int $projectId
     */
    public function setProjectId(int $projectId): void
    {
        $this->projectId = $projectId;
    }

    /**
     * @return array
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    /**
     * @param array $classes
     */
    public function setClasses(array $classes): void
    {
        $this->classes = $classes;
    }

    /**
     * @return array
     */
    public function getAllNotes(): array
    {
        return $this->allNotes;
    }

    /**
     * @param array $allNotes
     */
    public function setAllNotes(array $allNotes): void
    {
        $this->allNotes = $allNotes;
    }

    public function toArray(): array
    {
        return [
            'projectId' => $this->projectId,
            'classes' => $this->getClasses(),
            'notes' => $this->getAllNotes(),
        ];
    }
}
