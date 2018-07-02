function addToCart() {
    
    console.log("ok");
    jQuery.ajax({
        type: "POST",
        url: 'common.php',
        data: {fctName: "addToCart", id: 1},
    });

}