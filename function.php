<?php
require_once "./config.php";
require_once "./script/bbcode/Parser.php";
//Get Content
function base($query){
	$base = substr(__DIR__.'\\'.$query, strlen(__DIR__));
	return $base;
}
function getDir($dir){
	if (count(array_filter(glob($dir."\[0-9][0-9]-[0-9][0-9]-[0-9][0-9][0-9][0-9]_[a-zA-Z0-9]*.txt", GLOB_BRACE), 'is_file')) == 0){
	$iLoc = $dir.'\\';
	$iFile = '01-07-2016_Hello to you ;).txt';
	$iMessage = 'Hello to you ;). Thanks for using Simple CMS, a simple CMS as Simple as Blinking your eye ;) ###Note: you can change this content from your Content folder###';
	file_put_contents($iLoc.$iFile, $iMessage, FILE_APPEND | LOCK_EX);
	}
	global $ArrayPostTitle;
	$list = array_filter(glob($dir."\[0-9][0-9]-[0-9][0-9]-[0-9][0-9][0-9][0-9]_[a-zA-Z0-9]*.txt", GLOB_BRACE), 'is_file');
	$ArrayPostTitle = array();
	foreach ($list as $key) {
		$ArrayPostTitle[] = str_replace(".txt", "", $key);
	}
	return $ArrayPostTitle;
}

//Sort By Date
function SortByDate($x, $y){
	global $date;
	$date = array();
	foreach ($x as $anu) {
		$date[] = explode($y, substr($anu, strlen(__DIR__.'\content\\')));
		//$date[] = explode($y, $anu);
	}
	return usort($date, "date_sort");
}

	function date_sort($a, $b) {
    	return strtotime($b[0]) - strtotime($a[0]);
	}
