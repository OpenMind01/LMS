###*
 * This is the main JavaScript file for all functionalities in the
 * front-end of P4 LMS. Client version should be minified and
 * without comments.
 *
 * @summary		JavaScript functionalities for P4 LMS.
 *
 * @since		1.0 (if available)
 * @requires 	jquery.js
 ###


###*
 * @summary Live preview for themes in client admin backend.
 *
 * Function that allows the user to see the changes in template 
 * styles in real time when they change the theme options. Must be
 * persisted by clicking the save button, it won't auto save.
 *
 * @since 	1.0
 * @access 	public
 *
 * @param 	string $name Name of the theme.
 * @param 	string $type Type of the theme (a, b or c).
 * @return 	void
 ###
themeSwitcher = (name, type) ->
	path = '/assets/css/themes/type-' + type + '/' + name + '.min.css'
	if jQuery('#p4-theme').length 
		jQuery('#p4-theme').after('<link id="p4-theme-temp" href="' + path + '" rel="stylesheet">')
		setTimeout ( ->
			jQuery('#p4-theme').attr('href', path)
			jQuery(' #p4-theme-temp').remove()
		), 300
	else 
		jQuery('head').append('<link id="p4-theme" href="' + path + '" rel="stylesheet">')
	console.log "Done"

colorBoxes = (action) ->
	false

###*
 * @summary Real time color changer for UI Demo.
 *
 * Function that allows the user to see the changes in real time for
 * the color changes of UI in back-end.
 *
 * @since 	1.0
 * @access 	public
 *
 * @param 	string $color The color to change for.
 * @return 	void
 ###
colorUpdate = (color, target) ->
	ui = jQuery(target)
	if target is "#interface-example"
		ui.find('.panel-success,.bg-success,.btn-success')
			.css('background-color', color)
			.css('border-color', 'transparent')
		ui.find('.text-success')
			.css('color', color)
	else
		true

# When all DOM is ready
jQuery ($)->

	# When the user changes the theme preferences
	$('#templateSwitcher, input[name=style_type]').on "change", ->
		name = $('#templateSwitcher').val()
		type = $('input[name=style_type]:checked').val()
		themeSwitcher name, type

	# When the user hovers a color selector
	$('input[type=color]').on "mouseover", ->
		$('#interface-example').addClass('enable')
		$('#color-name').html($(this).data('original-title'))
		colorUpdate $(this).val(), $(this).data('target')

	# When the uses changes a color
	$('input[type=color]').on "input", ->
		colorUpdate $(this).val(), $(this).data('target')

