$('#toggle').click(function() {
    $('#qrcode').toggle();
});

function toggle_linenum(){
if(document.getElementsByTagName("ol")[0].style.listStyle.substr(0,4)=="none"){
	document.getElementsByTagName("ol")[0].style.listStyle="decimal";
	document.getElementsByTagName("ol")[0].style.paddingLeft="48px"
}else{
	document.getElementsByTagName("ol")[0].style.listStyle="none";
	document.getElementsByTagName("ol")[0].style.paddingLeft="5px"
}}