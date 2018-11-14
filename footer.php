</div>
<!-- /.wrapper -->	
<footer class="footer">
      
      <div class="footerrow1">
      	<p> emc.olsson@gmail.com | 0761775949 </p>
 	 </div>
     
     <div class="footerrow2">
     	<a href="<?php echo esc_html( get_option('twitter') ); ?>"> <img title="Twitter" alt="Twitter" src="https://socialmediawidgets.files.wordpress.com/2014/03/01_twitter.png"></a> 
        <a href="<?php echo esc_html( get_option('facebook') ); ?>"> <img title="Facebook" alt="Facebook" src="https://socialmediawidgets.files.wordpress.com/2014/03/02_facebook.png"></a> 
        <a href="<?php echo esc_html( get_option('linkedin') ); ?>"> <img title="LinkedIn" alt="LinkedIn" src="https://socialmediawidgets.files.wordpress.com/2014/03/07_linkedin.png"></a>
     </div>

 	<div class="footerrow3">
    	<p> &copy;
    		<?php
  				$fromYear = 2017; 	
  				$thisYear = (int)date('Y'); 
  				echo esc_html( $fromYear . (($fromYear != $thisYear) ? '-' . $thisYear : '') );
			?>
    			Emanuel Olsson </p>
    </div>
    
</footer>

<?php wp_footer(); ?>

</body></html>