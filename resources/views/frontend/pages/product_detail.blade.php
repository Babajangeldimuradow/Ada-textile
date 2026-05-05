@extends('frontend.layouts.master')

@section('meta')
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="{{ optional($product_detail)->summary ?? '' }}">
<meta property="og:title" content="{{ $product_detail ? $product_detail->title : 'ADA || ÖNÜMLER BÖLÜMI' }}">
<meta property="og:description" content="{{ $product_detail && $product_detail->description ? $product_detail->description : 'Haryt barada maglumat ýok' }}">
<meta property="og:image" content="{{ $product_detail && $product_detail->photo ? asset('storage/' . $product_detail->photo) : asset('default-product.png') }}">
<meta property="og:url" content="{{ $product_detail ? route('product-detail', $product_detail->slug) : '#' }}">
<meta property="og:type" content="article">
@endsection

@section('title','ADA || ÖNÜMLER BÖLÜMI')

@section('main-content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{route('home')}}">BAŞ SAHYPA<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="">DÜKAN AMMARY</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Shop Single -->
<section class="shop single section">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6 col-12">
                <div class="product-gallery">
                    <div class="flexslider-thumbnails">
                        <ul class="slides">
                            @php
                                $photos = $product_detail && $product_detail->photo ? explode(',', $product_detail->photo) : [];
                            @endphp
                            @foreach($photos as $photo)
                            <li data-thumb="{{asset('storage/' . $photo)}}" rel="adjustX:10, adjustY:">
                                <img src="{{asset('storage/' . $photo)}}" alt="{{$product_detail->title ?? 'Haryt'}}">
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-6 col-12">
                <div class="product-des">
                    <div class="short">
                        <h4>{{ $product_detail->title ?? 'Haryt tapylmady' }}</h4>
                        <div class="rating-main">
                            <ul class="rating">
                                @php
                                    $rate = $product_detail && $product_detail->getReview ? ceil($product_detail->getReview->avg('rate')) : 0;
                                    $review_count = $product_detail && $product_detail->getReview ? $product_detail->getReview->count() : 0;
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <li><i class="fa {{ $rate >= $i ? 'fa-star' : 'fa-star-o' }}"></i></li>
                                @endfor
                            </ul>
                            <a href="#" class="total-review">({{ $review_count }}) Beýany:</a>
                        </div>

                        @php 
                            $after_discount = $product_detail ? $product_detail->price - ($product_detail->price * $product_detail->discount / 100) : 0;
                        @endphp

                        <p class="price">
                            @if($product_detail && $product_detail->discount > 0)
                                <span class="discount">{{number_format($after_discount,2)}} TMT</span>
                                <s>{{number_format($product_detail->price,2)}} TMT</s>
                            @elseif($product_detail)
                                <span>{{number_format($product_detail->price,2)}} TMT</span>
                            @endif
                        </p>

                        <p class="description">{!! $product_detail->summary ?? '' !!}</p>
                    </div>

                    <!-- Size -->
                    @if($product_detail && $product_detail->size)
                    <div class="size mt-4">
                        <h4>Ölçegi</h4>
                        <ul>
                            @php $sizes = explode(',', $product_detail->size); @endphp
                            @foreach($sizes as $size)
                            <li><a href="#" class="one">{{$size}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Product Buy -->
                    <div class="product-buy">
                        @if($product_detail)
                        <form action="{{route('single-add-to-cart')}}" method="POST">
                            @csrf
                            <div class="quantity">
                                <h6>Mukdary :</h6>
                                <div class="input-group">
                                    <div class="button minus">
                                        <button type="button" class="btn btn-primary btn-number" disabled data-type="minus" data-field="quant[1]">
                                            <i class="ti-minus"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" name="slug" value="{{$product_detail->slug}}">
                                    <input type="text" name="quant[1]" class="input-number" data-min="1" data-max="1000" value="1" id="quantity">
                                    <div class="button plus">
                                        <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                            <i class="ti-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="add-to-cart mt-4">
                                <button type="submit" class="btn">Sebede goş</button>
                                <a class="btn min wishlist-btn {{ in_array($product_detail->id, $wishlist_product_ids ?? []) ? 'favorited' : '' }}" data-product-id="{{$product_detail->id}}">
                                    <i class="ti-heart"></i>
                                </a>
                            </div>
                        </form>
                        @endif

                        <p class="cat">
                            Kategoriýa :
                            <a href="{{ $product_detail && $product_detail->cat_info ? route('product-cat', $product_detail->cat_info['slug']) : '#' }}">
                                {{ $product_detail->cat_info['title'] ?? 'N/A' }}
                            </a>
                        </p>
                        @if($product_detail && $product_detail->sub_cat_info)
                        <p class="cat mt-1">
                            Baş kategoriýa :
                            <a href="{{ route('product-sub-cat', [$product_detail->cat_info['slug'], $product_detail->sub_cat_info['slug']]) }}">
                                {{ $product_detail->sub_cat_info['title'] ?? 'N/A' }}
                            </a>
                        </p>
                        @endif
                        <p class="availability">
                            Haryt : 
                            @if($product_detail && $product_detail->stock > 0)
                                <span class="badge badge-success">{{$product_detail->stock}}</span>
                            @else
                                <span class="badge badge-danger">{{$product_detail->stock ?? 0}}</span>
                            @endif
                        </p>
                    </div>
                    <!-- End Product Buy -->

                </div>
            </div>
        </div>

        <!-- Tab Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="product-info">
                    <div class="nav-main">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description" role="tab">Düşündiriş</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Beýany</a></li>
                        </ul>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="tab-single">
                                <div class="single-des">
                                    <p>{!! $product_detail->description ?? '' !!}</p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="tab-single review-panel">
                                @auth
                                @if($product_detail)
                                <form class="form" method="post" action="{{route('review.store',$product_detail->slug)}}">
                                    @csrf
                                    <h5>Beýan goşuň</h5>
                                    <p>E-poçtaňyz çap edilmez. Zerur meýdanlar bellendi.</p>
                                    <div class="rating_box">
                                        @for($i = 1; $i <= 5; $i++)
                                            <input class="star-rating__input" type="radio" id="star-{{$i}}" name="rate" value="{{$i}}">
                                            <label class="star-rating__ico fa fa-star-o" for="star-{{$i}}" title="{{$i}} out of 5 stars"></label>
                                        @endfor
                                        @error('rate') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group mt-2">
                                        <textarea name="review" rows="4" placeholder="Teswiriňizi ýaz..."></textarea>
                                    </div>
                                    <button type="submit" class="btn mt-2">Ýatda sakla</button>
                                </form>
                                @endif
                                @else
                                <p class="text-center p-5">
                                    Size gerek <a href="{{route('login.form')}}">Login</a> OR <a href="{{route('register.form')}}">Register</a>
                                </p>
                                @endauth

                                <div class="ratting-main mt-4">
                                    <div class="avg-ratting">
                                        <h4>{{ $rate }} <span>(Overall)</span></h4>
                                        <span>Şoňa esaslanýar {{ $review_count }} Teswirler</span>
                                    </div>

                                    @foreach($product_detail->getReview ?? [] as $data)
                                    <div class="single-rating">
                                        <div class="rating-author">
                                            @if($data->user_info['photo'])
                                                <img src="{{asset('storage/' . $data->user_info['photo'])}}" alt="{{$data->user_info['name']}}">
                                            @else
                                                <img src="{{asset('backend/img/avatar.png')}}" alt="Profile.jpg">
                                            @endif
                                        </div>
                                        <div class="rating-des">
                                            <h6>{{$data->user_info['name']}}</h6>
                                            <ul class="rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <li><i class="fa {{ $data->rate >= $i ? 'fa-star' : 'fa-star-o' }}"></i></li>
                                                @endfor
                                            </ul>
                                            <p>{{$data->review}}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="product-area most-popular related-product section mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h2>Degişli önümler</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="owl-carousel popular-slider">
                            @foreach($product_detail->rel_prods ?? [] as $data)
                            @php $after_discount = $data->price - ($data->price * $data->discount / 100); @endphp
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="{{route('product-detail',$data->slug)}}">
                                        @php $photos = $data->photo ? explode(',', $data->photo) : []; @endphp
                                        <img class="default-img" src="{{isset($photos[0]) ? asset('storage/' . $photos[0]) : asset('default-product.png')}}" alt="{{$data->title}}">
                                        <img class="hover-img" src="{{isset($photos[0]) ? asset('storage/' . $photos[0]) : asset('default-product.png')}}" alt="{{$data->title}}">
                                        @if($data->discount > 0)
                                        <span class="price-dec">{{$data->discount}} % Arzanladyş</span>
                                        @endif
                                    </a>
                                </div>
                                <div class="product-content">
                                    <h3><a href="{{route('product-detail',$data->slug)}}">{{$data->title}}</a></h3>
                                    <div class="product-price">
                                        @if($data->discount > 0)
                                            <span class="old">{{number_format($data->price,2)}}TMT</span>
                                            <span>{{number_format($after_discount,2)}}TMT</span>
                                        @else
                                            <span>{{number_format($data->price,2)}}TMT</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Related Products -->

    </div>
</section>
<!--/ End Shop Single -->

@endsection

@push('styles')
<style>
.rating_box { display: inline-flex; }
.star-rating__ico { cursor: pointer; color: #F7941D; font-size: 16px; padding-left: 2px; }
.star-rating__input { display: none; }
.wishlist-btn.favorited i { color: red; }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.wishlist-btn').on('click', function(e){
        e.preventDefault();
        var product_id = $(this).data('product-id');
        var $this = $(this); // Store reference to the button

        $.ajax({
            url: "{{ route('wishlist.toggle') }}",
            type: "POST",
            data: {
                product_id: product_id,
                _token: "{{ csrf_token() }}"
            },
            success: function(response){
                if(response.status){
                    if(response.action === 'added'){
                        $this.addClass('favorited');
                        swal('Üstünlikli!', response.message, 'success');
                    } else {
                        $this.removeClass('favorited');
                        swal('Üstünlikli!', response.message, 'success');
                    }
                } else {
                    swal('Ýalňyşlyk!', response.message, 'error');
                }
            },
            error: function(xhr, status, error){
                if(xhr.status === 401){ // Unauthorized
                    swal('Giriş ediň!', 'Bu funksiýany ulanmak üçin giriş etmeli.', 'warning').then(() => {
                        window.location.href = "{{ route('login.form') }}";
                    });
                } else {
                    swal('Ýalňyşlyk!', 'Bir zat ýalňyş boldy, gaýtadan synanyşyň.', 'error');
                }
            }
        });
    });
});
</script>
@endpush