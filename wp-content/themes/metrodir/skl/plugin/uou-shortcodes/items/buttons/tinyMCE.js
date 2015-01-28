(function() {
    tinymce.create('tinymce.plugins.sc_buttons', {
		// init
        init : function(ed, url) {
			ed.addCommand('cmd_sc_buttons', function() {
				ed.windowManager.open({
					file : url+'/window.php',
					width : 630,
					height : 280,
					inline : 1
				}, {
					plugin_url : url
				});
			});
            ed.addButton('sc_buttons', {
                title : 'Add a Button',
                image : url+'/icon.png',
				cmd: 'cmd_sc_buttons'
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('sc_buttons', tinymce.plugins.sc_buttons);
})();