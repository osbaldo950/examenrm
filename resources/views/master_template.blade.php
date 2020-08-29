<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" type="image/png" href="AdminLTE/dist/img/AdminLTELogo.png" sizes="16x16">
            <link rel="icon" type="image/png" href="AdminLTE/dist/img/AdminLTELogo.png" sizes="32x32">
            <title>APP - @yield('title')</title>
            @include('sections.head')
            @yield('additionals_css')
        </head>
        <body class="hold-transition sidebar-mini">
            <!-- Site wrapper -->
            <div class="wrapper">
                @include('sections.header')
                @include('sections.aside')
                @yield('content')
                @include('sections.footer')
                @include('sections.configuration')
            </div>
            <!-- ./wrapper -->
            @include('sections.footer_js')
            @yield('additionals_js')
        </body>    
    </html>