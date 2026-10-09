<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\BrandService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $users,
        private readonly BrandService $brands,
    ) {}

    public function index(): Response
    {
        Gate::authorize('viewAny', User::class);

        return Inertia::render('Admin/Users/Index', [
            'users' => UserResource::collection($this->users->paginate()),
        ]);
    }

    public function create(Request $request): Response
    {
        Gate::authorize('create', User::class);

        return $this->form($request, null);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $this->users->create($request->validated());

        return to_route('admin.users.index')->with('success', 'User created.');
    }

    public function edit(Request $request, User $user): Response
    {
        Gate::authorize('update', $user);

        return $this->form($request, $user->load('brands:id'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $this->users->update($user, $request->validated());

        return to_route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('delete', $user);

        $this->users->delete($user);

        return back()->with('success', 'User deleted.');
    }

    private function form(Request $request, ?User $user): Response
    {
        return Inertia::render('Admin/Users/Form', [
            'user' => $user ? UserResource::make($user) : null,
            'roles' => UserRole::options(),
            'brands' => BrandResource::collection($this->brands->optionsFor($request->user())),
        ]);
    }
}
