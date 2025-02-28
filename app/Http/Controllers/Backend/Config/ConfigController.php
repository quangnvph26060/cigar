<?php

namespace App\Http\Controllers\Backend\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Config\ConfigRequest;
use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function config()
    {
        return view('backend.config.save');
    }

    public function postConfig(ConfigRequest $request)
    {
        return transaction(function () use ($request) {
            $credentials = $request->validated();

            $config = Config::query()->first();

            if ($request->hasFile('logo')) {
                $credentials['logo'] = saveImages($request, 'logo', 'logo');
                deleteImage($config->logo);
            }

            if ($request->hasFile('icon')) {
                $credentials['icon'] = saveImages($request, 'icon', 'icon');
                deleteImage($config->icon);
            }

            $config->update($credentials);

            return handleResponse('Lưu thay đổi thành công.', 200);
        });
    }
}
