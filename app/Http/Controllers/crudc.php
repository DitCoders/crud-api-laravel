<?php

namespace App\Http\Controllers;

use App\Models\crudm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class crudc extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = crudm::get();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'info' => 'required|string',
        ]);
        if ($validasi->fails()) {
            return response()->json([
                'message' => $validasi->errors()
            ]);
        }
        $data = crudm::create([
            'name' => $request->name,
            'info' => $request->info
        ]);
        return response()->json([
            'message' => 'Berhasil menambahkan data'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'info' => 'required|string'
        ]);
        if ($validasi->fails()) {
            return response()->json([
                'message' => $validasi->errors()
            ]);
        }
        $data = crudm::find($id);
        $data->update([
            'name' => $request->name,
            'info'  => $request->info
        ]);
        return response()->json([
            'message' => 'Data berhasil diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = crudm::find($id);
        $data->delete();
    }
}
