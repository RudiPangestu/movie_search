<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch only the products of the logged-in user
        $produk = Auth::user()->produks;
        return view('produk.index', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input data
        $request->validate([
            'nama' => 'required|max:255',
            'jenis' => 'required|max:255',
            'release_year' => 'required|numeric',
            'actors' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ],
        [
            'nama.required' => 'Nama wajib diisi',
            'nama.max' => 'Nama maksimal 255 karakter',
            'jenis.required' => 'Jenis wajib diisi',
            'jenis.max' => 'Jenis maksimal 255 karakter',
            'foto.max' => 'Foto maksimal 2 MB',
            'foto.mimes' => 'File ekstensi hanya bisa jpg, png, jpeg, gif, svg',
            'foto.image' => 'File harus berbentuk image'
        ]);
        
        // Handle file upload
        $fileName = 'nophoto.jpg'; // Default image
        if($request->hasFile('foto')){
            $fileName = 'foto-' . uniqid() . '.' . $request->foto->extension();
            $request->foto->move(public_path('image'), $fileName);
        }
        
        // Create the product and associate with logged-in user
        try {
            Auth::user()->produks()->create([
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'release_year' => $request->release_year,
                'actors' => $request->actors,
                'deskripsi' => $request->deskripsi ?? '',
                'foto' => $fileName,
            ]);
            
            return redirect()->route('index.index')
                ->with('success', 'Produk berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ensure the user can only edit their own products
        $produk = Auth::user()->produks()->findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the product belonging to the logged-in user
        $produk = Auth::user()->produks()->findOrFail($id);

        // Validate input data
        $request->validate([
            'nama' => 'required|max:255',
            'jenis' => 'required|max:255',
            'release_year' => 'required|numeric',
            'actors' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ],
        [
            'nama.required' => 'Nama wajib diisi',
            'nama.max' => 'Nama maksimal 255 karakter',
            'jenis.required' => 'Jenis wajib diisi',
            'jenis.max' => 'Jenis maksimal 255 karakter',
            'foto.max' => 'Foto maksimal 2 MB',
            'foto.mimes' => 'File ekstensi hanya bisa jpg, png, jpeg, gif, svg',
            'foto.image' => 'File harus berbentuk image'
        ]);
 
        // Handle file upload
        $fileName = $produk->foto; // Keep existing image by default
        if($request->hasFile('foto')){
            // Delete old image if exists (except default)
            if($fileName !== 'nophoto.jpg' && file_exists(public_path('image/' . $fileName))){
                unlink(public_path('image/' . $fileName));
            }
            
            // Upload new image
            $fileName = 'foto-' . uniqid() . '.' . $request->foto->extension();
            $request->foto->move(public_path('image'), $fileName);
        }
 
        // Update the product
        try {
            $produk->update([
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'release_year' => $request->release_year,
                'actors' => $request->actors,
                'deskripsi' => $request->deskripsi ?? '',
                'foto' => $fileName,
            ]);
            
            return redirect()->route('index.index')
                ->with('success', 'Produk berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupdate produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find and delete only the user's own product
        $produk = Auth::user()->produks()->findOrFail($id);
        
        // Delete associated image file if not default
        if($produk->foto !== 'nophoto.jpg' && file_exists(public_path('image/' . $produk->foto))){
            unlink(public_path('image/' . $produk->foto));
        }
        
        // Delete the product
        try {
            $produk->delete();
            
            return redirect()->route('index.index')
                ->with('success', 'Produk berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    /**
     * Add product to wishlist
     */
    public function addToWishlist(Request $request)
    {
        // Validate input data
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'nullable|string|max:255',
            'release_year' => 'required|numeric',
            'actors' => 'required|string|max:255',
            'foto' => 'nullable|string|max:255',
        ]);

        try {
            // Create the product and associate with logged-in user
            Auth::user()->produks()->create([
                'nama' => $validatedData['nama'],
                'jenis' => $validatedData['jenis'] ?? '',
                'release_year' => $validatedData['release_year'],
                'actors' => $validatedData['actors'],
                'foto' => $validatedData['foto'] ?? 'nophoto.jpg', 
            ]);

            return response()->json([
                'message' => 'Film berhasil ditambahkan ke wishlist.',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menambahkan film: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }
}