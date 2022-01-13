<?php

namespace App\Http\Controllers\admin\author;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    function getAuthors()
    {
        $authors = User::select(
            "id",
            "f_name as first_name",
            "l_name as last_name",
            "role",
            "status",
            "email"
        )->where('role', env('AUTHOR'))->get();
        return response()->json($authors, 200);
    }
    function getAuthorById()
    {
        $authorId = request('author_id');
        if ($authorId == null) {
            return response('author id must be required', 403);
        }

        $author = User::select(
            "id",
            "f_name as first_name",
            "l_name as last_name",
            "role",
            "status",
            "email"
        )->where('id', $authorId)
            ->where('role', env('AUTHOR'))
            ->first();
        return response()->json($author, 200);
    }
    function action(Request $request)
    {
        // validating the request
        $rules = [
            'author_id' => 'required',
            'action' => 'required|in:0,1'
        ];

        $validator = Validator::make($request->all(), $rules);

        // if validation failed send response to front
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        User::find($request->author_id)->update(['status' => $request->action]);
        return response()->json(['message' => 'author status changed!']);
    }
}
