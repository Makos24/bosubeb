<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

      <!-- Tailwind is included -->
  <link rel="stylesheet" href="css/main.css?v=1628755089081">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

<!-- Styles -->
<link rel="stylesheet" href="{{ mix('css/app.css') }}">     

<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png"/>
<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png"/>
<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png"/>
<link rel="mask-icon" href="safari-pinned-tab.svg" color="#00b4b6"/>

<meta name="description" content="Admin One - free Tailwind dashboard">

<meta property="og:url" content="https://justboil.github.io/admin-one-tailwind/">
<meta property="og:site_name" content="JustBoil.me">
<meta property="og:title" content="Admin One HTML">
<meta property="og:description" content="Admin One - free Tailwind dashboard">
<meta property="og:image" content="https://justboil.me/images/one-tailwind/repository-preview-hi-res.png">
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="1920">
<meta property="og:image:height" content="960">

<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:title" content="Admin One HTML">
<meta property="twitter:description" content="Admin One - free Tailwind dashboard">
<meta property="twitter:image:src" content="https://justboil.me/images/one-tailwind/repository-preview-hi-res.png">
<meta property="twitter:image:width" content="1920">
<meta property="twitter:image:height" content="960">

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-130795909-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-130795909-1');
</script>


        @livewireStyles
        <style>
            [x-cloak] { display: none !important; }
        </style>

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="font-sans antialiased">

        @livewire('navigation-menu')

<aside class="aside is-placed-left is-expanded">
  <div class="aside-tools">
    <div>
      Admin <b class="font-black">One</b>
    </div>
  </div>
  <div class="menu is-menu-main">
    <p class="menu-label">General</p>
    <ul class="menu-list">
      <li @if(request()->routeIs('dashboard'))class="active"@endif>
        <a href="{{route('dashboard')}}">
          
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
</svg>
          <span class="menu-item-label mx-2">Dashboard</span>
        </a>
      </li>
    </ul>
    <p class="menu-label">Secondary</p>
    <ul class="menu-list">
    <li @if(request()->routeIs('lgas'))class="active"@endif>
        <a href="{{route('lgas')}}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
</svg>
          <span class="menu-item-label mx-2">LGAs</span>
        </a>
      </li>
      <li @if(request()->routeIs('schools'))class="active"@endif>
        <a href="{{route('schools')}}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
</svg>
          <span class="menu-item-label mx-2">Schools</span>
        </a>
      </li>
      <li @if(request()->routeIs('staff'))class="active"@endif>
        <a href="{{route('staff')}}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
</svg>
          <span class="menu-item-label mx-2">Staff Data</span>
        </a>
      </li>
      <li @if(request()->routeIs('ministries'))class="active"@endif>
        <a href="{{route('ministries')}}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
</svg>
          <span class="menu-item-label mx-2">Ministries</span>
        </a>
      </li>
      <li @if(request()->routeIs('agencies'))class="active"@endif>
        <a href="{{route('agencies')}}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
</svg>
          <span class="menu-item-label mx-2">Agencies</span>
        </a>
      </li>
     
      <li>
        <a class="dropdown">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
</svg>
          <span class="menu-item-label mx-2">Users</span>
          <span class="icon"><i class="mdi mdi-plus"></i></span>
        </a>
        <ul>
          <li>
            <a href="#void">
              <span>Sub-item One</span>
            </a>
          </li>
          <li>
            <a href="#void">
              <span>Sub-item Two</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
    <!-- <p class="menu-label">About</p>
    <ul class="menu-list">
      <li>
        <a href="https://justboil.me" onclick="alert('Coming soon'); return false" target="_blank" class="has-icon">
          <span class="icon"><i class="mdi mdi-credit-card-outline"></i></span>
          <span class="menu-item-label mx-2">Premium Demo</span>
        </a>
      </li>
      <li>
        <a href="https://justboil.me/tailwind-admin-templates" class="has-icon">
          <span class="icon"><i class="mdi mdi-help-circle"></i></span>
          <span class="menu-item-label mx-2">About</span>
        </a>
      </li>
      <li>
        <a href="https://github.com/justboil/admin-one-tailwind" class="has-icon">
          <span class="icon"><i class="mdi mdi-github-circle"></i></span>
          <span class="menu-item-label mx-2">GitHub</span>
        </a>
      </li>
    </ul> -->
  </div>
</aside>


<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>{{$header}}</li>
    </ul>
   
  </div>
</section>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
       
        @stack('modals')

        @livewireScripts

<script>
     
    window.addEventListener('swal',function(e){
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Data saved successfully',
                showConfirmButton: false,
                timer: 1500
            })
        });

        window.addEventListener('swal_del',function(e){
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Deleted!',
                'Record has been deleted.',
                'success'
              )
  }
})
        });
</script>
    </body>
</html>
