<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <div class="d-flex align-items-center flex-grow-1 min-w-0">
            <button type="button"
                    class="btn btn-outline-secondary d-flex align-items-center justify-content-center me-2 me-lg-3"
                    id="sidebarToggle"
                    aria-label="Toggle navigation">
                <i class="bi bi-list fs-4"></i>
            </button>
            <div class="d-flex flex-column">
                <h1 class="h5 mb-0 fw-semibold">@yield('page_title', config('app.name'))</h1>
            <small class="text-muted">@yield('page_subtitle')</small>
            </div>
            
        </div>

         <!-- Right Side (User Dropdown) -->
            <ul class="navbar-nav ms-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        {{ auth()->user()->name }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                Profile
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item">
                                    Logout
                                </button>
                            </form>
                        </li>

                    </ul>
                </li>

            </ul>
    </div>

    </nav>
