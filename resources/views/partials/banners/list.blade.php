@foreach($userBanners as $banner)
    @if(isset($client) && is_object($client)) {{-- */ if($banner->client_id != $client->id) continue; /* --}} @endif
    @include('partials.banners.show', ['banner' => $banner])
@endforeach