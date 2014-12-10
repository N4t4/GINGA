function DataView(title, data)
{
    this.title = title;
    this.data  = data;
}
function Pos(x, y)
{
    this.x = x;
    this.y = y;
}
function Size(width, height)
{
    this.height = height;
    this.width  = width;
}

function getLeft(item) {
    return $(item).offset().left - $(window).scrollLeft();
}
function getTop(item){
    return $(item).offset().top - $(window).scrollTop();
}
function getPosition(item){
    return new Pos($(item).offset().left, $(item).offset().top);
}
function getHalfHeight(qry) {
  return ($(window).height() / 2 - $(qry).height() / 2);
}
function getHalfWidth(qry) {
  return ($(window).width() / 2 - $(qry).width() / 2);
}
function getHalfWidthParent(qry) {
  return ($(qry).parent().width() / 2 - $(qry).width() / 2);
}
function getValorPx(valor){
    var v = parseInt(valor.substr(0, valor.length-1));
    return v;
}
function getRealHeight(item){
    var retorno = 0;
    
    var size_margin_top;
    if($(item).css("margin-top"))
        size_margin_top = getValorPx($(item).css("margin-top").toString());
        
    var size_margin_bottom;
    if($(item).css("margin-bottom"))
        size_margin_bottom = getValorPx($(item).css("margin-bottom").toString()); 
        
    var size_border_top;
    if($(item).css("border-top-width"))
        size_border_top = getValorPx($(item).css("border-top-width").toString()); 
        
    var size_border_bottom; 
    if($(item).css("border-bottom-width"))
        size_border_bottom = getValorPx($(item).css("border-bottom-width").toString()); 
    
    var size_padding_top;
    if($(item).css("padding-top"))
        size_padding_top = getValorPx($(item).css("padding-top").toString()); 
    
    var size_padding_bottom;
        if($(item).css("padding-bottom"))
            size_padding_bottom = getValorPx($(item).css("padding-bottom").toString());; 
            
    var size_height     = $(item).height();
    
    if(size_margin_top)
        retorno += size_margin_top;    
    if(size_margin_bottom)
        retorno += size_margin_bottom; 
    if(size_border_top)
        retorno += size_border_top;    
    if(size_border_bottom)
        retorno += size_border_bottom;
    if(size_padding_top)
        retorno += size_padding_top;    
    if(size_padding_bottom)
        retorno += size_padding_bottom;
    if(size_height)
        retorno += size_height;     
    
    return retorno;
}
function getRealWidth(item){

    var retorno = 0;
    
    var size_margin_left   = getValorPx($(item).css("margin-left").toString()); 
    var size_margin_right  = getValorPx($(item).css("margin-right").toString()); 
    var size_border_left   = getValorPx($(item).css("border-left-width").toString()); 
    var size_border_right  = getValorPx($(item).css("border-right-width").toString()); 
    var size_padding_left  = getValorPx($(item).css("padding-left").toString()); 
    var size_padding_right = getValorPx($(item).css("padding-right").toString());; 
    var size_width         = $(item).width();
    
    if(size_margin_left && size_margin_left > 0)
        retorno += size_margin_left;    
    if(size_margin_right && size_margin_right > 0)
        retorno += size_margin_right; 
    if(size_border_left)
        retorno += size_border_left;    
    if(size_border_right)
        retorno += size_border_right;
    if(size_padding_left)
        retorno += size_padding_left;   
    if(size_padding_right)
        retorno += size_padding_right;
    if(size_width)
        retorno += size_width;      

    return retorno;
}
function getRealWidthTESTE(item){

    var retorno = 0;
    
    var size_margin_left   = getValorPx($(item).css("margin-left").toString()); 
    var size_margin_right  = getValorPx($(item).css("margin-right").toString()); 
    var size_border_left   = getValorPx($(item).css("border-left-width").toString()); 
    var size_border_right  = getValorPx($(item).css("border-right-width").toString()); 
    var size_padding_left  = getValorPx($(item).css("padding-left").toString()); 
    var size_padding_right = getValorPx($(item).css("padding-right").toString());; 
    var size_width         = $(item).width();
    
    if(size_margin_left)
        retorno += size_margin_left;    
    if(size_margin_right)
        retorno += size_margin_right; 
    if(size_border_left)
        retorno += size_border_left;    
    if(size_border_right)
        retorno += size_border_right;
    if(size_padding_left)
        retorno += size_padding_left;   
    if(size_padding_right)
        retorno += size_padding_right;
    if(size_width)
        retorno += size_width;      

    return retorno;
}
function GetCenter(item){
    var left;
    
    if($(item).width() > $(item).parent().width())
    {
        left = (($(item).width()/2) - ($(item).parent().width()/2));
        left*= left > 0 ? -1 : 1;
    }
    else
    {
        left = ($(item).parent().width()/2) - ($(item).width()/2);
        left*= left > 0 ? 1 : -1;
    }
    return left;
}
function GetCenterWH(item){
    var left;
    var top;

    if($(item).width() > $(item).parent().width())
    {
        left = (($(item).width()/2) - ($(item).parent().width()/2));
        left*= left > 0 ? -1 : 1;
    }
    else
    {
        left = ($(item).parent().width()/2) - ($(item).width()/2);
        left*= left > 0 ? 1 : -1;
    }

    if($(item).height() > $(item).parent().height())
    {
        top = (($(item).height()/2) - ($(item).parent().height()/2));
        top*= top > 0 ? -1 : 1;
    }
    else
    {
        top = ($(item).parent().height()/2) - ($(item).height()/2);
        top*= top > 0 ? 1 : -1;
    }

    return (new Pos(left ,top));
}
function GetCenterWindow(item){
    var left;
    var top;

    if($(item).width() > $(window).width())
    {
        left = (($(item).width()/2) - ($(window).width()/2));
        left*= left > 0 ? -1 : 1;
    }
    else
    {
        left = ($(window).width()/2) - ($(item).width()/2);
        left*= left > 0 ? 1 : -1;
    }

    if($(item).height() > $(window).height())
    {
        top = (($(item).height()/2) - ($(window).height()/2));
        top*= top > 0 ? -1 : 1;
    }
    else
    {
        top = ($(window).height()/2) - ($(item).height()/2);
        top*= top > 0 ? 1 : -1;
    }

    return (new Pos(left ,top));
}
function SetInCenterW(item){
    $(item).css("margin-left", GetCenterWH(item).x+"px");
}
function SetInCenterH(item){
    $(item).css("margin-top", GetCenterWH(item).y+"px");
}
function SetInCenter(item){
    $(item).css("margin-top", GetCenterWH(item).y+"px");   
    $(item).css("margin-left", GetCenterWH(item).x+"px");   
}
function GetTheCenter(){

}

function GetMaginpaddingH(item){
    return getRealHeight(item) - $(item).height();
}
function InCenter(item){
    
    var pos  = GetCenterWH(item);

    $(item).animate(
        {
            top: pos.y + "px",
            left: pos.x + "px"
        },
        200,
        function(){}
    );
}
function WillResizeH(item){
    var t_height = 0;

    $(item).children("*").each(function(){
        t_height += getRealHeight(this);
    });
    $(item).css("height", t_height);

    return;
}
function TesteGlobal(){
	alert("teste");
}
function GetDifH(item){
    var dif = 0;
    item = $(item);

    if(item.css("margin-top"))
        dif +=  getValorPx(item.css("margin-top"));
    
    if(item.css("border-top-width"))
        dif +=  getValorPx(item.css("border-top-width"));


    return dif;
}
function GetDifW(item){
    var dif = 0;
    item = $(item);

    if(item.css("margin-left"))
        dif +=  getValorPx(item.css("margin-left"));
    
    if(item.css("border-left-width"))
        dif +=  getValorPx(item.css("border-left-width"));


    return dif;
}

/****Block************************************/
function Block(_open){
    $("#block").css("display", "block");
    $("#block").css("opacity", 0);
    $("#block").animate(
        {opacity: 1},
        750,
        function(){ 

            $(_open).css("display", "block");
            $(_open).css("opacity", 0);

            $(_open).animate(
                {opacity: 1},
                500,
                function(){ 
                    $(this).css("display", "block");
                }
            );
        }
    );
    return;
} 
function UnBlock(_close){
    $(_close).animate(
        {opacity: 0},
        750,
        function(){ 
            $(this).css("display", "none"); 
            $(_close).children("section").children("article").html(""); 

            $("#block").animate(
                {opacity: 0},
                1500,
                function(){ 
                    $(this).css("display", "none");
                }
            );
        }
    );
    return;
}    
/*********************************************/
    

/****Talking**********************************/
function InitTalk() {
    

    var on_an = false;
    $("#talk").css("opacity", 0);
    $("#talk").css("display", "none");
    

    $(".talking").mousemove(function (e) {
        
        if (on_an) return;

        var talk = $("#talk");
        if (talk.css("display") == "none") {
            talk.css("display", "block");
            talk.animate(
                { opacity: 1 },
                200,
                null
            );
        }

        talk.html($(this).attr("alt"));
        talk.css("top", (e.pageY - 22 - talk.height()));
        talk.css("left", (e.pageX - 22 - talk.width()));
    });
    $(".main, .talking").mouseleave(function () {
        $("#talk").animate(
            { opacity: 0 },
            200,
            function () { $("#talk").css("display", "none"); }
     );
    });
    $("#talk").mouseenter(function (e) {
        if (on_an) return;
        on_an = true;

        var talk = $(this);
        talk.animate(
            {
                opacity: 0,
                top: (getValorPx(talk.css("top")) - 10),
                left: (getValorPx(talk.css("left")) - 10)
            },
            150,
            function () {
                talk.css("display", "none");
                on_an = false;
            }
    );

    });
}
/*********************************************/

