<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Liza Cake</title>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="shortcut icon" href="{{ asset('images/icon.jpg') }}">
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <!-- Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <style>
    .food-item {
      position: relative;
      overflow: hidden;
      transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
      cursor: pointer;
    }

    .food-item:hover {
      transform: scale(1.05);
      box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
    }

    .food-item img {
      transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
    }

    .food-item:hover img {
      transform: scale(1.2);
      opacity: 0.8;
    }

    .food-item:hover .overlay {
      opacity: 1;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      opacity: 0;
      transition: opacity 0.3s ease-in-out;
    }

    @keyframes slide-up {
      0% { transform: translateY(40px); }
      100% { transform: translateY(0); }
    }

    /* Mobile specific styles */
    @media (max-width: 767.98px) {
      .navbar-nav {
        padding-top: 10px;
      }

      .nav-item {
        margin-bottom: 5px;
      }

      .nav-link {
        padding: 8px 15px;
      }

      .dropdown-menu {
        position: static;
        float: none;
        width: 100%;
      }

      .navbar-collapse {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
      }

      .cart-counter {
        position: relative;
        top: -8px;
        right: -5px;
      }

      .food-item {
        margin-bottom: 20px;
      }

      .modal-dialog {
        margin: 10px auto;
      }
    }

    /* Tablet and small desktop */
    @media (min-width: 768px) and (max-width: 991.98px) {
      .navbar-nav .nav-item {
        margin-right: 5px;
      }

      .nav-link {
        padding: 8px 10px;
      }
    }
  </style>
</head>

<body>
<div id="app" class="min-h-screen flex flex-col">
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand font-bold text-xl" href="{{ url('/') }}">
        {{ __('Liza Cake') }}
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
              aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item active mx-lg-1 my-1 my-lg-0">
            <a class="nav-link d-flex align-items-center" href="{{ route('home.index') }}" data-bs-toggle="tooltip" title="Home">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
              </svg>
              <span class="ms-1 d-lg-none">Home</span>
            </a>
          </li>

          <li class="nav-item active mx-lg-1 my-1 my-lg-0">
            <a class="nav-link d-flex align-items-center" href="{{ optional(auth()->user())->isAdmin ? route('history-order.index') : route('order.index') }}" data-bs-toggle="tooltip" title="History Pesanan">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
              </svg>
              <span class="ms-1 d-lg-none">History Pesanan</span>
            </a>
          </li>

          <li class="nav-item active mx-lg-1 my-1 my-lg-0 position-relative">
            <a class="nav-link d-flex align-items-center" href="{{ url('cart') }}" data-bs-toggle="tooltip" title="Keranjang">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
              </svg>
              @if (session('cart') != null)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-counter">
                  {{count(session('cart'))}}
                </span>
              @endif
              <span class="ms-1 d-lg-none">Keranjang</span>
            </a>
          </li>

          @can('isAdmin')
            <li class="nav-item active mx-lg-1 my-1 my-lg-0">
              <a class="nav-link d-flex align-items-center" href="{{ route('food.index') }}" data-bs-toggle="tooltip" title="View Food">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="ms-1 d-lg-none">View Food</span>
              </a>
            </li>
          @endcan

          <!-- Authentication Links -->
          @guest
            @if (Route::has('login'))
              <li class="nav-item mx-lg-1 my-1 my-lg-0">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
              </li>
            @endif

            @if (Route::has('register'))
              <li class="nav-item mx-lg-1 my-1 my-lg-0">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
              </li>
            @endif
          @else
            <li class="nav-item dropdown mx-lg-1 my-1 my-lg-0">
              <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                 data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <span class="me-1">{{ Auth::user()->name }}</span>
              </a>

              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('user.index') }}">
                  {{ __('Pengaturan') }}
                </a>
                <a id="deleteuser" class="dropdown-item" href="#">
                  {{ __('Hapus Akun') }}
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </div>
            </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>

  <!-- Remove user modal -->
  <div class="modal fade" id="remove-user-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Are you sure you want to delete the account?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0 me-3">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="red" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
            </div>
            <div>
              This action cannot be undone. All your data will be permanently deleted.
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <form name="remove_user_form" id="remove_user_form" method="POST" action='/user/{{Auth::id()}}'>
            @csrf
            @method('delete')
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Confirm Delete</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <main class="flex-grow py-4 h-full">
    <div class="container">
      @include('components.flash_message')
      @yield('content')
    </div>
  </main>

  <x-footer/>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Handle delete user modal
    const btnDeleteUser = document.querySelector('#deleteuser');
    if (btnDeleteUser) {
      btnDeleteUser.addEventListener('click', (e) => {
        e.preventDefault();
        var myModal = new bootstrap.Modal(document.getElementById('remove-user-modal'));
        myModal.show();
      })
    }
  });
</script>
</body>
</html>
