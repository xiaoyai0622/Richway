var $ = jQuery.noConflict();
var shortname = 'metrodir';

jQuery(document).ready(function() {
	
	// TABS
	jQuery(".metrodir-tabs").tabs({ fx: { opacity: 'toggle', duration:'fast' } });
	
	// SYSTEM MESSAGES
	$.template('messageTemplate', $('#messageTemplate').html());
	$(".message").click(function () {
      $(this).fadeOut();
    });
	
	//TIPSY
	jQuery('.tooltip').tipsy({fade: true, gravity: 's', opacity : 1, html:true, offset : 5});
	
	// SPINNERS
	$(".spin").spinner({ 
		places: 2
	});
	
	$(".spin-dec").spinner({ 
		places: 2,
		step: 0.25
	});
	
	$(".spin-cur").spinner({ 
		places: 2,
		step: 0.01,
		prefix: '$ '
	});
	
	// FORM VALIDATION
	$(".valid").validate({
		meta: "validate",
		errorPlacement: function(error, element) {
          error.insertAfter(element);
		}
	});
	
	// INPUT PLACEHOLDER
	$('input[placeholder], textarea[placeholder]').placeholder();
	
	// SELECTBOXES
	$(function() {
        $('select').not("select.multiple").selectmenu({
            style: 'dropdown',
            transferClasses: true,
            width: null,
			select : function(event, x) {
				//console.log(x);
			}
        });
    });
	
	// RADIOBUTTONS & CHECKBOXES
	$("input[type=radio], input[type=checkbox]").each(function() {
        if ($(this).parents("table").length === 0) {
            $(this).customInput();
        }
    });
	
	$('input[name="contact[method]"]').change(function() {
		if($(this).val() == 'smtp') $('#smtpPanel').show('fade');
		else $('#smtpPanel').hide('fade');
	});
	
	// FILE INPUT STYLE
    $("input[type=file]").filestyle({
        imageheight: 28,
        imagewidth: 85,
        width: 150
    });
	
	// DATEPICKER
	$(".datepicker").datepicker({
		dateFormat: 'MM dd, yy'
	});
	
	// AUTOGROW TEXTAREA
	jQuery('.grow').elastic();
	
	// INPUT FILTER
	$('.onlytext').filter_input({regex:'[a-zA-Z]'}); 
	$('.onlylow').filter_input({regex:'[a-z]'}); 
	$('.onlyup').filter_input({regex:'[A-Z]'}); 
	$('.onlynum').filter_input({regex:'[0-9]'}); 
	$('.onlyurl').filter_input({regex:'[a-zA-Z0-9_]'});
	
	//COLOR PICKER
	$('.colorSelector').ColorPicker({
		color: '#'+$('#backgroundColor').val(),
		onShow: function (colpkr) {
			$(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$('.colorSelector div').css('backgroundColor', '#' + hex);
			$('#backgroundColor').val(hex);
		}
	});
	
	//SELECT BACKGROUNDS
	$.fn.selectBg = function() {
		return this.each(function() {
			$(this).click(function() {
				$('#backgroudImgList > li').removeClass('selected');
				$(this).addClass('selected');
				$('#backgroundImg').val($(this).find('a.img').attr('href').replace("#", ""));
				return false;
			});
		});
	};
	$('#backgroudImgList > li').selectBg();
	
	//DELETE BACKGROUNDS
	$.fn.deleteBg = function() {
		return this.each(function() {
			$(this).click(function() {
				if(confirm(metrodir_LANG.ARE_YOU_SURE)) {
					var a = $(this);
					$.ajax({
						type : 'POST',
						dataType : 'json',
						url: ajaxurl,
						data: 'action=metrodir_file_delete&context=backgrounds&file='+a.attr('href').replace('#', ''),
						cache : false,
						success: function(response){
							if(response.success == 200) {
								a.parents('li').remove();
								if(a.parents('li').hasClass('selected')) {
									$('#backgroundImg').val('');
								}	
							}else {
								alert(response.message);	
							}
						}
					});
				}
				return false;
			});
		});
	};
	$('#backgroudImgList a.delete').deleteBg();
	
	
	//UPLOAD BACKGROUNDS
	new AjaxUpload('backgroundNew', {
		action: ajaxurl,
		name:'bgfile',
		data : {'action' : "metrodir_file_upload"},
		onSubmit : function(file , ext){
			if (ext && /^(jpg|png|jpeg|gif)$/.test(ext.toLowerCase())){
				$('#backgroundNew').toggleClass('active');
				$('#backgroundNew').text(metrodir_LANG.UPLOADING);
			} else {					
				alert(metrodir_LANG.ONLY_IMAGES_ALLOWED);
				return false;				
			}		
		},
		onComplete : function(file, response){
			if(response == '200') {
				var index = $('.bgs').length+1;
				var bg = $('#backgroundTemplate').tmpl([{File : file, Index : ++index}]);
				bg.selectBg();
				bg.find('a.delete').deleteBg();
				bg.appendTo('#backgroudImgList');
				$('#backgroundNew').toggleClass('active');
				;$('#backgroundNew').text(metrodir_LANG.ADD_NEW_BACKGROUND);
			}else {
				alert(response);	
			}
		}		
	});
	
	//UPLOAD PHOTO
	new AjaxUpload('photoChange', {
		action: ajaxurl,
		name:'photo',
		data : {'action' : "metrodir_file_upload"},
		onLoad : function(div) {
			$(div).hover(function() {
				$('.change', $('.site-logo')).animate({top : '0'}, 'fast', 'easeOutQuad');	
				$('.border', $('.site-logo')).animate({top : '0', left : '0' ,width : '179px', height : '65px'}, 'fast', 'easeOutQuad');
			}, function() {
				$('.change', $('.site-logo')).animate({top : '-30px'}, 'fast', 'easeOutQuad');
				$('.border', $('.site-logo')).animate({top : '-5px', left : '-5px' ,width : '185px', height : '75px'}, 'fast', 'easeOutQuad');
			});		
		},
		onSubmit : function(file , ext){
			if (ext && /^(jpg|png|jpeg|gif)$/.test(ext.toLowerCase())){
				$('.site-logo').toggleClass('busy');
				$('.site-logo').find('a.change').text(metrodir_LANG.UPLOADING);
			} else {					
				alert(metrodir_LANG.ONLY_IMAGES_ALLOWED);
				return false;				
			}		
		},
		onComplete : function(file, response){
			if(response == '200') {
				var img = $('img', $('.site-logo'));
				var src = img.attr('src').split('?')[0];
				img.hide('fade');
				$('img', $('.site-logo')).attr('src', src+"?"+Math.floor(Math.random()*11));
				img.show('fade');
				$('.site-logo').toggleClass('busy');
				$('.site-logo').find('a.change').text(metrodir_LANG.CHANGE);
				$('.change', $('.site-logo')).animate({top : '-30px'}, 'fast', 'easeOutQuad');
				$('.border', $('.site-logo')).animate({top : '-5px', left : '-5px' ,width : '180px', height : '65px'}, 'fast', 'easeOutQuad');
			}else {
				alert(response);	
			}
		}		
	});

    //UPLOAD Logo-small
    new AjaxUpload('photoChange', {
        action: ajaxurl,
        name:'photo',
        data : {'action' : "metrodir_file_upload"},
        onLoad : function(div) {
            $(div).hover(function() {
                $('.change', $('.site-logo')).animate({top : '0'}, 'fast', 'easeOutQuad');
                $('.border', $('.site-logo')).animate({top : '0', left : '0' ,width : '179px', height : '65px'}, 'fast', 'easeOutQuad');
            }, function() {
                $('.change', $('.site-logo')).animate({top : '-30px'}, 'fast', 'easeOutQuad');
                $('.border', $('.site-logo')).animate({top : '-5px', left : '-5px' ,width : '185px', height : '75px'}, 'fast', 'easeOutQuad');
            });
        },
        onSubmit : function(file , ext){
            if (ext && /^(jpg|png|jpeg|gif)$/.test(ext.toLowerCase())){
                $('.site-logo').toggleClass('busy');
                $('.site-logo').find('a.change').text(metrodir_LANG.UPLOADING);
            } else {
                alert(metrodir_LANG.ONLY_IMAGES_ALLOWED);
                return false;
            }
        },
        onComplete : function(file, response){
            if(response == '200') {
                var img = $('img', $('.site-logo'));
                var src = img.attr('src').split('?')[0];
                img.hide('fade');
                $('img', $('.site-logo')).attr('src', src+"?"+Math.floor(Math.random()*11));
                img.show('fade');
                $('.site-logo').toggleClass('busy');
                $('.site-logo').find('a.change').text(metrodir_LANG.CHANGE);
                $('.change', $('.site-logo')).animate({top : '-30px'}, 'fast', 'easeOutQuad');
                $('.border', $('.site-logo')).animate({top : '-5px', left : '-5px' ,width : '180px', height : '65px'}, 'fast', 'easeOutQuad');
            }else {
                alert(response);
            }
        }
    });
	
	//UPLOAD FAVICON
	new AjaxUpload('favicon', {
		action: ajaxurl,
		name:'favicon',
		data : {'action' : "metrodir_file_upload"},
		onSubmit : function(file , ext){
			if (ext && /^(ico)$/.test(ext.toLowerCase())){
				$('#faviconImg').css({opacity : 0.2});	
			} else {					
				alert(metrodir_LANG.ONLY_ICO_ALLOWED);
				return false;				
			}		
		},
		onComplete : function(file, response){
			if(response == '200') {
				var img = $('#faviconImg');
				var src = img.attr('src').split('?')[0];
				img.hide('fade');
				img.attr('src', src+"?"+Math.floor(Math.random()*11));
				img.show('fade', function() {img.css({opacity : 1});});
			}else {
				alert(response);	
			}
		}		
	});

	//SAVE ALL CHANGES
	var $targ;
	$('.row.save button').click(function() {
		$targ = $(this);	
	});
	$('#settingsForm').submit(function(event) {
		var query = $(this).serialize();
		$('.ajax-loader', $targ.parent()).show('fade');
		$.ajax({
			type : 'POST',
			dataType : 'json',
			url: ajaxurl,
			data: query+'&action=metrodir_settings_save',
			cache : false,
			success: function(response){
				var type = response.success != 200 ? 'warning' : 'success';
				var msg = $.tmpl('messageTemplate', [{Type : type, Message : response.message}]);
				var row = $targ.parents('.row.save');
				msg.click(function () { $(this).fadeOut(); });
				$('.message', row).length == 0 ? msg.prependTo(row) : $('.message', row).fadeOut('fast', function() {$(this).replaceWith(msg)});
				$('.ajax-loader', row).hide('fade');
			}
		});
		return false;
	});	
	
	//TEST SMTP
	$('#smptTest').click(function(event) {
		var btn = $(this);
		var query = 'protocol='+$('input[name="smtp[protocol]"]:checked').val();
		query += '&host='+$('input[name="smtp[host]"]').val();
		query += '&port='+$('input[name="smtp[port]"]').val();
		query += '&username='+$('input[name="smtp[username]"]').val();
		query += '&password='+$('input[name="smtp[password]"]').val();
		btn.addClass('orange');
		btn.attr('disabled', 'disabled');
		$.ajax({
			type : 'POST',
			dataType : 'json',
			url: ajaxurl,
			data: query+'&action=metrodir_smtp_test',
			cache : false,
			success: function(response){
				btn.removeClass('orange');
				btn.removeAttr('disabled', 'disabled');
				alert(response.message);
			},
			error : function(jqXHR, textStatus, errorThrown) {
				alert(textStatus);
				btn.removeAttr('disabled', 'disabled');
			}
		});
		return false;
	});	
	
	
	/* UPDATE *********************************************************/
	$('#installUpdate').click(function() {
		$('#instructions').show('fade');
		return false;		
	});
	//UPDATE CONSOLE
	function updateConsole() {
		$.ajax({
			async: true,
			url: ajaxurl,
			dataType: 'json',
			cache: false,
			data : 'action=metrodir_update_log',
			timeout: 5000,
			success: function(response) {
				if(response.done != 1) {
					 setTimeout(updateConsole, 500);	
				}
				$('.update-console').html('<li>'+response.message+'</li>');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ERROR");
			}
		});
	}
	$('#checkUpdate').click(function() {
		var btn = $(this);
		$.ajax({
			type : 'POST',
			dataType : 'json',
			url: ajaxurl,
			data: '&action=metrodir_update_check',
			cache : false,
			success: function(response){
				btn.removeClass('orange');
				btn.removeAttr('disabled', 'disabled');
				if(confirm(metrodir_LANG.RELOAD_PAGE)) {
					location.reload();	
				}
			},
			error : function(jqXHR, textStatus, errorThrown) {
				alert(textStatus);
				btn.removeAttr('disabled', 'disabled');
			}
		});
		return false;	
	});
	//UPLOAD UPDATE
	if($('#uploadZip').length) {
		new AjaxUpload('uploadZip', {
			action: ajaxurl,
			name:'update',
			data : {'action' : "metrodir_file_upload"},
			onSubmit : function(file , ext){
				if (ext && /^(zip)$/.test(ext.toLowerCase())){
					$('.update-load').show('fade');
					updateConsole();	
				} else {					
					alert(metrodir_LANG.ONLY_ZIP_ALLOWED);
					return false;				
				}		
			},
			onComplete : function(file, response){
				if(response == '200') {
				}else {
					alert(response);	
				}
				$('.update-load').hide('fade');	
			}		
		});
	}
	
	// SKILLS ********************************************************************************************* /
	
	
	//Init Vars
	var nbSkillsSections = 0;
	var nbSkillsSectionItems = [];
	
	//Sortable Sections
	$('.skills').sortable({handle : 'a.drag'});
	//$('.skills').disableSelection();
	$('#skillsSections').sortable({handle : 'a.skills-section-drag', placeholder: "ui-state-highlight", forcePlaceholderSize: true});
	
	//Init Templates
	$.template('skillsSectionTemplate', $('#skillsSectionTemplate').html());
	$.template('skillTemplate', $('#skillTemplate').html());
	
	
	//Bind Section Skill Events
	function bindSkill(skill) {
		
		skill.find('a.delete').click(function(event) {
			$(this).parents('li').remove();	
			return false;
		});
		
		skill.find('.metrodir-vote-bar a').click(function(event) {
			var width = parseInt($(this).css('width'));
			$(this).parents('.metrodir-vote-bar').css({width : width+"px"});
			$(this).parents('li').find('input.rats').val(width/18);
			return false;	
		});
	}
	
	//Bind Skills Sections Events
	function bindSkillsSection(section) {
		
		//Add new Skill
		$('a.skills-item-add', section).click(function(event) {
			
			var data = {};
			data.Rats = '0';
			data.Index = section.data('index');
			data.ItemIndex = nbSkillsSectionItems[data.Index]++;
			
			var skill = $.tmpl('skillTemplate', [data]);
			skill.hide();
			bindSkill(skill);//Bind the skill events
			skill.prependTo(section.find('.skills').get(0)).show('fade');
			
			return false;	
		});
		
		//Delete Section
		section.find('a.skills-section-delete').click(function(event) {
			if (confirm(metrodir_LANG.ARE_YOU_SURE)) {
				$(this).parents('.skills-section').remove();
			}
			return false;	
		});
	}
	
	//Add New Section
	$('.sections-new').click(function() {
		
		var section = $.tmpl("skillsSectionTemplate", [{Index : nbSkillsSections}]);
		section.hide();
		section.data('index', nbSkillsSections);
		bindSkillsSection(section);//Bind the section events
		section.prependTo("#skillsSections").show('fade');
		$('#skillsSectionTitle').val('');
		
		nbSkillsSectionItems[nbSkillsSections] = 0;
		nbSkillsSections++;
		
		//Refresh Stuff !
		$('.skills').sortable({handle : 'a.drag'});
			
		return false;	
	});
	
	//Bind Static Elements
	$('.skills-section').filter(function(index) {
  		return $(this).parents('.template').length == 0;//Don't select tempaltes
	}).each(function(index, section) {
		
		nbSkillsSectionItems[nbSkillsSections] = 0;
		
		bindSkillsSection($(section));//Bind Skills Sections
		$('.skills li', section).each(function(index, skill) {
			
			nbSkillsSectionItems[nbSkillsSections]++;
			bindSkill($(skill)); // Bind Section Skills
		});
		
		//Give identity !
		$(section).data('index', nbSkillsSections);
		nbSkillsSections++;
	});
	
	
	// RESUME ********************************************************************************************* /
	
	//Init Vars
	var nbResumeSections = 0;
	var nbResumeSectionItems = [];
	
	//Sortable Sections
	$('#resumeSections').sortable({handle : 'a.resume-section-drag', placeholder: 'ui-state-r-ph' });
	//$('#resumeSections').disableSelection();
	$('.resume').sortable({handle : 'a.resume-item-drag'});
	//$('.resume').disableSelection();
	
	//Init Templates
	$.template('resumeSectionTemplate', $('#resumeSectionTemplate').html());
	$.template('resumeInputTemplate', $('#resumeInputTemplate').html());
	$.template('resumeItemTemplate', $('#resumeItemTemplate').html());
	
	function resumeItemToInput(resumeItem) {
		var data = {};
		data.Title = $('h4', resumeItem).text();
		data.Place = $('h5', resumeItem).text();
		data.Date = $('.timelineDate', resumeItem).text();
		data.Desc = $('p', resumeItem).text();
		data.Action = metrodir_LANG.EDIT;
		
		var item = $.tmpl('resumeInputTemplate', [data]);
		item.find('button.resume-item-edit').click(function() {
			resumeInputToItem($(this).parents('.resume-input'));
			return false;	
		});
		item.find('button.resume-item-cancel').click(function() {
			resumeInputToItem($(this).parents('.resume-input'), data);
			return false;	
		})
		item.hide();
		resumeItem.replaceWith(item);
		item.show('fade');
	}
	
	function resumeInputToItem(resumeInput, data) {
		
		if(typeof data == 'undefined') {
			var data = {};
			data.Title = $('.resume-item-title', resumeInput).val();
			data.Place = $('.resume-item-place', resumeInput).val();
			data.Date = $('.resume-item-date', resumeInput).val();
			data.Desc = $('.resume-item-desc', resumeInput).val();
		}
		
		data.Index = resumeInput.parents('.resume-section').data('index');
		data.ItemIndex = nbResumeSectionItems[data.Index]++;
		
		var item = $.tmpl('resumeItemTemplate', [data]);
		item.find('a.resume-item-update').click(function() {
			resumeItemToInput($(this).parents('li'));
			return false;	
		});
		item.hide();
		bindResumeItem(item);
		resumeInput.replaceWith(item);
		item.show('fade');
	}
	
	function bindResumeSection(section) {
		
		$('a.resume-item-add', section).click(function(event) {
			
			var item = $.tmpl('resumeInputTemplate', [{Date : '', Action : 'Add'}]);
			//IE 8 Fix
			item.find('input').val('');
			item.find('button.resume-item-edit').click(function() {
				resumeInputToItem($(this).parents('.resume-input'));
				return false;	
			});
			item.find('button.resume-item-cancel').click(function() {
				$(this).parents('.resume-input').remove();
				return false;	
			});
			item.hide();
			bindResumeItem(item);
			item.prependTo(section.find('.resume').get(0));
			item.show('fade');
			//IE FIX
			$('input[placeholder], textarea[placeholder]').placeholder();
			
			$('.resume', section).sortable({handle : 'a.resume-item-drag'});
			return false;
		});	
		
		$('a.resume-section-delete', section).click(function(event) {
			if (confirm(metrodir_LANG.ARE_YOU_SURE)) {
				$(this).parents('.resume-section').fadeOut().remove();
			}
			return false;
		});	
	
		$('a.resume-item-update', section).click(function(event) {
			resumeItemToInput($(this).parents('li'));
			return false;	
		});
		
		section.resumeSectionToggle();
	}
	
	$.fn.resumeSectionToggle = function() {
		var section = $(this);
		$('a.resume-section-toggle', section).click(function() {
			if(section.data('expand')) {
				section.resumeSectionCollapse();
			}else {
				section.resumeSectionExpand();
			}
			return false;
		});
		return;
	};
	
	$.fn.resumeSectionCollapse = function() {
		return this.each(function() {
			var section = $(this);
			var resume = $('.resume', this);
			resume.slideUp('fast', 'swing', function() { 
				$('a.resume-section-toggle', section).text(metrodir_LANG.EXPAND);
				$('a.resume-section-toggle', section).removeClass('expanded');
				$('a.resume-item-add', section).hide('fade'); 
				$('a.resume-section-delete', section).show('fade');
				$('h3', section).css({backgroundColor : '#F2F2F2'});
				section.data('expand', false);
			});
		});
	};
	
	$.fn.resumeSectionExpand = function() {
		return this.each(function() {
			var section = $(this);
			var resume = $('.resume', this);
			resume.slideDown('fast', 'swing', function() { 
				$('a.resume-section-toggle', section).text(metrodir_LANG.COLLAPSE);
				$('a.resume-section-toggle', section).addClass('expanded');
				$('a.resume-item-add', section).show('fade');
				$('a.resume-section-delete', section).hide('fade'); 
				$('h3', section).css({backgroundColor : '#FFF'});
				section.data('expand', true);  
			});
		});
	};
	
	$('.resume-sections-toggle').toggle(function() {
		$('.resume-section').resumeSectionCollapse();
	}, function() {
		$('.resume-section').resumeSectionExpand();
	});
	
	function bindResumeItem(resumeItem) {
		resumeItem.hover(
			function(event) {
				$(this).find('a.resume-item-update, a.resume-item-delete').show('fade');
			}, function(event) {
				$(this).find('a.resume-item-update, a.resume-item-delete').hide('fade');
			}
		);
		
		$('a.resume-item-delete', resumeItem).click(function() {
			if (confirm(metrodir_LANG.ARE_YOU_SURE)) {
				$(this).parents('li').fadeOut().remove();
			}
			return false;
		});
	}
	
	$('.resume-section').filter(function(index) {
  		return $(this).parents('.template').length == 0;//Don't select tempaltes
	}).each(function(index, section) {
		
		nbResumeSectionItems[nbResumeSections] = 0;
		
		bindResumeSection($(section));
		$('.resume li', section).each(function(index, item) {
			
			nbResumeSectionItems[nbResumeSections]++;
			bindResumeItem($(item));
		});
		
		//Give identity !
		$(section).data('index', nbResumeSections);
		nbResumeSections++;
	});
	
	//Add New Section
	$('.resume-sections-new').click(function() {
		
		var section = $.tmpl("resumeSectionTemplate", [{Index : nbResumeSections}]);
		section.hide();
		section.data('index', nbResumeSections);
		bindResumeSection(section);//Bind the section events
		section.prependTo("#resumeSections").show('fade');
		
		nbResumeSectionItems[nbResumeSections] = 0;
		nbResumeSections++;
		
		return false;	
	});
});
