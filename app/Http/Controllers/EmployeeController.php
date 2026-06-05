<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Src\Modules\Employees\Actions\CreateEmployeeAction;
use Src\Modules\Employees\Actions\GetEmployeeFormOptionsAction;
use Src\Modules\Employees\Actions\ListEmployeesAction;
use Src\Modules\Employees\Actions\ShowEmployeeAction;
use Src\Modules\Employees\Actions\UpdateEmployeeAction;

class EmployeeController extends Controller
{
    public function __construct(
        private readonly ListEmployeesAction $listEmployeesAction,
        private readonly ShowEmployeeAction $showEmployeeAction,
        private readonly GetEmployeeFormOptionsAction $getEmployeeFormOptionsAction,
        private readonly CreateEmployeeAction $createEmployeeAction,
        private readonly UpdateEmployeeAction $updateEmployeeAction,
    ) {
    }

    public function index(): View
    {
        $employees = $this->listEmployeesAction->handle(20);

        return view('portal.employees.index', compact('employees'));
    }

    public function show(Employee $employee): View
    {
        $employee = $this->showEmployeeAction->handle($employee);

        return view('portal.employees.show', compact('employee'));
    }

    public function create(): View
    {
        $options = $this->getEmployeeFormOptionsAction->handle();
        $pharmacies = $options['pharmacies'];
        $users = $options['users'];

        return view('portal.employees.create', compact('pharmacies', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->createEmployeeAction->handle($request);

        return redirect()->route('employees.index');
    }

    public function edit(Employee $employee): View
    {
        $options = $this->getEmployeeFormOptionsAction->handle();
        $pharmacies = $options['pharmacies'];
        $users = $options['users'];

        return view('portal.employees.edit', compact('employee', 'pharmacies', 'users'));
    }

    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $this->updateEmployeeAction->handle($request, $employee);

        return redirect()->route('employees.index');
    }
}
