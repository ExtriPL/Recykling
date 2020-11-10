let items = {};

function addItem()
{
    let wasteName = $("#wastecategory").children("option:selected").val();
    let wasteQuantity = parseInt($("#wastequantity").val());
    addToBasket(wasteName,wasteQuantity);
    $("#data").val(JSON.stringify(items));
    console.log(items);
}

function addToBasket(itemName,itemQuantity)
{
    if($("#"+itemName).length)
    {
        updateItem(itemName,itemQuantity);
    }
    else
    {
        let item = "<div id='"+itemName+"'>"+itemName+" <span id='"+itemName+"Quantity'>"+itemQuantity+"</span></div>";
        $("#basket").append(item);
        items[itemName] = itemQuantity;
    }
}

function updateItem(itemName,addQuantity)
{
    items[itemName] += addQuantity;
    $("#"+itemName+"Quantity").text(items[itemName]);
}

function removeFromBasket(itemName)
{
    $("#"+itemName).remove();
}