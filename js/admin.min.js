jQuery(document).ready(function($){
	var htmlOutput = '<div id="faqss_settings_wrap" style="display: none;">'+
		'<h1>Settings</h1>'+
		'<table id="faqss_formtable">'+
			'<tr>'+
				'<td class="faqss_cellname">'+
					'Layout Style'+
				'</td>'+
				'<td class="faqss_celloption">'+
					'<select id="faqss_layoutstyle">'+
						'<option value="simple">Simple</option>'+
						'<option value="modern">Modern</option>'+
					'</select>'+
				'</td>'+
			'</tr>'+
			'<tr>'+
				'<td colspan="3">'+
					'<hr class="faqss_divider">'+
				'</td>'+
			'</tr>'+
			'<tr>'+
				'<td colspan="3">'+
					'<h3 class="faqss_subheader">Link Banner</h3>'+
				'</td>'+
			'</tr>'+
			'<tr>'+
				'<td style="padding-bottom: 15px;">'+
					'Hide link banner?'+
				'</td>'+
				'<td style="padding-bottom: 15px;" colspan="2">'+
					'<input id="faqss_hidebanner" type="checkbox" />'+
				'</td>'+
			'</tr>'+
			'<tr>'+
				'<td class="faqss_cellthird">'+
					'<input id="faqss_emailicon" type="text" value="envelope-o" />'+
				'</td>'+
				'<td class="faqss_cellthird">'+
					'<input id="faqss_emailtext" type="text" value="Email" />'+
				'</td>'+
				'<td class="faqss_cellthird">'+
					'<input id="faqss_emaillink" type="text" />'+
				'</td>'+
			'</tr>'+
			'<tr>'+
				'<td class="faqss_cellthird">'+
					'<input id="faqss_telicon" type="text" value="phone" />'+
				'</td>'+
				'<td class="faqss_cellthird">'+
					'<input id="faqss_teltext" type="text" value="Telephone" />'+
				'</td>'+
				'<td class="faqss_cellthird">'+
					'<input id="faqss_tellink" type="text" />'+
				'</td>'+
			'</tr>'+
			'<tr>'+
				'<td class="faqss_cellthird">'+
					'<input id="faqss_docicon" type="text" value="file" />'+
				'</td>'+
				'<td class="faqss_cellthird">'+
					'<input id="faqss_doctext" type="text" value="Documentation" />'+
				'</td>'+
				'<td class="faqss_cellthird">'+
					'<input id="faqss_doclink" type="text" />'+
				'</td>'+
			'</tr>'+
			'<tr>'+
				'<td class="faqss_cellthird">'+
					'<input id="faqss_forumicon" type="text" value="info" />'+
				'</td>'+
				'<td class="faqss_cellthird">'+
					'<input id="faqss_forumtext" type="text" value="Support Forum" />'+
				'</td>'+
				'<td class="faqss_cellthird">'+
					'<input id="faqss_forumlink" type="text" />'+
				'</td>'+
			'</tr>'+
			'<tr>'+
				'<td class="faqss_cellthird">'+
					'<small>Choose a Font Awesome icon.</small>'+
				'</td>'+
				'<td class="faqss_cellthird">'+
					'<small>Change the text to what you wish.</small>'+
				'</td>'+
				'<td class="faqss_cellthird">'+
					'<small>A link of your choice.</small>'+
				'</td>'+
			'</tr>'+
			'<tr>'+
				'<td colspan="3">'+
					'<button id="faqss_insertfaqs" class="button button-primary button-large">Insert FAQs</button>'+
					'<button id="faqss_insertcancel" class="button button-default button-large">Cancel</button>'+
				'</td>'+
			'</tr>'+
		'</table>'+
	'</div>';

	$('body').append( htmlOutput );

	$('#faqss_cbtn').click(function(e){
		tb_show( "FAQs Shortcode", "#TB_inline?width=753&height=550&inlineId=faqss_settings_wrap" );
		e.preventDefault();
	});

	$('#faqss_insertcancel').click(function(){
		tb_remove();
	});

	$('#faqss_insertfaqs').click(function(){
		var layoutStyle = $('#faqss_layoutstyle').val();

		var emailIcon = $('#faqss_emailicon').val();
		var emailText = $('#faqss_emailtext').val();
		var emailLink = $('#faqss_emaillink').val();

		var telIcon = $('#faqss_telicon').val();
		var telText = $('#faqss_teltext').val();
		var telLink = $('#faqss_tellink').val();

		var docIcon = $('#faqss_docicon').val();
		var docText = $('#faqss_doctext').val();
		var docLink = $('#faqss_doclink').val();

		var forumIcon = $('#faqss_forumicon').val();
		var forumText = $('#faqss_forumtext').val();
		var forumLink = $('#faqss_forumlink').val();

		if( layoutStyle == 'modern' && !$('#faqss_hidebanner').is(':checked') ){
			var hideBanner = ' hideBanner="false"';
			var linkBanner = ' emailIcon="'+ emailIcon +'"'+
			' emailText="'+ emailText +'"'+
			' emailLink="'+ emailLink +'"'+
			' telIcon="'+ telIcon +'"'+
			' telText="'+ telText +'"'+
			' telLink="'+ telLink +'"'+
			' docIcon="'+ docIcon +'"'+
			' docText="'+ docText +'"'+
			' docLink="'+ docLink +'"'+
			' forumIcon="'+ forumIcon +'"'+
			' forumText="'+ forumText +'"'+
			' forumLink="'+ encodeURI( forumLink ) +'"';
		} else if( layoutStyle == 'modern' && $('#faqss_hidebanner').is(':checked') ){
			var hideBanner = ' hideBanner="true"';
			var linkBanner = '';
		} else {
			var hideBanner = '';
			var linkBanner = '';
		}

		var shortcodeOutput = '[faqss'+
		' layoutStyle="'+ layoutStyle +'"'+
		hideBanner + linkBanner +']';

		send_to_editor( shortcodeOutput );
		tb_remove();
	});
});
