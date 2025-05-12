@include('layoutss.header')

<div id="wrapper">
    
    @include('layoutss.sidebar') {{-- sidebar sekarang fixed --}}

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layoutss.topbar')

            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

        @include('layoutss.footer')
    </div>
</div>