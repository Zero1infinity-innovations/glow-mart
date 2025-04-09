<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layout.head')
    <body>
        @include('layout.header')
        @yield('bodyContent')

        <!-- Back to Top -->
        <a href="https://wa.me/919876543210" class="btn back-to-top" target="_blank">
            <i class="fa-brands fa-whatsapp"
                style="background-color: #25D366; padding: 10px; border-radius: 50%; color: white;"></i>
        </a>
        
        @include('layout.footer')
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    @yield('scriptJs')
</html>
