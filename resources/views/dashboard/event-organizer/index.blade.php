{{-- tetep --}}
@extends('../../dashboard-template')

{{-- tetep --}}
@section('page-title','Dashboard')

{{-- Sessuain --}}
@section('title','View Event Organizer')

{{--  --}}
@section('breadcrumb')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ url('/dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item text-sm text-dark active" aria-current="page">Event Organizer</li>
@endsection

@section('main-content')
<section id="screen" class="fixed-top py-5">
    <div class="container my-auto">
      <div class="row">
        <div class="col-lg-6 text-center mx-auto">
          <div class="card p-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8 d-flex text-start">
                        <h5 class="mb-0 text-primary"><b>Register new<br>Event Organizer</b></h5>
                    </div>
                    <div class="col-md-4 text-end">
                        <button onclick="closeCreateModal()" class="btn btn-sm btn-outline-secondary px-3 text-center">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @if(session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif
                        <form action="{{ url('/dashboard/event-organizer/') }}" method="post" class="text-start">
                            @csrf
                            <div class="mb-2">
                                <label for="name">Event organizer name</label>
                                <input class="form-control @error('name') is-invalid @enderror " type="text" name="name" id="name" placeholder="Tickat Corp" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for="email">Email</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email" placeholder="tickat@fikriyuwi.com" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for="phone">Phone</label>
                                <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" id="phone" placeholder="62xxxxxxxx" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="password">Password</label>
                                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" placeholder="your password" value="{{ old('password') }}">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password-confirm">Password Confirm</label>
                                        <input class="form-control @error('password-confirm') is-invalid @enderror" type="password" name="password-confirm" id="password-confirm" placeholder="confirm your password" value="{{ old('password-confirm') }}">
                                        @error('password-confirm')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="location">Location</label>
                                <input class="form-control @error('location') is-invalid @enderror" type="text" name="location" id="location" placeholder="Malang, East Java, Indonesia" value="{{ old('location') }}">
                                @error('location')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Your description..." name="description" id="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button class="btn btn-primary mt-2 w-100" type="submit">add this data</button>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
<section>
    <div class="container">
        @if(session()->has('status'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success py-3" role="alert">
                    {{ session('status') }}
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Event Organizer Data</h6>
                            </div>
                            <div class="col-md-6 text-end">
                                <button class="btn btn-primary" type="button" onclick="showCreateModal()">register new event organizer</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($eos as $eo)
                                    <tr>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="{{ url('/assets/img/team-1.jpg') }}" class="avatar avatar-sm me-3" alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $eo->EventOrganizerName }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $eo->EventOrganizerOfficeAddress }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-{{ $eo->EventOrganizerStatus == 'active' ? 'success' : 'danger' }}">{{ $eo->EventOrganizerStatus }}</span>
                                        </td>
                                        <td class="text-center d-flex">
                                            <a href="{{ url('/dashboard/event-organizer/'.$eo->EventOrganizerId) }}" class="btn btn-sm btn-primary px-3 text-light text-center me-2">
                                                <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ url('/dashboard/event-organizer/'.$eo->EventOrganizerId.'/edit') }}" class="btn btn-sm btn-secondary px-3 text-light text-center me-2">
                                                <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                            </a>
                                            <form action="{{ url('/dashboard/event-organizer/'.$eo->EventOrganizerId) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-sm btn-danger px-3 text-center me-2" data-toggle="tooltip" data-original-title="Edit user" onclick="return confirm('Are you sure want to delete {{ $eo->EventOrganizerName }}?')">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                            <form action="{{ url('/dashboard/event-organizer/'.$eo->EventOrganizerId) }}{{$eo->EventOrganizerStatus == 'active' ? '/deactive' : '/active'}}" method="get">
                                                @csrf
                                                <button class="btn btn-sm btn-{{ $eo->EventOrganizerStatus == 'active' ? 'danger' : 'success' }} px-3 text-center" data-toggle="tooltip" data-original-title="Edit user" onclick="return confirm('Are you sure want to {{ $eo->EventOrganizerStatus == 'active' ? 'deactive ' : 'active '}}{{$eo->EventOrganizerName}}?')">
                                                    <i class="fa-solid fa-{{ $eo->EventOrganizerStatus == 'active' ? 'xmark' : 'check' }}"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection