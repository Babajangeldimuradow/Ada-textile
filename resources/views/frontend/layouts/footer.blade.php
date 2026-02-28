<!-- Start Footer Area -->
<footer class="footer">
    <!-- Footer Top -->
    <div class="footer-top section">
        <div class="container">
            <div class="row">
                <!-- Haqqymyzda bölümi -->
                <div class="col-lg-5 col-md-6 col-12">
                    <div class="single-footer about">
                        <div class="logo">
                            <a href="{{ route('home') }}"><img src="{{ asset('backend/img/logo2.png') }}" alt="Logo"></a>
                        </div>
                        @php
                            $setting = DB::table('settings')->first();
                        @endphp
                        @if($setting)
                            <p class="text">{{ strip_tags($setting->short_des) }}</p>
                            <p class="call">
                                <span><a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a></span>
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Maglumat bölümi -->
                <div class="col-lg-2 col-md-6 col-12">
                    <div class="single-footer links">
                        <h4>Maglumat</h4>
                        <ul>
                            <li><a href="{{ route('about-us') }}">Biz barada</a></li>
                            <li><a href="#">Habarlar</a></li>
                            <li><a href="#">Töleg we eltip bermek</a></li>
                            <li><a href="{{ route('contact') }}">Habarlaşyň</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Aragatnaşyk / sosial -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-footer social">
                        <h4>Habarlaşmak üçin</h4>
                        <div class="contact">
                            <ul>
                                @if($setting)
                                    <li>{{ strip_tags($setting->address) }}</li>
                                    <li>{{ $setting->email }}</li>
                                    <li>{{ $setting->phone }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Footer Top -->

    <!-- Footer aşagy (Copyright) -->
    <div class="copyright">
        <div class="container">
            <div class="inner">
                <div class="row">
                    <div class="col-12 text-center">
                        <p>Ähli hukuklar goralan {{ date('Y') }} 
                            <a href="https://github.com/Babajangeldimuradow" target="_blank">ADA</a> - söwda toplumy.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- /End Footer Area -->

<!-- JS Scriptler -->
<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery-migrate-3.0.0.js') }}"></script>
<script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('frontend/js/popper.min.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/js/colors.js') }}"></script>
<script src="{{ asset('frontend/js/slicknav.min.js') }}"></script>
<script src="{{ asset('frontend/js/owl-carousel.js') }}"></script>
<script src="{{ asset('frontend/js/magnific-popup.js') }}"></script>
<script src="{{ asset('frontend/js/waypoints.min.js') }}"></script>
<script src="{{ asset('frontend/js/finalcountdown.min.js') }}"></script>
<script src="{{ asset('frontend/js/nicesellect.js') }}"></script>
<script src="{{ asset('frontend/js/flex-slider.js') }}"></script>
<script src="{{ asset('frontend/js/scrollup.js') }}"></script>
<script src="{{ asset('frontend/js/onepage-nav.min.js') }}"></script>
<script src="{{ asset('frontend/js/isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/js/easing.js') }}"></script>
<script src="{{ asset('frontend/js/active.js') }}"></script>

@stack('scripts')
<script>
    setTimeout(function(){
      $('.alert').slideUp();
    },5000);

    $(function() {
        $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
            event.preventDefault();
            event.stopPropagation();

            $(this).siblings().toggleClass("show");

            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                $('.dropdown-submenu .show').removeClass("show");
            });
        });
    });
</script>