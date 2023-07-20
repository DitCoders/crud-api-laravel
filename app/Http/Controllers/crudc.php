<?php

namespace App\Http\Controllers;

use App\Models\crudm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class crudc extends Controller
{
    public function index()
    {
        $data = crudm::all();
        return response()->json([
            'message' => 'sukses ambil semua data',
            'data' => $data
        ], 200);
    }
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
        ], 200);
    }
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
        ], 200);
    }
    public function destroy(string $id)
    {
        $data = crudm::find($id);
        $data->delete();
    }
}
