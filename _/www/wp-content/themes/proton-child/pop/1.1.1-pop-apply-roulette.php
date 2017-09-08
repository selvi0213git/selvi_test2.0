<!-- ========== pop roulette =========== -->
<section class="pop-univ pop-alert pop-roulette">
	<div class="inner">
		<div class="pop-content">
			<div class="content">
				<div class="roulette-game">
					<div class="pane">
						<img src="/wp-content/themes/proton-child/assets/images/roulette-pane.png" alt="" class="flex-img">
					</div>
					<div class="wheel">
						<canvas id="canvas" width="434" height="434">
              <p style="{color: white}" align="center">지금 사용하고 계신 브라우저는 게임 진행이 불가능합니다. 다른 브라우저로 접속하시기 바랍니다.</p>
            </canvas>
					</div><!-- /.roulette -->
					<div class="roulette-controls">
						<input type="button" value="START" id="spin_button" class="btn-start blink" onClick="startSpin();">
					</div><!-- /.roulette-controls -->
				</div><!-- /.roulette-game -->
			</div>
		</div>
	</div><!-- /.inner -->
</section>

<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>

<script>
    // Create new wheel object specifying the parameters at creation time.
    var theWheel = new Winwheel({
        'numSegments'  : 6,     // Specify number of segments.
        'outerRadius'  : 212,   // Set outer radius so wheel fits inside the background.
        'textFontFamily': 'Noto Sans Korean Bold',
        'textFontSize' : 38,    // Set font size as desired.
        'segments'     :        // Define segments including colour and text.
        [
           {'fillStyle' : '#b17ffd', 'text' : '꽝!'},
           {'fillStyle' : '#7de3f3', 'text' : '당첨!'},
           {'fillStyle' : '#fc9252', 'text' : '꽝!'},
           {'fillStyle' : '#b17ffd', 'text' : '당첨!'},
           {'fillStyle' : '#7de3f3', 'text' : '꽝!'},
           {'fillStyle' : '#fc9252', 'text' : '당첨!'},
        ],
        'animation' :           // Specify the animation to use.
        {
            'type'     : 'spinToStop',
            'duration' : 5,     // Duration in seconds.
            'spins'    : 8,     // Number of complete spins.
            'callbackFinished' : 'alertPrize()'
        }
    });
    
    // Vars used by the code in this page to do power controls.
    var wheelPower    = 0;
    var wheelSpinning = false;
    
    // -------------------------------------------------------
    // Click handler for spin button.
    // -------------------------------------------------------
    function startSpin()
    {
        // Ensure that spinning can't be clicked again while already running.
        if (wheelSpinning == false)
        {
            // Based on the power level selected adjust the number of spins for the wheel, the more times is has
            // to rotate with the duration of the animation the quicker the wheel spins.
            if (wheelPower == 1)
            {
                theWheel.animation.spins = 3;
            }
            else if (wheelPower == 2)
            {
                theWheel.animation.spins = 8;
            }
            else if (wheelPower == 3)
            {
                theWheel.animation.spins = 15;
            }
            
            // Disable the spin button so can't click again while wheel is spinning.
            document.getElementById('spin_button').value = "진행중";
            document.getElementById('spin_button').className = "btn-start";

            //Get prize value
            getPrizeValue();
        }
    }

    function getPrizeValue() {
        /*$.ajax( "calculate_prize.php" )
          .done(function($data) {
            if($data) {
                toStart($data);
            }
          })
          .fail(function() {
            return;
          });*/
        var thisPrize = <?php echo $_GET["prize"] ?>;
        if(thisPrize) {
            var seg_num = get_segment_number(thisPrize);
            toStart(seg_num);
        } else {
            return;
        }
    }

    /**
     * get_segment_number function
     * @param  $prize lose=1, win=2
     * @return segment number
     */
    function get_segment_number($prize) {
        // $random_id = rand(1, 3);
        var $random_id = Math.floor((Math.random() * 3) + 1);
        var $seg_num;

      switch ($prize) {
        case 1 :
            $seg_num = ($random_id * 2) - 1; 
          break;
        case 2 :
            $seg_num = $random_id * 2; 
          break;
      }//switch
      
      return $seg_num;
    }

    function toStart($num) {
        var segmentNumber = $num;
        // Get random angle inside specified segment of the wheel.
        var stopAt = theWheel.getRandomForSegment(segmentNumber);

        // Important thing is to set the stopAngle of the animation before stating the spin.
        theWheel.animation.stopAngle = stopAt;

        // Start the spin animation here.
        theWheel.startAnimation();
        wheelSpinning = true;
    }

    // -------------------------------------------------------
    // Function for reset button.
    // -------------------------------------------------------
    function resetWheel()
    {
        theWheel.stopAnimation(false);  // Stop the animation, false as param so does not call callback function.
        theWheel.rotationAngle = 0;     // Re-set the wheel angle to 0 degrees.
        theWheel.draw();                // Call draw to render changes to the wheel.
        wheelSpinning = false;          // Reset to false to power buttons and spin can be clicked again.
    }
    
    // -------------------------------------------------------
    // Called when the spin animation has finished by the callback feature of the wheel because I specified callback in the parameters.
    // -------------------------------------------------------
    function alertPrize()
    {
        // Get the segment indicated by the pointer on the wheel background which is at 0 degrees.
        var winningSegment = theWheel.getIndicatedSegment();
        
        // Do basic alert of the segment text. You would probably want to do something more interesting with this information.
        // alert("You have won " + winningSegment.text);
        var result = winningSegment.text;

        document.getElementById('spin_button').value = result;
        
        if(result == "당첨!") {
        	setTimeout(openApplyWin, 800);
        } else {
        	setTimeout(openApplyLose, 800);
        }
    }
</script>