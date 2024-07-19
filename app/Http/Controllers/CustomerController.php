<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::all();
        return view('customer', compact('customers'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => ['required'],
            'email' => ['required', 'email', 'unique:customers'],
            'password' => ['required', 'min:1'],
            'nomor_hp' => ['required'],
            'foto' => ['required', 'mimes:jpg,jpeg,png'],
            'alamat' => ['required'],
            'updated_at' => ['nullable'],
        ]);


        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '.' . $file->extension();
            // Store the file in 'storage/uploads' directory
            $file->move(public_path('storage/uploads'), $fileName);
            $validatedData['foto'] = $fileName;
        }

        // Hash the password before saving
        $validatedData['password'] = Hash::make($request->password);

        // Save the data
        Customer::create($validatedData);
        // dd($validatedData);

        return redirect()->route('customer.index')
            ->with('success', 'Customer created successfully.');
    }



    public function destroy($id): RedirectResponse
    {
        //get post by ID
        $customer = Customer::findOrFail($id);

        //delete image
        Storage::disk('public')->delete('uploads/' . $customer->foto);

        //delete post
        $customer->delete();

        //redirect to index
        return redirect()->route('customer.index')
            ->with('success', 'Customer deleted successfully.');
    }




    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found.');
        }

        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'email' => ['required', 'email', Rule::unique('customers')->ignore($customer->id)],
            'password' => ['nullable', 'min:1'], // Allow password to be nullable
            'nomor_hp' => ['required'],
            'foto' => ['nullable', 'mimes:jpg,jpeg,png'],
            'alamat' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validated();

        $customer->nama = $validatedData['nama'];
        $customer->email = $validatedData['email'];
        $customer->nomor_hp = $validatedData['nomor_hp'];
        $customer->alamat = $validatedData['alamat'];

        // Handle file upload for foto
        if ($request->hasFile('foto')) {
            // Delete old foto if exists
            if ($customer->foto && file_exists(public_path('storage/uploads/' . $customer->foto))) {
                unlink(public_path('storage/uploads/' . $customer->foto));
            }
            $file = $request->file('foto');
            $fileName = time() . '.' . $file->extension();
            $file->move(public_path('storage/uploads/'), $fileName);
            $customer->foto = $fileName;
        }

        // Hash the password before saving if it is provided
        if (!empty($validatedData['password'])) {
            $customer->password = Hash::make($validatedData['password']);
        }

        $customer->save();

        return redirect()->route('customer.index')
            ->with('success', 'Data berhasil diupdate');
    }





    public function show($id)
    {
        $customers = Customer::find($id);
        return (view('customer', compact('customers')));
    }
}
