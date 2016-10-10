<ul>
@foreach($availableSnippets as $snippet)
<li>
    <div class="snippet-shortcode">{{ $snippet['shortcode'] }}</div>
    <div class="snippet-description">{{ $snippet['description'] }}</div>
</li>
@endforeach
</ul>