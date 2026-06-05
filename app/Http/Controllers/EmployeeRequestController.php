<?php

namespace App\Http\Controllers;

use App\Models\EmployeeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Src\Modules\EmployeeRequests\Actions\CreateEmployeeRequestAction;
use Src\Modules\EmployeeRequests\Actions\GetEmployeeRequestFormOptionsAction;
use Src\Modules\EmployeeRequests\Actions\ListEmployeeRequestsAction;
use Src\Modules\EmployeeRequests\Actions\ShowEmployeeRequestAction;
use Src\Modules\EmployeeRequests\Actions\UpdateEmployeeRequestAction;

class EmployeeRequestController extends Controller
{
    public function __construct(
        private readonly ListEmployeeRequestsAction $listEmployeeRequestsAction,
        private readonly ShowEmployeeRequestAction $showEmployeeRequestAction,
        private readonly GetEmployeeRequestFormOptionsAction $getEmployeeRequestFormOptionsAction,
        private readonly CreateEmployeeRequestAction $createEmployeeRequestAction,
        private readonly UpdateEmployeeRequestAction $updateEmployeeRequestAction,
    ) {
    }

    public function index(): View
    {
        $requests = $this->listEmployeeRequestsAction->handle(20);

        return view('portal.requests.index', compact('requests'));
    }

    public function show(EmployeeRequest $request): View
    {
        $request = $this->showEmployeeRequestAction->handle($request);

        return view('portal.requests.show', compact('request'));
    }

    public function create(): View
    {
        $options = $this->getEmployeeRequestFormOptionsAction->handle();
        $employees = $options['employees'];
        $users = $options['users'];

        return view('portal.requests.create', compact('employees', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->createEmployeeRequestAction->handle($request);

        return redirect()->route('requests.index');
    }

    public function edit(EmployeeRequest $request): View
    {
        $options = $this->getEmployeeRequestFormOptionsAction->handle();
        $employees = $options['employees'];
        $users = $options['users'];

        return view('portal.requests.edit', compact('request', 'employees', 'users'));
    }

    public function update(Request $httpRequest, EmployeeRequest $request): RedirectResponse
    {
        $this->updateEmployeeRequestAction->handle($httpRequest, $request);

        return redirect()->route('requests.index');
    }
}
