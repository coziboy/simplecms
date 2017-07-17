<?php
require_once './header.php';
require_once './function.php';

if (isset($_GET['q'])){
	switch ($_GET['q']) {
		case 'about':
      $content = '<div id="content" class="container">';
      $content .= '<div id="title-section"><h2>About Me</h2></div>';
      $content .= '<div class="container">';
      $content .= '<blockquote cite="http://www.keepinspiring.me/quotes-about-being-yourself/"><p>Be yourself; everyone else is already taken.</p><cite><a href="#">Oscar Wilde</a></cite></blockquote>';
      $content .= '<img width="216" height="216" class="pull-left" alt="me" src="/images/me.jpg"><p>My name is Andreas Asatera Sandi Nofa and I am just an ordinary person from Indonesia and author of <a href="http://scms.dev">Simple CMS</a>, a CMS that simple as blinking your eye ;)</p><p>For those who want to know me more you can contact me at:<br><a href="http://twitter.com/'.TWITTER.'" target="_blank"><img src="/images/social/twitter.png" alt="twitter"></a> <a href="http://facebook.com/'.FACEBOOK.'" target="_blank"><img src="/images/social/facebook.png" alt="facebook"></a> <a href="http://instagram.com/'.INSTAGRAM.'" target="_blank"><img src="/images/social/instagram.png" alt="instagram"></a> </p>';
      $content .= '</div>';
      $content .= '</div>';
      echo $content;
			break;

		default:
			include './404.php';
			break;
	}
}

echo '<div id="search-section" class="container">
     <form class="cf" action="/search.php">

        <div class="grid4 a-left first">
           <label for="q">Search the site</label>
        </div>

        <div class="grid8 a-right">
           <input type="text" id="q" name="q">
           <button type="submit">GO</button>
        </div>

     </form>
  </div>

</div>';


require_once './footer.php';
?>