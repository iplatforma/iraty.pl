$(document).ready(function(){
    $('#menu ul li a, #rwdmenu ul li a').each(function(index) {
        if(this.href.trim() == window.location)
            $(this).addClass("active");
    });
});
