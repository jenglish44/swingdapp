$(document).ready(function(){
	//var logged_in=0;
	var showpage=0;
	var url = window.location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	switch(filename)
	{
		case 'index.html':
			addSidebarContent();
			$('.page-content').show();
			$('.page-sidebar').show();
			$('#preloader').hide();
			break;
		case 'register.html':
			addRegisterBar();
			$('.page-content').show();
			$('.page-sidebar').show();
			$('#preloader').hide();
			break;
		case 'help.html':
		case 'resetpass.html':
			addResetBar();
			$('.page-content').show();
			$('.page-sidebar').show();
			$('#preloader').hide();
			break;
		case 'cageform.html':
			addSidebarContent();
			if(!checkLogin())
			{	window.location='index.html';
				return false;
			}
			else
			{
				var u=JSON.parse(window.localStorage.getItem("user"));
				if(typeof(u.user_group)=='undefined' || u.user_group=='Rookie')
					window.location='subscribe.html';
				else
				{
					$('.page-content').show();
					$('.page-sidebar').show();
					$('#preloader').hide();
				}
			}
			break;
		case 'game_pitch.html':
			if(!checkLogin())
				window.location='index.html';
			else
			{
					addSidebarContent();
					var g=window.localStorage.getItem("gamesrl");
					$('.batting_order').attr('href',$('.batting_order').attr('href')+'?g='+g);
					if(typeof(preload)=='function')
					{
						preload();
					}
					$('.page-content').show();
					$('.page-sidebar').show();
					$('#preloader').hide();
			}
			break;
		default:
			if(!checkLogin())
				window.location='index.html';
			else
			{
					addSidebarContent();
					if(typeof(preload)=='function')
					{
						preload();
					}
					$('.page-content').show();
					$('.page-sidebar').show();
					$('#preloader').hide();
			}
			break;
	}
	filename=filename.replace('.html','');
	$('a.'+filename).removeClass('menu-disabled').addClass('menu-enabled');
$('.show-sidebar').click(function(){
		$('.page-content').animate({
			left:'270px'
			
		}, 500, 'easeInOutExpo', function(){
			$('.page-content').css('position', 'fixed');
		});
	
		$('.show-sidebar').hide();
		$('.hide-sidebar').show();
		return false
	});
	
	$('.hide-sidebar').click(function(){
		$('.page-content').css('position', 'absolute');
		$('.page-content').animate({
			left:'0px'
		}, 500, 'easeInOutExpo');
		$('.show-sidebar').show();
		$('.hide-sidebar').hide();
		return false
	});
	
	$('.hide2-sidebar').click(function(){
		$('.page-content').css('position', 'absolute');
		$('.page-content').animate({
			left:'0px'
		}, 500, 'easeInOutExpo');
		$('.show-sidebar').show();
		$('.hide-sidebar').hide();
		return false
	});
	
	$('.page-content').click(function(){
		$('.page-content').css('position', 'absolute');
		$('.page-content').animate({
			left:'0px'
		}, 500, 'easeInOutExpo');
		$('.show-sidebar').show();
		$('.hide-sidebar').hide();
	});

	////////////////////
	//Submenu Deployer//
	////////////////////		
	$('.deploy-submenu').click(function(){
		$(this).parent().find('.submenu').toggle(500, 'easeInOutExpo');
		return false;
	});	
		
	$('.dropdown-hidden').hide();
	$('.dropdown-item').hide();

	$('.dropdown-deploy').click(function(){
		$(this).parent().parent().find('.dropdown-item').show(200);
		$(this).parent().parent().find('.dropdown-hidden').show();
		$(this).hide();
		return false;
	});
	
	$('.dropdown-hidden').click(function(){
		$(this).parent().parent().find('.dropdown-item').hide(200);
		$(this).parent().parent().find('.dropdown-deploy').show();
		$(this).parent().parent().find(this).hide();
		return false;		
	});
	
			$('.sliding-door-top').click(function(){
				$(this).animate({
					left:'101%'
				}, 500, 'easeInOutExpo');
				return false;
			});
			
			$('.sliding-door-bottom a em').click(function(){
				$(this).parent().parent().parent().find('.sliding-door-top').animate({
					left:'0px'
				}, 500, 'easeOutBounce');
				return false
			});
			$('.sliding-door-bottom a').click(function(){
				if($(this).attr('href')=='#')
				{
					//preventDefault
					return false
				}
			});

	$('.show-sidebar').click(function(){
		$('.page-content').animate({
			left:'270px'
			
		}, 500, 'easeInOutExpo', function(){
			$('.page-content').css('position', 'fixed');
			$('.page-sidebar').css('position', 'fixed');
			$('.header').css('left', '');
		});
	
		$('.show-sidebar').hide();
		$('.hide-sidebar').show();
		return false
	});
	
	$('.hide-sidebar').click(function(){
		$('.page-content').css('position', 'absolute');
		$('.page-sidebar').css('position', 'absolute');
		$('.header').css('left', '0');
		
		$('.page-content').animate({
			left:'0px'
		}, 500, 'easeInOutExpo');
		$('.show-sidebar').show();
		$('.hide-sidebar').hide();
		return false
	});
	
	$('.hide2-sidebar').click(function(){
		$('.page-content').css('position', 'absolute');
		$('.page-sidebar').css('position', 'absolute');
		$('.header').css('left', '0');
		$('.page-content').animate({
			left:'0px'
		}, 500, 'easeInOutExpo');
		$('.show-sidebar').show();
		$('.hide-sidebar').hide();
		return false
	});
	
	$('.page-content').click(function(){
		$('.page-content').css('position', 'absolute');
		$('.page-sidebar').css('position', 'absolute');
		$('.header').css('left', '0');
		$('.page-content').animate({
			left:'0px'
		}, 500, 'easeInOutExpo');
		$('.show-sidebar').show();
		$('.hide-sidebar').hide();
	});
	$('.logout_link').click(function(){
		window.localStorage.removeItem("user");
		window.location='index.html';
	});
 });

