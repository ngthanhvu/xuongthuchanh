<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Validation\ValidationException;
use Exception;

class AddressController extends Controller
{
    public function index()
    {
        return response()->json(Address::all(), 200);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'full_name'  => 'required|string|max:255',
                'phone'      => 'required|digits_between:10,15',
                'tinh_thanh' => 'required|string|max:255',
                'quan_huyen' => 'required|string|max:255',
                'xa_phuong'  => 'required|string|max:255',
                'thon_xom'   => 'required|string|max:255',
                'user_id'    => 'required|exists:users,id',
            ]);

            $address = Address::create($validatedData);

            return response()->json([
                'message' => 'Address created successfully',
                'address' => $address
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to create address', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(string $userId)
    {
        $addresses = Address::where('user_id', $userId)->get();
        return response()->json($addresses, 200);
    }

    public function update(Request $request, string $id)
    {
        try {
            $address = Address::findOrFail($id);

            $validatedData = $request->validate([
                'full_name'  => 'sometimes|string|max:255',
                'phone'      => 'sometimes|digits_between:10,15',
                'tinh_thanh' => 'sometimes|string|max:255',
                'quan_huyen' => 'sometimes|string|max:255',
                'xa_phuong'  => 'sometimes|string|max:255',
                'thon_xom'   => 'sometimes|string|max:255',
            ]);

            $address->update($validatedData);

            return response()->json(['message' => 'Address updated successfully', 'address' => $address], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to update address', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $address = Address::findOrFail($id);
            $address->delete();

            return response()->json(['message' => 'Address deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to delete address', 'error' => $e->getMessage()], 500);
        }
    }
}
