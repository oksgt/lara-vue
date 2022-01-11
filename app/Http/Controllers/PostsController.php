<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function index(){
        $posts = Post::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Posts',
            'data'    => $posts
        ], 200);
    }

    public function store(Request $request){
        //validate data
        $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'content' => 'required'
        ],
        [
            'title.required'   => 'Masukan Title!',
            'content.required' => 'Masukan Content!'
        ]
        );

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silakan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ], 400);
        } else {
            $post = Post::create([
                'title'   => $request->input('title'),
                'content' => $request->input('content')
            ]);

            if($post){
                return response()->json([
                    'success'  => true,
                    'message'  => 'Post berhasil simpan'
                ], 200);
            } else {
                return response()->json([
                    'succes'   => false,
                    'message'  => 'Post Gagal Simpan'
                ], 400);
            }
        }
    }

    public function show($id){
        $post = Post::whereId($id)->first();
        if($post){
            return response()->json([
                'success'  => true,
                'message'  => 'Detail Post',
                'data'     => $post
            ], 200);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'not found',
                'data'      => ''
            ], 400);
        }
    }

    public function update(Request $request){
        // validate data
        $validator = Validator::make($request->all(),[
            'title'   => 'required',
            'content' => 'required'
        ],
        [
            'title.required'    => 'Title tidak boleh kosong',
            'content.required'  => 'Content tidak boleh kosong'
        ]
        );

        if($validator->fails()){
            return response()->json([
                'success'    => false,
                'message'    => 'Silahkan isi yang kosong',
                'data'       => $validator->errors()
            ], 400);
        } else {
            $post = Post::whereId($request->input('id'))->update([
                'title'     => $request->input('title'),
                'content'   => $request->input('content')
            ]);

            if($post){
                return response()->json([
                    'success'   => true,
                    'message'   => 'Berhasil Update'
                ], 200);
            } else {
                return response()->json([
                    'success'   => false,
                    'message'   => 'Gagal Update'
                ], 500);
            }
        }
    }

    public function destroy($id){
        $post = Post::findOrFail($id);
        $post->delete();

        if($post){
            return response()->json([
                'success'   => true,
                'message'   => "Berhasil hapus"
            ], 200);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => "Gagal hapus"
            ], 500);
        }
    }
}
