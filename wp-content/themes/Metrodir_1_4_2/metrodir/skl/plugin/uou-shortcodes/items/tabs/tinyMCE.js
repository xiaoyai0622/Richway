(function() {
    tinymce.create('tinymce.plugins.sc_tabs', {
        //init
        init : function(ed, url) {
			ed.addCommand('cmd_sc_tabs', function() {
				ed.windowManager.open({
					file : url+'/window.php',
					width : 630,
					height : 20,
					inline : 1
				}, {
					plugin_url : url
				});
			});
            ed.addButton('sc_tabs', {
                title : 'Add a Tabs',
                image : url+'/icon.png',
				cmd: 'cmd_sc_tabs'
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('sc_tabs', tinymce.plugins.sc_tabs);
})();