@extends('backend.layouts.master')

@section('title','ADA || Banner Döretmek')

@section('main-content')

<div class="card">
    <h5 class="card-header">Banner goş</h5>
    <div class="card-body">
      <form method="post" action="{{route('banner.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Ady <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="title" placeholder="Adyny giriz"  value="{{old('title')}}" class="form-control">
        @error('title')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputDesc" class="col-form-label">Düşündirişi</label>
          <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="inputPhoto" class="col-form-label">Surat <span class="text-danger">*</span></label>
            <input id="inputPhoto" class="form-control" type="file" name="photo">
            @error('photo')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="active">Işjeň </option>
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

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Gysga düşündiriş ýazyň .....",
        tabsize: 2,
        height: 150
    });
    });
</script>
@endpush