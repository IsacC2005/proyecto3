<?php


namespace App\DTOs\Details;

use App\DTOs\Details\LearningProjectDetailDTO;

class TicketDetailDTO implements DTODetail
{
    public function __construct(
        public int $id,
        public int $assistence,
        public int $absence,
        public string $teacherName,
        public string $section,
        public string $studentName,
        public string $schoolId,
        public string $schoolYear,
        public string $schoolMoment,
        public string $average,
        public string $content,
        public string $suggestions,
        public string $projectTitle
    ) {}
}
