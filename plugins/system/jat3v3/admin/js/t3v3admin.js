var T3V3Admin = window.T3V3Admin || {};

!function ($) {

	$.extend(T3V3Admin, {
		layout: {
			maxcol: {
				'default': 6,
				'normal': 6,
				'wide': 6,
				'xtablet': 4,
				'tablet': 3,
				'mobile': 2
			},
			minspan: {
				'default': 2,
				'normal': 2,
				'wide': 2,
				'xtablet': 3,
				'tablet': 4,
				'mobile': 6
			},
			unitspan: {
				'default': 1,
				'normal': 1,
				'wide': 1,
				'xtablet': 1,
				'tablet': 1,
				'mobile': 6
			},
			clayout: 'default',
			nlayout: 'default',
			maxgrid: 12,
			maxcols: 6,
			mode: 0,

			rspace: /\s+/,
			rclass: /[\t\r\n]/g
		},

		initBuildLessBtn: function(){
			//t3 added
			$('#t3-toolbar-recompile').on('click', function(){
				var jrecompile = $(this);
				jrecompile.addClass('loading');
				$.get(T3V3Admin.adminurl, {'t3action': 'lesscall'}, function(rsp){
					jrecompile.removeClass('loading');

					rsp = $.trim(rsp);
					if(rsp){
						var json = rsp;
						if(rsp.charAt(0) != '[' && rsp.charAt(0) != '{'){
							json = rsp.match(/{.*?}/);
							if(json && json[0]){
								json = json[0];
							}
						}

						if(json && typeof json == 'string'){
							json = $.parseJSON(json);

							if(json && (json.error || json.successful)){
								T3V3Admin.systemMessage(json.error || json.successful);
							}
						}
					}
				});
				return false;
			});

			$('#t3-toolbar-themer').on('click', function(){
				if(!T3V3Admin.themermode){
					alert(T3V3Admin.langs.enableThemeMagic);
				} else {
					window.location.href = T3V3Admin.themerUrl;
				}
				return false;
			});

			//for style toolbar
			$('#t3-toolbar-style-save-save').on('click', function(){
				Joomla.submitbutton('style.apply');
			});

			$('#t3-toolbar-style-save-close').on('click', function(){
				Joomla.submitbutton('style.save');
			});
			
			$('#t3-toolbar-style-save-clone').on('click', function(){
				Joomla.submitbutton('style.save2copy');
			});

			$('#t3-toolbar-close').on('click', function(){
				Joomla.submitbutton(($(this).hasClass('template') ? 'template' : 'style') + '.cancel');
			});
		},

		initRadioGroup: function(){
			//copy from J3.0
			// Turn radios into btn-group
			$('.radio.btn-group label').addClass('btn');
			$('.btn-group label').unbind('click').click(function() {
				var label = $(this),
					input = $('#' + label.attr('for'));

				if (!input.prop('checked')){
					label.closest('.btn-group')
						.find('label')
						.removeClass('active btn-success btn-danger btn-primary');

					label.addClass('active ' + (input.val() == '' ? 'btn-primary' : (input.val() == 0 ? 'btn-danger' : 'btn-success')));
					
					input.prop('checked', true).trigger('change.less');
				}

			});

			$('.btn-group input[checked=checked]').each(function(){
				if($(this).val() == ''){
					$('label[for=' + $(this).attr('id') + ']').addClass('active btn-primary');
				} else if($(this).val() == 0){
					$('label[for=' + $(this).attr('id') + ']').addClass('active btn-danger');
				} else {
					$('label[for=' + $(this).attr('id') + ']').addClass('active btn-success');
				}
			});
		},
		
		initChosen: function(){
			$('#style-form').find('select').chosen({
				disable_search_threshold : 10,
				allow_single_deselect : true
			});
		},

		initT3Title: function(){
			var jptitle = $('.pagetitle');
			if(jptitle.length==0) {
				var jptitle = $('#mc-title');
			}
			if (!jptitle.length) jptitle = $('.page-title');
			var titles = jptitle.html().split(':');

			jptitle.html(titles[0] + '<small>' + titles[1] + '</small>');
		},

		hideDisabled: function(){
			$('#style-form').find('[disabled="disabled"]').filter(function(){
				return this.name.match(/^.*?\[params\]\[(.*?)\]/)
			}).closest('.control-group').hide();
		},

		initPreSubmit: function(){

			var form = document.adminForm;
			if(!form){
				return false;
			}

			var onsubmit = form.onsubmit;

			form.onsubmit = function(e){
				var json = {},
					urlparts = form.action.split('#');
					
				if(/apply|save2copy/.test(form['task'].value)){
					t3active = $('.t3-admin-nav .active a').attr('href').replace(/.*(?=#[^\s]*$)/, '').substr(1);

					if(urlparts[0].indexOf('?') == -1){
						urlparts[0] += '?t3lock=' + t3active;
					} else {
						urlparts[0] += '&t3lock=' + t3active;
					}
					
					form.action = urlparts.join('#');
				}
					
				var jcontainer = $(this).find('.t3-layout-cont'),
					jblocks = jcontainer.find('.t3-layout-pos'),
					jspls = jcontainer.find('[data-spotlight]'),
					jsplblocks = jspls.find('.t3-layout-pos');

				jblocks.not(jspls).not(jsplblocks).not('.block-message, .block-component').each(function(){
					var name = $(this).attr('data-original'),
						val = $(this).find('.t3-layout-posname').html(),
						vis = $(this).closest('[data-vis]').data('data-vis'),
						others = $(this).closest('[data-others]').data('data-others'),
						info = {position: val ? val : '', 'default': '', wide: '', normal: '', xtablet: '', tablet: '', mobile: ''};

					if(vis){
						vis = T3V3Admin.t3visible(0, vis.vals);
						T3V3Admin.t3formatvisible(info, vis);
						T3V3Admin.t3formatothers(info, others);
					}

					//optimize
					T3V3Admin.t3opimizeparam(info);

					json[name] = info;
				});
				
				jspls.each(function(){
					var name = $(this).attr('data-spotlight'),
						vis = $(this).data('data-vis'),
						widths = $(this).data('data-widths'),
						firsts = $(this).data('data-firsts'),
						others = $(this).data('data-others');

					$(this).children().each(function(idx){
						var jpos = $(this),
							pname = jpos.find('.t3-layout-pos').attr('data-original'),
							val = jpos.find('.t3-layout-posname').html(),
							info = {position: val, 'default': '', wide: '', normal: '', xtablet: '', tablet: '', mobile: ''},
							width = T3V3Admin.t3getwidth(idx, widths),
							visible = T3V3Admin.t3visible(idx, vis.vals),
							first = T3V3Admin.t3first(idx, firsts),
							other = T3V3Admin.t3others(idx, others);

						T3V3Admin.t3formatwidth(info, width);
						T3V3Admin.t3formatvisible(info, visible);
						T3V3Admin.t3formatfirst(info, first);
						T3V3Admin.t3formatothers(info, other);

						//optimize
						T3V3Admin.t3opimizeparam(info);

						json['block' + (idx + 1) + '@' + name] = info;
					
					});
				});

				$.ajax({
					async: false,
					url: T3V3Admin.mergeurl('t3action=layout&t3task=save&template=' + T3V3Admin.template + '&layout=' + $('#jform_params_mainlayout').val()),
					type: 'post',
					data: json,
					complete: function(){
						if($.isFunction(onsubmit)){
							onsubmit();
						}
					}
				});
			};

			//clean the json code - the value is no need
			$('#jform_params_jat3v3_positions').val('');
		},

		initLayoutPosition: function(){
			$(window).load(function(){
				setTimeout(function(){
					$('#jform_params_mainlayout').trigger('change.less');
				}, 500);
			});
		},

		initChangeStyle: function(){
			$('#t3-styles-list').on('change', function(){
				window.location.href = T3V3Admin.baseurl + '/index.php?option=com_templates&task=style.edit&id=' + this.value;
			});
		},

		initCheckupdate: function(){
			
			var tinfo = $('#tpl-info dd'),
				finfo = $('#frmk-info dd');

			T3V3Admin.chkupdating = null;
			T3V3Admin.tplname = tinfo.eq(0).html();
			T3V3Admin.tplversion = tinfo.eq(1).html();
			T3V3Admin.frmkname = finfo.eq(0).html();
			T3V3Admin.frmkversion = finfo.eq(1).html();
			
			$('#framework-home .updater, #template-home .updater').on('click', 'a.btn', function(){
				
				//if it is outdated, then we go direct to link
				if($(this).closest('.updater').hasClass('outdated')){
					return true;
				}

				//if we are checking, ignore this click, wait for it complete
				if(T3V3Admin.chkupdating){
					return false;
				}

				//checking
				$(this).addClass('loading');
				T3V3Admin.chkupdating = this;
				T3V3Admin.checkUpdate();

				return false;
			});
		},

		checkUpdate: function(){
			$.ajax({
				url: T3V3Admin.t3updateurl,
				data: {eid: T3V3Admin.eids},
				success: function(data) {
					var jfrmk = $('#framework-home .updater:first'),
						jtemp = $('#template-home .updater:first');

					jfrmk.find('.btn').removeClass('loading');
					jtemp.find('.btn').removeClass('loading');
					
					try {
						var ulist = $.parseJSON(data);
					} catch(e) {
						T3V3Admin.alert(T3V3Admin.langs.updateFailedGetList, T3V3Admin.chkupdating);
					}

					if (ulist instanceof Array) {
						if (ulist.length > 0) {
							
							var	chkfrmk = !jfrmk.hasClass('outdated'),
								chktemp = !jtemp.hasClass('outdated');

							if(chkfrmk || chktemp){
								for(var i = 0, il = ulist.length; i < il; i++){

									if(chkfrmk && ulist[i].element == T3V3Admin.felement && ulist[i].type == 'plugin'){
										jfrmk.addClass('outdated');
										jfrmk.find('.btn').attr('href', T3V3Admin.jupdateUrl).html(T3V3Admin.langs.updateDownLatest);
										jfrmk.find('h3').html(T3V3Admin.langs.updateHasNew.replace(/%s/g, T3V3Admin.frmkname));
										
										var ridx = 0,
											rvals = [T3V3Admin.frmkversion, T3V3Admin.frmkname, ulist[i].version];
										jfrmk.find('p').html(T3V3Admin.langs.updateCompare.replace(/%s/g, function(){
											return rvals[ridx++];
										}));

										T3V3Admin.langs.updateCompare.replace(/%s/g, function(){ return '' })
									}
									if(chktemp && ulist[i].element == T3V3Admin.telement && ulist[i].type == 'template'){
										jtemp.addClass('outdated');
										jtemp.find('.btn').attr('href', T3V3Admin.jupdateUrl).html(T3V3Admin.langs.updateDownLatest);

										jtemp.find('h3').html(T3V3Admin.langs.updateHasNew.replace(/%s/g, T3V3Admin.tplname));
										
										var ridx = 0,
											rvals = [T3V3Admin.tplversion, T3V3Admin.tplname, ulist[i].version];
										jtemp.find('p').html(T3V3Admin.langs.updateCompare.replace(/%s/g, function(){
											return rvals[ridx++];
										}));
									}
								}

								T3V3Admin.alert(T3V3Admin.langs.updateChkComplete, T3V3Admin.chkupdating);
							}
						}
					} else {
						T3V3Admin.alert(T3V3Admin.langs.updateFailedGetList, T3V3Admin.chkupdating);
					}

					T3V3Admin.chkupdating = null;
				},
				error: function() {
					T3V3Admin.alert(T3V3Admin.langs.updateFailedGetList, T3V3Admin.chkupdating);
					T3V3Admin.chkupdating = null;
				}
			});
		},

		initSystemMessage: function(){
			var jmessage = $('#system-message');
				
			if(!jmessage.length){
				jmessage = $('' + 
					'<dl id="system-message">' +
						'<dt class="message">Message</dt>' +
						'<dd class="message">' +
							'<ul><li></li></ul>' +
						'</dd>' +
					'</dl>').hide().appendTo($('#system-message-container'));
			}

			T3V3Admin.message = jmessage;
		},

		systemMessage: function(msg){
			T3V3Admin.message.show();
			if(T3V3Admin.message.find('li:first').length){
				T3V3Admin.message.find('li:first').html(msg).show();
			} else {
				T3V3Admin.message.html('' + 
					'<div class="alert">' +
						'<h4>Message</h4>' + 
						'<p>' + msg + '</p>' +
					'</div>');
			}
			
			clearTimeout(T3V3Admin.msgid);
			T3V3Admin.msgid = setTimeout(function(){
				T3V3Admin.message.hide();
			}, 5000);
		},

		alert: function(msg, place){
			clearTimeout($(place).data('alertid'));
			$(place).after('' + 
				'<div class="alert">' +
					'<p>' + msg + '</p>' +
				'</div>').data('alertid', setTimeout(function(){
					$(place).nextAll('.alert').remove();
				}, 5000));
		},

		switchTab: function () {
			$('a[data-toggle="tab"]').on('shown', function (e) {
				var url = e.target.href;
			  	window.location.hash = url.substring(url.indexOf('#')).replace ('_params', '');
			});

			var hash = window.location.hash;
			if (hash) {
				$('a[href="' + hash + '_params' + '"]').tab ('show');
			} else {
				var url = $('ul.nav-tabs li.active a').attr('href');
				if (url) {
			  		window.location.hash = url.substring(url.indexOf('#')).replace ('_params', '');
				} else {
					$('ul.nav-tabs li:first a').tab ('show');
				}
			}
		},

		mergeurl: function(query, base){
			base = base || window.location.href;
			var urlparts = base.split('#');
			
			if(urlparts[0].indexOf('?') == -1){
				urlparts[0] += '?' + query;
			} else {
				urlparts[0] += '&' + query;
			}
			
			return urlparts.join('#');
		},

		//this is not a general function, just use for t3 only - better performance
		t3copy: function(dst, src, valueonly){
			for(var p in src){
				if(src.hasOwnProperty(p)){
					if(!dst[p]){
						dst[p] = [];
					}

					for(var i = 0, s = src[p], il = s.length; i < il; i++){
						if(!valueonly || valueonly && s[i]){
							dst[p][i] = s[i];
						}
					}
				}
			}

			return dst;
		},

		t3equalheight: function(jcontainer){
			var property = ($.browser.msie && $.browser.version < 7) ? 'height' : 'min-height';

			// Store the tallest element's height
			$($(jcontainer).find('.row, .row-fluid').not('.ja-spotlight').get().reverse()).each(function(){
				var jrow = $(this),
					jchilds = jrow.children(),
					offset = jrow.offset().top,
					height = 0,
					maxHeight = 0;

				jchilds.each(function () {
					height = $(this).css('height', '').css('min-height', '').height();
					maxHeight = (height > maxHeight) ? height : maxHeight;
				});

				if(T3V3Admin.layout.clayout != 'mobile'){
					jchilds.css(property, maxHeight);
				}
			});
		},

		t3removeclass: function(clslist, clsremove){
			var removes = ( clsremove || '' ).split( T3V3Admin.layout.rspace ),
				lookup = (' '+ clslist + ' ').replace( T3V3Admin.layout.rclass, ' '),
				result = [];

			// loop over each item in the removal list
			for ( var c = 0, cl = removes.length; c < cl; c++ ) {
				// Remove until there is nothing to remove,
				if ( lookup.indexOf(' '+ removes[ c ] + ' ') == -1 ) {
					result.push(removes[c]);
				}
			}
			
			return result.join(' ');
		},

		t3opimizeparam: function(pos){
			var defcls = pos['default'];
			for(var p in pos){
				if(pos.hasOwnProperty(p) && pos[p] === defcls && p != 'default'){
					pos[p] = T3V3Admin.t3removeclass(defcls, pos[p]);
				}
			}

			//remove span100
			pos.mobile = T3V3Admin.t3removeclass('span100 spanfirst', pos.mobile);
			
			//remove empty property
			for(var p in pos){
				if(pos[p] === ''){
					delete pos[p];
				}
			}
		},

		t3formatwidth: function(result, info){
			for(var p in info){
				if(info.hasOwnProperty(p)){
					//width always be first - no need for a space
					result[p] += 'span' + T3V3Admin.t3widthconvert(info[p], p);
				}
			}
		},

		t3formatvisible: function(result, info){
			for(var p in info){
				if(info.hasOwnProperty(p) && info[p] == 1){
					result[p] += ' hidden';
				}
			}
		},

		t3formatfirst: function(result, info){
			for(var p in info){
				if(info.hasOwnProperty(p) && info[p] == 1){
					result[p] += ' spanfirst';
				}
			}
		},

		t3formatothers: function(result, info){
			for(var p in info){
				if(info.hasOwnProperty(p) && info[p] != ''){
					result[p] += ' ' + info[p];
				}
			}
		},

		//generate auto calculate width
		t3widthoptimize: function(numpos){
			var result = [],
				avg = Math.floor(T3V3Admin.layout.maxgrid / numpos),
				sum = 0;

			for(var i = 0; i < numpos - 1; i++){
				result.push(avg);
				sum += avg;
			}

			result.push(T3V3Admin.layout.maxgrid - sum);

			return result;
		},

		t3genwidth: function(layout, numpos){
			var cmaxcol = T3V3Admin.layout.maxcol[layout],
				cminspan = (layout == 'mobile') ? T3V3Admin.layout.maxgrid : T3V3Admin.layout.minspan[layout],
				cpmaxcol = cmaxcol - 1,
				total = cminspan * numpos,
				sum = 0;

			if(total <= T3V3Admin.layout.maxgrid) {
				return T3V3Admin.t3widthoptimize(numpos);
			} else {

				var result = [],
					rows = Math.ceil(total / T3V3Admin.layout.maxgrid),
					cols = Math.ceil(numpos / rows);

				for(var i = 0; i < rows - 1; i++){
					result = result.concat(T3V3Admin.t3widthoptimize(cols));
					numpos -= cols;
				}

				result = result.concat(T3V3Admin.t3widthoptimize(numpos));
			}
			
			return result;
		},

		t3widthbyvisible: function(widths, visibles, numpos){
			var i, dv, nvisible,
				width, visible, visibleIdxs = [];

			for(dv in widths){
				if(widths.hasOwnProperty(dv)){
					visible = visibles[dv],
					visibleIdxs.length = 0,
					nvisible = 0;

					for(i = 0; i < numpos; i++){
						if(visible[i] == 0 || visible[i] == undefined){
							visibleIdxs.push(i);
						}
					}

					width = T3V3Admin.t3genwidth(dv, visibleIdxs.length);

					for(i = 0; i < visibleIdxs.length; i++){
						widths[dv][visibleIdxs[i]] = width[i];
					}
				}
			}
		},

		t3getwidth: function(pidx, widths){
			var result = { 'default': 0,  wide: 0, normal: 0, xtablet: 0, tablet: 0, mobile: 0 },
				dv = null;

			for(dv in widths){
				if(widths.hasOwnProperty(dv)){
					result[dv] = widths[dv][pidx];
				}
			}
			
			return result;
		},

		t3widthconvert: function(span, layout){
			return ((layout || T3V3Admin.layout.clayout) == 'mobile') ? Math.floor(span / 12 * 100) : span;
		},

		t3visible: function(pidx, visible){
			var result = { 'default': 0,  wide: 0, normal: 0, xtablet: 0, tablet: 0, mobile: 0 },
				dv = null;

			for(dv in visible){
				if(visible.hasOwnProperty(dv)){
					result[dv] = visible[dv][pidx] || 0;
				}
			}
			
			return result;
		},

		t3first: function(pidx, firsts){
			var result = { 'default': 0,  wide: 0, normal: 0, xtablet: 0, tablet: 0, mobile: 0 },
				dv = null;

			for(dv in firsts){
				if(firsts.hasOwnProperty(dv)){
					result[dv] = firsts[dv][pidx] || 0;
				}
			}
			
			return result;
		},

		t3others: function(pidx, others){
			var result = { 'default': '', wide: '', normal: '', xtablet: '', tablet: '', mobile: '' },
				dv = null;

			for(dv in others){
				if(others.hasOwnProperty(dv)){
					result[dv] = others[dv][pidx] || '';
				}
			}
			
			return result;
		},

		// change the grid limit 
		t3updategrid: function (spl) {
			//update grid and limit for resizable
			var jspl = $(spl),
				layout = T3V3Admin.layout.clayout,
				cmaxcol = T3V3Admin.layout.maxcol[layout],
				junitspan = $('<div class="span' + T3V3Admin.t3widthconvert(T3V3Admin.layout.unitspan[layout]) + '"></div>').appendTo(jspl),
				jminspan = $('<div class="span' + T3V3Admin.t3widthconvert(T3V3Admin.layout.minspan[layout]) + '"></div>').appendTo(jspl),
				gridgap = parseInt(junitspan.css('marginLeft')),
				absgap = Math.abs(gridgap),
				gridsize = Math.floor(junitspan.width())
				minsize = Math.floor(jminspan.width()),
				widths = jspl.data('data-widths'),
				firsts = jspl.data('data-firsts'),
				visible = jspl.data('data-vis').vals[layout],
				width = widths[layout],
				first = firsts[layout],
				needfirst = visible[0] == 1,
				sum = 0;
			
			junitspan.remove();
			jminspan.remove();

			jspl.data('rzdata', {
				grid: gridsize + absgap,
				gap: absgap,
				minwidth: gridsize,
				maxwidth: (minsize + absgap) * cmaxcol - absgap + 6
			});

			jspl.find('.t3-layout-unit').each(function(idx){
				if(visible[idx] == 0 || visible[idx] == undefined){ //ignore all hidden spans
					if(needfirst || (sum + parseInt(width[idx]) > T3V3Admin.layout.maxgrid)){
						$(this).addClass('spanfirst');
						sum = parseInt(width[idx]);
						first[idx] = 1;
						needfirst = false;
					} else {
						$(this).removeClass('spanfirst');
						sum += parseInt(width[idx]);
						first[idx] = 0;
					}
				}
			});

			jspl.find('.t3-layout-rzhandle').css('right', Math.min(-7, -3.5 - absgap / 2));
		},

		// apply the visibility value for current device - trigger when change device
		t3updatevisible: function(idx, item){
			var jvis = $(item),
				jdata = jvis.closest('[data-vis]'),
				visible = jdata.data('data-vis').vals[T3V3Admin.layout.clayout],
				state = 0, idx = 0,
				spotlight = jdata.attr('data-spotlight');

			//if spotlight -> get the index
			if(spotlight){
				idx = jvis.closest('.t3-layout-unit').index();
			}
			
			state = visible[idx] || 0;
			
			if(spotlight){
				jvis.closest('.t3-layout-unit')[state == 0 ? 'show' : 'hide']();

				var jhiddenpos = jdata.nextAll('.t3-layout-hiddenpos');
				jhiddenpos.children().eq(idx)[state == 0 ? 'addClass' : 'removeClass']('hide');
				jhiddenpos[jhiddenpos.children().not('.hide, .t3-hide').length ? 'addClass' : 'removeClass']('has-pos');
			}

			jvis.parent()[state == 1 && T3V3Admin.layout.mode ? 'addClass' : 'removeClass']('pos-hidden');
			jvis.children().removeClass('icon-eye-close icon-eye-open').addClass(state == 1 ? 'icon-eye-close' : 'icon-eye-open');
		},

		// apply the change (width, columns) of spotlight block when change device 
		t3updatespl: function(si, spl){
			var jspl = $(spl),
				width = jspl.data('data-widths')[T3V3Admin.layout.clayout];

			jspl.children().each(function(idx){
				//remove all class and reset style width
				this.className = this.className.replace(/(\s*)span(\d+)(\s*)/g, ' ');
				$(this).css('width', '').addClass('span' + T3V3Admin.t3widthconvert(width[idx])).find('.t3-layout-poswidth').html(width[idx]);
			});

			T3V3Admin.t3updategrid(spl);
		},

		//apply responsive class - maybe we do not need this
		t3updatedevice: function(jallelms, jspls, jrelms, nlayout){
			//if (nlayout == T3V3Admin.layout.clayout){
			//	return false;
			//}
			var clayout = T3V3Admin.layout.clayout;

			jrelms.each(function(){
				var jelm = $(this);
				// no override for all devices 
				if (!jelm.data('default')){
					return;
				}

				// keep default 
				if (!jelm.data(nlayout) && (!clayout || !jelm.data(clayout))){
					return;
				}

				// remove current
				if (jelm.data(clayout)){
					jelm.removeClass(jelm.data(clayout));
				} else {
					jelm.removeClass (jelm.data('default'));
				}

				// add new
				if (jelm.data(nlayout)){
					jelm.addClass (jelm.data(nlayout));
				} else{
					jelm.addClass (jelm.data('default'));
				}
			});

			T3V3Admin.layout.clayout = nlayout;
			
			//apply width from previous settings
			jspls.each(T3V3Admin.t3updatespl);
			jallelms.find('.t3-layout-vis').each(T3V3Admin.t3updatevisible);

			T3V3Admin.t3equalheight(jallelms);
		},

		t3resetdevice: function(container){
			
			var layout = T3V3Admin.layout.clayout,
				jcontainer = $(container),
				jblocks = jcontainer.find('.t3-layout-pos'),
				jspls = jcontainer.find('[data-spotlight]'),
				jsplblocks = jspls.find('.t3-layout-pos');

			jblocks.not(jspls).not(jsplblocks).not('.block-message, .block-component').each(function(){
				var name = $(this).attr('data-original'),
					vis = $(this).closest('[data-vis]').data('data-vis');

				if(layout && vis){
					$.extend(true, vis.vals[layout], vis.deft[layout]);
				}
			});
			
			jspls.each(function(){
				var name = $(this).attr('data-spotlight'),
					vis = $(this).data('data-vis'),
					widths = $(this).data('data-widths'),
					owidths = $(this).data('data-owidths'),
					firsts = $(this).data('data-firsts'),
					ofirsts = $(this).data('data-ofirsts');

				$.extend(true, vis.vals[layout], vis.deft[layout]);
				$.extend(true, widths[layout], widths[layout].length == owidths[layout].length ? owidths[layout] : T3V3Admin.t3genwidth(layout, widths[layout].length));
				$.extend(true, firsts[layout], ofirsts[layout]);

				for(var i = vis.deft[layout].length; i < T3V3Admin.layout.maxcols; i++){
					vis.vals[layout][i] = 0;
				}

				for(var i = firsts[layout].length; i < T3V3Admin.layout.maxcols; i++){
					firsts[layout][i] = '';
				}
			});

			jspls.each(T3V3Admin.t3updatespl);
			jcontainer.find('.t3-layout-vis').each(T3V3Admin.t3updatevisible);
		},

		t3resetall: function(container){
			var layout = T3V3Admin.layout.clayout,
				jcontainer = $(container),
				jblocks = jcontainer.find('.t3-layout-pos'),
				jspls = jcontainer.find('[data-spotlight]'),
				jsplblocks = jspls.find('.t3-layout-pos');

			jblocks.not(jspls).not(jsplblocks).not('.block-message, .block-component').each(function(){
				if($(this).find('[data-original]').length){
					return;
				}

				var name = $(this).attr('data-original'),
					vis = $(this).closest('[data-vis]').data('data-vis');

				//change the name
				$(this).find('.t3-layout-posname').html(name);
				if(vis){
					$.extend(true, vis.vals, vis.deft);
				}
			});
			
			jspls.each(function(){
				var jspl = $(this),
					jhides = jspl.nextAll('.t3-layout-hiddenpos').children(),
					vis = jspl.data('data-vis'),
					widths = jspl.data('data-widths'),
					//firsts = $(this).data('data-firsts'),
					original = jspl.attr('data-original').split(','),
					owidths = jspl.data('data-owidths'),
					//ofirsts = $(this).data('data-ofirsts'),
					numcols = owidths['default'].length,
					html = [];

				for(var i = 0; i < numcols; i++){
					html = html.concat([
					'<div class="t3-layout-unit span', owidths['default'][i], '">', //we do not need convert width here
						'<div class="t3-layout-pos block-', original[i], (original[i] == T3V3Admin.langs.emptyLayoutPosition ? ' pos-off' : ''), '" data-original="', (original[i] || ''), '">',
							'<span class="t3-layout-edit"><i class="icon-cog"></i></span>',
							'<span class="t3-layout-poswidth" title="', T3V3Admin.langs.layoutPosWidth, '">', owidths['default'][i], '</span>',
							'<h3 class="t3-layout-posname" title="', T3V3Admin.langs.layoutPosName, '">', original[i], '</h3>',
							'<span class="t3-layout-vis" title="', T3V3Admin.langs.layoutHidePosition, '"><i class="icon-eye-open"></i></span>',
						'</div>',
						'<div class="t3-layout-rzhandle" title="', T3V3Admin.langs.layoutDragResize, '"></div>',
					'</div>']);

					jhides.eq(i).html(original[i] + '<i class="icon-eye-close">').removeClass('t3-hide');
				}

				for(var i = numcols; i < T3V3Admin.layout.maxcols; i++){
					jhides.eq(i).addClass('t3-hide');
				}

				//reset value
				$(this)
					.empty()
					.html(html.join(''));

				$.extend(true, vis.vals, vis.deft);
				$.extend(true, widths, owidths);
				
				//optimized: not need
				//$.extend(true, firsts, ofirsts);

				$(this).nextAll('.t3-layout-ncolumns').children().eq(owidths['default'].length - 1).trigger('click');
			});

			//change to default view
			jcontainer.prev().find('.mode-structure').trigger('click');
		},

		t3resetposition: function(container){
			var layout = T3V3Admin.layout.clayout,
				jcontainer = $(container),
				jblocks = jcontainer.find('.t3-layout-pos'),
				jspls = jcontainer.find('[data-spotlight]'),
				jsplblocks = jspls.find('.t3-layout-pos');

			jblocks.not(jspls).not(jsplblocks).not('.block-message, .block-component').each(function(){
				//reset position
				$(this).find('.t3-layout-posname')
					.html(
						$(this).attr('data-original')
					)
					.parent()
					.removeClass('pos-off pos-active');
			});
			
			jspls.each(function(){
				var original = $(this).attr('data-original').split(','),
					jhides = $(this).nextAll('.t3-layout-hiddenpos').children();

				$(this).find('.t3-layout-pos').each(function(idx){
					if(original[idx] != undefined){
						$(this)[original[idx] == T3V3Admin.langs.emptyLayoutPosition ? 'addClass' : 'removeClass']('pos-off')
						.find('.t3-layout-posname')
						.html(original[idx]);
						
						jhides.eq(idx).html(original[idx] + '<i class="icon-eye-close">');
					} else {
						$(this).addClass('pos-off').find('.t3-layout-posname').html(T3V3Admin.langs.emptyLayoutPosition);
					}
				});
			});
		},

		t3onvisible: function(){
			var jvis = $(this),
				jpos = jvis.parent(),
				jdata = jvis.closest('[data-vis]'),
				junits = null,
				layout = T3V3Admin.layout.clayout,
				state = jpos.hasClass('pos-hidden'),
				visible = jdata.data('data-vis').vals[layout],
				spotlight = jdata.attr('data-spotlight'),
				idx = 0;

			//if spotlight -> the name is based on block, else use the name property
			if(spotlight){
				idx = jvis.closest('.t3-layout-unit').index();
				junits = jdata.children();
			}

			//toggle state
			state = 1 - state;
			
			if(spotlight){
				jvis.closest('.t3-layout-unit')[state == 0 ? 'show' : 'hide']();
			
				var jhiddenpos = jdata.nextAll('.t3-layout-hiddenpos');
				jhiddenpos.children().eq(idx)[state == 0 ? 'addClass' : 'removeClass']('hide');
				jhiddenpos[jhiddenpos.children().not('.hide, .t3-hide').length ? 'addClass' : 'removeClass']('has-pos');

				var visibleIdxs = [];
				for(var i = 0, il = junits.length; i < il; i++){
					if(junits[i].style.display != 'none'){
						visibleIdxs.push(i);
					}
				}

				if(visibleIdxs.length){
					var widths = jdata.data('data-widths')[layout],
						width = T3V3Admin.t3genwidth(layout, visibleIdxs.length),
						vi = 0;

					for(var i = 0, il = visibleIdxs.length; i < il; i++){
						vi = visibleIdxs[i];
						widths[vi] = width[i];
						junits[vi].className = junits[vi].className.replace(/(\s*)span(\d+)(\s*)/g, ' ');
						junits.eq(vi).addClass('span' + T3V3Admin.t3widthconvert(width[i])).find('.t3-layout-poswidth').html(width[i]);
					}
				}
			}
			
			jpos[state == 1 ? 'addClass' : 'removeClass']('pos-hidden');
			jvis.children().removeClass('icon-eye-close icon-eye-open').addClass(state == 1 ? 'icon-eye-close' : 'icon-eye-open');
			
			visible[idx] = state;

			if(spotlight){
				T3V3Admin.t3updategrid(jdata);
			}
			return false;
		},

		t3layout: function(form, ctrlelm, ctrl, rsp){
			if(rsp){
				var bdhtml = rsp.match(/<body[^>]*>([\w|\W]*)<\/body>/im),
					vname = ctrlelm.name.replace(/[\[\]]/g, ''),
					jcontrol = $([
							'<div class="control-group">',
								'<div class="control-label">',
									'<label class="hasTip" title=""></label>', 
								'</div>',
								'<div class="controls">',
								'</div>',
							'</div>'].join(''))
							.insertAfter($('#jformparamsjat3_all_pos').closest('.control-group'));

				//stripScripts
				if(bdhtml){
					bdhtml = bdhtml[0].replace(new RegExp('<script[^>]*>([\\S\\s]*?)<\/script\\s*>', 'img'), '');
				}

				if(bdhtml){
					//clean those bootstrap fixed class
					bdhtml = bdhtml.replace(/navbar-fixed-(top|bottom)/gi, '');

					var jtabpane = $('#jform_params_mainlayout').closest('.tab-pane'),
						active = jtabpane.hasClass('active');

					if(!active){	//if not active, then we show it
						jtabpane.addClass('active');
					}

					T3V3Admin.layout.mode = 0; // 0 for structure, 1 for layout

					var	curspan = null,
						jelms = $(['<div class="t3-layout-cont layout-custom ', vname, ' t3-layout-mode-m"></div>'].join(''))
							.html(bdhtml).appendTo(jcontrol.find('.controls')),
						jtbs = $([
							'<div class="t3-inline-nav clearfix">',
								'<div class="t3-row-mode clearfix"></div>',
								'<div class="t3-row-device clearfix"></div>',
							'</div>'].join(''))
							.insertBefore(jelms),
						jmodes = $([
							'<ul class="nav nav-tabs t3-layout-modes">',
								'<li class="active mode-structure"><a href="#" title="', T3V3Admin.langs.displayModeStructure, '">', T3V3Admin.langs.displayModeStructure, '</a></li>',
								'<li class="mode-layout"><a href="#" title="', T3V3Admin.langs.displayModeLayout, '">', T3V3Admin.langs.displayModeLayout, '</a></li>',
							'</ul>'].join(''))
							.appendTo(jtbs.find('.t3-row-mode'))
							.on('click', 'li', function(){
								if($(this).hasClass('mode-layout')){
									jelms.removeClass('t3-layout-mode-m').addClass('t3-layout-mode-r');
									T3V3Admin.layout.mode = 1;

									jdevices.removeClass('hide');
									jresetdevice.removeClass('hide');
									jresetposition.addClass('hide');

									jelms.find('.t3-layout-vis').each(T3V3Admin.t3updatevisible);
									jdevices.find('[data-device="wide"]').removeClass('active').trigger('click');
								} else {
									jelms.removeClass('t3-layout-mode-r').addClass('t3-layout-mode-m');
									T3V3Admin.layout.mode = 0;

									jdevices.addClass('hide');
									jresetdevice.addClass('hide');
									jresetposition.removeClass('hide');

									jelms.removeClass(T3V3Admin.layout.clayout);
									T3V3Admin.t3updatedevice(jelms, jspls, jrlems, 'default');
								}

								$(this).addClass('active').siblings().removeClass('active');
								return false;
							}),
						jdevices = $([
							'<div class="btn-group t3-layout-devices hide">',
								'<button class="btn t3-dv-wide" data-device="wide" title="', T3V3Admin.langs.devideWide, '">', T3V3Admin.langs.devideWide, '</button>',
								'<button class="btn t3-dv-normal" data-device="normal" title="', T3V3Admin.langs.devideNormal, '">', T3V3Admin.langs.devideNormal, '</button>',
								'<button class="btn t3-dv-xtablet" data-device="xtablet" title="', T3V3Admin.langs.devideXTablet , '">', T3V3Admin.langs.devideXTablet, '</button>',
								'<button class="btn t3-dv-tablet" data-device="tablet" title="', T3V3Admin.langs.devideTablet, '">', T3V3Admin.langs.devideTablet, '</button>',
								'<button class="btn t3-dv-mobile" data-device="mobile" title="', T3V3Admin.langs.devideMobile, '">', T3V3Admin.langs.devideMobile, '</button>',
							'</div>'].join(''))
							.appendTo(jtbs.find('.t3-row-device'))
							.on('click', '.btn', function(e){
								if(!$(this).hasClass('active')){
									var nlayout = $(this).attr('data-device');
									$(this).addClass('active').siblings('.active').removeClass('active');

									jelms.removeClass(T3V3Admin.layout.clayout);
									if(T3V3Admin.layout.mode == 1){
										jelms.addClass(nlayout);
									}

									T3V3Admin.t3updatedevice(jelms, jspls, jrlems, nlayout);
								}

								return false;
							}),
						
						jresetall = $('<button class="btn btn-danger t3-reset-all pull-right">' + T3V3Admin.langs.layoutResetAll + '</button>')
							.insertAfter(jmodes)
							.on('click', function(){
								T3V3Admin.t3resetall(jelms);
								return false;
							}),

						jresetposition = $('<button class="btn btn-danger t3-reset-position pull-right">' + T3V3Admin.langs.layoutResetPosition + '</button>')
							.insertAfter(jdevices)
							.on('click', function(){
								T3V3Admin.t3resetposition(jelms);
								return false;
							}),

						jresetdevice = $('<button class="btn btn-danger t3-reset-device pull-right hide">' + T3V3Admin.langs.layoutResetDevice + '</button>')
							.insertAfter(jdevices)
							.on('click', function(){
								T3V3Admin.t3resetdevice(jelms);
								return false;
							}),

						jrlems = jelms.find('[class*="span"]').each(function(){
							var jelm = $(this);
							jelm.data();
							jelm.removeAttr('data-default data-wide data-normal data-xtablet data-tablet data-mobile');
							if (!jelm.data('default')){
								jelm.data('default', jelm.attr('class'));
							}
						}),

						jallpos = $('#jformparamsjat3_all_pos').clone()
							.attr({
								'id': 'jaa_sel_' + ctrl.uid++,
								'name': '',
								'style': '',
							}),
							
						jselect = $([
							'<div class="popover right" style="z-index: 10000">',
								'<div class="arrow"></div>',
								'<h3 class="popover-title">', T3V3Admin.langs.popoverLayoutTitle, '</h3>',
								'<div class="popover-content">',
									(T3V3Admin.langs.popoverLayoutDesc ? '<p>' + T3V3Admin.langs.popoverLayoutDesc + '</p>' : '' ),
								'</div>',
							'</div>'].join(''))
							.appendTo(document.body)
							.on('click', function(e){
								return false;
							}),
						jspls = jelms.find('[data-spotlight]');

					jselect.find('.popover-content').append(
						jallpos
						.prop('disabled', false)
						.prop('size', 10)
						.on('change', function(){
							if(curspan){
								$(curspan).parent().removeClass('pos-off pos-active').find('h3').html(this.value || T3V3Admin.langs.emptyLayoutPosition);
								$(this).closest('.popover').hide();

								var jspl = $(curspan).parent().parent().parent();
								if(jspl.attr('data-spotlight')){
									var spanidx = $(curspan).closest('.t3-layout-unit').index();
									jspl.nextAll('.t3-layout-hiddenpos').children().eq(spanidx).html((this.value || T3V3Admin.langs.emptyLayoutPosition) + '<i class="icon-eye-close">');
								}

								if(!this.value){
									$(curspan).parent().addClass('pos-off');
								}

								$(this)
									.next('.t3-chzn-empty')[this.value ? 'removeClass' : 'addClass']('disabled')
									.next('.t3-chzn-default')[this.value != $(curspan).closest('[data-original]').attr('data-original') ? 'removeClass' : 'addClass']('disabled');
							}

							return false;
						})
					);

					ctrl.elms.push(jselect[0]);

					$(document).off('click.' + vname).on('click.' + vname, function(){
						if(curspan){
							$(curspan).parent().removeClass('pos-active');
						}

						jselect.hide();
					});

					jallpos
						.after([
							'<btn class="btn btn-small t3-chzn-empty"><i class="icon-remove"></i>', T3V3Admin.langs.emptyLayoutPosition, '</btn>',
							'<btn class="btn btn-small btn-success t3-chzn-default"><i class="icon-ok-circle"></i>', T3V3Admin.langs.defaultLayoutPosition, '</btn>'
							].join(''))
						.nextAll('.t3-chzn-empty, .t3-chzn-default')
						.on('click', function(){
							if(curspan && !$(this).hasClass('disabled')){
								var vdef = $(this).hasClass('t3-chzn-default') ? $(curspan).closest('[data-original]').attr('data-original') : '';
								jallpos.val(vdef).trigger('change');
							}

							return false;
						});

					jelms
						.find('.logo h1:first')
						.html(T3V3Admin.langs.logoPresent);

					jelms
						.find('.t3-layout-pos')
						.not('.block-message, .block-component')
						.prepend('<span class="t3-layout-edit" title="' + T3V3Admin.langs.layoutEditPosition + '"><i class="icon-cog"></i></span>');

					jelms
						.find('[data-vis]')
						.not('[data-spotlight]')
						.each(function(){ 
							$(this)
								.data('data-vis', $.parseJSON($(this).attr('data-vis')))
								.data('data-others', $.parseJSON($(this).attr('data-others')))
								.attr('data-vis', '')
								.attr('data-others', '')
						})
						.find('.t3-layout-pos')
						.append('<span class="t3-layout-vis" title="' + T3V3Admin.langs.layoutHidePosition + '"><i class="icon-eye-open"></i></span>');

					jelms
						.find('.t3-layout-pos')
						.find('h3, h1')
						.addClass('t3-layout-posname')
						.attr('title', T3V3Admin.langs.layoutPosName)
						.each(function(){
							var jparent = $(this).parentsUntil('.row').last(),
								span = parseInt(jparent.prop('className').replace(/(.*?)span(\d+)(.*)/, "$2"));

							if(isNaN(span)){
								span = T3V3Admin.langs.layoutUnknownWidth;
							}

							$(this).before('<span class="t3-layout-poswidth" title="' + T3V3Admin.langs.layoutPosWidth + '">' + span + '</span>');
						});

					jelms
						.on('click', '.t3-layout-vis', T3V3Admin.t3onvisible)
						.on('click', '.t3-layout-edit', function(e){
							if(curspan){
								$(curspan).parent().removeClass('pos-active');
							}

							curspan = this;
							var jspan = $(this),
								offs = $(this).offset();

							jspan.parent().addClass('pos-active');
							jselect.removeClass('top').addClass('right');

							var top = offs.top + (jspan.height() - jselect.height()) / 2,
								left = offs.left + jspan.width();

							if(left + jselect.outerWidth(true) > $(window).width()){
								jselect.removeClass('right').addClass('top');
								top = offs.top - jselect.outerHeight(true);
								left = offs.left + (jspan.width() - jselect.width()) / 2;
							}

							jselect.css({
								top: top,
								left: left
							}).show()
								.find('select')
								.val(jspan.siblings('h3').html())
								.next('.t3-chzn-empty')[jallpos.val() ? 'removeClass' : 'addClass']('disabled')
								.next('.t3-chzn-default')[jspan.siblings('h3').html() != jspan.closest('[data-original]').attr('data-original') ? 'removeClass' : 'addClass']('disabled');

							jallpos.scrollTop(Math.min(jallpos.prop('scrollHeight') - jallpos.height(), jallpos.prop('selectedIndex') * (jallpos.prop('scrollHeight') / jallpos[0].options.length)));
							
							return false;
						});
						
						jspls.each(function(){

							var jncols = $([
								'<div class="btn-group t3-layout-ncolumns">',
									'<span class="btn" title="', T3V3Admin.langs.layoutChangeNumpos, '">1</span>',
									'<span class="btn" title="', T3V3Admin.langs.layoutChangeNumpos, '">2</span>',
									'<span class="btn" title="', T3V3Admin.langs.layoutChangeNumpos, '">3</span>',
									'<span class="btn" title="', T3V3Admin.langs.layoutChangeNumpos, '">4</span>',
									'<span class="btn" title="', T3V3Admin.langs.layoutChangeNumpos, '">5</span>',
									'<span class="btn" title="', T3V3Admin.langs.layoutChangeNumpos, '">6</span>',
								'</div>'].join('')).appendTo(this.parentNode),

								jcols = $(this).children(),
								numpos = jcols.length,
								spotlight = this,
								positions = [],
								defpos = $(this).attr('data-original').replace(/\s+/g, '').split(','),
								visibles = $.parseJSON($(this).attr('data-vis')),
								twidths = $.parseJSON($(this).attr('data-widths')),
								widths = {},
								owidths = $.parseJSON($(this).attr('data-owidths')),
								ofirsts = $.parseJSON($(this).attr('data-ofirsts')),
								firsts = $.parseJSON($(this).attr('data-firsts'));
							
							$(spotlight)
								.data('data-widths', widths).removeAttr('data-widths', '') //store and clean the data
								.data('data-owidths', owidths).removeAttr('data-owidths', '') //store and clean the data
								.data('data-vis', visibles).attr('data-vis', '') //store and clean the data - keep the marker for selector
								.data('data-ofirsts', ofirsts).removeAttr('data-ofirsts', '') //store and clean the data
								.data('data-firsts', firsts).removeAttr('data-firsts', '') //store and clean the data
								.data('data-others', $.parseJSON($(this).attr('data-others'))).removeAttr('data-others', '') //store and clean the data
								.parent().addClass('t3-layout-splgroup');

							jcols.each(function(idx){
								positions[idx] = $(this).find('h3').html();

								$(this)
								.addClass('t3-layout-unit')
								.find('.t3-layout-pos')
								.attr('data-original', defpos[idx])
								.append('<span class="t3-layout-vis" title="' + T3V3Admin.langs.layoutHidePosition + '"><i class="icon-eye-open"></i></span>');
							});

							for(var i = numpos; i < 6; i++){
								positions[i] = defpos[i] || T3V3Admin.langs.emptyLayoutPosition;
							}

							var jhides = $([
								'<div class="t3-layout-hiddenpos" title="', T3V3Admin.langs.layoutHiddenposDesc, '">',
									'<span class="pos-hidden" title="', T3V3Admin.langs.layoutShowPosition, '">', positions[0], '<i class="icon-eye-close"></i></span>',
									'<span class="pos-hidden" title="', T3V3Admin.langs.layoutShowPosition, '">', positions[1], '<i class="icon-eye-close"></i></span>',
									'<span class="pos-hidden" title="', T3V3Admin.langs.layoutShowPosition, '">', positions[2], '<i class="icon-eye-close"></i></span>',
									'<span class="pos-hidden" title="', T3V3Admin.langs.layoutShowPosition, '">', positions[3], '<i class="icon-eye-close"></i></span>',
									'<span class="pos-hidden" title="', T3V3Admin.langs.layoutShowPosition, '">', positions[4], '<i class="icon-eye-close"></i></span>',
									'<span class="pos-hidden" title="', T3V3Admin.langs.layoutShowPosition, '">', positions[5], '<i class="icon-eye-close"></i></span>',
								'</div>'].join('')).appendTo(this.parentNode),
								jhcols = jhides.children();

							for(var i = 0; i < T3V3Admin.layout.maxcols; i++){
								jhcols.eq(i)[i < numpos ? 'removeClass' : 'addClass']('t3-hide');	
							}

							//temporary calculate the widths for each devices size
							T3V3Admin.t3copy(widths, twidths); //first - clone the current object
							T3V3Admin.t3widthbyvisible(widths, visibles.vals, numpos); //then extend it with autogenerate width
							T3V3Admin.t3copy(widths, twidths); // if widths has value, it should be priority
							
							$(spotlight).xresize({
								grid: false,
								gap: 0,
								selector: '.t3-layout-unit'
							});

							jncols.on('click', '.btn', function(e){

								if(!e.isTrigger){
									numpos = $(this).index() + 1;
									for(var i = 0; i < numpos; i++){
										if(!positions[i] || positions[i] == T3V3Admin.langs.emptyLayoutPosition){
											positions[i] = defpos[i] || T3V3Admin.langs.emptyLayoutPosition;
										}

										jhcols.eq(i).html(positions[i] + '<i class="icon-eye-close">').removeClass('t3-hide');
									}

									for(var i = numpos; i < T3V3Admin.layout.maxcols; i++){
										jhcols.eq(i).addClass('t3-hide');	
									}

									//automatic re-calculate the widths for each devices size
									T3V3Admin.t3widthbyvisible(widths, visibles.vals, numpos);

									var html = [];
									for(i = 0; i < numpos; i++){
										html = html.concat([
										'<div class="t3-layout-unit span', widths['default'][i], '">',
											'<div class="t3-layout-pos block-', positions[i], (positions[i] == T3V3Admin.langs.emptyLayoutPosition ? ' pos-off' : ''), '" data-original="', (defpos[i] || ''), '">',
												'<span class="t3-layout-edit"><i class="icon-cog"></i></span>',
												'<span class="t3-layout-poswidth" title="', T3V3Admin.langs.layoutPosWidth, '">', widths['default'][i], '</span>',
												'<h3 class="t3-layout-posname" title="', T3V3Admin.langs.layoutPosName, '">', positions[i], '</h3>',
												'<span class="t3-layout-vis" title="', T3V3Admin.langs.layoutHidePosition, '"><i class="icon-eye-open"></i></span>',
											'</div>',
											'<div class="t3-layout-rzhandle" title="', T3V3Admin.langs.layoutDragResize, '"></div>',
										'</div>']);
									}

									//reset value
									$(spotlight)
										.empty()
										.html(html.join(''));
								}

								//change gridsize for resize 
								T3V3Admin.t3updategrid(spotlight);

								$(this).addClass('active').siblings().removeClass('active');

							}).children().removeClass('active').eq(numpos -1).addClass('active').trigger('click');

							jhides.on('click', 'span', function(){
								T3V3Admin.t3onvisible.call($(spotlight).children().eq($(this).index()).find('.t3-layout-vis'));
								return false;
							});
						});

					T3V3Admin.t3equalheight(jelms);

					if(!active){	//restore current status
						jtabpane.removeClass('active');
					}
				} else {
					jcontrol.find('.controls').html('<p class="t3-layout-error">' + T3V3Admin.langs.layoutCanNotLoad + '</p>');
				}

				ctrl.elms.push(jcontrol[0]);
			}
		}
	});
	
	$(document).ready(function(){
		T3V3Admin.initSystemMessage();
		T3V3Admin.initT3Title();
		T3V3Admin.initBuildLessBtn();
		T3V3Admin.initRadioGroup();
		T3V3Admin.initChosen();
		T3V3Admin.initPreSubmit();
		T3V3Admin.initLayoutPosition();
		T3V3Admin.hideDisabled();
		T3V3Admin.initChangeStyle();
		//T3V3Admin.initCheckupdate();
		T3V3Admin.switchTab();
	});
	
}(window.$ja || window.jQuery);


!function($){

	var isdown = false,
		curelm = null,
		opts, memwidth, memfirst, memvisible, owidth, 
		mx, rzleft, rzwidth, rzlayout, rzindex, rzminspan,

		snapoffset = function(grid, size) {
			var limit = grid / 2;
			if ((size % grid) > limit) {
				return grid-(size % grid);
			} else {
				return -size % grid;
			}
		},

		spanfirst = function(rwidth){
			var sum = 0,
				needfirst = (memvisible[0] == 1);

			$(curelm).parent().children().each(function(idx){
				if(memvisible[idx] == 0 || memvisible[idx] == undefined){
					if(needfirst || ((sum + parseInt(memwidth[idx]) > T3V3Admin.layout.maxgrid) || (rzindex + 1 == idx && sum + parseInt(memwidth[idx]) == T3V3Admin.layout.maxgrid && (rwidth > owidth)))){
						$(this).addClass('spanfirst');
						memfirst[idx] = 1;
						sum = parseInt(memwidth[idx]);
						needfirst = false;
					} else {
						$(this).removeClass('spanfirst');
						memfirst[idx] = 0;
						sum += parseInt(memwidth[idx]);
					}
				}
			});
		},

		updatesize = function(e, togrid) {
			var mx = e.pageX,
				width = rwidth = (mx - rzleft + rzwidth);

			if(opts.grid){
				width = width + snapoffset(opts.grid, width) - opts.gap;
			}

			if(rwidth < opts.minwidth){
				rwidth = opts.minwidth;
			} else if (rwidth > opts.maxwidth){
				rwidth = opts.maxwidth;
			}

			if(width < opts.minwidth){
				width = opts.minwidth;
			} else if (width > opts.maxwidth){
				width = opts.maxwidth;
			}

			if(owidth != width){
				memwidth[rzindex] = rzminspan * ((width + opts.gap) / opts.grid) >> 0;
				owidth = width;

				$(curelm).find('.t3-layout-poswidth').html(memwidth[rzindex]);
			}

			curelm.style['width'] = (togrid ? width : rwidth) + 'px';

			spanfirst(rwidth);
		},

		updatecls = function(e){
			var mx = e.pageX,
				width = (mx - rzleft + rzwidth);

			if(opts.grid){
				width = width + snapoffset(opts.grid, width) - opts.gap;
			}

			if(width < opts.minwidth){
				width = opts.minwidth;
			} else if (width > opts.maxwidth){
				width = opts.maxwidth;
			}

			curelm.className = curelm.className.replace(/(\s*)span(\d+)(\s*)/g, ' ');
			$(curelm).css('width', '').addClass('span' + T3V3Admin.t3widthconvert((rzminspan * ((width + opts.gap) / opts.grid) >> 0)));

			spanfirst(width);
		},

		mousedown = function (e) {
			curelm = this.parentNode;
			isdown = true;
			rzleft = e.pageX;
			owidth = rzwidth  = $(curelm).width();

			var jdata = $(this).closest('.t3-layout-xresize');
			
			opts = jdata.data('rzdata');
			rzlayout = T3V3Admin.layout.clayout;
			rzminspan = T3V3Admin.layout.unitspan[rzlayout];
			rzindex = $(this).parent().index();
			memwidth = jdata.data('data-widths')[rzlayout];
			memfirst = jdata.data('data-firsts')[rzlayout];
			memvisible = jdata.data('data-vis').vals[rzlayout];

			updatesize(e);

			$(document)
			.on('mousemove.xresize', mousemove)
			.on('mouseup.xresize', mouseup);

			return false;
		},
		mousemove = function (e) {
			if(isdown) {
				updatesize(e);
				return false;
			}
		},
		mouseup = function (e) {
			isdown = false;
			updatecls(e);
			$(document).unbind('.xresize');
		};

	$.fn.xresize = function(opts) {
		return this.each(function () {
			$(opts.selector ? $(this).find(opts.selector) : this).append('<div class="t3-layout-rzhandle" title="' + T3V3Admin.langs.layoutDragResize + '"></div>');			
			$(this)
			.addClass('t3-layout-xresize')
			.data('rzdata', $.extend({
				selector: '',
				minwidth: 0,
				maxwidth: 100000,
				minheight: 0,
				maxheight: 100000,
				grid: 0,
				gap: 0
			}, opts))
			.on('mousedown.wresize', '.t3-layout-rzhandle', mousedown);
		});
	};

}(window.$ja || window.jQuery);