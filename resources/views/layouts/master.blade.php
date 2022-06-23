<!DOCTYPE html>
<html lang="en" style="height: auto;">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Starter</title>
    <link rel="stylesheet" href="{{ mix("css/app.css") }}"/>


    @livewireStyles

    </head>
    <body class="sidebar-mini sidebar-closed sidebar-collapse" style="height: auto;">
    <div class="wrapper">

        <!-- Navbar-->
        <x-topnav/>

        <!-- Main Sidebar container-->
        <x-menu />

        <div class="content-wrapper" style="min-height: 430px;">
            <div class="content">
                <div class="container-fluid">
               @yield("contenu")  
            {{--    {{$slot}} --}}
                </div>
            </div>
            
        </div>

        <!-- Control Sidebar-->
        <x-sidebar />

        <!-- Main footer-->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <strong>Copyright © 2022 <a href="https://adminlte.io">ltfi.bf</a>.</strong> All rights reserved.
        </footer>
        <div id="sidebar-overlay"></div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>

    @livewireScripts

    </body>
</html>