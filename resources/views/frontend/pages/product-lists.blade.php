	@extends('frontend.layouts.master')

@section('title','ADA || ÖNÜMLER SAHYPAsy')

@section('main-content')
	
	<!-- Navigasiýa ýoly -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{route('home')}}">Baş sahypa<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="javascript:void(0);">Dükan sanawy</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Navigasiýa ýoly gutardy -->

	<form action="{{route('shop.filter')}}" method="POST">
	@csrf
		<!-- Önümler sanawy bölümi -->
		<section class="product-area shop-sidebar shop-list shop section">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-4 col-12">
						<div class="shop-sidebar">
							<!-- Kategoriýalar widgeti -->
							<div class="single-widget category">
								<h3 class="title">Kategoriýalar</h3>
								<ul class="categor-list">
									@php
										$menu=App\Models\Category::getAllParentWithChild();
									@endphp
									@if($menu)
									<li>
										@foreach($menu as $cat_info)
												@if($cat_info->child_cat->count()>0)
													<li><a href="{{route('product-cat',$cat_info->slug)}}">{{$cat_info->title}}</a>
														<ul>
															@foreach($cat_info->child_cat as $sub_menu)
																<li><a href="{{route('product-sub-cat',[$cat_info->slug,$sub_menu->slug])}}">{{$sub_menu->title}}</a></li>
															@endforeach
														</ul>
													</li>
												@else
													<li><a href="{{route('product-cat',$cat_info->slug)}}">{{$cat_info->title}}</a></li>
												@endif
										@endforeach
									</li>
									@endif
								</ul>
							</div>
							<!--/ Kategoriýalar widgeti gutardy -->

							<!-- Bahasy boýunça süzgüç widgeti -->
							<div class="single-widget range">
								<h3 class="title">Bahasy boýunça</h3>
								<div class="price-filter">
									<div class="price-filter-inner">
										@php
											$max=DB::table('products')->max('price');
										@endphp
										<div id="slider-range" data-min="0" data-max="{{$max}}"></div>
										<div class="product_filter">
											<button type="submit" class="filter_button">Süzgüç</button>
											<div class="label-input">
												<span>Aralyk:</span>
												<input style="" type="text" id="amount" readonly/>
												<input type="hidden" name="price_range" id="price_range" value="@if(!empty($_GET['price'])){{$_GET['price']}}@endif"/>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--/ Bahasy boýunça süzgüç gutardy -->

							<!-- Iň soňky postlar widgeti -->
							<div class="single-widget recent-post">
								<h3 class="title">Soňky goşulan önümler</h3>
								@foreach($recent_products as $product)
									@php 
										$photo=explode(',',$product->photo);
									@endphp
									<div class="single-post first">
										<div class="image">
											<img src="{{$photo[0]}}" alt="{{$photo[0]}}">
										</div>
										<div class="content">
											<h5><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h5>
											@php
												$org=($product->price-($product->price*$product->discount)/100);
											@endphp
											<p class="price"><del class="text-muted">{{number_format($product->price,2)}} TMT</del> {{number_format($org,2)}} TMT</p>
                                                
										</div>
									</div>
								@endforeach
							</div>
							<!--/ Iň soňky postlar gutardy -->

							<!-- Markalar widgeti -->
							<div class="single-widget category">
								<h3 class="title">Markalar</h3>
								<ul class="categor-list">
									@php
										$brands=DB::table('brands')->orderBy('title','ASC')->where('status','active')->get();
									@endphp
									@foreach($brands as $brand)
										<li><a href="{{route('product-brand',$brand->slug)}}">{{$brand->title}}</a></li>
									@endforeach
								</ul>
							</div>
							<!--/ Markalar widgeti gutardy -->

						</div>
					</div>

					<!-- Önümler sanawy bölegi -->
					<div class="col-lg-9 col-md-8 col-12">
						<div class="row">
							<div class="col-12">
								<!-- Önümler sanawynyň ýokarky bölegi -->
								<div class="shop-top">
									<div class="shop-shorter">
										<div class="single-shorter">
											<label>Görkez :</label>
											<select class="show" name="show" onchange="this.form.submit();">
												<option value="">Başlangyç</option>
												<option value="9" @if(!empty($_GET['show']) && $_GET['show']=='9') selected @endif>09</option>
												<option value="15" @if(!empty($_GET['show']) && $_GET['show']=='15') selected @endif>15</option>
												<option value="21" @if(!empty($_GET['show']) && $_GET['show']=='21') selected @endif>21</option>
												<option value="30" @if(!empty($_GET['show']) && $_GET['show']=='30') selected @endif>30</option>
											</select>
										</div>
										<div class="single-shorter">
											<label>Yzygiderlik boýunça :</label>
											<select class='sortBy' name='sortBy' onchange="this.form.submit();">
												<option value="">Başlangyç</option>
												<option value="title" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='title') selected @endif>Ady boýunça</option>
												<option value="price" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='price') selected @endif>Bahasy boýunça</option>
												<option value="category" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='category') selected @endif>Kategoriýa boýunça</option>
												<option value="brand" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='brand') selected @endif>Marka boýunça</option>
											</select>
										</div>
									</div>
									<ul class="view-mode">
										<li><a href="{{route('product-grids')}}"><i class="fa fa-th-large"></i></a></li>
										<li class="active"><a href="javascript:void(0)"><i class="fa fa-th-list"></i></a></li>
									</ul>
								</div>
								<!--/ Önümler sanawynyň ýokarky bölegi gutardy -->
							</div>
						</div>
						<div class="row">
							@if(count($products))
								@foreach($products as $product)
									<!-- Ýeke-ýekeden sanaw görnüşi -->
									<div class="col-12">
										<div class="row">
											<div class="col-lg-4 col-md-6 col-sm-6">
												<div class="single-product">
													<div class="product-img">
														<a href="{{route('product-detail',$product->slug)}}">
															@php 
																$photo=explode(',',$product->photo);
															@endphp
															<img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
															<img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
														</a>
														<div class="button-head">
															<div class="product-action">
																<a data-toggle="modal" data-target="#{{$product->id}}" title="Çalt gözden geçirmek" href="#"><i class=" ti-eye"></i><span>Çalt satyn alyş</span></a>
																<a title="Islendik sanawa goş" href="{{route('add-to-wishlist',$product->slug)}}" class="wishlist" data-id="{{$product->id}}"><i class=" ti-heart "></i><span>Islendik sanawa goş</span></a>
															</div>
															<div class="product-action-2">
																<a title="Sebede goş" href="{{route('add-to-cart',$product->slug)}}">Sebede goş</a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-8 col-md-6 col-12">
												<div class="list-content">
													<div class="product-content">
														<div class="product-price">
															@php
																$after_discount=($product->price-($product->price*$product->discount)/100);
															@endphp
															<span>{{number_format($after_discount,2)}}TMT</span>
															<del>{{number_format($product->price,2)}}TMT</del>
														</div>
														<h3 class="title"><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
													</div>
													<p class="des pt-2">{!! html_entity_decode($product->summary) !!}</p>
													<a href="javascript:void(0)" class="btn cart" data-id="{{$product->id}}">Satyn al!</a>
												</div>
											</div>
										</div>
									</div>
									<!--/ Ýeke-ýekeden sanaw gutardy -->
								@endforeach
							@else
								<h4 class="text-warning" style="margin:100px auto;">Önüm tapylmady!!!</h4>
							@endif
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/ Önümler sanawy gutardy -->	
	</form>
