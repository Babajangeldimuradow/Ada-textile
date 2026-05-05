@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Ulanyjy goşmak</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Ady</label>
        <input id="inputTitle" type="text" name="name" placeholder="Ady giriz"  value="{{old('name')}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
            <label for="inputEmail" class="col-form-label">Emaily</label>
          <input id="inputEmail" type="email" name="email" placeholder="Email giriz"  value="{{old('email')}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="inputPassword" class="col-form-label">Parol</label>
          <input id="inputPassword" type="password" name="password" placeholder="Paroly giriz"  value="{{old('password')}}" class="form-control">
          @error('password')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="inputPhoto" class="col-form-label">Surat</label>
            <div class="input-group">
                <input id="thumbnail" class="form-control" type="file" name="photo" onchange="previewImage(event)">
            </div>
            <img id="holder" style="margin-top:15px;max-height:100px;" src="{{old('photo')}}">
            @error('photo')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        @php 
$roles = ['admin', 'user']; // Static role list, DB-den alman
@endphp
<div class="form-group">
    <label for="role" class="col-form-label">Roly</label>
    <select name="role" class="form-control">
        <option value="">-----Roly saýlaň-----</option>
        @foreach($roles as $role)
            <option value="{{$role}}" {{ old('role') == $role ? 'selected' : '' }}>{{$role}}</option>
        @endforeach
    </select>
    @error('role')
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

@push('scripts')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('holder');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush