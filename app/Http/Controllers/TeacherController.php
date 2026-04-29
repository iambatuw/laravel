<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TeacherController extends Controller
{
    public function csvImport(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt,xlsx,xls', 'max:2048'],
        ], [
            'csv_file.required' => 'Dosya seçmelisiniz.',
            'csv_file.mimes' => 'Dosya CSV veya Excel formatında olmalıdır.',
        ]);

        $file = $request->file('csv_file');
        $ext = strtolower($file->getClientOriginalExtension());

        if (in_array($ext, ['xlsx', 'xls'])) {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
            $header = array_map('trim', array_shift($sheetData));
            $rows = $sheetData;
        } else {
            $rows = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_map('trim', array_shift($rows));
        }

        $imported = 0;
        $skipped = 0;
        $errors = [];

        foreach ($rows as $i => $row) {
            if (count($row) < count($header)) continue;
            $data = array_combine($header, array_map('trim', $row));
            $line = $i + 2;

            $name = $data['ad_soyad'] ?? $data['ad'] ?? $data['name'] ?? '';
            $email = $data['eposta'] ?? $data['email'] ?? '';
            $branch = $data['brans'] ?? $data['branş'] ?? $data['branch'] ?? '';

            if (empty($name) || empty($email)) {
                $errors[] = "Satır {$line}: Ad veya e-posta boş.";
                continue;
            }

            if (User::where('email', $email)->exists()) {
                $skipped++;
                continue;
            }

            $password = $data['sifre'] ?? $data['password'] ?? 'password';
            $phone = $data['telefon'] ?? $data['phone'] ?? null;
            $role = $data['rol'] ?? $data['role'] ?? 'teacher';
            $roleMap = ['öğretmen' => 'teacher', 'ogretmen' => 'teacher', 'yönetici' => 'admin', 'yonetici' => 'admin'];
            $role = $roleMap[mb_strtolower($role)] ?? $role;

            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'branch' => $branch ?: null,
                'phone' => $phone,
                'role' => in_array($role, ['admin', 'teacher']) ? $role : 'teacher',
            ]);
            $imported++;
        }

        $msg = "{$imported} öğretmen başarıyla eklendi.";
        if ($skipped > 0) $msg .= " {$skipped} adet zaten kayıtlı olduğu için atlandı.";
        if (!empty($errors)) $msg .= ' ' . count($errors) . ' satırda hata: ' . implode(' | ', array_slice($errors, 0, 3));

        return redirect()->route('teachers.index')->with($imported > 0 ? 'success' : 'error', $msg);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => ['required', 'array'], 'ids.*' => ['exists:users,id']]);

        $count = 0;
        foreach ($request->ids as $id) {
            $teacher = User::find($id);
            if ($teacher && $teacher->id !== auth()->id()) {
                if ($teacher->avatar) Storage::disk('public')->delete($teacher->avatar);
                $teacher->delete();
                $count++;
            }
        }

        return redirect()->route('teachers.index')->with('success', "{$count} öğretmen başarıyla silindi.");
    }

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
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$teacher->id],
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