//Post to index
function IndexContent($date, $page, $totla_pages){
	$file = file('./content/'.$date[0][0]."_".$date[0][1].".txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  	$parser = new JBBCode\Parser();
    $parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());
	//First article
	$datetolink = str_replace("-", "/", $date[0][0]);
	//$datetolink = substr($datetolink, strlen(__DIR__.'\content\\'));
    $titletolink = str_replace(" ", "-", $date[0][1]);
    $isi = IsiContent($date[0][0]."_".$date[0][1].".txt");
	$readmore = '... <p class="continue cf"><a class="button" href="'.$datetolink.'/'.$titletolink.'.html">Continue Reading</a>';
	$isi = cut::truncate($isi, 500, $readmore, true);
	$parser->parse($isi);
	$content = '<article id="latest-article" class="container">';
	$content .= '<h2><a href="'.$datetolink.'/'.$titletolink.'.html">'.$date[0][1].'</a></h2>';
	$content .= '<p class="post-info">by <span><a href="#">'.NAME.'</a></span>';
	if (count($file) > 3 && $file[0] == '---' && $file[2] == '---') {
		$tagarray = getTag(__DIR__."/content/".$date[0][0]."_".$date[0][1].".txt");
		$content .= ', tag: ';
		$tag = array();
		foreach ($tagarray as $key) {
			$tag[] = '<a href="/search.php?tag='.$key.'">'.$key.'</a>';
		}
		$content .= implode(', ', $tag);
	}
	$content .= '</p>';
	$content .= '<div class="dcontent cf"><p>'.$parser->GetAsText().'</p>';
	$content .= '<div class="post-meta">';
	$content .= '<p class="dateinfo">'.date('d', strtotime($date[0][0])).'<span class="dmonth">'.date('M', strtotime($date[0][0])).'</span><span class="dyear">'.date('Y', strtotime($date[0][0])).'</span></p>';
	if (file_exists(__DIR__.'\content\comment\\'.$date[0][0].'_'.$date[0][1].'.txt')) {
		$comment = substr_count(file_get_contents(__DIR__.'\content\comment\\'.$date[0][0].'_'.$date[0][1].'.txt'), PHP_EOL) + 1;
		$content .= '<div class="comments"><a href="#" title="comment on...">'.$comment.'</a></div>';
	}
	$content .= '</div>';
	$content .= '</div></article>';

	//End of first article

	//More article

	$content .= '<div id="more-articles" class="container">';

	for ($i=1; $i < count($date) ; $i++) {
		$datetolink = str_replace("-", "/", $date[$i][0]);
		//$datetolink = substr($datetolink, strlen(__DIR__.'\content\\'));
    	$titletolink = str_replace(" ", "-", $date[$i][1]);
    	$isi = IsiContent($date[$i][0]."_".$date[$i][1].".txt");
    	//$date[$i][0] = substr($date[$i][0], strlen(__DIR__.'\content\\'));
    	$readmore = '... <a href="'.$datetolink.'/'.$titletolink.'.html">Continue Reading</a>';
		$isi = cut::truncate($isi, 500, $readmore, true);
		$parser->parse($isi);

		$content .= '<article class="cf">';
		$content .= '<div class="grid8 a-left first" style="padding-right:0;padding-left:82px;"><p style="font-size:100%; font-family:Noticia text, serif;line-height: 30px;">'.$parser->GetAsText().'</p></div>';
		$content .= '<div class="grid4 a-right" style="padding-left:0; padding-right:54px;">';
		$content .= '<h3><a href="'.$datetolink.'/'.$titletolink.'.html" style="font-family: Sans-Serif;font-weight: bold;font-size: 22px;line-height: 30px;color: #666666;margin-bottom: 6px;">'.$date[$i][1].'</a></h3><p>'.date('F d, Y', strtotime($date[$i][0])).'</p>';
		if (file_exists(__DIR__.'\content\comment\\'.$date[$i][0].'_'.$date[$i][1].'.txt')) {
		$comment = substr_count(file_get_contents(__DIR__.'\content\comment\\'.$date[$i][0].'_'.$date[$i][1].'.txt'), PHP_EOL) + 1;
		$content .= '<div class="comments"><a href="#" title="comment on...">'.$comment.'</a></div>';
		}
		$content .= '</div>';
		
		$content .= '</article>';
	}
	$content .= '</div>';
	echo $content;
	pagination($page, $totla_pages, '/page/');

}

