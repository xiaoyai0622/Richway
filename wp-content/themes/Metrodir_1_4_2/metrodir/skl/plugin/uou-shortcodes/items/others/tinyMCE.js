(function() {
    tinymce.create('tinymce.plugins.sc_others', {
        // init
        init : function(ed, url) {
			ed.addCommand('cmd_sc_others', function() {
				ed.windowManager.open({
					file : url+'/window.php',
					width : 630,
					height : 150,
					inline : 1
				}, {
					plugin_url : url
				});
			});
            ed.addButton('sc_others', {
                title : 'Add a others',
                image : url+'/icon.png',
				cmd: 'cmd_sc_others'
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('sc_others', tinymce.plugins.sc_others);
})();