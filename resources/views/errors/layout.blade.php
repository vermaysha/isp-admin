@extends('layouts.pages')

@section('content')
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="clearfix">
                        <h1 class="float-start display-3 me-4">@yield('code')</h1>
                        <h4 class="pt-3">@yield('title')</h4>
                        <p class="text-medium-emphasis">@yield('message')</p>
                    </div>
                    {{-- <div class="input-group"><span class="input-group-text">
              <i class="icon cil cil-magnifying-glass"></i></span>
            <input class="form-control" id="prependedInput" size="16" type="text" placeholder="What are you looking for?">
            <button class="btn btn-info" type="button">Search</button>
          </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
