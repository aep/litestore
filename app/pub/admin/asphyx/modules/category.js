asphyxPluginBuilder('com.handelsweise.litestore.category',
{
    name: { 
        en:'Category',
        de:'Kategorie'
    },
    construct: function(plugin){

        var newCategoryImage= function(construct){

            var oP = new Object();
            oP.img = new Image();
            oP.input = new Ext.form.TextField({ 
                id: construct.id,
                labelSeparator: '',
                fieldLabel: '',
                anchor:'100%'
            });
            oP.inputPanel=new Ext.Panel({
                border:false,
                layout:'column',
                items:[
                    new Ext.Panel({
                        layout:'form',
                        border:false,
                        columnWidth:1,
                        bodyStyle:'padding:0 18px 0 0',
                        items:[oP.input]
                    }),
                    new Ext.form.FileUploadField({
                        id : 'azr_category_images_uploadC',
                        buttonOnly: true,
                        buttonText: 'Hochladen...',
                        listeners: {
                            'fileselected':    function(fb, v){
                                var u = this;
                                var f = new Ext.form.FormPanel({
                                    items:[u]
                                });
                                f.getForm().submit({
                                    url: 'upload.php',
                                    success: function(fp, o){
                                        if(Ext.isOpera){
                                            var x=function(){
                                                rpcCommand(
                                                    {
                                                        command: 'asphyx',
                                                        aclass: 'com.handelsweise.litestore.category',
                                                        action : 'get',
                                                        image_nr: plugin.node.data.image_nr,
                                                        product: plugin.node.data.products_id,
                                                    },
                                                    function (v){
                                                        plugin.form.form.items.map.url_small.setValue(v.url_small);
                                                        plugin.form.form.items.map.url_middle.setValue(v.url_middle);
                                                        plugin.form.form.items.map.url_big.setValue(v.url_big);
                                                        plugin.imgpanel.reload();
                                                    }
                                                );
                                             };
                                             x.defer(1);
                                        }
                                        else{
                                            plugin.form.form.items.map.url_small.setValue(o.result.url_small);
                                            plugin.form.form.items.map.url_middle.setValue(o.result.url_middle);
                                            plugin.form.form.items.map.url_big.setValue(o.result.url_big);
                                            plugin.imgpanel.reload();
                                        }
                                    },
                                    failure: function(fp, o){ 
                                        Ext.Msg.alert('File upload error',
                                            'The backend rejected this file. It might be too big or in an unsupported format');
                                    }
                                });
                            }
                        }
                    })
                ]
            });
            oP.imgPanel=new Ext.Panel({
                layout:'column',
                border: false,
                fieldLabel: construct.fieldLabel,
                items:[{
                    border:false,
                    width:205,
                    html:construct.fieldLabel+':'
                },{
                    border:false,
                    el: oP.img
                }],
                listeners:{
                    render : function(){
                        this.body.on('mouseover', function(e) {
                            oP.imgPanel.disable();
                            oP.imgPanel.el._mask.addClass('mask-reload-btn');
                            oP.imgPanel.el._mask.on('mouseout', function(e) {
                                oP.imgPanel.enable();
                            });
                            oP.imgPanel.el._mask.on('click', function(e) {
                                oP.reload();
                            });
                        });
                    }
                }
            });
            oP.reload= function(){
                oP.img.src= 'images/kein_bild-thumb.png';
                var e=oP.input.getValue();
                if(e!='' && e!=undefined){
                    var t1=e+'?nocache='+(new Date());
                    rpcCommand({command: 'checkRemoteUrl',url: toAbsURL(t1)},function (v){
                        if(v){
                            oP.img.src= t1;
                        }
                        else {
                            rpcCommand({command: 'checkRemoteUrl',url: toAbsURL(e)},function (v){
                                if(v){
                                    oP.img.src=  e;
                                }                        
                            });
                        }
                    });
                }
            };
            oP.setValue= function(v){
                oP.input.setValue(v);
                oP.reload();
            };
            oP.getValue= function(v){
                return oP.input.getValue();
            };
            oP.panel= new Ext.Panel({
                id:construct.id,
                oP:oP,
                setValue:oP.setValue,
                getValue:oP.getValue,
                border:false,
                items:[
                    oP.imgPanel,
                    oP.inputPanel
                ],
                listeners:{
                    render:function(){
                        oP.reload();
                    }
                }
            });

            return oP.panel;
        };


        plugin.editor = new Ext.form.FormPanel
        ({
            labelWidth: 200,
            defaultType: 'textfield',
            autoScroll: true,
            defaults:{
                border:false
            },
            items: [ { 
                    id: 'name',
                    fieldLabel: 'Name',
                    width: '100%'
                },{ 
                    id: 'heading_title',
                    fieldLabel: 'Überschrift',
                    width: '100%'
                },
                newCategoryImage({
                    id:'image',
                    fieldLabel: 'Bild',
                }),
                newCategoryImage({
                    id:'teaser',
                    fieldLabel: 'Teaser',
                }),
                new Ext.form.HtmlEditor(
                { 
                    id: 'description',
                    fieldLabel: 'Beschreibung'
                }),
                new Ext.form.Checkbox(
                { 
                    id: 'status',
                    fieldLabel: 'Aktiv',
                }),
                { 
                    id: 'meta_title',
                    fieldLabel: 'Meta Title',
                    width: '100%'
                },
                { 
                    id: 'meta_description',
                    fieldLabel: 'Meta Description',
                    width: '100%'
                },
                { 
                    id: 'meta_keywords',
                    fieldLabel: 'Meta Keywords',
                    width: '100%'
                },    
                new Ext.form.ComboBox({
                    fieldLabel: 'Produkte sortien nach',
                    id: 'products_sorting_keyCC',
                    hiddenName: 'products_sorting_key',
                    store: new Ext.data.SimpleStore({
                        fields: ['v','d'],
                        data :  [
                            ['Artikelnummer','p.products_model'],
                            ['Artikelname','pd.products_name'],
                            ['letzter Änderung','p.products_last_modified'],
                            ['angegebener Reihenfolge','p.products_sort']
                        ]
                    }),
                    displayField:'v',
                    valueField: 'd',
                    mode: 'local',
                    triggerAction: 'all',
                    emptyText:'Select a sorting key...',
                    selectOnFocus:true,
                    forceSelection: true
                }),    
                new Ext.form.ComboBox({
                    fieldLabel: 'Sortierrichtung',
                    id: 'products_sortingCC',
                    hiddenName: 'products_sorting',
                    store: new Ext.data.SimpleStore({
                        fields: ['v','d'],
                        data :  [
                            ['Aufsteigend','0'],
                            ['Absteigend','1']
                        ]
                    }),
                    displayField:'v',
                    valueField: 'd',
                    mode: 'local',
                    triggerAction: 'all',
                    selectOnFocus:true,
                    forceSelection: true
                })
            ]
        });

        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.handelsweise.litestore.category',
                action : 'get',
                categories_id: plugin.node.data.categories_id
            },
            function (value){
                plugin.editor.items.map.name.setValue(value.name);
                plugin.editor.items.map.description.setValue(value.description);
                plugin.editor.items.map.heading_title.setValue(value.heading_title);
                plugin.editor.items.map.meta_title.setValue(value.meta_title);
                plugin.editor.items.map.meta_keywords.setValue(value.meta_keywords);
                plugin.editor.items.map.meta_description.setValue(value.meta_description);
                plugin.editor.items.map.status.setValue(value.status);
                plugin.editor.items.map.products_sorting_keyCC.setValue(value.products_sorting_key);
                plugin.editor.items.map.products_sortingCC.setValue(value.products_sorting);
                plugin.editor.items.map.products_sortingCC.setValue(value.products_sorting);
                plugin.editor.items.map.image.setValue(value.image);
                plugin.editor.items.map.teaser.setValue(value.teaser);
            }
        );
    },
    save :  function(plugin){
        plugin.editor.items.map.description.syncValue();
        plugin.data=plugin.editor.getForm().getValues();
        plugin.data.id=plugin.node.data.categories_id;
        plugin.node.setText(plugin.editor.items.map.name.getValue());
        rpcCommand({ command: 'asphyx',aclass: 'com.handelsweise.litestore.category', action : 'set', data: plugin.data });
    },
    createNode:  function(node){
        if(node.aclass!="com.handelsweise.litestore.category"){
            return;
        }
        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.handelsweise.litestore.category',
                action : 'create',
                parent: node.data.categories_id,
                name  : 'Neue Kategorie'
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
        if(node.data.categories_id<2){
            return false;
        }
        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.handelsweise.litestore.category',
                action : 'delete',
                category: node.data.categories_id,
            },
            function (value){
                node.parentNode.select();
                node.remove();
            }
        );
    },
    canDrop:  function(e){
        var newParent=(e.point=='append')?e.target:e.target.parentNode;        
        return (newParent.aclass=='com.handelsweise.litestore.category');
    },
    drop: function (e){
        var newParent=(e.point=='append')?e.target:e.target.parentNode;

        rpcCommand(
            {
                command: 'asphyx',
                aclass: 'com.handelsweise.litestore.category',
                action : 'move',
                relative: e.point,
                relativeTo: e.target.data.categories_id,
                parentOld: e.dropNode.parentNode.data.categories_id,
                parentNew: newParent.data.categories_id,
                category: e.dropNode.data.categories_id
            },
            function (value){
//                newParent.reload();
            }
        );
        return true;
    },
    acceptedChildClasses: function (){
        return [
            'com.handelsweise.litestore.category',
            'com.handelsweise.litestore.product'
        ];
    }
});



