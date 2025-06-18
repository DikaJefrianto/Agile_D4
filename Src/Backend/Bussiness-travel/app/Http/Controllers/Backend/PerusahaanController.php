<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use App\Models\User;
use App\Services\RolesService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerusahaanController extends Controller
{
    public function __construct(private readonly RolesService $rolesService)
    {
    }
    /**
     * Check if the user has the required permissions.
     *
     * @param \App\Models\User $user
     * @param array $permissions
     * @return void
     */
    public function index(Request $request): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['perusahaan.view']);

        $search = $request->query('search');

        $query = Perusahaan::with('user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('email', 'like', '%' . $search . '%');
                    });
            });
        }

        $perusahaans = $query->paginate(10)->withQueryString();

        return view('backend.pages.perusahaans.index', compact('perusahaans'));
    }

    public function create(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['perusahaan.create']);

        return view('backend.pages.perusahaans.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['perusahaan.create']);

        $data = $request->validate([
            'nama'       => 'required|string|max:100',
            'username'   => 'required|string|max:255|unique:users,username',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:6|confirmed',
            'alamat'     => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
        ]);



        // Buat user baru untuk perusahaan ini
        $user = User::create([
            'name'     => $data['nama'],
            'email'    => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('Perusahaan');

        // Buat perusahaan dan kaitkan dengan user
        Perusahaan::create([
            'user_id'    => $user->id,
            'nama'       => $data['nama'],
            'username'   => $data['username'],
            'email'      => $data['email'],
            'alamat'     => $data['alamat'],
            'keterangan' => $data['keterangan'] ?? null,
        ]);

        return redirect()->route('admin.perusahaans.index')
            ->with('success', 'Perusahaan dan akun berhasil dibuat.');
    }

    public function show(int $id): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['perusahaan.view']);
        $perusahaan = Perusahaan::withCount(['karyawans'])->findOrFail($id);
        $perusahaan->load('user');
        // Pastikan perusahaan memiliki relasi dengan user
        if (!$perusahaan->user) {
            return redirect()->route('admin.perusahaans.index')
                ->with('error', 'Perusahaan tidak ditemukan atau tidak memiliki akun terkait.');
        }
        // Jika perusahaan memiliki relasi dengan user, tampilkan detailnya
        $perusahaan->load('user');
        $perusahaan->loadCount('karyawans');
        $perusahaan->load('karyawans');

        return view('backend.pages.perusahaans.show', compact('perusahaan'));
    }

    public function edit(Perusahaan $perusahaan): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['perusahaan.edit']);

        return view('backend.pages.perusahaans.edit', compact('perusahaan'));
    }

    public function update(Request $request, Perusahaan $perusahaan): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['perusahaan.edit']);

        $data = $request->validate([
            'nama'       => 'required|string|max:255',
            'username'   => 'required|string|max:255|unique:users,username,' . $perusahaan->user_id,
            'email'      => 'required|email|unique:users,email,' . $perusahaan->user_id,
            'alamat'     => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Update user terkait
        $user           = $perusahaan->user;
        $user->name     = $data['nama'];
        $user->email    = $data['email'];
        $user->username = $data['username'];
        $user->save();

        // Update data perusahaan
        $perusahaan->update([
            'nama'       => $data['nama'],
            'email'      => $data['email'],
            'username'   => $data['username'],
            'alamat'     => $data['alamat'],
            'keterangan' => $data['keterangan'] ?? $perusahaan->keterangan,
        ]);

        return redirect()->route('admin.perusahaans.index')
            ->with('success', 'Perusahaan berhasil diperbarui.');
    }

    public function destroy(Perusahaan $perusahaan): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['perusahaan.delete']);

        // Pastikan kalau ada relasi dengan user dihapus juga di model Perusahaan dengan onDelete('cascade')
        $perusahaan->delete();

        return redirect()->route('admin.perusahaans.index')
            ->with('success', 'Perusahaan dan akun berhasil dihapus.');
    }
    
}
