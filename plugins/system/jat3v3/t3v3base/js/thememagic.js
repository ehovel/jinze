
!function($){
	T3V3Theme = window.T3V3Theme || {};

	$.extend(T3V3Theme, {
		handleLink: function(){
			var links = document.links,
				forms = document.forms,
				origin = [window.location.protocol, '//', window.location.hostname, window.location.port].join(''),
				iter, i, il;

			for(i = 0, il = links.length; i < il; i++) {
				iter = links[i];

				if(iter.href && iter.hostname == window.location.hostname && iter.href.indexOf('#') == -1){
					iter.href = iter.href + (iter.href.lastIndexOf('?') != -1 ? '&' : '?') + (iter.href.lastIndexOf('themer=') == -1 ? 'themer=Y' : ''); 
				}
			}

			
			for(i = 0, il = forms.length; i < il; i++) {
				iter = forms[i];

				if(iter.action.indexOf(origin) == 0){
					iter.action = iter.action + (iter.action.lastIndexOf('?') != -1 ? '&' : '?') + (iter.action.lastIndexOf('themer=') == -1 ? 'themer=Y' : ''); 
				}
			}
		},
		applyLess: function(data){
			if(data && typeof data == 'object'){
				T3V3Theme.vars = data.vars;
				T3V3Theme.others = data.others;
				T3V3Theme.theme = data.theme;		
			}
			
			less.refresh(true);
		},

		onCompile: function(completed, total){
			if(window.parent != window && window.parent.T3V3Theme){
				window.parent.T3V3Theme.onCompile(completed, total);
			}

			if(completed >= total){
				T3V3Theme.bodyReady();
			}
		},

		bodyReady: function(){
			if(!this.ready){
				$(document).ready(function(){
					T3V3Theme.ready = 1;
					$(document.body).addClass('ready');
				});
			} else {
				$(document.body).addClass('ready');
			}
		}
	});

	$(document).ready(function(){
		T3V3Theme.handleLink();
	});
	
}(window.$ja || window.jQuery);
