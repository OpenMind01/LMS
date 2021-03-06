{!! Form::hidden('client_id', $client->id) !!}

<div class="form-group">
    {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('icon', 'Icon', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10 ">
	    <div class="btn-group">
	  		<button type="button" class="btn " id="icon-place">
	  		@if(!empty($module) && $module->icon)
	  		<span class="{{$module->icon}}" aria-hidden="true"></span>
	  		@else 
	  		<span class="glyphicon" aria-hidden="true"></span>
	  		@endif
	  		</button>
	  		<button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    	<span class="caret"></span>
	    	<span class="sr-only">Toggle Dropdown</span>
	  		</button>

	  		<button type="button" class="btn btn-danger icon-remove" 	  		
	  		><i class="fa fa-trash"></i></button>

	  		<ul class="dropdown-menu icon-gallery-list">
	  			<li> 
	  				<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
	  			</li>

	  			<li> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
	  			</li>

				 <li> <span class="glyphicon glyphicon-euro" aria-hidden="true"></span> </li>

				 <li> <span class="glyphicon glyphicon-eur" aria-hidden="true"></span> </li>

				 <li> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-cloud" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-glass" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-music" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-search" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-heart" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-star" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-film" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-th" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-zoom-out" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-off" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-signal" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-home" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-file" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-time" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-road" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-download" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-play-circle" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-lock" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-flag" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-headphones" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-volume-off" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-volume-down" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-volume-up" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-barcode" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-tag" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-tags" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-book" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-camera" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-font" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-bold" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-italic" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-text-height" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-text-width" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-align-center" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-align-right" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-list" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-indent-left" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-indent-right" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-picture" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-adjust" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-tint" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-share" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-check" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-move" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-fast-backward" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-backward" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-play" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-pause" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-stop" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-forward" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-fast-forward" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-eject" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-screenshot" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-resize-full" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-resize-small" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-gift" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-leaf" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-fire" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-plane" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-random" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-magnet" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-retweet" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-resize-vertical" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-resize-horizontal" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-hdd" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-bell" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-certificate" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-hand-left" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-hand-down" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-circle-arrow-up" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-globe" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-filter" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-link" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-phone" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-usd" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-gbp" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-sort" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-sort-by-alphabet" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-sort-by-alphabet-alt" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-sort-by-order" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-sort-by-order-alt" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-expand" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-collapse-up" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-flash" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-record" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-save" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-open" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-saved" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-import" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-export" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-send" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-floppy-saved" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-floppy-remove" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-floppy-open" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-header" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-compressed" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-tower" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-stats" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-sd-video" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-hd-video" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-subtitles" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-sound-stereo" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-sound-dolby" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-sound-5-1" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-sound-6-1" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-sound-7-1" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-copyright-mark" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-registration-mark" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-tree-conifer" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-tree-deciduous" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-cd" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-open-file" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-level-up" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-copy" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-paste" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-alert" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-equalizer" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-king" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-queen" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-pawn" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-bishop" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-knight" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-baby-formula" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-tent" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-bed" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-apple" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-erase" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-lamp" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-piggy-bank" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-scissors" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-bitcoin" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-btc" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-xbt" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-yen" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-jpy" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-ruble" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-rub" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-scale" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-ice-lolly" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-ice-lolly-tasted" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-education" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-modal-window" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-oil" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-grain" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-text-size" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-text-color" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-text-background" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-object-align-top" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-object-align-bottom" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-object-align-horizontal" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-object-align-left" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-object-align-vertical" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-object-align-right" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-console" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-superscript" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-subscript" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span> </li>
				 <li> <span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span> </li>
				 </ul>
	  		
		</div>        
		{!! Form::hidden('icon', Input::old('icon'), ['class' => 'form-control', 'placeholder' => 'icon']) !!}
    </div>
</div>

@if(!empty($module) && $module->id)
<div class="form-group">
    {!! Form::label('slug', 'Slug', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('slug', Input::old('slug'), ['class' => 'form-control', 'placeholder' => 'Slug']) !!}
    </div>
</div>
@endif
