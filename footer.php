<footer class="container">

      <div class="grid4 first">

         <div class="footer-logo" style="height: 25px; margin-bottom: 0;">
            <h3><?php
            echo TITLE;
            if ((defined('TWITTER') && TWITTER !='') || (defined('FACEBOOK') && FACEBOOK !='') || (defined('PLUS') && PLUS !='') || (defined('INSTAGRAM') && INSTAGRAM !='')) echo ' Social';
               ?></h3>
         </div>

            <ul class="social-links cf">
				   <?php if(defined('TWITTER') && TWITTER !='' ) echo '<li class="twitter"><a href="http://twitter.com/'.TWITTER.'" target="_blank">'.TWITTER.'</a></li>'; ?>
				   <?php if(defined('FACEBOOK') && FACEBOOK !='' ) echo '<li class="facebook"><a href="http://facebook.com/'.FACEBOOK.'" target="_blank">'.FACEBOOK.'</a></li>'; ?>
				   <?php if(defined('PLUS') && PLUS !='' ) echo '<li class="google"><a href="#" target="_blank">'.PLUS.'</a></li>'; ?>
				   <?php if(defined('INSTAGRAM') && INSTAGRAM !='' ) echo '<li class="instagram"><a href="http://instagram.com/'.INSTAGRAM.'" target="_blank">'.INSTAGRAM.'</a></li>'; ?>
			   </ul>

      </div>

      <div class="grid4">

         <h3>Explore our site</h3>

            <ul class="link-list">
               <li><a href="/">Home</a></li>
               <li><a href="/p/about">About</a></li>
            </ul>

      </div>

      <div class="grid4">

         <h3>Contact Info</h3>

		   <p>
         <strong>E-mail: </strong>eas.coziboy@gmail.com<br>
         Want more info - go to our <a href="/p/about">contact page</a>
         </p>

	   </div>
<!--footer-bottom-->
<div id="footer-bottom" class="grid12 first">

	      <p>
         2017 Copyright Info <?php echo TITLE ?>
         </p>

         <!-- Back To Top Button -->
         <div id="go-top"><a href="#" title="Back to Top">Go To Top</a></div>

      </div>

   </footer>


<!--Java Script-->
<script src="/js/jquery.min.js"></script>
   <script>window.jQuery || document.write(\'<script src="/js/jquery-1.10.2.min.js"><\/script>\')</script>
   <script src="/js/custom.js"></script>

</body>

</html>