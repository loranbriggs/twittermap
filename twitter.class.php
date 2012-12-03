<?php

class twitter_class
{	
	function twitter_class()
	{
		$this->realNamePattern = '/\((.*?)\)/';
		$this->searchURL = 'http://search.twitter.com/search.atom?lang=en&q=';
		
		$this->intervalNames   = array('second', 'minute', 'hour', 'day', 'week', 'month', 'year');
		$this->intervalSeconds = array( 1,        60,       3600,   86400, 604800, 2630880, 31570560);
		
		$this->badWords = array('somebadword', 'anotherbadword');
	}

	function getTweets($keyword, $location, $limit=15)
	{
		$output = '';

		// get the seach result
		$ch= curl_init($this->searchURL . urlencode($keyword) . "&geocode=" . urlencode($location) );

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		$response = curl_exec($ch);

		if ($response !== FALSE)
		{
			$xml = simplexml_load_string($response);
	
			$output = '';
			$tweets = 0;
      $locations = array();
			
			for($i=0; $i<count($xml->entry); $i++)
			{
				$crtEntry = $xml->entry[$i];
				$account  = $crtEntry->author->uri;
				$image    = $crtEntry->link[1]->attributes()->href;
				$tweet    = $crtEntry->content;
        $twittergeo     = $crtEntry->children('twitter', true)->geo->children('georss', true)->point;
        $googlelocation = $crtEntry->children('google',  true)->location;

        // add location to array
        if (isset($twittergeo)) {
          $locations[$i] = $twittergeo;
        } else if (isset($googlelocation)) {
          $locations[$i] = $googlelocation;
        }
	
				// skip tweets containing banned words
				$foundBadWord = false;
				foreach ($this->badWords as $badWord)
				{
					if(stristr($tweet, $badWord) !== FALSE)
					{
						$foundBadWord = true;
						break;
					}
				}
				
				$tweet = str_replace('<a href=', '<a target="_blank" href=', $tweet);
				
				// skip this tweet containing a banned word
				if ($foundBadWord)
					continue;

				// don't process any more tweets if at the limit
				if ($tweets==$limit)
					break;
				$tweets++;
	
				// name is in this format "acountname (Real Name)"
				preg_match($this->realNamePattern, $crtEntry->author->name, $matches);
				$name = $matches[1];
	
				// get the time passed between now and the time of tweet, don't allow for negative
				// (future) values that may have occured if server time is wrong
				$time = 'just now';
				$secondsPassed = time() - strtotime($crtEntry->published);

				if ($secondsPassed>0)
				{
					// see what interval are we in
					for($j = count($this->intervalSeconds)-1; ($j >= 0); $j--)
					{
						$crtIntervalName = $this->intervalNames[$j];
						$crtInterval = $this->intervalSeconds[$j];
							
						if ($secondsPassed >= $crtInterval)
						{
							$value = floor($secondsPassed / $crtInterval);
							if ($value > 1)
								$crtIntervalName .= 's';
								
							$time = $value . ' ' . $crtIntervalName . ' ago';
							
							break;
						}
					}
				}
				
				$output .= '
				<div class="tweet">
					<div class="avatar">
						<a href="' . $account . '" target="_blank"><img src="' . $image .'"></a>
					</div>
					<div class="message">
						<span class="author"><a href="' . $account . '"  target="_blank">' . $name . '</a></span>: ' . 
						$tweet . 
						'<span class="time"> - ' . $time . '</span>
					</div>
          <div class="location">' .
            $twittergeo . $googlelocation . '
          </div>
				</div>
        <script> locations[' . $i . '] = "' . $locations[$i] . '";</script>
        ';
			}
      // pass php variables to javascript
      $output .= '<script> var tweets = ' . $tweets . '</script>';
		}
		else
			$output = '<div class="tweet"><span class="error">' . curl_error($ch) . '</span></div>';
		
		curl_close($ch);
		return $output;
	}
}

?>
