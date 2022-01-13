<?php

namespace App\Http\Controllers\author;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
