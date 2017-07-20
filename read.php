<?php
require_once './header.php';
require_once './function.php';
$parser = new Golonka\BBCode\BBCodeParser;
//Get Variable
$d = $_GET['d'];
$m = $_GET['m'];
$y = $_GET['y'];
$title = $_GET['title'];
$date = date("F d, Y",strtotime($d."-".$m."-".$y));

//Post Commend
if (isset($_POST['date']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
  $wdate = $_POST['date'];
  $wname = $_POST['name'];
  $wemail = $_POST['email'];
  $wmessage = str_replace(PHP_EOL, '<br>', $_POST['message']);
  $wtitle = str_replace("-", " ", $title);
  $wloc = __DIR__.'/content/comment/';
  $wfile = $wdate.'->'.$wname.'->'.$wemail.'->'.$wmessage;
  $myFile = $wloc.$d."-".$m."-".$y."_".$wtitle.".txt";
  if (file_exists($myFile)) file_put_contents($myFile, PHP_EOL.$wfile , FILE_APPEND | LOCK_EX);
  if (!file_exists($myFile)) file_put_contents($myFile, $wfile , FILE_APPEND | LOCK_EX);
}
if (!empty($d) && !empty($m) && !empty($y) && !empty($title) && isset($d, $m, $y, $title)) {
  $title = str_replace("-", " ", $title);
  $content = '<div id="content" class="container">';
  $content .= '<div id="main" class="grid12 first"><article>';

  //Content
  if(!file_exists("./content/".$d."-".$m."-".$y."_".$title.".txt")) $isi ="";
  else{
    $file = file('./content/'.$d."-".$m."-".$y."_".$title.".txt");
    $content .= '<h2 class="huge">'.$title.'</h2>';
    $content .= '<p class="post-info">by <span><a href="'.BASEURL.'">'.NAME.'</a></span>, '.$date.'</p>';
    if (count($file) > 1 && count($file) > 3 && trim($file[0]) == '---' && trim($file[2]) == '---') {
      $tagarray = getTag('./content/'.$d."-".$m."-".$y."_".$title.".txt");
      unset($file[0],$file[1],$file[2]);
      $isi = implode('<br>', $file);
      $content .= '<p>'.$parser->parse($isi).'</p>';
      $content .= '<p class="postmeta"><span><strong>Tagged in</strong> </span>';
      foreach ($tagarray as $tags) {
        $content .= '<span><a href="/search.php?tag='.$tags.'">'.$tags.'</a></span>';
        $content .= '</p>';
      }
    }
    else{
      $isi = implode('<br>', $file);
      $content .= '<p>'.$parser->parse($isi).'</p>'; 
    }
  }

  //Read Comment
  if (file_exists("./content/comment/".$d."-".$m."-".$y."_".$title.".txt")) {
    $comment = nl2br(file_get_contents(__DIR__."/content/comment/".$d."-".$m."-".$y."_".$title.".txt"));
    $comment = $parser->stripBBCodeTags($comment);
    $comment = explode(PHP_EOL, $comment);
    $splitcomment = array();
    foreach ($comment as $key) {
      $splitcomment[] = explode('->', $key);
    }
    function comment_sort($a, $b){
      return strtotime($b[0]) - strtotime($a[0]);
    }
    usort($splitcomment, "comment_sort");
    $content .= '<section id="comments"><h3>'.count($comment).' Responses</h3><ol class="commentlist">';
    $div_flag = false;
    foreach ($splitcomment as $v1) {
      $cdate = date('F j, Y \a\t H:i', strtotime($v1[0]));
      $cname = $v1[1];
      $cmail = $v1[2];
      $cisi = $v1[3];
      $content .= '<li class="'.($div_flag ? "" : "thread-alt").' depth-1">';
      $content .= '<div class="comment-info"><cite style="margin:6px 15px 12px 30px;">';
      $content .= '<strong><a class="author">'.$cname.'</a></strong><br>';
      $content .= '<span class="comment-data">'.$cdate.'</span></cite></div>';
      $content .= '<div class="comment-text"><p>'.$cisi.'</p></div></li>';
      $div_flag = !$div_flag;
    }
    $content .= '</ol></section>';
  }

 //Reply
  $content .= '<section id="respond"><h3>Leave a Reply</h3>';
  $content .= '<form id="contactform" method="post">';
  $content .= '<div><p>Send me a message</p></div>';
  $content .= '<input type="hidden" id="date" name="date">';
  $content .= '<div><label>Name <span class="required">*</span></label><input type="text" value="" id="name" name="name"></div>';
  $content .= '<div><label>Email <span class="required">*</span></label><input type="text" value="" id="email" name="email"></div>';
  $content .= '<div><label>Message <span class="required">*</span></label><textarea id="message" cols="50" rows="20" name="message"></textarea></div>';
  $content .= '<div><input type="submit" class="button" value="Submit"><input type="reset" class="button" value="Reset"></div></form></section>';

  $content .= '<a class="button" href="'.BASEURL.'">Back to Home</a>';
  $content .= '</article></div></div>';
  echo $content;
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

echo '<script type="text/javascript" src="'.BASEURL.'js/clocktick.js"></script>';
require_once './footer.php';
?>