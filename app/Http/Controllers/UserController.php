<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Src\Modules\Users\Actions\CreateUserAction;
use Src\Modules\Users\Actions\ListUsersAction;
use Src\Modules\Users\Actions\ShowUserAction;
use Src\Modules\Users\Actions\UpdateUserAction;

class UserController extends Controller
{
    public function __construct(
        private readonly ListUsersAction $listUsersAction,
        private readonly ShowUserAction $showUserAction,
        private readonly CreateUserAction $createUserAction,
        private readonly UpdateUserAction $updateUserAction,
    ) {
    }

    public function index(): View
    {
        $users = $this->listUsersAction->handle(20);

        return view('portal.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $user = $this->showUserAction->handle($user);

        return view('portal.users.show', compact('user'));
    }

    public function create(): View
    {
        return view('portal.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->createUserAction->handle($request);

        return redirect()->route('users.index');
    }

    public function edit(User $user): View
    {
        return view('portal.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->updateUserAction->handle($request, $user);

        return redirect()->route('users.index');
    }
}
