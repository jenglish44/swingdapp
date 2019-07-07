/* 
	author: istockphp.com
*/
//jQuery(function($) {
function readypopup()
{
	$("a.topopup").click(function() {
			loading(); // loading
			setTimeout(function(){ // then show popup, deley in .5 second
				loadPopup(); // function show popup 
			}, 500); // .5 second
	return false;
	});
	
	/* event for close the popup */
	$("div.close").hover(
					function() {
						$('span.ecs_tooltip').show();
					},
					function () {
    					$('span.ecs_tooltip').hide();
  					}
				);
	
	$("div.close").click(function() {
		disablePopup();  // function close pop up
	});
	
	$(this).keyup(function(event) {
		if (event.which == 27) { // 27 is 'Ecs' in the keyboard
			disablePopup();  // function close pop up
		}  	
	});
	
	$("div#backgroundPopup").click(function() {
		disablePopup();  // function close pop up
	});
	
	$('a.livebox').click(function() {
	return false;
	});
	
}
	 /************** start: functions. **************/
	var popupStatus = 0; // set value
	function loading() {
		$("div.loader").show();  
	}
	function closeloading() {
		$("div.loader").fadeOut('normal');  
	}
	
	
	function loadPopup() { 
		if(popupStatus == 0) { // if value is 0, show popup
			closeloading(); // fadeout loading
			$("#toPopup").fadeIn(0500); // fadein popup div
			$("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
			$("#backgroundPopup").fadeIn(0001); 
			popupStatus = 1; // and set value to 1
		}	
	}
		
	function disablePopup() {
		if(popupStatus == 1) { // if value is 1, close popup
			$("#toPopup").fadeOut("normal");  
			$("#backgroundPopup").fadeOut("normal");  
			popupStatus = 0;  // and set value to 0
		}
	}
	/************** end: functions. **************/
//}); // jQuery End
//swingd popup
function confirmout()
{
	$('#popup_content').html('Another out for this team. Press Yes to confirm.<div><input type="hidden" name="confirm_type" id="confirm_type" value="confirmout" /><input type="button" name="confirm_btn" id="confirm_btn1" value="No" class="grey_btn confirm_btn"/><input type="button" name="confirm_btn" id="confirm_btn2" value="Yes" class="red_btn confirm_btn"/></div>');
	loadPopup();
	initbtn();
}
function confirmover()
{
	$('#popup_content').html('Game Ended. Press Yes to confirm.<div><input type="hidden" name="confirm_type" id="confirm_type" value="confirmover" /><input type="button" name="confirm_btn" id="confirm_btn1" value="No" class="grey_btn confirm_btn"/><input type="button" name="confirm_btn" id="confirm_btn2" value="Yes" class="red_btn confirm_btn"/></div>');
	loadPopup();	
	initbtn();
}
function confirmgoback()
{
	$('#popup_content').html('Do you want to go back? Press Yes to confirm.<div><input type="hidden" name="confirm_type" id="confirm_type" value="confirmgoback" /><input type="button" name="confirm_btn" id="confirm_btn1" value="No" class="grey_btn confirm_btn"/><input type="button" name="confirm_btn" id="confirm_btn2" value="Yes" class="red_btn confirm_btn"/></div>');
	loadPopup();	
	initbtn();
}
function confirmundo()
{
	$('#popup_content').html('Do you want to permanently undo the following action? <br /><b> '+showoutcome()+'.</b> Yes to confirm.<div><input type="hidden" name="confirm_type" id="confirm_type" value="confirmundo" /><input type="button" name="confirm_btn" id="confirm_btn1" value="No" class="grey_btn confirm_btn"/><input type="button" name="confirm_btn" id="confirm_btn2" value="Yes" class="red_btn confirm_btn"/></div>');
	loadPopup();	
	initbtn();
}
function confirmchangebo()
{
	$('#popup_content').html('Do you want to replace current batter with the selected batter? Yes to confirm.<div><input type="hidden" name="confirm_type" id="confirm_type" value="confirmchangebo" /><input type="button" name="confirm_btn" id="confirm_btn1" value="No" class="grey_btn confirm_btn"/><input type="button" name="confirm_btn" id="confirm_btn2" value="Yes" class="red_btn confirm_btn"/></div>');
	loadPopup();	
	initbtn();
}
function confirmclear()
{
	$('#popup_content').html('Do you want to delete all game data stored on your phone and return to opening page?  This cannot be undone.<div><input type="hidden" name="confirm_type" id="confirm_type" value="confirmclear" /><input type="button" name="confirm_btn" id="confirm_btn1" value="No" class="grey_btn confirm_btn"/><input type="button" name="confirm_btn" id="confirm_btn2" value="Yes" class="red_btn confirm_btn"/></div>');
	loadPopup();	
	initbtn();
}