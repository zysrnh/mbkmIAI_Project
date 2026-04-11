tinymce.PluginManager.add('leaui_formula', function(editor, url) {
	function showDialog() {
		var dom = editor.dom;

		function GetTheHtml(){
			var html = '<iframe name="leauiFormulaIfr" id="leauiFormulaIfr" src="'+ url + '/index.html'+ '?' + new Date().getTime() + '" scrolling="no" frameborder="0"></iframe>';
			return html;
		}
		
		window.CKEDITOR_LEAUI_FORMULAR = editor;
		win = editor.windowManager.open({
			title: "Formula",
			width : 822,
			height : 382,
			html: GetTheHtml(),
			buttons: [
				{
					text: 'Cancel',
					onclick: function() {
						this.parent().parent().close();
					}
				},

				{
					text: 'Insert Formula',
					subtype: 'primary',
					onclick: function(e) {
						var me = this;
						if(window.frames['leauiFormulaIfr'] && window.frames['leauiFormulaIfr'].getData) {
							window.frames['leauiFormulaIfr'].getData(function(src, latex) {
								if(src) {
									editor.insertContent('<img src="' + src + '" data-latex="' + latex + '"/>');
								}
								me.parent().parent().close();
							});
						} else {
							me.parent().parent().close();
						}
					}
				}
			]
		});
	}
	
	editor.addButton('leaui_formula', {
		image: url + '/icon.png',
		tooltip: 'Insert Formula',
		onclick: showDialog,
		// stateSelector: 'img:not([data-mce-object])'
	});

	editor.addMenuItem('leaui_formula', {
		image: url + '/icon.png',
		text: 'Insert Formula',
		onclick: showDialog,
		context: 'insert',
		prependToContext: true
	});
});
