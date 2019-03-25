<?php
namespace INFO2\CAPANR;


class Rss {

	public $feed;


	public function __construct($feed) {
        $this->feed = $feed;
    }

	function parse() {
		$rss = simplexml_load_file($this->feed);
		$rss_split = array();
		foreach ($rss->channel->item as $item) {
		   $title = (string) $item->title; // Title
		   $link = (string) $item->link; // Url Link
		   $description = (string) $item->description; //Description
		   $rss_split[] = '<div class="h5">
		   <a href="' . $link . '" target="_blank" title="" >
		   ' . $title . '
		   </a>
		   </div>';
		}
		return $rss_split;
	}

	function display($numrows, $head) {
		$rss_split = $this->parse();
		$i = 0;
		$rss_data = '
		<div class="vas">
		<div class="feeds-head h3 mt-3 mb-4">
		' . $head . '
		</div>
		<br />
		<div class="feeds-links text-center">';

		while ($i < $numrows) {
			$rss_data .= $rss_split[$i].'<br /><br />';
			$i++;
		}
		$trim = str_replace('', '', $this->feed);
		$user = str_replace('&lang=en-us&format=rss_200', '', $trim);
		$rss_data.='</div></div>';
		return $rss_data;
	}
}
