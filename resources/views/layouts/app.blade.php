<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = { user: @json(Auth::user()) };</script>
    <title>KJPP App</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-[#f8fafc] font-['Inter'] antialiased">
    <div class="min-h-screen">
        @include('partials.header')

        @php $isDashboard = request()->routeIs('dashboard'); @endphp
        <main class="{{ $isDashboard ? 'pt-24 pb-6 h-full overflow-hidden' : 'pt-24 pb-6 min-h-screen overflow-auto' }}">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
        
        <!-- Global Toast Notification -->
        @include('partials.toast')
    </div>
    @livewireScripts
    <script>
        // Set global SweetAlert2 defaults
        Swal = Swal.mixin({
            confirmButtonColor: '#82C17D',
            cancelButtonColor: '#6b7280',
            reverseButtons: true
        });

        window.confirmDelete = function(event, form, message = 'Yakin ingin menghapus data ini?') {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // Red for delete specifically
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        };
    </script>
</body>

</html>