<?php

namespace App\Http\Controllers;

use App\Models\SettingIA;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingIAController extends Controller
{
    public function index()
    {
        $data = SettingIA::first();
        return Inertia::render('SettingIA/SettingIA', [
            'initialConfig' => [
                'system_instruction' => $data->system_instruction,
                'model' => $data->model,
                'key' => $data->key,
                'temperature' => $data->temperature
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'system_instruction' => 'required|string',
            'model' => 'required|string',
            'key' => 'required|string',
            'temperature' => 'required|numeric'
        ]);

        SettingIA::query()->delete(); // Borra todos los registros

        $settings = SettingIA::create([
            'system_instruction' => $request->input('system_instruction'),
            'model' => $request->input('model'),
            'key' => $request->input('key'),
            'temperature' => $request->input('temperature')
        ]);
    }
}
