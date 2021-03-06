<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request['search']??"";
        $data['posts'] = Post::orderBy('id','asc')->where('name','LIKE',"%$search%")->orWhere('email','LIKE',"%$search%")->paginate(5);

        $data1['search'] = $search;

        return view('admin/admin-event', $data, $data1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:posts',
            'subject' => 'required',
            'phone' => 'required|unique:posts',
        ],[
            'name.required' => 'Name is required',
            'email.required' => 'Email is required and Unique',
            'subject.required' => 'Subject is required',
            'phone.required' => 'Phone is required and Unique',
            ]);
        $post = new Post;
        $post->name = $request->name;
        $post->email=$request->email;
        $post->subject=$request->subject;
        $post->message=$request->message;
        $post->phone=$request->phone;
        $post->save();

        return view('pages/home')
            ->with('success','Post has been created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post   $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success','Post has been deleted successfully');

    }
}
