<?	defined( "_29h9xwpHzQWKK6U3ov54noaKk1YASDBhrNPg" ) or die( "Direct Access to this location is not allowed." );

	function printn($string) {
		print($string."\n");
	}

	function polacz_z_baza(&$link) {
		$link=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD)
			or die("Nie mogę nawiązać połączenia z bazą danych.");

		mysql_select_db(DB_DATABASE) OR die('Nie udalo mi sie wybrać bazy danych: '.mysql_error());
  	}


	function rozlacz_z_baza(&$link) {
	 	@mysql_close($link);
	}

  	function zalogowany() {
 		if(isset($_SESSION['zalogowany']) && $_SESSION['zalogowany']==true && !empty($_SESSION['id']) && !empty($_SESSION['pass_session'])) {
                    $category_db = 'users';
                    $id = $_SESSION['id'];
                    $pass_session = $_SESSION['pass_session'];
                    $sql = "SELECT * FROM `$category_db` WHERE `id` = '$id' AND `pass_session` = '$pass_session' AND `active` = '1' LIMIT 1";
                    $wynik = mysql_query($sql);
                    $w = mysql_fetch_array($wynik);
                    if($w) {
                        generuj_menu_top();
                        $result = true;
                    } else {
                        $result = false;
                    }
 		} else $result = false;
 			
 		return $result;
 		
 	}

        function switch_lang($lang = '') {
            $id = $_SESSION['id'];
            //$lang = generate_lang($lang);
            if(!in_array($lang, unserialize(LANGS))) $lang = DEFAULT_LANG;
            $sql = "UPDATE `users` SET `lang` = '$lang' WHERE `id` = $id";
            $wynik = mysql_query($sql);
            $_SESSION['lang'] = $lang;
        }

        function generate_next_lang() {
            $langs = unserialize(LANGS);
            $key = array_search(LANG, $langs) +1;
            if($key==sizeof($langs)) $key = 0;
            return $langs[$key];
        }

        function generate_lang($lang = '') {
            if(!in_array($lang, unserialize(LANGS))) $lang = DEFAULT_LANG;
            return $lang;
        }

 	/**
	 * Funkcja tworzy miniature z obrazka
	 *
	 * @param int $max_width - (maksymalna) szerokość miniatury
	 * @param int $max_height - (maksymalna) wysokość miniatury
	 * @param string $source - ścieżka do obrazka
	 * @param string $source_type typ obrazka. np 'jpg' albo 'image/jpeg'
	 * @param string $dest - ścieżka docelowa miniaturki
	 * @param string $dest_type typ obrazka. np 'jpg'
	 * @param bool $proportional - czy proporcjonalne mają być boki, czy nie ($max_width * $max_height)
	 * @param bool $powieksz - czy ma powiękaszać gdy obrazek jest mniejszy
	 * @param bool $kadruj - czy ma kadrować obrazek (środek) do określonego rozmiaru
	 */
	function stworz_miniature($max_width, $max_height, $source, $source_type, $dest, $dest_type = 'jpg', $proportional = false, $powieksz = true, $kadruj = false) {
	    $size = getimagesize($source);
	    $w = $size[0];
	    $h = $size[1];
	    switch($source_type) {
	        case 'gif':
	        	$simg = imagecreatefromgif($source);
	        	break;
	        case 'image/gif':
	        	$simg = imagecreatefromgif($source);
	        	break;
	        case 'jpg':
	        	$simg = imagecreatefromjpeg($source);
	        	break;
	        case 'image/jpeg':
	        	$simg = imagecreatefromjpeg($source);
	        	break;
	        case 'image/pjpeg':
	        	$simg = imagecreatefromjpeg($source);
	        	break;
	        case 'png':
	        	$simg = imagecreatefrompng($source);
	        	break;
	        case 'image/png':
	        	$simg = imagecreatefrompng($source);
	        	break;
			default:
	        	$simg = imagecreatefromjpeg($source);
	        	break;
	    }

            if(!$powieksz) {
                if($max_width>$w) {
                    $max_width = $w;
                }
                if($max_height>$h) {
                    $max_height = $h;
                }
            }
	    if (($proportional) && (!$kadruj)) {

	    	$stosunek_szerokosci = $max_width/$w;
	    	$stosunek_wysokosci = $max_height/$h;
	    	if($stosunek_szerokosci<$stosunek_wysokosci) {
                    $max_height = floor($stosunek_szerokosci*$h);
                } else {
                    $max_width = floor($stosunek_wysokosci*$w);
                }
	    }
	    $dimg = imagecreatetruecolor($max_width, $max_height);

            if(($powieksz) && (($max_height>$h) || ($max_width>$w))) {
                 if($max_height>$h) {
                    $new_height = $max_height;
                    $new_width = floor(($new_height/$h) * $w);
                 } else {
                    $new_width = $max_width;
                    $new_height = floor(($new_width/$w) * $h);
                 }

                 $new_simg = imagecreatetruecolor($new_width, $new_height);
                 imagecopyresampled($new_simg, $simg, 0, 0, 0, 0, $new_width, $new_height, $w, $h);
                 $simg = $new_simg;
            }

            if($kadruj) {
		 	$x = 0;
			$y = 0;
			$width_ratio = $w/$max_width;  //>1 dla dużej grafiki
			$height_ratio = $h/$max_height;

			if($width_ratio>$height_ratio) {
                                $old_w = $w;
                                $w = floor($height_ratio*$max_width);
				$y = 0;
				$x = floor(($old_w-$w)/2);
			} else {
                                $old_h = $h;
                                $h = floor($width_ratio*$max_height);
				$x = 0;
				$y = floor(($old_h-$h)/2);
			}
		 	imagecopyresampled($dimg, $simg, 0, 0, $x, $y, $max_width, $max_height, $w, $h);

            } else imagecopyresampled($dimg, $simg, 0, 0, 0, 0, $max_width, $max_height, $w, $h);


            $spnMatrix = array( array(-1,-1,-1,),
                                        array(-1,16,-1,),
                                        array(-1,-1,-1));
            $divisor = 8;
            $offset = 0;
            if(function_exists('imageconvolution')) {
              imageconvolution($dimg, $spnMatrix, $divisor, $offset);
            }
	    switch($dest_type) {
	        case 'gif':
		        imagegif($dimg,$dest,85);
		        break;
	        case 'jpg':
		        imagejpeg($dimg,$dest,85);
		        break;
	        case 'png':
		        imagepng($dimg,$dest,9);
		        break;
	    }
    }

	function generate_url($string, $table = false, $section = 0, $id = 0, $row = 'url')
    {
		$trans0 = array
		(
			'ą' => 'a',
			'ć' => 'c',
			'ę' => 'e',
			'ł' => 'l',
			'ń' => 'n',
			'ó' => 'o',
			'ś' => 's',
			'ź' => 'z',
			'ż' => 'z',
		
			'Ą' => 'A',
			'Ć' => 'C',
			'Ę' => 'E',
			'Ł' => 'L',
			'Ń' => 'N',
			'Ó' => 'O',
			'Ś' => 'S',
			'Ź' => 'Z',
			'Ż' => 'Z',
		);

		
		$trans1 = array
		(
			' ' => '-',
			'.' => '',
			',' => '',
			'!' => '',
			'\'' => '',
			'/' => '',

			'&amp;' => '',
			'&' => '',		
		);
		
		$trans2 = array
		(
			'-------' => '-',
			'------' => '-',
			'-----' => '-',
			'----' => '-',
			'---' => '-',
			'--' => '-',
		);
		
		$string = trim($string);
		$string = strtr($string, $trans0);
		$string = strtr($string, $trans1);
		$string = strtr($string, $trans2);
		$string = strtolower($string);
		$string = urlencode($string);
                $string = substr($string, 0, 40);

                if($table!==false) {
                    $counter = 1;
                    $loop = true;
                    $string_copy = $string;
                    do {
                        if($section>0) {
                            $sql = "SELECT * FROM `$table` WHERE `$row` = '$string' AND `id` != '$id' AND `section` = '$section' LIMIT 1";
                        } else {
                            $sql = "SELECT * FROM `$table` WHERE `$row` = '$string' AND `id` != '$id' LIMIT 1";
                        }
                        $wynik = mysql_query($sql);
                        $w = mysql_fetch_array($wynik);
                        if($w) {
                            $string = substr($string_copy, 0, 40-strlen($counter));
                            $string.=$counter;
                            $counter++;
                        } else {
                            $loop = false;
                        }
                    } while($loop);
                }
                
		return $string;	
    }	
	
    function escape_data($data) {
    	global $link;
    	if(ini_get('magic_quotes_gpc')) {
    		$data = stripslashes($data);
    	}
    	return mysql_real_escape_string($data, $link);
    }

    function include_default($return = false) {
        $adres = $_SESSION['sections'][$_SESSION['default_controller']]['url'];
        if(empty($adres)) $adres = 'limit';
        if($return) {
            return $adres;
        } else {
            include('controllers/'.$adres.'.php');
        }
    }

    function redirect_default($return = false) {
        $adres = 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"];
        if($return) {
            return $adres;
        } else {
            header("Location: $adres");
            exit();
        }
    }

    function generuj_long_text_show($text) {
        //$text = stripslashes($text);
        return $text;
    }

    function generuj_long_text_onecolumn_show($text) {
        //$text = stripslashes($text);
        $replace = array('<p>&nbsp;</p>'=>'', '<p>'=>'<p class="white-text"><span>', '<p class=\"white\">' => '<p class="white-text"><span>', '<p class=\"blue\">' => '<p class="blue-text"><span>', '<p class=\"brown\">' => '<p class="brown-text"><span>', '</p>' => '</span></p><br>', '<ul>' => '<ul class="bluearrowul">', '<li class=\"brown\">' => '<li><p class="brown-text"><span>', '<li class=\"blue\">' => '<li><p class="blue-text"><span>', '<li>' => '<li><p class="white-text"><span>', '<li class=\"white\">' => '<li><p class="white-text"><span>', '</li>' => '</span></p></li>');
        $text = strtr($text, $replace);
        $text= '<div class="column2">'.$text;
        if(substr($text,-4)=='<br>') {
            $text = substr($text,0, -4);
        }
        $text.='</div>';
        return $text;
    }

    function generuj_order($category2 = '') {
        global $category;
        if(empty ($category2)) $category2 = $category;
        $wynik = mysql_query("SELECT MAX(id) `m_id` FROM `$category2`");
        $w = mysql_fetch_array($wynik);
        $order = $w['m_id'] + 1;
        return $order;
    }

    function generuj_title_url($title, $id = '', $category2 = '') {
        return generate_url($title);
    }

    function mail_utf8($to, $subject = '(No subject)', $message = '', $from) {
      $header = 'MIME-Version: 1.0' . "\n" . 'Content-type: text/html; charset=UTF-8'
        . "\n" . 'From: digitalica.pl <' . $from . ">\n";
      @mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header);
    }

    function generate_random_string($length) {
            $new_pass = '';//.rand(1,62);
            for($i=0;$i<$length;$i++) {
                    $a = rand(0,61);
                    if($a<=9) $symbol = $a;
                    else{
                            $a = $a - 10;
                            if($a<=25) $symbol = chr(65+$a);
                            else {
                                    $a = $a - 26;
                                    $symbol = chr(97+$a);
                            }
                    }
                    $new_pass.= $symbol;
            }
            return $new_pass;
    }

    function generuj_menu_top() {
            $category_db = 'privileges';
            $category_db2 = 'sections';
            $id = $_SESSION['id'];
            $sql = "SELECT * FROM `$category_db2` WHERE `id` IN (SELECT `section` FROM `$category_db` WHERE `user`='$id' AND `active`= 1) ORDER BY `id`";
            $wynik = mysql_query($sql);
            $sections = array();
            $default_controller = '';
            while($w = mysql_fetch_array($wynik)) {
                $sections[$w['id']] = $w;
                if(empty($default_controller)) {
                    $default_controller = $w['id'];
                }
            }
            $_SESSION['default_controller'] = $default_controller;
            $_SESSION['sections'] = $sections;
    }

    function curl_download($url, $post = null){

        // is cURL installed yet?
        if (!function_exists('curl_init')){
            die('Sorry cURL is not installed!');
        }

        // OK cool - then let's create a new cURL resource handle
        $ch = curl_init();

        // Now set some options (most are optional)

        // Set URL to download
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if(!empty($post)) {
            curl_setopt($ch, CURLOPT_POST, 1);//przesylamy metodą post
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }

        // User agent
        curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
        // Include header in result? (0 = yes, 1 = no)
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch , CURLOPT_FOLLOWLOCATION, true);
        // Should cURL return or print out the data? (true = return, false = print)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        // Download the given URL, and return output
        $output = curl_exec($ch);
        // Close the cURL resource, and free system resources
        curl_close($ch);

        return $output;
    }



    function post_tweet($tweet) {
        $post['message'] = $tweet;
        $post['password'] = TWITTER_CURL_PASSWORD;
        return curl_download(TWITTER_CURL_URL.'?message=', $post);
    }
    
    


// A simple function using Curl to post (GET) to Twitter
// Kosso : March 14 2007

function postToTwitter($tweet){

 $host = "http://twitter.com/statuses/update.xml?status=".urlencode(stripslashes(urldecode($tweet)));

 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $host);
 curl_setopt($ch, CURLOPT_VERBOSE, 1);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_USERPWD, TWITTER_USERNAME.":".TWITTER_PASSWORD);
 curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
 curl_setopt($ch, CURLOPT_POST, 1);

 $result = curl_exec($ch);
 // Look at the returned header
 $resultArray = curl_getinfo($ch);
 

 curl_close($ch);

 if($resultArray['http_code'] == "200"){
 $twitter_status='Your message has been sended! <a href="http://twitter.com/'.TWITTER_USERNAME.'">See your profile</a>';
 } else {
 $twitter_status="Error posting to Twitter. Retry";
 $twitter_status.=" - $result";
 }
 return $twitter_status;
}
    
    
?>