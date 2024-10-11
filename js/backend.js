$(function() {

	'use strict';
    
    //hide placeholder on focus
	$('[placeholder]').focus(function() {

		$(this).attr('data-text', $(this).attr('placeholder'));
		$(this).attr('placeholder', '');

	}).blur(function() {

        $(this).attr('placeholder', $(this).attr('data-text'));
	});
    



    

    // confirmation to delete
    $('.confirm').click(function () {

    	return confirm('are you sure ?');

    });

    




});






//secs       =  parseInt(document.getElementById('mytimer').innerHTML,10);
//document.getElementById('mytimer').innerHTML = "Hello" ;
//setTimeout("countdown('mytimer',"+secs+")", 1000);


function countdown(id, timer){
				timer++;
				hourRemain = Math.floor(timer / 3600)%24;
				minRemain  = Math.floor(timer / 60 )%60;
				secsRemain = new String(timer %60);
				// Pad the string with leading 0 if less than 2 chars long
				if (secsRemain.length < 2) {
					secsRemain = '0' + secsRemain;
				}

				// String format the remaining time
				clock      = hourRemain + ":" + minRemain + ":" + secsRemain;
				document.getElementById(id).innerHTML = clock;
				if ( timer > 0 ) {
					// Time still remains, call this function again in 1 sec
					setTimeout("countdown('" + id + "'," + timer + ")", 1000);
				} else {
					document.getElementById(id).style.display = 'none';

					//	  alert("One Playstation Time Has ended Please Bill the Customers");
					//	  window.location = "devices_ps.php?id=<? echo $deviceID;?>"
					//	document.write("<p>The text from the intro paragraph: " + x.innerHTML + "</p>");
					//document.getElementById("done_<? echo $deviceID;?>").innerHTML="Bill";
					// Time is out! Hide the countdown
				}
				
			}


