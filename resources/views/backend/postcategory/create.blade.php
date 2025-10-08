@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Post bölümine goşmak</h5>
    <div class="card-body">
      <form method="post" action="{{route('post-category.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Ady</label>
          <input id="inputTitle" type="text" name="title" placeholder="Ady giriz"  value="{{old('title')}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Ýagdaýy</label>
          <select name="status" class="form-control">
              <option value="active">Işjeň</option>
              <option value="inactive">Işjeň däl</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Täzeden düzmek</button>
           <button class="btn btn-success" type="submit">Ýatda sakla</button>
        </div>
      </form>
    </div>
</div>

@endsection
