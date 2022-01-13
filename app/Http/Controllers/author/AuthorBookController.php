<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthorBookController extends Controller
{
    function getBooks()
    {
        $books = Book::where('users_id', Auth::user()->id)->get();
        return response()->json($books, 200);
    }
    function getBooksById()
    {
        $bookId = request('book_id');
        $book = Book::where('users_id', Auth::user()->id)
            ->where('id', $bookId)
            ->first();
        return response()->json($book, 200);
    }
    function addBook(Request $request)
    {
        // validating the request
        $rules = [
            'image_url' => 'required|string',
            'book_name' => 'required|string|min:2',
        ];

        $validator = Validator::make($request->all(), $rules);

        // if validation failed send response
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            Book::create([
                'image' => $request->image_url,
                'name' => $request->book_name,
                'status' => env('ACTIVE'),
                'users_id' => Auth::user()->id,
            ]);
            return response()->json([
                'message' => 'new book added!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Unable to add a new record!'
            ], 400);
        }
    }
}