function pagination($page, $totla_pages, $rewriteurl){
	if ($page > $totla_pages) {
		$content = exit(header("Location: ../404.php"));
	}

	$stages = 3;
	$prev = $page - 1;	
	$next = $page + 1;
	$lastpage = $totla_pages;
	$LastPagem1 = $lastpage - 1;
	if($lastpage > 1)
	{
		$content = "<div class='center'><div class='pagination'>";
		// Previous
		if ($page > 1){
			$content .= "<a href='".$prev."'>&laquo;</a>";
		}else{
			$content .= "<a class='disabled'>&laquo;</a>";
		}
		// Pages	
		if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page){
					$content.= "<a class='active disabled'>".$counter."</span>";
				}else{
					$content.= "<a href='".$rewriteurl.$counter."'>".$counter."</a>";
				}
			}
		}
		elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?
		{
			// Beginning only hide later pages
			if($page < 1 + ($stages * 2))		
			{
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
				{
					if ($counter == $page){
						$content.= "<a class='active disabled'>".$counter."</span>";
					}else{
						$content.= "<a href='".$rewriteurl.$counter."'>".$counter."</a>";
					}
				}
				$content.= "<a class='disabled'>...</a>";
				$content.= "<a href='".$rewriteurl.$LastPagem1."'>".$LastPagem1."</a>";
				$content.= "<a href='".$rewriteurl.$lastpage."'>".$lastpage."</a>";
			}
			elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
			{
				$content.= "<a href='".$rewriteurl."1'>1</a>";
				$content.= "<a href='".$rewriteurl."2'>2</a>";
				$content.= "<a class='disabled'>...</a>";
				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
				{
					if ($counter == $page){
						$content.= "<a class='active disabled'>".$counter."</span>";
					}else{
						$content.= "<a href='".$rewriteurl.$counter."'>".$counter."</a>";
					}					
				}
				$content.= "<a class='disabled'>...</a>";
				$content.= "<a href='".$rewriteurl.$LastPagem1."'>".$LastPagem1."</a>";
				$content.= "<a href='".$rewriteurl.$lastpage."'>".$lastpage."</a>";		
			}
			// End only hide early pages
			else
			{
				$content.= "<a href='".$rewriteurl."1'>1</a>";
				$content.= "<a href='".$rewriteurl."2'>2</a>";
				$content.= "<a class='disabled'>...</a>";
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$content.= "<a class='active disabled'>".$counter."</span>";
					}else{
						$content.= "<a href='".$rewriteurl.$counter."'>".$counter."</a>";
					}					
				}
			}
		}
		// Next
		if ($page < $counter - 1){ 
			$content.= "<a href='".$rewriteurl.$next."'>&raquo;</a>";
		}else{
			$content.= "<a class='disabled'>&raquo;</a>";
		}
		$content .= "</div></div>";
	echo $content;
	}
}
function getTag($dir){
	$file = file($dir, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	if (count($file) > 1) {
		if (count($file) > 3 && $file[0] == '---' && $file[2] == '---') {
			$tag = explode('=', $file[1]);
			$tag = explode(',', $tag[1]);
			$tag = array_filter($tag);
			$tagarray = array();
			foreach ($tag as $key => $value) {
				$value = trim($value);
				if (empty($value));
				$tagarray[] = $value;
			}
			return $tagarray;
		}
	}
}

function IsiContent($dir){
	$file = file('./content/'.$dir, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	if (count($file) > 1) {
        if (count($file) > 3 && $file[0] == '---' && $file[2] == '---') {
        	unset($file[0]);
          	unset($file[1]);
          	unset($file[2]);
        }
        $arr = array();
        foreach ($file as $new) {
          $arr[] = $new;
        }
        $isi = implode('<br>', $arr);
        return $isi;
    }
    else return implode('<br>', $file);
}

function search($query, $page){
	$parser = new JBBCode\Parser();
    $parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());
	$content = '<div id="content" class="container">';
	$content .= '<div id="main" class="grid12 first"><article>';
	$list = array_filter(glob(__DIR__."\content\[0-9][0-9]-[0-9][0-9]-[0-9][0-9][0-9][0-9]_[a-zA-Z0-9]*.txt", GLOB_BRACE), 'is_file');
	$p = 0;
	$datesort = array();
	foreach ($list as $sumpages) {
		if(stristr(file_get_contents($sumpages), $query) == true){
			$datesort[] = explode('_', substr($sumpages, strlen(__DIR__.'\content\\')));
			$p++;
		}
	}
	usort($datesort, "date_sort");
	$record_count  = CONTENT;
	$totalpages   = ceil($p/$record_count);
	$offset        = ($page-1)*$record_count;
	$datesort  = array_slice($datesort, $offset,$record_count);
	$found = array();
	$i = 0;
	foreach ($datesort as $filename => $value) {
		$fli = file_get_contents('./content/'.$value[0].'_'.$value[1]);
		$lines = explode("\n", $fli);
		if (count($lines) > 3 && trim($lines[0]) == '---' && trim($lines[2]) == '---') $fli = implode("\n", array_slice($lines, 2));
		else $fli = implode("\n", $lines);
			$match = stristr($fli, $query);
		    if($match!==false){
		    	$date = $value[0];
		    	$title = str_replace('.txt', '', $value[1]);
		    	$datetolink = str_replace("-", "/", $date);
		    	$titletolink = str_replace(" ", "-", $title);
		    	$content .= '<h4><a href="'.$datetolink.'/'.$titletolink.'.html" style="color:#1e83b6">'.$title.'</a></h4>';
		    	$content .= '<p class="post-info">by <span><a href="'.BASEURL.'">'.NAME.'</a></span>, '.date("F d, Y",strtotime($date)).'</p>';
		    	$match = preg_replace('/'.$query.'/i', '<span style="background-color:#FFFF00">'.$query.'</span>', $match, 1);
		    	$readmore = '... <a href="'.$datetolink.'/'.$titletolink.'.html" style="color:#1e83b6">(continue reading)</a>';
		    	$match = cut::truncate($match, 150, $readmore, true);
		    	$parser->parse($match);
		    	$content .='<p>'.$parser->GetAsText().'</p>';
		    	$i++;
		    }
		//}
	}
	if ($i == 0) $content .= "<h5>0 article found</h5>";
	if ($i !== 0) $content .= "<h5>".$i." Article found</h5>";
	$content .= '</article></div></div>';
	echo $content;
	pagination($page, $totalpages, '/search.php?q='.$query.'&page=');
}

function searchTag($query){
	$content = '<div id="content" class="container">';
	$content .= '<div id="main" class="grid12 first"><article>';
	$list = array_filter(glob(__DIR__."\content\[0-9][0-9]-[0-9][0-9]-[0-9][0-9][0-9][0-9]_[a-zA-Z0-9]*.txt", GLOB_BRACE), 'is_file');
	$found = array();
	foreach ($list as $key) {
		$found[] = substr($key, strlen(__DIR__.'\content\\'));
	}
	$i = 0;
	foreach ($found as $filename) {
		$parser = new JBBCode\Parser();
    	$parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());
		$fli = file(__DIR__.'\content\\'.$filename);
		$match = stristr($fli[1], $query);
		if($match!==false){
			$split = explode('_', $filename);
		    	$date = $split[0];
		    	$title = str_replace('.txt', '', $split[1]);
		    	$datetolink = str_replace("-", "/", $date);
		    	$titletolink = str_replace(" ", "-", $title);
		    	$content .= '<h4><a href="'.$datetolink.'/'.$titletolink.'.html" style="color:#1e83b6">'.$title.'</a></h4>';
		    	$content .= '<p class="post-info">by <span><a href="'.BASEURL.'">'.NAME.'</a></span>, '.date("F d, Y",strtotime($date)).'</p>';
		    	$readmore = '... <a href="'.$datetolink.'/'.$titletolink.'.html" style="color:#1e83b6">(continue reading)</a>';
		    	unset($fli[0], $fli[1], $fli[2]);
		    	$match = cut::truncate(implode('', $fli), 150, $readmore, true);
		    	$parser->parse($match);
		    	$content .='<p>'.$parser->GetAsText().'</p>';
		    	$i++;
		}
	}
	if ($i == 0) $content .= "<h5>0 article under \"".$query."\" category</h5>";
	if ($i !== 0) $content .= "<h5>".$i." Article found under \"".$query."\" category</h5>";
	$content .= '</article></div></div>';
	echo $content;
}

class cut{
	public static function truncate($s, $l, $e = '...', $isHTML = false){
		$i = 0;
		$tags = array();
		if($isHTML){
			preg_match_all('/<[^>]+>([^<]*)/', $s, $m, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
			foreach($m as $o){
				if($o[0][1] - $i >= $l)
					break;
				$t = substr(strtok($o[0][0], " \t\n\r\0\x0B>"), 1);
				if($t[0] != '/')
					$tags[] = $t;
				elseif(end($tags) == substr($t, 1))
					array_pop($tags);
				$i += $o[1][1] - $o[0][1];
			}
		}
		return substr($s, 0, $l = min(strlen($s),  $l + $i)) . (count($tags = array_reverse($tags)) ? '
    
    ' : '') . (strlen($s) > $l ? $e : '');
	}
}
?>