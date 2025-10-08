@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Kupon goşmak</h5>
    <div class="card-body">
      <form method="post" action="{{route('coupon.store')}}">
        {{csrf_field()}}
        <div class="form-group">
        <label for="inputTitle" class="col-form-label">Kupon kody <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="code" placeholder="Kody giriziň"  value="{{old('code')}}" class="form-control">
        @error('code')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
            <label for="type" class="col-form-label">Görnüşi <span class="text-danger">*</span></label>
            <select name="type" class="form-control">
                <option value="fixed">Bellenen</option>
                <option value="percent">Göterimi</option>
            </select>
            @error('type')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputTitle" class="col-form-label">Bahasy  <span class="text-danger">*</span></label>
            <input id="inputTitle" type="number" name="value" placeholder="Kuponyň bahasyny giriziň"  value="{{old('value')}}" class="form-control">
            @error('value')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        
        <div class="form-group">
          <label for="status" class="col-form-label">Ýagdaýy <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="active">Işjeň</option>
              <option value="inactive">Işjeň däl</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Täzeden düzetmek</button>
           <button class="btn btn-success" type="submit">Ýatda saklamak</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });
</script>
@endpush