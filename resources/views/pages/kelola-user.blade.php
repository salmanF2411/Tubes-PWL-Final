@extends('layouts.layoutAdminPanel')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-900">
        <i class="fa-solid fa-users text-blue-600 mr-2"></i>Kelola User
    </h1>
    <p class="text-slate-500 text-sm mt-1">Manajemen pengguna sistem mini market</p>
</div>

<div class="mb-6 flex items-center justify-between gap-4">
    <form action="#" class="flex-1 flex gap-3">
        <input
            type="text"
            name="q"
            placeholder="Cari user..."
            class="w-full max-w-md px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400">

        <select name="role" class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400">
            <option value="">Semua Role</option>
            <option value="owner">Owner</option>
            <option value="store_manager">Manajer Toko</option>
            <option value="supervisor">Supervisor</option>
            <option value="cashier">Kasir</option>
            <option value="warehouse_staff">Pegawai Gudang</option>
        </select>

        <button type="button" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
            <i class="fa-solid fa-search"></i>
            Filter
        </button>
    </form>
</div>

<div id="form-user" class="bg-white rounded-lg border border-slate-200 p-6 mb-8">
    <h2 class="font-bold text-slate-900 mb-4">
        Tambah User
    </h2>

    <form action="#" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Nama</label>
            <input
                name="name"
                value=""
                class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400"
                required>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
            <input
                type="email"
                name="email"
                value=""
                class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400"
                required>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">No. HP</label>
            <input
                name="phone"
                value=""
                class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
            <input
                type="password"
                name="password"
                placeholder="Minimal 6 karakter"
                class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400"
                required>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Role</label>
            <select name="role" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
                <option value="owner">Owner</option>
                <option value="store_manager">Manajer Toko</option>
                <option value="supervisor">Supervisor</option>
                <option value="cashier" selected>Kasir</option>
                <option value="warehouse_staff">Pegawai Gudang</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Cabang</label>
            <select name="store_id" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400">
                <option value="">Pusat / Owner</option>
                <option value="1">Cabang Cianjur</option>
                <option value="2">Cabang Bandung</option>
                <option value="3">Cabang Bogor</option>
                <option value="4">Cabang Sukabumi</option>
                <option value="5">Cabang Jakarta</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
            <select name="status" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-400" required>
                <option value="active" selected>Aktif</option>
                <option value="inactive">Nonaktif</option>
            </select>
        </div>

        <div class="flex items-end gap-3">
            <button type="button" class="px-4 py-2 rounded-lg transition inline-flex items-center gap-2 text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
                <i class="fa-solid fa-save"></i>
                Simpan
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h2 class="font-bold text-slate-900">Daftar User</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200">
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Nama</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Email</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Role</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Cabang</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Status</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-900">Jayusman</td>
                    <td class="px-6 py-4 text-slate-600">owner@jayusmanmart.com</td>
                    <td class="px-6 py-4 text-slate-600">Owner</td>
                    <td class="px-6 py-4 text-slate-600">Pusat</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            Aktif
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="#form-user" class="text-blue-600 hover:text-blue-700" title="Edit">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button type="button" class="text-red-600 hover:text-red-700" title="Nonaktifkan">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-900">Budi Santoso</td>
                    <td class="px-6 py-4 text-slate-600">manager.cianjur@jayusmanmart.com</td>
                    <td class="px-6 py-4 text-slate-600">Manajer Toko</td>
                    <td class="px-6 py-4 text-slate-600">Cabang Cianjur</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            Aktif
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="#form-user" class="text-blue-600 hover:text-blue-700" title="Edit">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button type="button" class="text-red-600 hover:text-red-700" title="Nonaktifkan">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-900">Siti Aminah</td>
                    <td class="px-6 py-4 text-slate-600">supervisor.bandung@jayusmanmart.com</td>
                    <td class="px-6 py-4 text-slate-600">Supervisor</td>
                    <td class="px-6 py-4 text-slate-600">Cabang Bandung</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            Aktif
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="#form-user" class="text-blue-600 hover:text-blue-700" title="Edit">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button type="button" class="text-red-600 hover:text-red-700" title="Nonaktifkan">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-900">Rizki Maulana</td>
                    <td class="px-6 py-4 text-slate-600">kasir.bogor@jayusmanmart.com</td>
                    <td class="px-6 py-4 text-slate-600">Kasir</td>
                    <td class="px-6 py-4 text-slate-600">Cabang Bogor</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            Aktif
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="#form-user" class="text-blue-600 hover:text-blue-700" title="Edit">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button type="button" class="text-red-600 hover:text-red-700" title="Nonaktifkan">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr class="border-b border-slate-100 hover:bg-blue-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-900">Dewi Lestari</td>
                    <td class="px-6 py-4 text-slate-600">gudang.sukabumi@jayusmanmart.com</td>
                    <td class="px-6 py-4 text-slate-600">Pegawai Gudang</td>
                    <td class="px-6 py-4 text-slate-600">Cabang Sukabumi</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            Aktif
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="#form-user" class="text-blue-600 hover:text-blue-700" title="Edit">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button type="button" class="text-red-600 hover:text-red-700" title="Nonaktifkan">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr class="hover:bg-blue-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-900">Andi Saputra</td>
                    <td class="px-6 py-4 text-slate-600">kasir.jakarta@jayusmanmart.com</td>
                    <td class="px-6 py-4 text-slate-600">Kasir</td>
                    <td class="px-6 py-4 text-slate-600">Cabang Jakarta</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-600">
                            Nonaktif
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="#form-user" class="text-blue-600 hover:text-blue-700" title="Edit">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <button type="button" class="text-red-600 hover:text-red-700" title="Nonaktifkan">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection