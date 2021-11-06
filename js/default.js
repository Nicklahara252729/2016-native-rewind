$(function(){
    $(window).scroll(function(){
        if($(window).scrollTop()>250){
            $('.top').css({
                height:'40px',
            });
            $('.header-tengah').css({
                position:'fixed',
                top:'0',
                height:'50px',
                color:'white',
                background:'#004fa7',
            });
            $('.header-tengah input').css({
                border:'0',
            });
            $('.header-tengah select').css({
                border:'0',
            });
        }else{
            $('.top').css({
                height:'0px',
            });
            $('.header-tengah').css({
                position:'relative',
                background:'white',
                color:'black'
            });
            $('.header-tengah input').css({
                border:'solid 1px lightgray',
            });
            $('.header-tengah select').css({
                border:'solid 1px lightgray',
            });
        }
    });
    $('.top').click(function(){
        $('body,html').animate({
           scrollTop:0, 
        },1000);
    });
});

$(function(){
    $('.btn-login').click(function(){
        $('.login').css({
            display:'block',
        });
    });
    $('.btn-regis').click(function(){
        $('.register').css({
            display:'block',
        });
    });
});
