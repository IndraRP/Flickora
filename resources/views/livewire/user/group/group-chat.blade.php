<div class="container text-white">
    <h3>Grup: {{ $group->name }}</h3>

    <div id="chat-box">
        @foreach ($messages as $message)
            <div class="message">
                <strong>{{ $message->user->name }}:</strong>
                <p>{{ $message->message }}</p>
            </div>
        @endforeach
    </div>

    <form wire:submit.prevent="sendMessage">
        <div class="input-group mt-3">
            <input type="text" wire:model="message" class="form-control" placeholder="Tulis pesan..." required>
            <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
    </form>
</div>
