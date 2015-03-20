<?php
$mapText = '<?xml version="1.0" encoding="UTF-8"?>';
$mapText .= ''.'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
$mapText .= '<!-- SiteMap re-created: '.$nowDateTime.'; free-cheese.com -->';
$mapText .= '<url>
  <loc>http://free-cheese.com/</loc>
  <changefreq>monthly</changefreq>
  <priority>0.5</priority>
</url>
<url>
  <loc>http://free-cheese.com/about</loc>
  <changefreq>monthly</changefreq>
  <priority>0.5</priority>
</url>
<url>
  <loc>http://free-cheese.com/raffles</loc>
  <changefreq>monthly</changefreq>
  <priority>0.5</priority>
</url>
<url>
  <loc>http://free-cheese.com/winners</loc>
  <changefreq>monthly</changefreq>
  <priority>0.5</priority>
</url>
<url>
  <loc>http://free-cheese.com/news</loc>
  <changefreq>monthly</changefreq>
  <priority>0.5</priority>
</url>
<url>
  <loc>http://free-cheese.com/articles</loc>
  <changefreq>monthly</changefreq>
  <priority>0.5</priority>
</url>
<url>
  <loc>http://free-cheese.com/blog</loc>
  <changefreq>monthly</changefreq>
  <priority>0.5</priority>
</url>
<url>
  <loc>http://free-cheese.com/contacts</loc>
  <changefreq>monthly</changefreq>
  <priority>0.5</priority>
</url>
<url>
  <loc>http://free-cheese.com/social</loc>
  <changefreq>monthly</changefreq>
  <priority>0.5</priority>
</url>';
$mappedEvents = mysql_query("SELECT * FROM events WHERE event_start <= '$nowDate'");
if (mysql_num_rows($mappedEvents)) {
    while ($mappedEventsInfo = mysql_fetch_assoc($mappedEvents)) {
        if ($mappedEventsInfo['event_type'] == 1) {
            $mappedEventHref = 'mainRaffle?id='.$mappedEventsInfo['event_id'];
        }
        else {
            $mappedEventHref = 'oneRaffle?id='.$mappedEventsInfo['event_id'];
        }
        $mapText .= '<url>';
        $mapText .= '<loc>http://free-cheese.com/'.$mappedEventHref.'</loc>';
        $mapText .= '<lastmod>'.$mappedEventsInfo['event_start'].'</lastmod>';
        $mapText .= '<changefreq>monthly</changefreq>';
        $mapText .= '<priority>0.5</priority>';
        $mapText .= '</url>';
    }
}
$mappedArticles = mysql_query("SELECT * FROM articles WHERE article_start <= '$nowDateTime'");
if (mysql_num_rows($mappedArticles)) {
    while ($mappedArticlesInfo = mysql_fetch_assoc($mappedArticles)) {
        $mappedArticlesDate = date_create($mappedArticlesInfo['article_start']);
        $mappedArticlesDate = date_format($mappedArticlesDate, 'Y-m-d');
        $mappedArticlesHref = 'oneArticle?id='.$mappedArticlesInfo['article_id'];
        $mapText .= '<url>';
        $mapText .= '<loc>http://free-cheese.com/'.$mappedArticlesHref.'</loc>';
        $mapText .= '<lastmod>'.$mappedArticlesDate.'</lastmod>';
        $mapText .= '<changefreq>daily</changefreq>';
        $mapText .= '<priority>0.8</priority>';
        $mapText .= '</url>';
    }
}
$mappedNews = mysql_query("SELECT * FROM news WHERE news_start <= '$nowDateTime'");
if (mysql_num_rows($mappedNews)) {
    while ($mappedNewsInfo = mysql_fetch_assoc($mappedNews)) {
        $mappedNewsDate = date_create($mappedNewsInfo['news_start']);
        $mappedNewsDate = date_format($mappedNewsDate, 'Y-m-d');
        $mappedNewsHref = 'oneNews?id='.$mappedNewsInfo['news_id'];
        $mapText .= '<url>';
        $mapText .= '<loc>http://free-cheese.com/'.$mappedNewsHref.'</loc>';
        $mapText .= '<lastmod>'.$mappedNewsDate.'</lastmod>';
        $mapText .= '<changefreq>daily</changefreq>';
        $mapText .= '<priority>0.8</priority>';
        $mapText .= '</url>';
    }
}
$mapText .= '</urlset>';
$file="sitemap.xml";
$fp = fopen($file, "w");
fwrite($fp,$mapText);
fclose($fp);