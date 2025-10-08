@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Post belliklerini üýtgetmek</h5>
    <div class="card-body">
      <form method="post" action="{{route('post-tag.update',$postTag->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Ady</label>
          <input id="inputTitle" type="text" name="title" placeholder="Adyny giriz"  value="{{$postTag->title}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Ýagdaýy</label>
          <select name="status" class="form-control">
            <option value="active" {{(($postTag->status=='active') ? 'selected' : '')}}>Işjeň</option>
            <option value="inactive" {{(($postTag->status=='inactive') ? 'selected' : '')}}>Işjeň däl</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Täzele</button>
        </div>
      </form>
    </div>
</div>

@endsection
