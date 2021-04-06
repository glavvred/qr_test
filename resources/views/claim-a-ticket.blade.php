@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Claiming a ticket') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($ticket->quantity > 0)
                        <form method="post" action="\claim\confirm">
                            {{ csrf_field() }}
                            <input type="hidden" name="ticket_id" readonly value="{{ $ticket->id }}">
                            Action: {{ $ticket->action_name }}
                            <label>Current quantity:
                                <input type="string" name="quantity" alt="quantity" readonly value="{{ $ticket->quantity }}">
                            </label>
                            <input type="submit" value="claim a bit">
                        </form>
                        @else
                            <h2>Ticket already claimed</h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


