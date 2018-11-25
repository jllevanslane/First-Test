<?php

namespace App\Http\Controllers;

use App\Post;
use App\Like;
use App\Tag;
use Auth;
use Gate;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /*
     * Get the main Post view.
     */
    public function getIndex() {
        $posts = Post::orderBy('created_at', 'desc')->paginate(2);
        return view('blog.index', ['posts' => $posts]);
    }

    /*
     * Get a view for a specific post.
     */
    public function getPost($id) {
        $post = Post::where('id', '=', $id)->first();
        return view('blog.post', ['post' => $post]);
    }

    /*
     * Add a new like for this post.
     */
    public function getPostLike($id) {
        $post = Post::find($id);
        $like = new Like();
        $post->likes()->save($like);
        return redirect()->back();
    }

    /*
     * Get the main view for the admin page.
     */
    public function getAdminIndex(Request $request) {
        $posts = Post::orderBy('title', 'asc')->get();
        return view( 'admin.index', ['posts' => $posts]);
    }

    /*
     * Get view for creating a new post.
     */
    public function getAdminCreate() {
        $tags = Tag::all();
        return view('admin.create', ['tags' => $tags]);
    }

    /*
     * Create a new post.
     */
    public function postAdminCreate(Request $request) {
        $this->validate($request, [
            'title'   => 'required | min:5',
            'content' => 'required | min:10'
        ]);
        $user = Auth::user();
        if (!$user) {
            return redirect()->back();
        }

        $post = new Post([ 'title' => $request->input('title'), 'content' => $request->input('content') ]);
        $user->posts()->save($post);
        $post->tags()->attach($request->input('tags') === null ? [] : $request->input('tags'));
        return redirect()->route('admin.index')->with('info', 'Post added. Title: ' .$request->input('title'));
    }

    /*
     * Get view to edit a post.
     */
    public function getAdminEdit($id) {
        $post = Post::find($id);
        $tags = Tag::all();
        return view('admin.edit', ['post' => $post, 'tags' => $tags]);
    }

    /*
     * Edit a post.
     */
    public function postAdminEdit(Request $request) {
        $this->validate($request, [
            'title'   => 'required | min:5',
            'content' => 'required | min:10'
        ]);
        $post = Post::find($request->input('id'));
        if (Gate::denies('manipulate-post', $post)) {
            return redirect()->back();
        }
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();
        $post->tags()->sync($request->input('tags') === null ? [] : $request->input('tags'));
        return redirect()->route('admin.index')->with('info', "Post updated. Title: " .$request->input('title'));
    }

    /*
     * Delete a post.
     */
    public function getAdminDelete($id) {
        $post = Post::find($id);
        if (Gate::denies('manipulate-post', $post)) {
            return redirect()->back();
        }
        $post->likes()->delete();
        $post->tags()->detach();
        $post->delete();
        return redirect()->route('admin.index')->with('info', 'Post deleted.');
    }
}
