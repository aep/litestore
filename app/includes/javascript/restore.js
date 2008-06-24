restoreInit= function ()
{
    var em=document.getElementsByClassName('quickbuy');

    for(var i = 0;i < em.length;i++)
    {

        var id=em[i].readAttribute('id');
        id=id.replace('quickbuy_','');
        em[i].writeAttribute('href','javascript:restoreQuickBuy(\''+id+'\')');

        restoreQuickBuy(id);
    }
}


restoreQuickBuy= function ( em )
{

    var a=$('quickbuy_'+em);

    a.addClassName('quickbuy_loading');
    $('box_shopping_cart').addClassName('shopping_cart_loading');
    $('box_shopping_cart').update(" ( Loading... ) ");


    a.removeAttribute('href');

    new Ajax.Request('/ajax/cart/?action=buy_now&BUYproducts_id='+em, 
    {
        method: 'post',
        onSuccess: function(transport) 
        {
            a.writeAttribute('href','javascript:restoreQuickBuy(\''+em+'\')');
            a.removeClassName('quickbuy_loading');
            $('box_shopping_cart').removeClassName('shopping_cart_loading');

            $('box_shopping_cart').replace(transport.responseText);
        }
    });







}
