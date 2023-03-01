<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    private $model;
    private $category;
    
    public function __construct(Article $article, Category $category)
    {
        $this->model = $article;
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->category->all('id', 'name');
        return view('admin.article.form', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        $validate = (object) $request->validate([
            'category_id' => 'required|exists:App\Models\Category,id',
            // 'user_id' => 'required|exists:App\Models\User,id',
            'title' => 'required',
            'image' => 'image',
            'body' => 'required'
        ], [
            'category_id' => 'Category tidak ditemukan.',
            // 'user_id' => 'User tidak ditemukan.',
            'title' => 'Tile tidak valid.',
            'image' => 'Image tidak valid.',
            'body' => 'Body tidak valid.'
        ]);
        try  {            
            $validate->image = $request->file('image')->store('/article');
            $validate->user_id = Auth::user()->id;

            if (is_null($this->model->create((array) $validate))) 
                throw new Exception('Faild store');
            DB::commit();
            return redirect('/dashboard/article');
        } catch(Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Failed to store');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = $this->category->all('id', 'name');
        $article = $this->model->where('slug', $id)->first();

        return view('admin.article.form', [
            'categories' => $categories,
            'article' => $article
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        $validate = (object) $request->validate([
            'category_id' => 'nullable|exists:App\Models\Category,id',
            // 'user_id' => 'required|exists:App\Models\User,id',
            'title' => 'required',
            // 'slug' => 'nul',
            'image' => 'image|nullable',
            'body' => 'required'
        ], [
            'category_id' => 'Category tidak ditemukan.',
            // 'user_id' => 'User tidak ditemukan.',
            'title' => 'Tile tidak valid.',
            // 'slug' => 'Slug tidak valid.',
            'image' => 'Image tidak valid.',
            'body' => 'Body  tidak valid.'
        ]);
        try  {
            $article = $this->model->where('slug', $id)->first();
            if ($request->file('image')) {
                Storage::delete($article->image);
                $validate->image = $request->file('image')->store('/article');
            }


            if (is_null($article->update((array) $validate))) 
                throw new Exception('Faild store');
            DB::commit();
            return redirect('/dashboard/article');
        } catch(Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->with('failed', 'Failed to store');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try  {
            if (is_null($this->model->find($id)->delete())) 
                throw new Exception('Faild store');
            DB::commit();
            return redirect('/dashboard/article');
        } catch(Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Failed to store');
        }
    }

    /**
     * Show admin page and pacakage list
     */
    public function adminIndex()
    {
        return view('admin.article.index', [
            'articlies' => $this->model->with('category')->get()
        ]);
    }
}
