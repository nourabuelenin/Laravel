<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title ?? 'iti_store'}}</title>
    <link rel="shortchut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon"> {{--  asset is a global routing method --}}
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
{{-- Navbar --}}

<x-navbar/>
{{--Display success messages--}}
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container top-0 end-0 p-3">
            <!-- Then put toasts within -->
            <div id="successToast" class="toast text-white bg-success toast-custom" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                </div>
            </div>
        </div>
    </div>

<div class="container">
    {{ $slot }}
</div>

{{-- Footer --}}
<x-footer/>

<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let successToast = document.getElementById('successToast');
        if (successToast) {
            let toast = new bootstrap.Toast(successToast);
            toast.show();
            setTimeout(() => {
                toast.hide();
            }, 3000); // hide toast after 3 seconds
        }
    });
</script>
</body>
</html>