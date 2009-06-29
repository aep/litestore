asphyxRegistry['com.handelsweise.litestore.product_image']={
    name: { 
        en:'ProductImage',
        de:'Produktbild'
    },
    construct: function(plugin){



        plugin.img1 = new Image();
        plugin.img2 = new Image();
        plugin.img3 = new Image();

        plugin.imgpanel = new Ext.Panel({
            layout: 'column',
            items : [
                new Ext.BoxComponent({el:plugin.img3}),
                new Ext.BoxComponent({el:plugin.img2}),
                new Ext.BoxComponent({el:plugin.img1})
            ]
        });
        plugin.imgpanel.reload=function(){
            plugin.node.data.url_small  = plugin.form.form.items.map.url_small.getValue();
            plugin.node.data.url_middle = plugin.form.form.items.map.url_middle.getValue();
            plugin.node.data.url_big    = plugin.form.form.items.map.url_big.getValue();
            plugin.img1.src= 'images/kein_bild-thumb.png';
            plugin.img2.src= 'images/kein_bild-klein.png';
            plugin.img3.src= 'images/kein_bild-gross.png';

            if(plugin.node.data.url_small!=''){
                var t1=plugin.node.data.url_small+'?nocache='+(new Date());

                rpcCommand({command: 'checkRemoteUrl',url: toAbsURL(t1)},function (v){
                    if(v){
                        plugin.img1.src= t1;
                    }
                    else {
                        rpcCommand({command: 'checkRemoteUrl',url: toAbsURL(plugin.node.data.url_small)},function (v){
                            if(v){
                                plugin.img1.src=  plugin.node.data.url_small;
                            }                        
                        });
                    }
                });
            }
            if(plugin.node.data.url_middle!=''){
                var t2=plugin.node.data.url_middle+'?nocache='+(new Date());

                rpcCommand({command: 'checkRemoteUrl',url: toAbsURL(t2)},function (v){
                    if(v){
                        plugin.img2.src= t2;
                    }
                    else {
                        rpcCommand({command: 'checkRemoteUrl',url: toAbsURL(plugin.node.data.url_middle)},function (v){
                            if(v){
                                plugin.img2.src=  plugin.node.data.url_middle;
                            }                        
                        });
                    }
                });
            }
            if(plugin.node.data.url_big!=''){
                var t3=plugin.node.data.url_big+'?nocache='+(new Date());

                rpcCommand({command: 'checkRemoteUrl',url: toAbsURL(t3)},function (v){
                    if(v){
                        plugin.img3.src= t3;
                    }
                    else {
                        rpcCommand({command: 'checkRemoteUrl',url: toAbsURL(plugin.node.data.url_big)},function (v){
                            if(v){
                                plugin.img3.src=  plugin.node.data.url_big;
                            }                        
                        });
                    }
                });
            }
        }




        plugin.uploadform = new Ext.form.FormPanel
        ({ 
            labelWidth: 200,
            border:false,
            fileUpload: true,
            items:[ 
                    new Ext.form.FileUploadField({
                        id : 'azr_product_images_upload',
                        buttonOnly: true,
                        buttonText: 'Hochladen...',
                        listeners: {
                            'fileselected': function(fb, v){
                                plugin.uploadform.getForm().submit({
                                    url: 'upload.php',
                                    success: function(fp, o){
                                        plugin.form.form.items.map.url_small.setValue(o.result.url_small);
                                        plugin.form.form.items.map.url_middle.setValue(o.result.url_middle);
                                        plugin.form.form.items.map.url_big.setValue(o.result.url_big);
                                        plugin.imgpanel.reload();
                                    },
                                    failure: function(fp, o){ 
                                        Ext.Msg.alert('File upload error',
                                            'The backend rejected this file. It might be too big or in an unsupported format');
                                    }
                                });
                            }
                        }
                    }),
                    new Ext.form.Hidden({
                        id :'products_id',
                        value : plugin.node.data.products_id,
                    }),
                    new Ext.form.Hidden({
                        id :'image_nr',
                        value : plugin.node.data.image_nr
                    }),
                    new Ext.form.Hidden({
                        id :'command',
                        value: 'uploadProductsImage'
                    })


                ]
        });
        plugin.form = new Ext.form.FormPanel
        ({
            border:false,
            labelWidth: 200,
            defaultType: 'textfield',
            items: [ 
                { 
                    id: 'url_small',
                    fieldLabel: 'Kleines Bild',
                    width: '100%',
                    value: plugin.node.data.url_small
                },
                { 
                    id: 'url_middle',
                    fieldLabel: 'Mittelgroßes Bild',
                    width: '100%',
                    value: plugin.node.data.url_middle
                },
                { 
                    id: 'url_big',
                    fieldLabel: 'Großes Bild',
                    width: '100%',
                    value: plugin.node.data.url_big
                }
            ]
        });

        plugin.editor = new Ext.Panel({
            items: [plugin.imgpanel,plugin.form,plugin.uploadform],
            autoScroll: true   
        });

        plugin.save =  function(plugin){
            plugin.imgpanel.reload();
            plugin.data=plugin.form.getForm().getValues();
            plugin.data.products_id=plugin.node.data.products_id;
            plugin.data.image_nr=plugin.node.data.image_nr;
            plugin.node.data=plugin.data;
            rpcCommand({ command: 'asphyx',aclass: 'com.handelsweise.litestore.product_image', action : 'set', data: plugin.data }
            );
        };


        plugin.form.on('render',function(){
            plugin.imgpanel.reload();
            plugin.imgpanel.body.on('mouseover', function(e) {
                plugin.imgpanel.disable();

                plugin.imgpanel.el._mask.addClass('mask-reload-btn');
                plugin.imgpanel.el._mask.on('mouseout', function(e) {
                    plugin.imgpanel.enable();
                });
                plugin.imgpanel.el._mask.on('click', function(e) {
                    plugin.imgpanel.reload();
                });
            });

        });



    },
    createNode:  function(node){
        if(node.aclass!="com.handelsweise.litestore.product"){
            return;
        }
        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.handelsweise.litestore.product_image',
                action : 'create',
                parent: node.parentNode.data.categories_id,
                product: node.data.products_id,

            },
            function (value){
                var n=node.appendChild(node.attributes.loader.createNode(value));
                var p=n.getPath();
                var tree=n.getOwnerTree();
                n.ensureVisible(function(){tree.selectPath(p);});
            }
        );
    },
    removeNode:  function(node){
        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.handelsweise.litestore.product_image',
                action : 'delete',
                nr: node.data.image_nr,
                product: node.data.products_id,
            },
            function (value){
                node.parentNode.select();
                node.remove();
            }
        );
    },
    canDrop:  function(e){
        var newParent=(e.point=='append')?e.target:e.target.parentNode;        
        return (newParent.aclass=='com.handelsweise.litestore.product');
    },
    drop: function (e){
        var newParent=(e.point=='append')?e.target:e.target.parentNode;

        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.handelsweise.litestore.product_image',
                action : 'move',
                relative: e.point,
                relativeTo: e.target.data.image_nr,
                productOld: e.dropNode.data.products_id,
                productNew: newParent.data.products_id,
                nrOld: e.dropNode.data.image_nr,
            },
            function (value){
                newParent.reload();
            }
        );
        return true;
    }
}



/*
Kategorie Bild:
Kategorie Teaser: 	
Artikel-Sortierung: 	
Artikel-Sortierung: 	
*/


