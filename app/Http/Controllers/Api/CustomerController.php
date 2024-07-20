<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Dotenv\Parser\Value;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        $dataCustomer = Customer::all();
        return response()->json($dataCustomer);
    }

    public function show(string $id)
    {

        $dataCustomer = Customer::find($id);

        if ($dataCustomer) {
            return response()->json([
                'status' => "okeh",
                'message' => "data customer ditemukan",
                "data" => $dataCustomer,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "data customer tidak ditemukan",
            ]);
        }
    }

    // public function store(Request $request)
    // {
    //     $addCustomer = new Customer;
    //     $addCustomer->nama = $request->nama;
    //     $addCustomer->email = $request->email;
    //     $addCustomer->password = Hash::make($request->password);
    //     $addCustomer->foto = $request->foto;
    //     $addCustomer->nomor_hp = $request->nomor_hp;
    //     $addCustomer->alamat = $request->alamat;

    //     $addCustomer->save();

    //     if ($addCustomer) {

    //         return response()->json([
    //             'status' => 200,
    //             'message' => "data customer ditambahkan",
    //             "data" => $addCustomer,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 404,
    //             'message' => "data customer gagal",
    //         ]);
    //     }
    // }


    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'nama' => ['required'],
            'email' => ['required', 'email', 'unique:customers'],
            'password' => ['required', 'min:1'],
            'nomor_hp' => ['required'],
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            // 'foto' => ['nullable'],
            // foto disini memang nullable , tetapi saat di front end wajib validasi dikarenakan error di postman
            'alamat' => ['required'],
            'updated_at' => ['nullable'],
        ]);

        try {
            // Buat instance Customer baru
            $addCustomer = new Customer;
            $addCustomer->nama = $validatedData['nama'];
            $addCustomer->email = $validatedData['email'];
            $addCustomer->password = Hash::make($validatedData['password']);
            $addCustomer->foto = $validatedData['foto'] ?? null;
            $addCustomer->nomor_hp = $validatedData['nomor_hp'] ?? null;
            $addCustomer->alamat = $validatedData['alamat'] ?? null;


            // Menangani upload file foto
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                // Pindahkan file ke direktori 'public/storage/uploads'
                $file->move(public_path('storage/uploads'), $fileName);
                $addCustomer->foto = $fileName;
            } else {
                $addCustomer->foto = null;
            }

            // Simpan data customer
            $addCustomer->save();

            // Return response jika data berhasil disimpan
            return response()->json([
                'status' => 200,
                'message' => "Data customer ditambahkan",
                'data' => $addCustomer,
            ], 200);
        } catch (\Exception $e) {
            // Return response jika terjadi error
            return response()->json([
                'status' => 500,
                'message' => "Data customer gagal ditambahkan",
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:customers,email,' . $id,
            'password' => 'nullable|min:1',
            'nomor_hp' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'alamat' => 'required',
        ]);

        try {
            // Temukan customer berdasarkan ID
            $customer = Customer::findOrFail($id);

            // Perbarui data customer
            $customer->nama = $validatedData['nama'];
            $customer->email = $validatedData['email'];

            if ($request->filled('password')) {
                $customer->password = Hash::make($validatedData['password']);
            }

            $customer->nomor_hp = $validatedData['nomor_hp'];
            $customer->alamat = $validatedData['alamat'];

            // Menangani upload file foto
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($customer->foto) {
                    $oldFilePath = public_path('storage/uploads') . '/' . $customer->foto;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                // Upload foto baru
                $file = $request->file('foto');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/uploads'), $fileName);
                $customer->foto = $fileName;
            }

            // Simpan data customer yang diperbarui
            $customer->save();

            // Return response jika data berhasil diperbarui
            return response()->json([
                'status' => 200,
                'message' => "Data customer diperbarui",
                'data' => $customer,
            ], 200);
        } catch (\Exception $e) {
            // Return response jika terjadi error
            return response()->json([
                'status' => 500,
                'message' => "Data customer gagal diperbarui",
                'error' => $e->getMessage(),
            ], 500);
        }
    }




    public function destroy($id)
    {
        try {
            // Temukan customer berdasarkan ID
            $customer = Customer::findOrFail($id);

            // Hapus foto jika ada
            if ($customer->foto) {
                $filePath = public_path('storage/uploads') . '/' . $customer->foto;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Hapus data customer
            $customer->delete();

            // Return response jika data berhasil dihapus
            return response()->json([
                'status' => 200,
                'message' => "Data customer berhasil dihapus",
            ], 200);
        } catch (\Exception $e) {
            // Return response jika terjadi error
            return response()->json([
                'status' => 500,
                'message' => "Data customer gagal dihapus",
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
