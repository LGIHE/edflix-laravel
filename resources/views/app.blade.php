@include('components.header')

<body class="{{ $bodyClass }}">

{{ $slot }}

@include('components.footer')
