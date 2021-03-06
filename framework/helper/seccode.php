<?php
class seccode
{
	public $consts = 'bcdfhjkmnpqrstwxyz', 
	       $vowels = 'aei23456789',
	       $height = 24,
	       $length = 4,
	       $angle = 10,		//倾斜度
	       $contort = 2,	//扭曲度
	       $image = null,	//图片二进制
	       $fonts;

	function __construct($sessionid = false)
	{
		$session = factory::session();
        if ($sessionid !== false) {
            session_id($sessionid);
        }

		$session->start();
        $this->colors = array(
            array(57, 99, 131),
            array(158, 93, 63),
            array(85, 96, 41),
        );
        $this->bgcolors = array(
            array(255, 255, 255),
            array(239, 247, 253),
            array(248, 248, 248),
            array(250, 251, 236),
        );
		$this->fonts = array(
            ROOT_PATH.'resources/fonts/couri.ttf',
            ROOT_PATH.'resources/fonts/consolas.ttf',
        );
	}
	
	function image(array $options = array(), $binary = false)
	{
		$string = $this->_string();
		$this->_image($string, $options, $binary);
	}
	
	function valid($destroy = false)
	{
		$result = isset($_SESSION['seccode']) && strcasecmp($_REQUEST['seccode'], $_SESSION['seccode']) == 0;
		if ($destroy) unset($_SESSION['seccode']);
		return $result;
	}
	
	function _string()
	{
		$constslen = strlen($this->consts) - 1;
		$vowelslen = strlen($this->vowels) - 1;
		$string = '';
		for ($x = 0; $x < $this->length; $x++)
		{
			$string .= $x%2 == 0 ? substr($this->consts, mt_rand(0, $constslen), 1) : substr($this->vowels, mt_rand(0, $vowelslen), 1);
		}
		$_SESSION['seccode'] = $string;
		return $_SESSION['seccode'];
	}
	
	function _image($string, array $options, $binary = false)
	{
        if ($binary === false) {
		    ob_clean();
        } else {
            ob_clean();
            ob_start();
        }

        $height = !empty($options['height']) ? intval($options['height']) : $this->height;
        $width = ceil($height * 13 / 24);
        $text_offset = floor($height * 2 / 13);
        $text_y = floor($height * 18 / 24);
        $font_size_min = floor($width / 18 * 24);
        $font_size_max = floor($width / 16 * 24);

        $imageY = $height;						//the image height
		$imageX = strlen($string)*$width;	//the image width
		$im = imagecreatetruecolor($imageX, $imageY);

		//背景
        $bgcolor = mt_rand(0, 3);
		imagefill($im, 0, 0, imagecolorallocate($im, $this->bgcolors[$bgcolor][0], $this->bgcolors[$bgcolor][1], $this->bgcolors[$bgcolor][2]));
		
		//角度旋转写入
        $color = mt_rand(0, 2);
		$fontColor = imagecolorallocate($im, $this->colors[$color][0], $this->colors[$color][1], $this->colors[$color][2]);
        $font = mt_rand(0, 1);
		for($i=0; $i<strlen($string); $i++)
		{
			$angle = mt_rand(-$this->angle, $this->angle);	//角度随机
			$fontsize = mt_rand($font_size_min, $font_size_max);	//字体大小随机
			imagefttext ($im , $fontsize , $angle , $text_offset+$i*($width-$text_offset) , $text_y , $fontColor, $this->fonts[$font] , $string[$i]);
		}
		
		
		//扭曲
		$dstim = imagecreatetruecolor ($imageX , $imageY);       
		imagefill($dstim, 0, 0, imagecolorallocate($dstim,255,255,255) );
		
		$this->contort = mt_rand(1, $this->contort);
		$funcs = array('sin', 'cos');
		$func = $funcs[mt_rand(0, 1)];
		for ( $j=0; $j<$imageY; $j++) {
			$amend = round($func($j/$imageY*2*M_PI-M_PI*0.5) * $this->contort);
			for ( $i=0; $i<$imageX; $i++) {
				$rgb = imagecolorat($im, $i , $j);
				imagesetpixel($dstim, $i+$amend, $j, $rgb);
			}
		}
		
		//边框
        if (empty($options['no_border'])) {
            $border = imagecolorallocate($dstim, 133, 153, 193);
            imagerectangle($dstim, 0, 0, $imageX - 1, $imageY - 1, $border);
        }

        $binary === false && header("content-type:image/png\r\n");

        imagepng($dstim);
        imagedestroy($im);
        imagedestroy($dstim);

        if ($binary === true) {
            $this->image = ob_get_contents();
            ob_end_clean();
        }
	}
}