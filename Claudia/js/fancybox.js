$(document).ready(function() {
			$("a[rel=group]").fancybox({
				'overlayColor'		: '#2a2c31',
				'padding'			: '5px',	
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'outside',
				'cyclic'			: 'true',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
									  var titlestring = title.split('$');
									  return '<span id="fancybox-title-over">' + titlestring[0] + (titlestring[1].length ? ': <br /><br /> ' + titlestring[1] : '') + '</span>';
									  }
			});

		});