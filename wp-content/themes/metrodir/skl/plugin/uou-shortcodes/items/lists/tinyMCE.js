(function() {
    tinymce.create('tinymce.plugins.sc_lists', {
        // init
        init : function(ed, url) { 
			ed.addCommand('cmd_sc_lists', function() {
				ed.windowManager.open({
					file : url+'/window.php',
					width : 630,
					height : 140,
					inline : 1
				}, {
					plugin_url : url
				});
			});
            ed.addButton('sc_lists', {
                title : 'Add a List',
                image : url+'/icon.png',
				cmd: 'cmd_sc_lists'
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('sc_lists', tinymce.plugins.sc_lists);
})();