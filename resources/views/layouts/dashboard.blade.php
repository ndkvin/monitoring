<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Monitoring Solar</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="{{ asset("/assets/plugins/perfectscroll/perfect-scrollbar.css") }}" rel="stylesheet">
    <link href="{{ asset("/assets/plugins/pace/pace.css") }} rel="stylesheet">
    <link href="{{ asset("/assets/plugins/highlight/styles/github-gist.css") }}" rel="stylesheet">
    <link href="{{ asset("/assets/plugins/datatables/datatables.min.css") }}" rel="stylesheet">

    <!-- Theme Styles -->
    <link href="{{ asset("/assets/css/main.min.css") }}" rel="stylesheet">
    <link href="{{ asset("/assets/css/custom.css") }}" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset("/assets/images/neptune.png") }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset("/assets/images/neptune.png") }}" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="/assets/plugins/flatpickr/flatpickr.min.css" rel="stylesheet" />
    </head>

<body>
    <div class="app
        align-content-stretch d-flex flex-wrap">

    @include('components.sidebar')

    <div class="app-container">

        @include('components.header')

        <div class="app-content">
            <div class="content-wrapper">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Javascripts -->
    <script src="{{ asset("/assets/plugins/jquery/jquery-3.5.1.min.js") }}"></script>
    <script src="{{ asset("/assets/plugins/bootstrap/js/popper.min.js") }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="{{ asset("/assets/plugins/perfectscroll/perfect-scrollbar.min.js") }}"></script>
    <script src="{{ asset("/assets/plugins/pace/pace.min.js") }}"></script>
    <script src="{{ asset("/assets/plugins/highlight/highlight.pack.js") }}"></script>
    <script src="{{ asset("/assets/plugins/datatables/datatables.min.js") }}"></script>
    <script src="{{ asset("/assets/js/main.min.js") }}"></script>
    <script src="{{ asset("/assets/js/custom.js") }}"></script>
    <script src="{{ asset("/assets/js/pages/datatables.js") }}"></script>
    <script src="{{ asset("/assets/plugins/flatpickr/flatpickr.js") }}"></script>
    @yield('scripts')
    @if ($errors->any())
        <script>
            console.log('errror')
            let errorMessages = '';
            @foreach ($errors->all() as $error)
                errorMessages += "{{ $error }}";
            @endforeach
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorMessages,
            })
        </script>
    @endif
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
            })
        </script>
    @endif
    </body>

</html>
