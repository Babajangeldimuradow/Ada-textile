@extends('frontend.layouts.master')

@section('title','ADA || Gözegçilik sahypasy')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">BAŞ SAHYPA<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Gözegçilik bölümi</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
<section class="tracking_box_area section_gap py-5">
    <div class="container">
        <div class="tracking_box_inner">
            <p>Sargydyňyzy yzarlamak üçin Sargyt ID-ni aşakdaky gutujyga giriziň we "Yzarla" düwmesine basyň. Bu berildi 
kwitansiýaňyzda we almaly tassyklama e-poçtaňyzda.</p>
            <form class="row tracking_form my-4" action="{{route('product.track.order')}}" method="post" novalidate="novalidate">
              @csrf
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control p-2"  name="order_number" placeholder="Sargyt belgiňizi giriziň">
                </div>
                <div class="col-md-8 form-group">
                    <button type="submit" value="submit" class="btn submit_btn">Gözegçilik tertibi</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection