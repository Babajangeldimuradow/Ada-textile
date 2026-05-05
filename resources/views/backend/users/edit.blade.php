@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Ulanyjyny üýtgetmek</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.update',$user->id)}}" enctype="multipart/form-data">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Ady</label>
        <input id="inputTitle" type="text" name="name" placeholder="Ady giriz"  value="{{$user->name}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
            <label for="inputEmail" class="col-form-label">Emaily</label>
          <input id="inputEmail" type="email" name="email" placeholder="Email giriz"  value="{{$user->email}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        {{-- <div class="form-group">
            <label for="inputPassword" class="col-form-label">Parol</label>
          <input id="inputPassword" type="password" name="password" placeholder="Enter password"  value="{{$user->password}}" class="form-control">
          @error('password')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div> --}}

        <div class="form-group">
            <label for="inputPhoto" class="col-form-label">Surat</label>
            <div class="input-group">
                <input id="thumbnail" class="form-control" type="file" name="photo" onchange="previewImage(event)">
            </div>
            <img id="holder" style="margin-top:15px;max-height:100px;" src="{{$user->photo ? asset($user->photo) : ''}}">
            @error('photo')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="role" class="col-form-label">Roly</label>
            <select name="role" class="form-control">
                <option value="">-----Roly saýla-----</option>
                <option value="admin" {{((old('role') ? old('role') : $user->role) == 'admin') ? 'selected' : ''}}>Admin</option>
                <option value="user" {{((old('role') ? old('role') : $user->role) == 'user') ? 'selected' : ''}}>User</option>
            </select>
          @error('role')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>
          <div class="form-group">
            <label for="status" class="col-form-label">Ýagdaýy</label>
            <select name="status" class="form-control">
                <option value="active" {{(($user->status=='active') ? 'selected' : '')}}>Işjeň</option>
                <option value="inactive" {{(($user->status=='inactive') ? 'selected' : '')}}>Işjeň däl</option>
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