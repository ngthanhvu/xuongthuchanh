<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;


class AddressController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'full_name' => 'required|string|max:255',
                'phone' => 'required|integer',
                'tinh_thanh' => 'required|string|max:255',
                'quan_huyen' => 'required|string|max:255',
                'xa_phuong' => 'required|string|max:255',
                'thon_xom' => 'required|string|max:255',
                'user_id' => 'required|exists:users,id',
            ]);

            $address = Address::create($validatedData);

            return response()->json([
                'message' => 'Address created successfully',
                'address' => $address
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create address',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function show(string $id)
    {
        $userId = $id;
        $addresses = Address::where('user_id', $userId)->get();
        return response()->json($addresses, 200);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        try {
            Address::where('id', $id)->delete();
            return response()->json(['message' => 'Address deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete address'], 500);
        }
    }
}