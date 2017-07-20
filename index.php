<?php
require_once './header.php';
require_once './function.php';

/*                latest article
==================================================*/

$content = getDir(__DIR__."/content");
SortByDate($content, "_");

$record_count  = CONTENT;
$totalpages   = ceil(count($date)/$record_count);
if (!isset($_REQUEST['page'])) $page = 1;
else $page          = $_REQUEST['page']; ///make it dyanamic :: page num
$offset        = ($page-1)*$record_count;
$date  = array_slice($date, $offset,$record_count);

IndexContent($date, $page, $totalpages);

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

/*                   footer
==================================================*/
require_once './footer.php';
?>