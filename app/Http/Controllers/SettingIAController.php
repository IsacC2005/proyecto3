<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingIaRequest;
use App\Models\SettingIA;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingIAController extends Controller
{
    public function index()
    {
        $data = SettingIA::first();


        $models = [
            'gemini-2.5-flash-lite',
            'gemini-2.5-flash',
            'gemini-2.5-pro',
        ];

        return Inertia::render('SettingIA/SettingIA', [
            'initialConfig' => [
                'system_instruction' => $data->system_instruction ?? '',
                'model' => $data->model ?? '',
                'key' => '',
                'temperature' => $data->temperature ?? 1
            ],
            'models' => $models
        ]);
    }

    public function store(SettingIaRequest $request)
    {

        $settings = SettingIA::create([
            'system_instruction' => $request['system_instruction'],
            'model' => $request['model'],
            'key' => $request['key'],
            'temperature' => $request['temperature']
        ]);
    }


    public function update(SettingIaRequest $request)
    {
        $settings = [
            'system_instruction' => $request['system_instruction'],
            'model' => $request['model'],
            'temperature' => $request['temperature']
        ];

        if ($request['key']) {
            $settings['key'] = $request['key'];
        }

        SettingIA::UpdateOrCreate(['id' => 1], $settings);
    }
}
