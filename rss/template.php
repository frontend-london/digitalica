<?	defined( "_RSS_INDEX" ) or die( "Direct Access to this location is not allowed." );
  echo "<?xml version=\"1.0\" encoding=\"utf-8\"?".">";
?>
<rss version="2.0">
  <channel>
    <title>Digitalica.pl</title>
    <link><?=ADRES;?></link>
    <description>Digitalica.pl RSS</description>
    <language>pl-PL</language>
    <lastBuildDate><?=$t['lastBuildDate'];?></lastBuildDate>
    
    <?if(!empty($t['item'])): ?>
      <?$counter=0; foreach ($t['item'] as $item): ?>
        <item>
          <title><?=$item['title'];?></title>
          <link><?=$item['link'];?></link>
          <description><?=$item['description'];?></description>
          <pubDate><?=$item['pubDate'];?></pubDate>
          <guid><?=$item['guid'];?></guid>
        </item>        
      <?$counter++; endforeach; ?>
    <?endif; ?>    
  </channel>
</rss>