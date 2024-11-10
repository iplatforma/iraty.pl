tinyMCE.init({
    theme: "advanced",
    mode: "exact",
    elements: "tresc",
	oninit: background,
    extended_valid_elements: 'i[*],span[*]',
	plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,visualblocks",

	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,forecolor,backcolor,|,styleprops,spellchecker,|,bullist,numlist,|,blockquote,|,link,unlink,anchor,image,media",
	theme_advanced_buttons2 : "pastetext,pasteword,|,replace,|,undo,redo,|,removeformat,|,formatselect,fontsizeselect,styleselect,|,code,|,template",
	theme_advanced_buttons3 : "tablecontrols,visualblocks",
	theme_advanced_buttons4 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
	// Skin options
	skin : "o2k7",
	skin_variant : "silver",
	
	schema: 'html5',
	
	end_container_on_empty_block: true,
	
	
	style_formats : [
			{title : 'Nagłówek duży', block : 'h2', classes:'bigger'},
			{title : 'Paragraf duży', block : 'p', classes: 'bigger' },
			{title : 'Nagłówek mały', block : 'h3',  classes: 'header'  },
			{title : 'Paragraf mały', block : 'p', classes: 'header' },
			{title : 'Przycisk niebieski', inline : 'a', classes: 'button' },
			{title : 'Przycisk szary', inline : 'a', classes: 'button grey' },
			{title : 'Przycisk biały', inline : 'a', classes: 'button white' },
			{title : 'Link download', inline : 'a', classes: 'download' },
			{title : 'p', inline : 'p'},
			{title : 'Przerwa', block : 'aside', classes: 'clear', wrapper: true}
	],
	

	template_templates : [
	  {
		title : "Lewa tekst | (z tłem)",
		src : "/assets/js/tinymce_3/plugins/template/left.htm",
		description : "Po lewej tekst"
	  },
	  {
		title : "Prawa tekst | (z tłem)",
		src : "/assets/js/tinymce_3/plugins/template/right.htm",
		description : "Po prawej tekst"
	  },
	  {
		title : "Lewa tekst | Prawa tekst",
		src : "/assets/js/tinymce_3/plugins/template/left_right.htm",
		description : "Po lewej tekst i po prawej tekst"
	  },
	  {
		title : "Tekst 100%",
		src : "/assets/js/tinymce_3/plugins/template/100.htm",
		description : "Tekst na całej szerokości"
	  },
	  {
		title : "Tekst 70%",
		src : "/assets/js/tinymce_3/plugins/template/70_center.htm",
		description : "70% szerokości wycentrowane"
	  },
	  {
		title : "3 boksy",
		src : "/assets/js/tinymce_3/plugins/template/box_3.htm",
		description : "Podzielone na 3 równe części"
	  },
	  {
		title : "4 boksy",
		src : "/assets/js/tinymce_3/plugins/template/box_4.htm",
		description : "Podzielone na 4 równe części"
	  },
	  {
		title : "5 boksów",
		src : "/assets/js/tinymce_3/plugins/template/box_5.htm",
		description : "Podzielone na 5 równych części"
	  },
	  {
		title : "3 boksy (animacja)",
		src : "/assets/js/tinymce_3/plugins/template/box_3_animate.htm",
		description : "Podzielone na 3 równe części z animacja po najechaniu"
	  }
	],

	// Example content CSS (should be your site CSS)
	content_css : "/assets/js/tinymce_3/themes/advanced/skins/o2k7/content.css",
	file_browser_callback : 'elFinderBrowser',

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "js/template_list.js",
	external_link_list_url : "js/link_list.js",
	external_image_list_url : "js/image_list.js",
	media_external_list_url : "js/media_list.js",
    width:"100%",
	height:"700px",
    language: "pl"
	});
		
function background() {
	if($('input#background_color').val() != null) {
		$('iframe#mce_editor_0_ifr').contents().find('body.mceContentBody').css('background-color','#'+$('input#background_color').val());
	}
}
		
function elFinderBrowser (field_name, url, type, win) {
  var elfinder_url = '/assets/js/elfinder/elfinder.html';    // use an absolute path!
  tinyMCE.activeEditor.windowManager.open({
    file: elfinder_url,
    title: 'elFinder 2.0',
    width: 900,  
    height: 450,
    resizable: 'yes',
    inline: 'yes',    // This parameter only has an effect if you use the inlinepopups plugin!
    popup_css: false, // Disable TinyMCE's default popup CSS
    close_previous: 'no'
  }, {
    window: win,
    input: field_name
  });
  return false;
}
