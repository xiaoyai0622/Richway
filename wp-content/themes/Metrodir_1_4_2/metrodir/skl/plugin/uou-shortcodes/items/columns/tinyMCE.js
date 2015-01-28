(function() {
    tinymce.create('tinymce.plugins.sc_columns', {
		// init
        init : function(ed, url) {
			ed.addCommand('cmd_sc_columns', function() {
				ed.windowManager.open({
					file : url+'/window.php',
					width : 630,
					height : 170,
					inline : 1
				}, {
					plugin_url : url
				});
			});
            ed.addButton('sc_columns', {
                title : 'Add a Column',
                image : url+'/icon.png',
				cmd: 'cmd_sc_columns'
            }); 
			 
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('sc_columns', tinymce.plugins.sc_columns);
})();