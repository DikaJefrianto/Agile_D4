<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    public function index(Request $request): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['karyawan.view']);

        $search = $request->query('search');

        $query = Karyawan::with('perusahaan', 'user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('email', 'like', '%' . $search . '%');
                    });
            });
        }

        $karyawans = $query->paginate(10)->withQueryString();

        return view('backend.pages.karyawans.index', compact('karyawans'));
    }

    public function create(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['karyawan.create']);

        $perusahaans = Perusahaan::all();
        return view('backend.pages.karyawans.create', compact('perusahaans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['karyawan.create']);

        $data = $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:8|confirmed',
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'no_hp'         => 'required|string|max:15',
            'alamat'        => 'required|string|max:255',
            'jabatan'       => 'required|string|max:255',
            'foto'          => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('karyawan_foto', 'public');
        }

        // Buat akun user
        $user = User::create([
            'name'     => $data['nama_lengkap'],
            'email'    => $data['email'],
            'username' => strtolower(str_replace(' ', '_', $data['nama_lengkap'])),
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole('Karyawan');

        // Simpan data karyawan
        Karyawan::create([
            'nama_lengkap'  => $data['nama_lengkap'],
            'no_hp'         => $data['no_hp'] ?? null,
            'alamat'        => $data['alamat'] ?? null,
            'jabatan'       => $data['jabatan'] ?? null,
            'foto'          => $fotoPath,
            'user_id'       => $user->id,
            'perusahaan_id' => $data['perusahaan_id'],
        ]);

        return redirect()->route('admin.karyawans.index')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function show(Karyawan $karyawan): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['karyawan.view']);

        $karyawan->load('user', 'perusahaan');
        return view('backend.pages.karyawans.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['karyawan.edit']);

        $perusahaans = Perusahaan::all();
        $karyawan->load('user');
        return view('backend.pages.karyawans.edit', compact('karyawan', 'perusahaans'));
    }

    public function update(Request $request, Karyawan $karyawan): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['karyawan.edit']);

        $data = $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => ['required', 'email', Rule::unique('users', 'email')->ignore($karyawan->user_id)],
            'password'      => 'nullable|string|min:8|confirmed',
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'no_hp'         => 'nullable|string|max:15',
            'alamat'        => 'nullable|string|max:255',
            'jabatan'       => 'nullable|string|max:255',
            'foto'          => 'nullable|image|max:2048',
        ]);

        // Update akun user
        $user        = $karyawan->user;
        $user->name  = $data['nama_lengkap'];
        $user->email = $data['email'];
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        // Handle upload foto baru
        if ($request->hasFile('foto')) {
            $fotoPath       = $request->file('foto')->store('karyawan_foto', 'public');
            $karyawan->foto = $fotoPath;
        }

        // Update data karyawan
        $karyawan->update([
            'nama_lengkap'  => $data['nama_lengkap'],
            'no_hp'         => $data['no_hp'] ?? null,
            'alamat'        => $data['alamat'] ?? null,
            'jabatan'       => $data['jabatan'] ?? null,
            'perusahaan_id' => $data['perusahaan_id'],
        ]);

        return redirect()->route('admin.karyawans.index')
            ->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['karyawan.delete']);
        $karyawan->delete();

        return redirect()->route('admin.karyawans.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}
