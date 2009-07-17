asphyxPluginBuilderExtend('com.asgaartech.asphyx.folder','com.asgaartech.asphyx.conditional.random',{
    name:{
        en:'Random',
        de:'Zufall'
    },
    construct: function(plugin){
        plugin.editor = new Ext.form.FormPanel({});
    },
    save :  function(plugin){
    } 
});



