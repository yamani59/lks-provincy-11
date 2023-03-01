@extends('admin.layouts.index')

@section('dashboard')
<div class="p-3 w-75 mx-auto">
  <span class="h3">Create Article</span>
  <form class="mt-5" action="{{ isset($article) ? '/article/'.$article->slug : '/article' }}" method="post"
    enctype="multipart/form-data" novalidate>
    @csrf
    @method(isset($article) ? 'patch' : 'post')

    <div class="mb-3 row">
      <div class="col-3">
        <label class="form-label">Title</label>
        <input @class(['form-control', 'py-3' , 'is-invalid'=> $errors->has('title')]) required type="text" value="{{
        $article->title ?? old('title') }}" name="title">
        <div class="invalid-feedback">
          {{ $errors->first('title') }}
        </div>
      </div>
      <div class="col-3">
        <label class="form-label">Slug</label>
        <input @class(['form-control', 'py-3' , 'is-invalid'=> $errors->has('slug')]) required type="text" value="{{
        $article->slug ?? old('slug') }}" name="slug" id="">
        <div class="invalid-feedback">
          {{ $errors->first('slug') }}
        </div>
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Banner</label>
      <div class="text-center">
        <img src="{{ empty($article->image) ? '' : asset('storage/' . $article->image) }}" id="img-preview"
          class="w-50 mb-3" alt="">
      </div>
      <input onchange="previewImageUpload()" @class(['form-control', 'py-3' , 'is-invalid'=> $errors->has('slug')])
      required type="file" name="image"
      id="image">
      <div class="invalid-feedback">
        {{ $errors->first('image') }}
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Kategori</label>
      <select name="category_id" value="{{ $article->category_id ?? old('category_id') }}" required
        @class(['form-select', 'py-3' , 'is-invalid'=> $errors->has('category_id')])>
        <option 
          value="" 
          disabled 
          {!! 
            is_null($article->category_id ?? old('category_id'))
              ? 'selected' : '' 
          !!}
        >Choose Category</option>
          @foreach ($categories as $category)
            <option
              value="{{ $category->id }}"
              {!! 
                is_null($article->category_id ?? old('category_id'))
                  ? ''
                  : ($category->id == $article->category_id
                    ? 'selected'
                    : '')
              !!}  
            >{{ $category->name }}</option>
          @endforeach
      </select>
      <div class="invalid-feedback"></div>
    </div>
    <div class="mb-3">
      <label class="form-label">Content</label>
      <input type="hidden" name="body" id="x">
      <trix-editor input="x">
        {{ $article->body ?? old('body') }}
      </trix-editor>
    </div>
    <div class="text-end">
      <button class="btn btn-primary">
        <a href="/dashboard/article" class="text-white remove-style">Batal</a>
      </button>
      <button type="submit" class="btn btn-primary">Kirim</button>
    </div>
  </form>
</div>
<script>
  const previewImageUpload = () => {
    const image = document.querySelector('#img-preview');
    const inputImage = document.querySelector('#image').files[0]
    const renderImage = new FileReader()
    
    renderImage.readAsDataURL(inputImage)
    renderImage.onload = function() {
      image.src = renderImage.result
    }
  }
</script>
@endsection