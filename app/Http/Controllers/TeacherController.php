<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', 'teacher')
            ->withCount('dutyAssignments')
            ->latest()
            ->paginate(10);

        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(StoreTeacherRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($data);

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Öğretmen başarıyla eklendi.');
    }

    public function show(User $teacher)
    {
        $teacher->load(['dutyAssignments.dutySchedule', 'dutyAssignments.location']);

        $recentDuties = $teacher->dutyAssignments()
            ->with(['dutySchedule', 'location'])
            ->latest()
            ->paginate(10);

        return view('teachers.show', compact('teacher', 'recentDuties'));
    }

    public function edit(User $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, User $teacher)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $teacher->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'branch' => ['required', 'string', 'max:100'],
            'role' => ['required', 'in:admin,teacher'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'name.required' => 'Ad soyad zorunludur.',
            'email.required' => 'E-posta adresi zorunludur.',
            'email.unique' => 'Bu e-posta adresi zaten kayıtlı.',
            'branch.required' => 'Branş alanı zorunludur.',
            'password.min' => 'Şifre en az 8 karakter olmalıdır.',
            'avatar.image' => 'Yüklenen dosya bir resim olmalıdır.',
            'avatar.max' => 'Resim boyutu en fazla 2MB olabilir.',
        ]);

        $data = $request->except(['password', 'password_confirmation', 'avatar']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Eski avatarı sil
            if ($teacher->avatar) {
                Storage::disk('public')->delete($teacher->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $teacher->update($data);

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Öğretmen bilgileri başarıyla güncellendi.');
    }

    public function destroy(User $teacher)
    {
        if ($teacher->avatar) {
            Storage::disk('public')->delete($teacher->avatar);
        }

        $teacher->delete(); // Soft delete

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Öğretmen başarıyla silindi.');
    }

    // Silinen öğretmenler
    public function trashed()
    {
        $teachers = User::onlyTrashed()
            ->where('role', 'teacher')
            ->paginate(10);

        return view('teachers.trashed', compact('teachers'));
    }

    // Silinen öğretmeni geri getir
    public function restore($id)
    {
        $teacher = User::onlyTrashed()->findOrFail($id);
        $teacher->restore();

        return redirect()
            ->route('teachers.trashed')
            ->with('success', 'Öğretmen başarıyla geri yüklendi.');
    }
}
