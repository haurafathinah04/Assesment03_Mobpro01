<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $email = $request->query('user_email');

        $data = Book::where(
            'user_email',
            $email
        )
        ->latest()
        ->get();

        foreach ($data as $book) {

            $book->cover =
                url('storage/' . $book->cover);
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {

            $request->validate([

                'user_email' => 'required',

                'title' => 'required',

                'author' => 'required',

                'publisher' => 'required',

                'year' => 'required',

                'cover' => 'required|image'
            ]);

            $path = $request
                ->file('cover')
                ->store(
                    'books',
                    'public'
                );

            Book::create([

                'user_email' =>
                $request->user_email,

                'title' =>
                $request->title,

                'author' =>
                $request->author,

                'publisher' =>
                $request->publisher,

                'year' =>
                $request->year,

                'cover' =>
                $path
            ]);

            return response()->json([
                'status' => 'success'
            ]);

        } catch (Exception $e) {

            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function update(
        Request $request,
        $id
    )
    {
        try {

            $book =
                Book::findOrFail($id);

            $book->update([

                'title' =>
                $request->title,

                'author' =>
                $request->author,

                'publisher' =>
                $request->publisher,

                'year' =>
                $request->year
            ]);

            return response()->json([
                'status' => 'success'
            ]);

        } catch (Exception $e) {

            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {

            $book =
                Book::findOrFail($id);

            Storage::disk('public')
                ->delete($book->cover);

            $book->delete();

            return response()->json([
                'status' => 'success'
            ]);

        } catch (Exception $e) {

            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    }
}
