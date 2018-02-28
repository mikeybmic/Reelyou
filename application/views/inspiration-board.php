<div class="center-content">
    <div class="map-cont">
    
    <form name="inspiration" action="" method="post" enctype="multipart/form-data">
    
    <?php
	
		if(isset($error)){?>
        
		<div class="alert alert-danger">
			<span><?php echo $error;?></span>
        </div>	
		
	<?php }else{
	
    	foreach($quotes as $intKey=>$objQuote){?>
         		  <h5 class="mid-heading"><?php echo $objQuote->title?></h5>
                  
                  
                  
                  <img src="<?php echo $objQuote->background?>" alt="" title="">
                  
                  
                  <div class="quote-wrap">
				 	<p><?php echo '<span class="start">"</span>'.$objQuote->quote.'<span class="end">"</span>'?></p>
                  </div>
                  <input type="hidden" name="background" value="<?php echo $objQuote->background?>" />
                  <input type="hidden" name="quote" value="<?php echo $objQuote->quote?>" />
                  
                  <input type="submit" value="share on wall" class="blue-btn" name="share" />
                  
        <?php
		
		}
		 }?>
        
        </form>
    </div>
</div>