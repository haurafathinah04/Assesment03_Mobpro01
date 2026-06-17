<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return Book::latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'genre' => 'required',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imageUrl = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')
                ->store('books', 'public');

            $imageUrl = asset('storage/' . $path);
        }

        $book = Book::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'genre' => $request->genre,
            'status' => $request->status,
            'image_url' => $imageUrl,
        ]);

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'data' => $book,
        ], 201);
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'genre' => 'required',
            'status' => 'required',
        ]);

        $book->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'genre' => $request->genre,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Buku berhasil diperbarui',
            'data' => $book,
        ]);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus'
        ]);
    }
}