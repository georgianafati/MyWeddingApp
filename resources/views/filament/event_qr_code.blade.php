<div>
    <img src="{{ (new chillerlan\QRCode\QRCode)->render(route('invite', $event->id)) }}" alt="QR Code" class="w-64 h-64" />
    <p>
        Invite in {{ $event->name }}<br />
    </p>
</div>