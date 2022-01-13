<?php

namespace App\Http\Controllers\admin\book;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    function getBooks()
    {
        $books = Book::select(
            "id",
            "name as book_name",
            "image as image_url",
            "status"
        )->get();
        return response()->json($books, 200);
    }
    function getBooksByAuthor()
    {
        $authorId = request('author_id');
        if ($authorId == null) {
            return response('author id must be required', 403);
        }

        $books = Book::select(
            "id",
            "name as book_name",
            "image as image_url",
            "status"
        )->where('users_id', $authorId)->get();
        return response()->json($books, 200);
    }
    function getBooksById()
    {
        $id = request('book_id');
        if ($id == null) {
            return response('author id must be required', 403);
        }

        $books = Book::select(
            "id",
            "name as book_name",
            "image as image_url",
            "status"
        )->find($id);
        return response()->json($books, 200);
    }
    function action(Request $request)
    {
        // validating the request
        $rules = [
            'book_id' => 'required',
            'action' => 'required|in:0,1'
        ];

        $validator = Validator::make($request->all(), $rules);

        // if validation failed send response to front
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        Book::find($request->book_id)->update(['status' => $request->action]);
        return response()->json(['message' => 'book status changed!']);
    }
}
