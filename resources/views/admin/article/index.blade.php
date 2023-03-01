@extends('admin.layouts.index')

@section('dashboard')
<div class="p-3">
  <span class="h3">Artikel</span>
  <div class="p-4 mt-3 hover:bg-dark pointer w-50 bg-white border rounded d-flex align-items-center">
    <div class="circle bg-info-subtle h-30-px w-30-px d-flex justify-content-center align-items-center">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil"
        viewBox="0 0 16 16">
        <path
          d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
      </svg>
    </div>
    <a href="/dashboard/article/create" class="remove-style">
      <div class="ms-3 d-flex flex-column">
        <span class="text-dark">Tulis Artikel</span>
        <span class="fs-12-px text-dark">Buat sesuatu yang menarik hari ini</span>
      </div>
  </div>
  </a>
  <div class="mt-5">
    <span class="header-2">Resent Post</span>
    <div class="row">
      @foreach ($articlies as $key => $article)
      <div class="col-3 mb-4">
        <div id="{{ 'article-card' }}">
          <x-card-blog :title="$article->title" :image="$article->image">
            <div class="text-primary">{{ $article->category->name }}</div>
            {!! $article->body !!}
          </x-card-blog>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
<script>
  const articlies = @json($articlies);
  document.querySelectorAll('#article-card').forEach((node, index) => {
    node.addEventListener('click', () => {
      console.log(articlies)
      window.location.replace('/dashboard/article/' + articlies[index].slug + '/edit');
    })
  })
</script>
@endsection