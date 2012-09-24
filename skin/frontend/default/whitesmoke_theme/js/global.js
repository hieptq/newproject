function switchImage(cnt){
                document.getElementById('video-'+cnt).style.display="none";
                document.getElementById('image-'+cnt).style.display="block";
                document.getElementById('switchVideo-'+cnt).style.display="block";
                document.getElementById('switchImage-'+cnt).style.display="none";
                document.getElementById('featured-'+cnt).style.display="block";
                document.getElementById('featured-'+cnt).style.width="440px";
                document.getElementById('featured-'+cnt).style.height="276px";
            }
function switchVideo(cnt){
                document.getElementById('featured-'+cnt).style.display="none";
                document.getElementById('video-'+cnt).style.display="block";
                document.getElementById('switchVideo-'+cnt).style.display="none";
                document.getElementById('switchImage-'+cnt).style.display="block";
            }


function toggleSubscribe(){
//    alert ("hai");

    document.getElementById('toggle-subscribe').style.display="block";
    document.getElementById('subscribe-info').style.display="none";
    
}

function closeButton(){
    document.getElementById('menu_middlebg').style.display="none";
}

function toggleCity(){
    Effect.toggle('toggle_blind', 'blind',{duration: 0.1});
    Effect.toggle('currentCity', 'blind', 'borderBottomWidth', {Width: thick});
}

jQuery.noConflict();
jQuery(document).ready(function(){
jQuery("#currentCity").mouseover(function()
{

    jQuery("#currentCity").css("border-bottom","none");
    jQuery("#toggle_blind").show("400");

});
jQuery("body").click(function()
{
    jQuery("#toggle_blind").hide("400");
    jQuery("#currentCity").css("border-bottom","1px solid #CDD6F8");

});
});