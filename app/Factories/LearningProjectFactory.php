<?php

namespace App\Factories;

use App\DTOs\Details\LearningProjectDetailDTO;
use App\DTOs\Summary\LearningProjectDTO;
use App\DTOs\Summary\StudentDTO;
use Dotenv\Exception\ValidationException;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DTOs\Summary\DTOSummary;
use App\DTOs\Details\DTODetail;
use App\Exceptions\Teacher\TeacherNotFindException;

class LearningProjectFactory implements Factory
{



    public static function fromRequest(Request $request): LearningProjectDTO
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'schoolMoment' => 'required|integer|in:1,2,3'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->messages());
        }

        // Si la validación pasa, crea y retorna el DTO.
        return new LearningProjectDTO(
            id: 0,
            title: $request->input('title'),
            content: $request->input('content'),
            schoolMoment: $request->input('schoolMoment')
        );
    }




    public static function fromRequestDetail(Request $request): LearningProjectDetailDTO
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string|max:100000',
            'schoolMoment' => 'required|integer|in:1,2,3',
            'dailyClasses' => 'required|array',
            'dailyClasses.*.title' => 'required|string|max:255',
            'dailyClasses.*.content' => 'nullable|string|max:100000',

        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->messages());
        }

        /**
         *  TODO: aqui se esta validando si el teacher se a enviado solo el id o un array completo
         *  TODO: ya que las formas para despues crear el DTODetail de teacher son distintas
         */

        if ($request->input('teacher') !== null) {
            /**
             * #
             * #
             * #
             */
        } elseif ($request->input('teacherId') !== null) {
            $teacher = TeacherFactory::fromArrayDetail([
                'id' => $request->input('teacherId')
            ]);
        }

        /**
         *  TODO: aqui se esta validando si al Enrollment se a enviado solo el id o un array completo
         *  TODO: ya que las formas para despues crear el DTODetail de enrollment son distintas
         */

        if ($request->input('enrollment') !== null) {
            /**
             * #
             * #
             * #
             */
        } elseif ($request->input('enrollmentId') !== null) {
            $enrollment = EnrollmentFactory::fromArrayDetail([
                'id' => $request->input('enrollmentId')
            ]);
        }

        $project = new LearningProjectDetailDTO(
            id: 0,
            title: $request->input('title'),
            content: $request->input('content') ? $request->input('content') : '',
            schoolMoment: $request->input('schoolMoment'),
            teacher: $teacher ?? null,
            enrollment: $enrollment ?? null
        );

        if ($request->input('dailyClasses')) {
            $data = $request->input('dailyClasses');

            foreach ($data as $item) {
                $project->addDailyClasses(DailyClassFactory::fromArray($item));
            }
        }

        return $project;
    }




    public static function fromArray(array $data): DTOSummary
    {
        return new LearningProjectDTO(
            id: $data['id'] ?? 0,
            title: $data['title'] ?? '',
            content: $data['content'] ?? '',
            schoolMoment: $data['schoolMoment'] ?? -1
        );
    }

    public static function fromArrayDetail(array $data): DTODetail
    {
        return new LearningProjectDetailDTO(
            id: $data['id'] ?? 0,
            title: $data['title'] ?? '',
            content: $data['content'] ?? '',
            schoolMoment: $data['schoolMoment'] ?? -1,
            teacher: isset($data['teacher']) ? TeacherFactory::fromArray($data['teacher']) : null,
            enrollment: isset($data['enrollment']) ? EnrollmentFactory::fromArray($data['enrollment']) : null
        );
    }
}