function checkLogin()
{
	var u=JSON.parse(window.localStorage.getItem("user"));
	if(u==null)
		return false;
	if(u.remember=='1')
	{
		return true;
	}
	else
	{
		var d = new Date();
		var n = d.getTime();
		
		if(typeof(u.id)=='undefined' || n>=u.expiretime)
		{
			window.localStorage.removeItem("user");
			return false;
		}
		else
		{
			u.expiretime=eval(n)+eval(21600000);
			window.localStorage.setItem("user",JSON.stringify(u));
			return true;
		}
	}
	
}
function addSidebarContent()
{
	var str='<div class="page-sidebar-scroll">';
  	//str+='<a href="javascript:void(0);" class="sidebar-button hide2-sidebar"><em class="sidebar-button-close"></em></a>';
	str+='<img class="sidebar-logo replace-2x" src="images/menu_logo.png" alt="img">';
    str+='<div class="menu">';
    str+='<div class="menu-item">';
    str+='<strong class="home-icon"></strong>';
    str+='<a class="menu-disabled index" href="index.html">Home</a>';
    str+='</div>';
    str+='<div class="menu-item">';
    str+='<strong class="home-icon"></strong>';
    str+='<a class="menu-disabled cageform" href="cageform.html">Batting Practice</a>';
    str+='</div>';
    str+='<div class="menu-item">';
    str+='<strong class="home-icon"></strong>';
    str+='<a class="menu-disabled game_play" href="game_play.html">Start Game</a>';
    str+='</div>';
    str+='<div class="menu-item">';
    str+='<strong class="home-icon"></strong>';
    str+='<a class="menu-disabled batting_order" href="batting_order.html">Batting Lineup</a>';
    str+='</div>';
    /*str+='<div class="menu-item">';
    str+='<strong class="home-icon"></strong>';
    str+='<a class="menu-disabled dataupload" href="dataupload.html">Upload</a>';
    str+='</div>';*/
    str+='<div class="menu-item">';
    str+='<strong class="home-icon"></strong>';
    str+='<a class="menu-disabled dataupload" href="#" id="update_link">Refresh Roster</a>';
    str+='</div>';
    str+='<div class="menu-item">';
    str+='<strong class="icon-shadow-game"></strong>';
    str+='<a class="menu-disabled resetpass checkout subscribe deploy-submenu" href="#">User</a>';
    str+='<div class="clear"></div>';
    //str+='<div class="submenu">';
   // str+='<a class="menu-disabled" href="userprofile.html">Update Profile</a><em class="submenu-decoration"></em>';
    //str+='</div>';
    str+='<div class="submenu">';
    str+='<a class="menu-disabled" href="resetpass.html?t=userreset">Reset Passsword</a>        <em class="submenu-decoration"></em>';
    str+='</div>';
    str+='<div class="submenu">';
    str+='<a class="menu-disabled logout_link" href="javascript:void(0);" >Log Out</a>        <em class="submenu-decoration"></em>';
    str+='</div>';
    str+='</div> ';
    str+='<div class="menu-item">';
    str+='<strong class="contact-icon"></strong>';
    str+='<a class="menu-disabled" href="mailto:service@swingd.com?subject=SwingD Inquiry">Email</a>';
    str+='</div>';
    str+='<div class="menu-item">';
    str+='<strong class="admin-icon"></strong>';
    str+='<a class="menu-disabled external" href="https://www.swingd.com/swingadmin/">Reports</a>';
    str+='</div>';
    str+='<div class="menu-item">';
    str+='<strong class="help-icon"></strong>';
    str+='<a class="menu-disabled help" href="help.html">Help</a>';
    str+='</div>';
    str+='</div>';
  	str+='<a href="https://www.facebook.com/swingdapp" class="external sidebar-button2"><em class="sidebar-button-facebook">FACEBOOK</em></a>';
    str+='<p class="sidebar-copyright center-text">Copyright 2016. All rights reserved!</p>';
    str+='<div class="clear"></div>';
	str+='</div>';
	$('.page-sidebar').html(str);
 }

