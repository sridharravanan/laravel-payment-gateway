<!doctype html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <!-- CSRF Token -->
            <meta name="csrf-token" content="{{ csrf_token() }}">

            <title>{{ config('app.name') }}</title>
            @include('includes.head')
        </head>
    <body>
        @include('includes.sidebar')
        <!-- Right Panel -->
        <div id="right-panel" class="right-panel">
            <!--vue js mounted..!-->
            <div id="app">
                @include('includes.top_bar')
                @yield('content')
            </div>
            <!-- .content -->
        </div>
        <!-- Right Panel -->

        @stack('scripts')
        @include('includes.footer')
    </body>
    </html>
