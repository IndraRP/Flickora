@extends("layouts.app")

@section("content")
    <div class="container">
        <h3>Private Chat</h3>
        <div class="list-group">
            @foreach ($conversations as $conversation)
                <a href="{{ route("chatify.private", ["id" => $conversation->id]) }}" class="list-group-item">
                    <h5>{{ $conversation->users->first()->name ?? "Unknown" }}</h5>
                    <p class="text-muted">{{ $conversation->lastMessage?->body ?? "No messages yet" }}</p>
                </a>
            @endforeach
        </div>
    </div>
@endsection
