@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Umumy sazlamalar</h5>
    <div class="card-body">

    <form method="POST" action="{{ route('settings.update') }}">
        @csrf
        @method('PATCH')

        {{-- SHORT DESCRIPTION --}}
        <div class="form-group">
            <label class="col-form-label">
                Gysgaça beýany <span class="text-danger">*</span>
            </label>

            <textarea class="form-control"
                      id="quote"
                      name="short_des">{{ old('short_des', $data->short_des ?? '') }}</textarea>

            @error('short_des')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        {{-- DESCRIPTION --}}
        <div class="form-group">
            <label class="col-form-label">
                Düşündirilişi <span class="text-danger">*</span>
            </label>

            <textarea class="form-control"
                      id="description"
                      name="description">{{ old('description', $data->description ?? '') }}</textarea>

            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        {{-- LOGO --}}
        <div class="form-group">
            <label class="col-form-label">
                Logo <span class="text-danger">*</span>
            </label>

            <div class="input-group">
                <span class="input-group-btn">
                    <a id="lfm1"
                       data-input="thumbnail1"
                       data-preview="holder1"
                       class="btn btn-primary">
                        <i class="fa fa-picture-o"></i> Saýla
                    </a>
                </span>

                <input id="thumbnail1"
                       class="form-control"
                       type="text"
                       name="logo"
                       value="{{ old('logo', $data->logo ?? '') }}">
            </div>

            <div id="holder1" style="margin-top:15px;max-height:100px;"></div>

            @error('logo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        {{-- PHOTO --}}
        <div class="form-group">
            <label class="col-form-label">
                Surat <span class="text-danger">*</span>
            </label>

            <div class="input-group">
                <span class="input-group-btn">
                    <a id="lfm"
                       data-input="thumbnail"
                       data-preview="holder"
                       class="btn btn-primary">
                        <i class="fa fa-picture-o"></i> Saýla
                    </a>
                </span>

                <input id="thumbnail"
                       class="form-control"
                       type="text"
                       name="photo"
                       value="{{ old('photo', $data->photo ?? '') }}">
            </div>

            <div id="holder" style="margin-top:15px;max-height:100px;"></div>

            @error('photo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        {{-- ADDRESS --}}
        <div class="form-group">
            <label class="col-form-label">
                Salgy <span class="text-danger">*</span>
            </label>

            <input type="text"
                   class="form-control"
                   name="address"
                   value="{{ old('address', $data->address ?? '') }}"
                   required>

            @error('address')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        {{-- EMAIL --}}
        <div class="form-group">
            <label class="col-form-label">
                Poçta salgy <span class="text-danger">*</span>
            </label>

            <input type="email"
                   class="form-control"
                   name="email"
                   value="{{ old('email', $data->email ?? '') }}"
                   required>

            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        {{-- PHONE --}}
        <div class="form-group">
            <label class="col-form-label">
                Telefon belgi <span class="text-danger">*</span>
            </label>

            <input type="text"
                   class="form-control"
                   name="phone"
                   value="{{ old('phone', $data->phone ?? '') }}"
                   required>

            @error('phone')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <button class="btn btn-success" type="submit">
                Täzele
            </button>
        </div>

    </form>
    </div>
</div>


@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');
    $('#lfm1').filemanager('image');
    $(document).ready(function() {
    $('#summary').summernote({
      placeholder: "Gysgaça beýany ýazyň.....",
        tabsize: 2,
        height: 150
    });
    });

    $(document).ready(function() {
      $('#quote').summernote({
        placeholder: "Teswirleriňizi ýazyň.....",
          tabsize: 2,
          height: 100
      });
    });
    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Jikme-jik düşündiriş ýazyň.....",
          tabsize: 2,
          height: 150
      });
    });
</script>
@endpush