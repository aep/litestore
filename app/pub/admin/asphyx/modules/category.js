asphyxPluginBuilder('com.handelsweise.litestore.category',
{
    name: { 
        en:'Category',
        de:'Kategorie'
    },
    construct: function(plugin){



        var CategoryImage= Ext.extend(Ext.Panel, {

            constructor: function(config) {
                var CI=this;

                this.init=config;

                this.img = new Image();
                this.imgpanel=  new Ext.Panel({
                    border:false,
                    colspan:2,
                    items:[new Ext.BoxComponent({el:this.img})]
                    
                });

                this.input = new Ext.form.TextField ({
                    width:'100%'
                });

                this.uploadfield = new Ext.form.FileUploadField({
                    id : config.id,
                    hideLabel:'true',
                    buttonOnly: true,
                    buttonText: 'Hochladen...',
                    listeners: {
                        'fileselected': function(fb, v){
                            CI.fileselected(fb,v);
                        }
                    }       
                });
                this.uploadform = new Ext.form.FormPanel ({
                    labelWidth: 200,
                    defaultType: 'textfield',
                    fileUpload: true,
                    autoScroll: true,
                    border:false,
                    defaults:{
                        border:false
                    },
                    layout:'column',
                    items:[
                        this.uploadfield,
                        new Ext.form.Hidden({
                            id :'categories_id',
                            value : plugin.node.data.categories_id,
                        }),
                        new Ext.form.Hidden({
                            id :'field',
                            value: config.id
                        }),
                        new Ext.form.Hidden({
                            id :'command',
                            value: 'uploadCategoryImage'
                        })
                    ]
                });


                config = Ext.apply({
                    id:config.id+'_f',
                    items:[
                        this.imgpanel,
                        this.input,
                        this.uploadform,
                    ],
                    layout:'table',
                    layoutConfig: {
                        columns: 2
                    },
                    bodyStyle:'padding:10px'
                }, config);

                CategoryImage.superclass.constructor.call(this, config);

                this.imgpanel.on('render',function(){
                    CI.reload();
                    CI.imgpanel.body.on('mouseover',function(e) {
                        CI.imgpanel.disable();
            
                        CI.imgpanel.el._mask.addClass('mask-reload-btn');
                        CI.imgpanel.el._mask.on('mouseout', function(e) {
                            CI.imgpanel.enable();
                        });
                        CI.imgpanel.el._mask.on('click', function(e) {
                            CI.reload();
                        });
                    });
                });


            },
            fileselected:  function(fb, v){
                var CI=this;
                this.uploadform.getForm().submit({
                    url: 'upload.php',
                    success: function(fp, o){
                        if(Ext.isOpera){
                            var x=function(){
                                rpcCommand(
                                    {
                                        command: 'asphyx',
                                        aclass: 'com.handelsweise.litestore.category',
                                        action : 'get',
                                        categories_id: plugin.node.data.categories_id
                                    },
                                    function (value){
                                        CI.setValue(value[CI.init.id]);
                                    }
                                );
                             };
                             x.defer(1);
                        }
                        else{
                            CI.input.setValue(o.result.url);
                            CI.reload.call(CI);
                        }
                    },
                    failure: function(fp, o){ 
                        Ext.Msg.alert('File upload error',
                            'The backend rejected this file. It might be too big or in an unsupported format');
                    }
                });
            },
            reload: function(){
                var CI=this;
                this.img.src= 'images/kein_bild-thumb.png';
                var e=this.input.getValue();
                if(e!='' && e!=undefined){
                    var t1=e+'?nocache='+(new Date());
                    rpcCommand({command: 'checkRemoteUrl',url: toAbsURL(t1)},function (v){
                        if(v){
                            CI.img.src= t1;
                        }
                        else {
                            rpcCommand({command: 'checkRemoteUrl',url: toAbsURL(e)},function (v){
                                if(v){
                                    CI.img.src=  e;
                                }                        
                            });
                        }
                    });
                }
            },
            setValue: function(v){
                this.input.setValue(v);
                this.reload();
            },
            getValue: function(v){
                return this.input.getValue();
            }
        });



        plugin.baseeditor = new Ext.form.FormPanel
        ({
            title:'Base',
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



        plugin.imageditor=new CategoryImage({
            id:'image',
            title: 'Bild',
            labelWidth:'200'
        });
        plugin.teasereditor=new  CategoryImage({
            id:'teaser',
            title: 'Teaser',
            labelWidth:'200'
        })

        plugin.editor=new Ext.Panel({
            autoScroll: true,
            items:[
                plugin.baseeditor,
                plugin.imageditor,
                plugin.teasereditor

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
                plugin.baseeditor.items.map.name.setValue(value.name);
                plugin.baseeditor.items.map.description.setValue(value.description);
                plugin.baseeditor.items.map.heading_title.setValue(value.heading_title);
                plugin.baseeditor.items.map.meta_title.setValue(value.meta_title);
                plugin.baseeditor.items.map.meta_keywords.setValue(value.meta_keywords);
                plugin.baseeditor.items.map.meta_description.setValue(value.meta_description);
                plugin.baseeditor.items.map.status.setValue(value.status);
                plugin.baseeditor.items.map.products_sorting_keyCC.setValue(value.products_sorting_key);
                plugin.baseeditor.items.map.products_sortingCC.setValue(value.products_sorting);
                plugin.baseeditor.items.map.products_sortingCC.setValue(value.products_sorting);
                plugin.imageditor.setValue(value.image);
                plugin.teasereditor.setValue(value.teaser);
            }
        );

    },
    save :  function(plugin){
        plugin.baseeditor.items.map.description.syncValue();
        plugin.data=plugin.baseeditor.getForm().getValues();
        plugin.data.id=plugin.node.data.categories_id;

        plugin.data.image=plugin.imageditor.getValue();
        plugin.data.teaser=plugin.teasereditor.getValue();

        plugin.node.setText(plugin.baseeditor.items.map.name.getValue());
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
    acceptedChildClasses: function (){
        return [
            'com.handelsweise.litestore.category',
            'com.handelsweise.litestore.product'
        ];
    }
});



