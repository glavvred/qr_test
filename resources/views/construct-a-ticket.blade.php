@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Constructing new ticket') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="post" action="\store">
                            {{ csrf_field() }}
                            <label for="quantity">Quantity:</label>
                            <input type="string" name="quantity" alt="quantity">
                            <label for="action_name">Name:</label>
                            <input type="string" name="action_name" alt="action_name">
                            <input type="submit" value="go">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


