@include('admin.layouts._header')

<body>
    <script src="{{asset('assets/admin/static/js/initTheme.js')}}"></script>

    <div id="app">
        @include('admin.layouts._sidebar')
        <div id="main">
            
            @yield('content')

            @include('admin.layouts._footer')
            
        </div>
    </div>

    <script src="{{ asset('assets/admin/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <!-- Need: Apexcharts -->
    <script src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/dashboard.js') }}"></script>

    @yield('script')

</body>

</html>