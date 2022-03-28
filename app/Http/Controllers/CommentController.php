<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;

class CommentController extends Controller {

	public function store(Request $request) {
		$validator = Validator::make($request->all(), [
	        'comment' => 'required|max:500',
		    'comment_type' => 'required',
		    'name' => 'required'	
		]);

		if($validator->fails()) {
			return response()->json([
                'status' => false,
                'data' => $validator->errors()
            ], 400);
		}

		$ip_test = Http::get('https://europe-west3-devrcc.cloudfunctions.net/whatismyip');

    	$ip_address = $ip_test['ip'];

		$created = Comment::create([
			'comment' => $request->comment, 
			'ip_address' => $ip_address, 
			'comment_type' => $request->comment_type, 
			'name' => $request->name
		]);

		if( !$created) {
			return response()->json([
                'status' => false,
                'message' => 'Comment not created. Please reach out to the help section.'
            ], 500);
		}

		return response()->json([
            'status' => true,
            'message' => 'Comment created!'
        ], 200);
	}

	public function index() {
		$comments = Comment::select('comment' , 'ip_address', 'comment_type', 'name', 'created_at', 'id')
		    ->orderBy('id', 'DESC')
			->get();

		return response()->json([
            'status' => true,
            'data' => $comments,
            'total' => count($comments)
        ], 200);
	}

	public function showByName(Request $request) {
		$comments = Comment::select('comment' , 'ip_address', 'comment_type', 'name', 'created_at', 'id')
			->where('name', $request->name)
		    ->orderBy('id', 'DESC')
			->get();

		return response()->json([
            'status' => true,
            'data' => $comments,
            'total' => count($comments)
        ], 200);		
	}
}