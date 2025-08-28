<?php

namespace App\Factories;

use App\DTOs\Details\DailyClassDetailDTO;
use App\DTOs\Summary\DTOSummary;
use Illuminate\Http\Request;
use App\DTOs\Details\DTODetail;
use App\DTOs\Details\ItemEvaluationDetailDTO;
use App\DTOs\Summary\DailyClassDTO;
use DateTime;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Validator;

class DailyClassFactory implements Factory
{
    public static function fromRequest(Request $request): DailyClassDTO
    {
        $validator = Validator::make($request->all(), [
            'grade' => 'required|integer|min:0 |max:6',
            'secction' => 'required|string|max:1',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->messages());
        }

        return new DailyClassDTO(
            id: 0,
            date: new DateTime(),
            title: '',
            content: '',
            learningProjectId: -0,
        );
    }

    public static function fromRequestDetail(Request $request): DailyClassDetailDTO
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'string|nullable',
            'indicators' => 'array|nullable',
            'indicators*title' => 'string|nullable|max:255'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->messages());
        }

        $data = new DailyClassDetailDTO(
            id: 0,
            date: new DateTime(),
            title: $request->input('title'),
            content: $request->input('content') ? $request->input('content') : '',
            learningProject: null,
        );

        if ($request->input('indicators')) {
            foreach ($request->input('indicators') as $item) {
                $data->addItemEvaluation(new ItemEvaluationDetailDTO(
                    id: $item['id'] ?? 0,
                    title: $item['title']
                ));
            }
        }

        return $data;
    }

    public static function fromArray(array $data): DTOSummary
    {
        return new DailyClassDTO(
            id: $data['id'] ?? 0,
            date: isset($data['date']) ? new DateTime($data['date']) : new DateTime(),
            title: $data['title'] ?? '',
            content: $data['content'] ?? '',
            learningProjectId: $data['learningProjectId'] ?? 0,
        );
    }

    public static function fromArrayDetail(array $data): DTODetail
    {
        return new DailyClassDetailDTO(
            id: $data['id'] ?? 0,
            date: isset($data['date']) ? new DateTime($data['date']) : new DateTime(),
            title: $data['title'] ?? '',
            content: $data['content'] ?? '',
            learningProject: isset($data['learningProject']) ? LearningProjectFactory::fromArray($data['learningProject']) : null,
        );
    }
}
