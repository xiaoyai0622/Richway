(function() {
    tinymce.create('tinymce.plugins.sc_notifications', {
        // init
        init : function(ed, url) {
			ed.addCommand('cmd_sc_notifications', function() {
				ed.windowManager.open({
					file : url+'/window.php',
					width : 630,
					height : 290,
					inline : 1
				}, {
					plugin_url : url
				});
			});
            ed.addButton('sc_notifications', {
                title : 'Add a Notification',
                image : url+'/icon.png',
				cmd: 'cmd_sc_notifications'
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('sc_notifications', tinymce.plugins.sc_notifications);
})();