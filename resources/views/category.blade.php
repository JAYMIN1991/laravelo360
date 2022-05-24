@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Category') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    {!!Form::open(array('route' => 'store', 'method' => 'POST'))!!}

                    {{Form::text('title')}}<br>
                    <br>
                    {{Form::submit('submit')}}
                    {!!Form::close()!!}

                    
                    <h5 class="card-header">Categories</h5>
                        <div class="card-body">
                         <div class="row">
                         {!!Form::open(array('route' => 'savetodb', 'method' => 'POST'))!!}
                         @if(Session::get('category'))
                                @foreach(Session::get('category') as $category)
                                <div class="col-lg-12">
                                <ul class="list-unstyled mb-0">
                                    <li>
                                    <a href="#">{{($category)}}</a>
                                    </li>
                                </ul>
                                </div>
                                @endforeach
                            @endif
                            <br>
                            {{Form::submit('submit')}}
                            {!!Form::close()!!}
                            </div>
                        </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
