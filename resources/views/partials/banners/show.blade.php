<div data-banner-id="{{ $banner->id }}" class="banner alert alert-{{ $banner->style }} fade in clearfix">
    <button class="close" data-dismiss="alert"><span>×</span></button>
    @if($banner->icon)
        <div class="icon pull-left">
            <i class="fa {{ $banner->icon }} fa-2x"></i>
        </div>
    @endif
    <div class="content">
        <div class="title">{{ Snippet::process($banner->title, $viewData) }}</div>
        <div class="body">{{ Snippet::process($banner->body, $viewData) }}</div>
    </div>
</div>