$(document).ready(function(){
	$('a.external').each(function(){
		$(this).attr('ref',$(this).attr('href'));
		$(this).attr('href','#');
								 });
	$('a.external').click(function(){
		var ref = window.open($(this).attr('ref'), '_system', 'location=yes');
								  });
	$('#update_link').click(function(){
		forceUpdate();
	});
						   });
var cache_day=1;
function sortPlayer(pl)
{
	var bo_arr=res=new Array();
	var l=pl.length;
	for(var i=0;i<l;i++)
	{
		bo_arr[i]=pl[i].bo;
	}
	for(i=0;i<l-1;i++)
	{
		for(var j=i+1;j<l;j++)
		{
			//if(pl[j].bo==bo_arr[i])
			if(pl[i].bo!=null && parseInt(pl[i].bo)>parseInt(pl[j].bo))
			{	
				var tmp=pl[i];
				pl[i]=pl[j];
				pl[j]=tmp;
				//res[i]=pl[j];
				//pl[j].bo='';
			}
		}	
	}
	return pl;
}
function getplayername(p)
{
	var n='';
	if(p===undefined)
		return n;
	var pl=getPlayer();
	for(var i=0;i<pl.length;i++)
	{
		if(pl[i].id==p)
		{
			n=pl[i].name;
			break;
		}
	}
	if(n=="")
		n=p;
	return n;
}

function gotopage(p)
{
	window.location=p;
}
function getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null
}
function shorten(text) {
	if(text=='' || typeof(text)=='undefined')
		return false;
   var maxLength=parseInt(($(window).width()*(6/10))/14);
 //  alert(maxLength);
    var ret = text;
    if (ret.length > maxLength) {
        ret = ret.substr(0,maxLength-3) + "...";
    }
    return ret;
}
function numProps(obj) {
  var c = 0;
  for (var key in obj) {
    if (obj.hasOwnProperty(key)) ++c;
  }
  return c;
}
function getPlayer()
{
	var player=window.localStorage.getItem("player");
	var playerdate=window.localStorage.getItem("playerdate");
	return JSON.parse(player);
}
function getSessionKey()
{
	var str=Math.random().toString(36).slice(2);
	str=str.substring(0,8);
	return str;
}
function dateDiff( date1, date2 ) {
	  //Get 1 day in milliseconds
	  var one_day=1000*60*60*24;
	
		date1=new Date(date1);
		date2=new Date(date2);
	  // Convert both dates to milliseconds
	  var date1_ms = date1.getTime();
	  var date2_ms = date2.getTime();
	
	  // Calculate the difference in milliseconds
	  var difference_ms = date2_ms - date1_ms;
		
	  // Convert back to days and return
	  return Math.round(difference_ms/one_day); 
}
function forceUpdate()
{
	var p=forceUpdatePlayer();
	var t=forceUpdateTeam();
	$('#preloader').hide();
}
function forceUpdatePlayer()
{
		//alert('triggered action');
	$('#preloader').html('Loading Players...').show();
	var u=JSON.parse(window.localStorage.getItem("user"));
	$.ajax({
	  url: "https://www.swingd.com/action/getplayer.php",
	  //url: "action/getplayer.php",
	  data: "u="+u.id,
	  dataType: 'json',
	  async: true,
	 // data: myData,
	  success: function(c) {
		//alert(c);
		window.localStorage.setItem("player",JSON.stringify(c));
		window.localStorage.setItem("playerdate",new Date());
		//var w=window.localStorage.getItem("winery");
		//alert(w);
		$('#preloader').hide();
		return true;
	  }
	});
		return true;
}
function forceUpdateTeam()
{
	$('#preloader').html('Loading Team...').show();
	var u=JSON.parse(window.localStorage.getItem("user"));
	$.ajax({
	  url: "https://www.swingd.com/action/getteam.php",
	 // url: "action/getteam.php",
	  dataType: 'json',
	  async: true,
	  data: "u="+u.id,
	  success: function(c) {
		//alert(c);
		window.localStorage.setItem("team",JSON.stringify(c));
		window.localStorage.setItem("teamdate",new Date());
		//var w=window.localStorage.getItem("winery");
		//alert(w);
		$('#preloader').hide();
		return true;
	  }
	});
		return true;
}