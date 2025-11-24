<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\User\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function index(Request $request): View
    {
        $users = $this->userService->getAllUsers($request->input('search'));
        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'whatsapp_number' => 'required|string|max:20',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'is_active' => 'boolean',
        ]);

        $userDTO = new CreateUserDTO(
            roleId: (int)$request->input('role_id'),
            name: $request->input('name'),
            phone: $request->input('phone'),
            whatsappNumber: $request->input('whatsapp_number'),
            username: $request->input('username'),
            password: $request->input('password'),
            isActive: (bool)$request->input('is_active', true)
        );

        $this->userService->createUser($userDTO);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم إضافة المستخدم بنجاح');
    }

    public function edit(int $userId): View
    {
        $user = $this->userService->findUserById($userId);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, int $userId): RedirectResponse
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'whatsapp_number' => 'required|string|max:20',
            'username' => 'required|string|max:50|unique:users,username,' . $userId,
            'password' => 'nullable|string|min:6',
            'is_active' => 'boolean',
        ]);

        $userDTO = new UpdateUserDTO(
            roleId: (int)$request->input('role_id'),
            name: $request->input('name'),
            phone: $request->input('phone'),
            whatsappNumber: $request->input('whatsapp_number'),
            username: $request->input('username'),
            password: $request->input('password'),
            isActive: (bool)$request->input('is_active', true)
        );

        $this->userService->updateUser($userId, $userDTO);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم تحديث المستخدم بنجاح');
    }

    public function destroy(int $userId): RedirectResponse
    {
        $this->userService->deleteUser($userId);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }
}
