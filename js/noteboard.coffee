jQuery ($) ->
	notes = $ '#notes'
	
	init = ->
		scrollable()
	
	scrollable = ->
		notes.kinetic
			triggerHardware : yes

		$( 'input, textarea, #note' ).focusout ->
			notes.kinetic 'attach'
		.focusin ->
			notes.kinetic 'detach'
		
		shim()
		
	shim = ->			
		$( '#notes-by-group, #notes' )
			.wrapInner '<table cellspacing="30"><tr>'
			
		$( '#notes-by-group .group:not(.all), .section' )
			.wrap '<td valign="top"></td>'
			
		$( '#notes-by-group .group' ).each ->
			group = $ @
			notes = group
					.children( '.group-of-notes' )
					.children( 'li' )
			size  = notes.size()
			
			if group.hasClass 'all'
				group.css 'width', ( (size / 2) + 1 ) * 260
			else
				group.css 'width', if size > 3 then 780 else (size * 260)
				
		$( '#notes.kinetic-active' ).css
			height : $(window).height() - $( '#notes' ).offset().top
	
	init()