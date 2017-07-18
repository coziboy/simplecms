<?php
require_once './header.php';
require_once './function.php';


if (isset($_GET['q']) && !empty($_GET['q'])) {
   if (!isset($_REQUEST['page'])) $page = 1;
   else $page          = $_REQUEST['page']; ///make it dyanamic :: page num
   search($_GET['q'], $page);
}
if (isset($_GET['tag']) && !empty($_GET['tag'])) {
   if (!isset($_REQUEST['page'])) $page = 1;
   else $page          = $_REQUEST['page']; ///make it dyanamic :: page num
   searchTag($_GET['tag'], $page);
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