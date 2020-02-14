<?php

require __DIR__."/getID3/getid3/getid3.php";

//header('Content-Type: application/rss+xml');
header('Content-Type: application/xml');

echo <<<HTML
<rss version="2.0">
    <channel>
        <title>Mon site</title>
        <description>flux RSS 2.0</description>
        <lastBuildDate>Jeu, 13 Fev 2020 15:00:01</lastBuildDate>

HTML;

$items = array();
$dir = new DirectoryIterator('.');
foreach ($dir as $fileinfo) {
    if ($fileinfo->getExtension() == "mp3") {
        $fileName = $fileinfo->getFilename();
        $length = $fileinfo->getSize();
        $getID3 = new getID3;
        $infos = $getID3->analyze($fileName);
        $id3v2 = $infos['tags']['id3v2'];
        $dateSrc = isset($id3v2['recording_time'][0]) ? $id3v2['recording_time'][0] : null;
        $newDate = (new DateTime($dateSrc))->format('D, d M o H:i:s T');

        $items[$fileinfo->getMTime()] = <<<HTML
<item>
    <title>{$id3v2['title'][0]}</title>
    <description>{$id3v2['album'][0]}</description>
    <pubDate>{$newDate}</pubDate>
    <enclosure url="http://localhost/Converter/{$fileName}" length="{$length}" type="audio/mpeg" />
    <link>http://localhost/Converter/{$fileName}</link>
</item>

HTML;
    }
}

krsort($items);

foreach ($items as $item) {
    echo $item;
}

echo <<<HTML
    </channel>
</rss>
HTML;
