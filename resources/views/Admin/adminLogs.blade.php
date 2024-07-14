<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link href="{{ asset('/css/trackadmin.css') }}" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('/logo/R_logo_2.jpg') }}">
    @extends('Admin.layout')
</head>

<body>
<nav class="navbar shadow-lg navbar-expand-sm bg-black custom-nav">
        <div class="container">
            <h1>Stockpile</h1>
            <div class="btn-group ms-auto">
                <button class="btn btn-sm  custom-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <span class="d-none d-sm-block">
                            @auth
                                @if(auth()->check() && auth()->user()->name)
                                    <span style="color: white">{{ auth()->user()->name }}</span>
                                @else
                                    Welcome, valued user!
                                @endif
                            @endauth

                        </span>
                        <span style="color: white; padding-left:1vh;" class="dropdown-toggle"></span>
                    </div>

                </button>
                <ul class="dropdown-menu dropdown-menu-end" id="targetItems" style="z-index:99999;">
                    <li class="d-flex justify-content-center align-items-center"
                        style="white-space:nowrap; padding: 1vh 6vh;"><i class="ti ti-user-circle icon"> </i>Admin ID:
                        {{ auth()->user()->id }}</li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item d-flex justify-content-center align-items-center"
                            style="white-space:nowrap; padding: 1vh 6vh;" href="{{ route('logout') }}"><i
                                class="ti ti-logout-2 icon"> </i>
                            Logout</a></li>
                </ul>
            </div>

        </div>
    </nav>
    <div class="sticky-navbar">
        <div class="container stk-cont">
            <a class="btn" href="{{ route('Admin.index') }}">
                <li class="{{ request()->routeIs('Admin.index') ? 'active' : '' }}">Dashboard</li>
            </a>
            <a class="btn" href="{{ route('Admin.trackorder') }}">
                <li class="{{ request()->routeIs('Admin.trackorder') ? 'active' : '' }}">Track Order</li>
            </a>
            <a class="btn" href="{{ route('admin.logs') }}">
                <li class="{{ request()->routeIs('admin.logs') ? 'active' : '' }}">Admin Logs</li>
            </a>
            <a class="btn" href="{{ route('catalogs.index') }}" target="_blank">
                <li class="{{ request()->routeIs('catalogs.index') ? 'active' : '' }}">Catalog</li>
            </a>
        </div>
    </div>
    <div class="container">
        <h1>Admin Logs</h1>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Date</th>
                        <th>Admin ID</th>
                        <th>Action</th>
                        <th>Description</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $log->user->id }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->description }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $logs->links() }} {{-- Pagination links --}}
    </div>
</body>