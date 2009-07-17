asphyxPluginBuilderExtend('com.asgaartech.asphyx.folder','com.asgaartech.asphyx.preset',{
    name:{
        en:'Preset',
        de:'Preset'
    },
    canDrop:  function(e){
        var newParent=(e.point=='append')?e.target:e.target.parentNode;        
        return newParent==e.dropNode.parentNode;
    },
});



