<?php

namespace App\Http\Controllers;

use App\Models\SystemSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Src\Modules\Settings\Actions\CreateSettingAction;
use Src\Modules\Settings\Actions\ListSettingsAction;
use Src\Modules\Settings\Actions\ShowSettingAction;
use Src\Modules\Settings\Actions\UpdateSettingAction;

class SettingController extends Controller
{
    public function __construct(
        private readonly ListSettingsAction $listSettingsAction,
        private readonly ShowSettingAction $showSettingAction,
        private readonly CreateSettingAction $createSettingAction,
        private readonly UpdateSettingAction $updateSettingAction,
    ) {
    }

    public function index(): View
    {
        $settings = $this->listSettingsAction->handle(30);

        return view('portal.settings.index', compact('settings'));
    }

    public function show(SystemSetting $setting): View
    {
        $setting = $this->showSettingAction->handle($setting);

        return view('portal.settings.show', compact('setting'));
    }

    public function create(): View
    {
        return view('portal.settings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->createSettingAction->handle($request);

        return redirect()->route('settings.index');
    }

    public function edit(SystemSetting $setting): View
    {
        return view('portal.settings.edit', compact('setting'));
    }

    public function update(Request $request, SystemSetting $setting): RedirectResponse
    {
        $this->updateSettingAction->handle($request, $setting);

        return redirect()->route('settings.index');
    }
}
