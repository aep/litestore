restoreInit= function ()
{
    var em=document.getElementsByClassName('quickbuy');

    for(var i = 0;i < em.length;i++)
    {
        var id=em[i].readAttribute('id');
        id=id.replace('quickbuy_','');
        restoreQuickBuy(id,false);
    }


    var slp=document.getElementsByClassName('slideshowThumbnail');

    for(var i = 0;i < slp.length;i++)
    {
        var hr=slp[i].readAttribute('href');
        slp[i].writeAttribute('href','javascript:restoreSlideShow( \''+hr+'\')');
    }
}


restoreSlideShow = function (img)
{
    var a=$('slideshowImg').writeAttribute('src',img);
}


restoreQuickBuy= function ( em ,actuallybuy )
{

    var a=$('quickbuy_'+em);

    a.addClassName('quickbuy_loading');
    $('box_shopping_cart').addClassName('shopping_cart_loading');
    $('box_shopping_cart').update(" ( Loading... ) ");


    a.removeAttribute('href');


    var uri='/ajax/cart/'
    if(actuallybuy)
        uri+='?action=buy_now&BUYproducts_id='+em;

    new Ajax.Request(uri, 
    {
        method: 'post',
        onSuccess: function(transport) 
        {
            a.writeAttribute('href','javascript:restoreQuickBuy(\''+em+'\',true)');
            a.removeClassName('quickbuy_loading');
            $('box_shopping_cart').removeClassName('shopping_cart_loading');
            $('box_shopping_cart').replace(transport.responseText);
        }
    });
}
