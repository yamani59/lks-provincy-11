<div class="w-40-vh bg-white overflow-hidden rounded pointer hover:shadow">
    <img class="w-40-vh object-fit-cover h-20-vh" src="{{ asset('storage/' . $image) }}">
    <div class="p-3">
        <span class="h3">{{ $title }}</span>
        <div class="h-20-vh overflow-hidden">
            {{ $slot }}
        </div>
    </div>
</div>