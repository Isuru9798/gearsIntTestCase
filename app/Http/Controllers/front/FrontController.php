<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    function getBooks()
    {
        $books = DB::table('books')
            ->select(
                'books.id as book_id',
                'books.name as book_name',
                'books.status as book_status',
                'books.image as image_url',
                'users.id as author_id',
                'users.f_name as author_f_name',
                'users.l_name as author_l_name',
                'users.email as author_email',
            )
            ->join('users', 'users.id', 'books.users_id')
            ->where('books.status', env('ACTIVE'))
            ->where('users.status', env('ACTIVE'))
            ->get();
        return response()->json($books, 200);
    }
}
