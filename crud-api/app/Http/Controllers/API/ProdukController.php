<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'jenis_produk' => 'required',
            'detail_produk' => 'required',
            'harga_produk' => 'required',
        ]);

        $user = $request->user();
        $data = $request->only('nama_produk', 'jenis_produk', 'detail_produk', 'harga_produk');
        $data['user_id'] = $user->id;

        $produk = Produk::create($data);

        return response()->json(['message' => 'Produk berhasil dibuat', 'produk' => $produk], 201);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $produks = Produk::where('user_id', $user->id)->get();

        return response()->json(['produks' => $produks]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required',
            'jenis_produk' => 'required',
            'detail_produk' => 'required',
            'harga_produk' => 'required',
        ]);

        $user = $request->user();
        $produk = Produk::where('user_id', $user->id)->find($id);

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $data = $request->only('nama_produk', 'jenis_produk', 'detail_produk', 'harga_produk');
        $produk->update($data);

        return response()->json(['message' => 'Produk berhasil diupdate', 'produk' => $produk]);
    }

    public function delete(Request $request, $id)
    {
        $user = $request->user();
        $produk = Produk::where('user_id', $user->id)->find($id);

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $produk->delete();

        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
    public function getProdukById(Request $request, $id)
    {
        $user = $request->user();
        $produk = Produk::where('user_id', $user->id)->find($id);

        if (!$produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json(['produk' => $produk]);
    }
}