@endsection

	@push ('styles')
	<style>
		.pagination{
			display:inline-flex;
		}
		.filter_button{
			/* height:20px; */
			text-align: center;
			background:#F7941D;
			padding:8px 16px;
			margin-top:10px;
			color: white;
		}
	</style>
	@endpush
	@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

		{{-- <script>
			$('.cart').click(function(){
				var quantity=1;
				var pro_id=$(this).data('id');
				$.ajax({
					url:"{{route('add-to-cart')}}",
					type:"POST",
					data:{
						_token:"{{csrf_token()}}",
						quantity:quantity,
						pro_id:pro_id
					},
					success:function(response){
						console.log(response);
						if(typeof(response)!='object'){
							response=$.parseJSON(response);
						}
						if(response.status){
							swal('success',response.msg,'success').then(function(){
								document.location.href=document.location.href;
							});
						}
						else{
							swal('error',response.msg,'error').then(function(){
								// document.location.href=document.location.href;
							}); 
						}
					}
				})
			});
		</script> --}}
		<script>
			$(document).ready(function(){
			/*----------------------------------------------------*/
			/*  Jquery Ui slider js
			/*----------------------------------------------------*/
			if ($("#slider-range").length > 0) {
				const max_value = parseInt( $("#slider-range").data('max') ) || 500;
				const min_value = parseInt($("#slider-range").data('min')) || 0;
				const currency = $("#slider-range").data('currency') || '';
				let price_range = min_value+'-'+max_value;
				if($("#price_range").length > 0 && $("#price_range").val()){
					price_range = $("#price_range").val().trim();
				}
				
				let price = price_range.split('-');
				$("#slider-range").slider({
					range: true,
					min: min_value,
					max: max_value,
					values: price,
					slide: function (event, ui) {
						$("#amount").val(currency + ui.values[0] + " -  "+currency+ ui.values[1]);
						$("#price_range").val(ui.values[0] + "-" + ui.values[1]);
					}
				});
				}
			if ($("#amount").length > 0) {
				const m_currency = $("#slider-range").data('currency') || '';
				$("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
					"  -  "+m_currency + $("#slider-range").slider("values", 1));
				}
			})
		</script>

	@endpush