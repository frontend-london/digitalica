<?
  define('_RSS_INDEX', 1);
  define( "_27MMmPsKneKT6sWaOA33dqklg0OuF6sHzwV", 1);
  
  require('../include/_data.php');
  require('../include/config.php');
  require('../include/functions.php');
  
  polacz_z_baza($link);
  
  mysql_query("SET NAMES utf8");
  mysql_query("SET CHARACTER SET utf8");
  mysql_query("SET SESSION collation_connection='utf8_general_ci'");
  
  $select = "SELECT t.`short_text` description, t.`title`, t.`date` pubDate, t.`section`, t.`url`, s.`url` s_url FROM `threads` t, `sections` s WHERE t.`active`='1' AND s.`id` = t.`section` ORDER BY t.`date` DESC LIMIT ".RSS_LIMIT;
  $wynik = mysql_query($select);
  while($w = mysql_fetch_array($wynik)) {
          $w['pubDate'] = gmdate('D, d M Y H:i:s T',strtotime($w['pubDate'].'+1 day'));
          $w['description'] = htmlentities(strip_tags($w['description']));
          $w['link'] = htmlentities(ADRES.$w['s_url'].'/'.$w['url']);
          $w['guid'] = htmlentities($w['link']);
          $t['item'][] = $w;
  }    
    
//    print_r($t['item']); exit();
  
  $t['lastBuildDate'] =$t['item'][0]['pubDate']; // data ostatniej zmiany 
  
  header("Content-Type: application/rss+xml");
  
  require('template.php');

  rozlacz_z_baza($link);

?>