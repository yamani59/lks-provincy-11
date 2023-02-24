@extends('template.head')

@section('body')
<div class="d-flex flex-column bg-dark-subtle justify-content-center align-items-center h-100-vh">
  <div class="div bg-light p-3 rounded">
    <div class="border-bottom mb-3 text-center">
      <h3>{{ $page }}</h3>
    </div>
    <form class="mb-3" action="{{ 
        $page == 'register' 
          ? 'register'
            : 'login'
        }}" method="post">
      @method('POST')
      @csrf
      @if ($page == 'register')
      <div class="mb-3">
        <input type="text" autocomplete="off" required placeholder="Username" name="name" class="form-control">
      </div>
      @endif
      <div class="mb-3">
        <input type="text" autocomplete="off" required placeholder="Email" name="email" class="form-control">
      </div>
      <div class="mb-3">
        <input type="password" autocomplete="off" required placeholder="Password" name="password" class="form-control">
      </div>
      <input type="text" name="role" class="form-control" hidden value="writer">
      <div class="border-top pt-3 d-flex justify-content-end">
        <button class="btn btn-primary" type="submit">Kirim</button>
      </div>
    </form>

    {{-- alert login failed --}}
    @if (Session::has('loginError'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      Login failed
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

  </div>
</div>
@endsection