/****Data-VIEW*******************************/
function OpenDataView(item, end_exec) {

    var obj_view = $("#fm_data_view");
    
    $("#block").css("display", "block");
    $("#block").css("opacity", 0);

    $("#fm_data_view>article").html(item.data);
    $("#fm_data_view>.header>h2").html(item.title);

    obj_view.css("display", "block");
    var the_top = getHalfHeight(obj_view);
    obj_view.css("opacity", 0);
    obj_view.css("top", getHalfHeight(obj_view) + "px");
    obj_view.css("left", getHalfWidth(obj_view) + "px");

    $("#block").animate(
        { opacity: 1 },
        250,
        function () {
            obj_view.animate(
                { opacity: 1 },
                500,
                null
            );
        }
    );

    $("#fm_data_view>.header>input, #block").click(function () {
        $("#fm_data_view").css("display", "none");
        $("#block").animate(
            { opacity: 0 },
            100,
            function () {
                $("#fm_data_view").css("display", "none");
                $("#fm_data_view>article").html("");
                $("#block").css("display", "none");
                if(end_exec)
                    end_exec();
          }
       );
    });
}
/********************************************/

/****Media - View*****************************/
function BildFmMediaView(){
    var ls;
    var fm_media_view_atual;
    
 //   FmMediaInit();
}

function FmMediaAt(at){

    fm_media_view_atual+=at;

    if(fm_media_view_atual < 0)
        fm_media_view_atual = ls.length - 1;
    if(fm_media_view_atual >= ls.length)
        fm_media_view_atual = 0;


    $("#fm_media_view>section>article").css("opacity", 0);
    $("#fm_media_view>section>article").html(ls.eq(fm_media_view_atual).html());
    $("#fm_media_view>section>article").animate({opacity: 1}, 500, null);
    return;
}
function FmMediaEvents(){
    $(".fm_media_view_open").unbind("click");
    $(".fm_media_view_open").click(function(){
        fm_media_view_atual = $(".fm_media_view_open").index(this);
        FmMediaAt(0);
        Block("#fm_media_view");
    });
    $("#fm_media_view>section>header>input").unbind("click");
    $("#fm_media_view>section>header>input").click(function(){
        UnBlock("#fm_media_view");
    });
    $("#fm_media_view .next").unbind("click");
    $("#fm_media_view .next").click(function(){  
        FmMediaAt(1);
    });
    $("#fm_media_view .prev").unbind("click");
    $("#fm_media_view .prev").click(function(){  
        FmMediaAt(-1);
    });
    return;
}
function FmMediaInit(owner){
    InCenter("#fm_media_view>section");
    ls = $(owner + " .to_fm_media");

    FmMediaEvents()
    return;
}
/*********************************************/


var MAX_MOBILE = 480;

$(document).ready(function () {
   
    $("body").append("<div id='block' style='display: none;'></div>");

    $("body").append("<div id='talk' style='display: none;'>nome</div>");
    setTimeout(function () { InitTalk(); }, 1000);

    $("body").append(
        "<div id='fm_data_view' style='display: none;'>"+
            "<div class='header'>"+
                "<h2>Title</h2>"+
                "<input type='button'/>"+
            "</div>"+
            "<article>"+
            "</article>"+
        "</div>"
    );

    $("body").append(
        "<div id='fm_media_view' style='display: none;'>"+
            "<section class='wspan10 hspan10'>"+
            "<header><input type='button'></header>"+
            "<article></article>"+
            "<footer><input type='button' class='next'/><input type='button' class='prev'/></footer>"+
            "</section>"+
        "</div>"
    );
    setTimeout(function () { BildFmMediaView(); }, 1000);


    /**In-Center*******************/
    if($(".in-center").length > 0){
        function InCenterInit(){
            
            var v = GetCenterWindow(".in-center");

            $(".in-center").animate(
                {
                    left: v.x + "px",
                    top:  v.y + "px"
                },
                500,
                null
            );
        }
        InCenterInit();
        $(window).bind('resize', function(e){
            window.resizeEvt;
            $(window).resize(function(){
                    clearTimeout(window.resizeEvt);
                    window.resizeEvt = setTimeout(function(){InCenterInit();}, 120);
            });
        });
    }
    /******************************/ 

});
