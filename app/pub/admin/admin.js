window.onerror = function(message, uri, line)
{
    var fullMessage = message + "\n at " + uri + ": " + line + "\n\n<br/> The Application will now attemp to reload. If the problem persists, please contact the system administrator."

    //remoteLogger.log(fullMessage)
 
    Ext.MessageBox.alert('Litestore Admin has crashed',fullMessage, function(btn, text){ location.reload();});
    return false                      
}

var mainpanel;
var mainmenu;
var menus = new Object();
var statusbar;

var appInitState= new Ext.util.Observable();
appInitState.addEvents({
    "loadMenus" : true,
});


Ext.onReady(function()
{

    Ext.BLANK_IMAGE_URL = 'images/s.gif';

    Ext.QuickTips.init();

    mainpanel = new Ext.Panel({
        autoScroll  :  'true',
	    region:'center',
	    deferredRender:false,
        activeTab:0,
        layout: 'card',
        border:false
    });
    mainmenu = new Ext.Toolbar({
        id:'action-panel',
        region:'north',
        border: false,
        height: '20',
    });
    statusbar = new Ext.StatusBar({
        region:'south'
    });


    // Configure viewport
    viewport = new Ext.Viewport({
           layout:'border',
           items:[mainmenu,mainpanel,statusbar]});

    module_html('Willkommen','/admin/start.php');

    appInitState.fireEvent("loadMenus");

    mainmenu.add({text:'Beenden',iconCls:'icon_exit',handler:function(){logout()}});
    mainmenu.addFill();

});


var busycount=0;
function busyRef(){
    busycount++;
    statusbar.showBusy();
};

function busyDeref(){
    if(--busycount<1){
        statusbar.clearStatus();
    }
};
Ext.Ajax.on('beforerequest', function(){busyRef();});
Ext.Ajax.on('requestcomplete', function(){busyDeref();});


function module_iframe(title,uri)
{
    busyRef();
    document.title = 'Litemin - '+title;
    
    var panel = new Ext.Panel({
        border: false,
        html : '<iframe src="'+uri+'" width="100%" height="100%" marginheight="0" marginwidth="0" frameborder="0"/>'
    });

    mainpanel.remove(0);
    mainpanel.add(panel);
    mainpanel.getLayout().setActiveItem(0);
    mainpanel.doLayout();    

    busyDeref();
}





function module_js(uri)
{
    new Ajax.Request(uri,
    {
        evalJS: false,
        method: 'get',
        onSuccess: function(transport) 
        {   
            eval(transport.responseText);
        },
        onFailure: function(transport)
        {
            alert("failure");
        }
    });
}



function module_html(title,uri)
{
    busyRef();
    document.title = 'Litemin - '+title;

    new Ajax.Request(uri,
    {
        method: 'get',
        onSuccess: function(transport) 
        {   

            var panel = new Ext.Panel({
	            border: false,
                html    :transport.responseText
            });

            mainpanel.remove(0);
            mainpanel.add(panel);
            mainpanel.getLayout().setActiveItem(0);
            mainpanel.doLayout();

            var sl=transport.responseText.extractScripts();
            for(var i = 0;i < sl.length;i++)
            {
                eval(sl[i]);
            }
            busyDeref();
        },
        onFailure: function(transport)
        {
            throw "module_html failure";
        }
    });
}



function logout()
{
    new Ajax.Request('/logout',
    {
        onSuccess: function(transport)         
        {
            location.reload();
        },
        onFailure: function(transport)
        {
            alert("failure");
        }
    });

}



function rpcCommand(command,callback){
    Ext.Ajax.request({
        url: '/admin/rpc.php',  
        jsonData : [command],
        success: function(transport)
        {
            var o=Ext.util.JSON.decode(transport.responseText)[0];
            if(!o.success){
                throw 'RPC command not succesfull: '+o.error;
            }
            callback(o.value);
        },
        failure: function(transport)
        {
                throw 'RPC command not succesfull: Transport error ';
        }
    });
}