function addRegisterBar()
{
	var str='<div class="page-sidebar-scroll">';
	//str+='<a href="javascript:void(0);" class="sidebar-button hide2-sidebar"><em class="sidebar-button-close"></em></a>';
	str+='<img class="sidebar-logo replace-2x" src="images/menu_logo.png" alt="img">';
    str+='<div class="menu">';
    str+='<div class="menu-item">';
    str+='<strong class="home-icon"></strong>';
    str+='<a class="menu-disabled index" href="index.html">Home</a>';
    str+='</div>';
    str+='<div class="menu-item">';
    str+='<strong class="contact-icon"></strong>';
    str+='<a class="menu-disabled" href="mailto:service@swingd.com?subject=SwingD Inquiry">Email</a>';
    str+='</div>';
    str+='</div>';
  	str+='<a href="https://www.facebook.com/swingd" class="external sidebar-button2"><em class="sidebar-button-facebook">FACEBOOK</em></a>';
    str+='<p class="sidebar-copyright center-text">Copyright 2016. All rights reserved!</p>';
    str+='<div class="clear"></div>';
  	str+='</div>';
	$('.page-sidebar').html(str);
}
  
function addResetBar()
{
	var str='<div class="page-sidebar-scroll">';
  	//str+='<a href="javascript:void(0);" class="sidebar-button hide2-sidebar"><em class="sidebar-button-close"></em></a>';
	str+='<img class="sidebar-logo replace-2x" src="images/menu_logo.png" alt="img">';
    str+='<div class="menu">';
    str+='<div class="menu-item">';
    str+='<strong class="home-icon"></strong>';
    str+='<a class="menu-disabled index" href="index.html">Home</a>';
    str+='</div>';
    str+='<div class="menu-item">';
    str+='<strong class="icon-shadow-game"></strong>';
    str+='<a class="menu-disabled resetpass deploy-submenu" href="#">User</a>';
    str+='<div class="clear"></div>';
    str+='<div class="submenu">';
    str+='<a class="menu-disabled" href="resetpass.html?t=userreset">Reset Passsword</a>        <em class="submenu-decoration"></em>';
    str+='</div>';
    str+='</div>';
    str+='<div class="menu-item">';
    str+='<strong class="contact-icon"></strong>';
    str+='<a class="menu-disabled" href="mailto:service@swingd.com?subject=SwingD Inquiry">Email</a>';
    str+='</div> ';
    str+='</div>';
  	str+='<a href="https://www.facebook.com/swingd" class="external sidebar-button2"><em class="sidebar-button-facebook">FACEBOOK</em></a>';
    str+='<p class="sidebar-copyright center-text">Copyright 2016. All rights reserved!</p>';
    str+='<div class="clear"></div>';
  	str+='</div>';
	$('.page-sidebar').html(str);
}