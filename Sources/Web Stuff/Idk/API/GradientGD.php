<?php
class gd_gradient_fill {
	
	// Constructor. Creates, fills and returns an image
	function gd_gradient_fill($w,$h,$d,$s,$e,$step=0) {
		$this->width = $w;
		$this->height = $h;
		$this->direction = $d;
		$this->startcolor = $s;
		$this->endcolor = $e;
		$this->step = intval(abs($step));

		// Attempt to create a blank image in true colors, or a new palette based image if this fails
		if (function_exists('imagecreatetruecolor')) {
			$this->image = imagecreatetruecolor($this->width,$this->height);
		} elseif (function_exists('imagecreate')) {
			$this->image = imagecreate($this->width,$this->height);
		} else {
			die('Unable to create an image');
		}
		
		// Fill it
		$this->fill($this->image,$this->direction,$this->startcolor,$this->endcolor);
		
		// Show it		
		$this->display($this->image);
		
		// Return it
		return $this->image;
	}
	function display ($im) {
		if (function_exists("imagepng")) {
			header("Content-type: image/png");
			imagepng($im);
		}
		elseif (function_exists("imagegif")) {
			header("Content-type: image/gif");
			imagegif($im);
		}
		elseif (function_exists("imagejpeg")) {
			header("Content-type: image/jpeg");
			imagejpeg($im, "", 0.5);
		}
		elseif (function_exists("imagewbmp")) {
			header("Content-type: image/vnd.wap.wbmp");
			imagewbmp($im);
		} else {
			die("Doh ! No graphical functions on this server ?");
		}
		return true;
	}
	function fill($im,$direction,$start,$end) {
		
		switch($direction) {
			case 'horizontal':
				$line_numbers = imagesx($im);
				$line_width = imagesy($im);
				list($r1,$g1,$b1) = $this->hex2rgb($start);
				list($r2,$g2,$b2) = $this->hex2rgb($end);
				break;
			case 'vertical':
				$line_numbers = imagesy($im);
				$line_width = imagesx($im);
				list($r1,$g1,$b1) = $this->hex2rgb($start);
				list($r2,$g2,$b2) = $this->hex2rgb($end);
				break;
			case 'ellipse':
				$width = imagesx($im);
				$height = imagesy($im);
				$rh=$height>$width?1:$width/$height;
				$rw=$width>$height?1:$height/$width;
				$line_numbers = min($width,$height);
				$center_x = $width/2;
				$center_y = $height/2;
				list($r1,$g1,$b1) = $this->hex2rgb($end);
				list($r2,$g2,$b2) = $this->hex2rgb($start);
				imagefill($im, 0, 0, imagecolorallocate( $im, $r1, $g1, $b1 ));
				break;
			case 'ellipse2':
				$width = imagesx($im);
				$height = imagesy($im);
				$rh=$height>$width?1:$width/$height;
				$rw=$width>$height?1:$height/$width;
				$line_numbers = sqrt(pow($width,2)+pow($height,2));
				$center_x = $width/2;
				$center_y = $height/2;
				list($r1,$g1,$b1) = $this->hex2rgb($end);
				list($r2,$g2,$b2) = $this->hex2rgb($start);
				break;
			case 'circle':
				$width = imagesx($im);
				$height = imagesy($im);
				$line_numbers = sqrt(pow($width,2)+pow($height,2));
				$center_x = $width/2;
				$center_y = $height/2;
				$rh = $rw = 1;
				list($r1,$g1,$b1) = $this->hex2rgb($end);
				list($r2,$g2,$b2) = $this->hex2rgb($start);
				break;
			case 'circle2':
				$width = imagesx($im);
				$height = imagesy($im);
				$line_numbers = min($width,$height);
				$center_x = $width/2;
				$center_y = $height/2;
				$rh = $rw = 1;
				list($r1,$g1,$b1) = $this->hex2rgb($end);
				list($r2,$g2,$b2) = $this->hex2rgb($start);
				imagefill($im, 0, 0, imagecolorallocate( $im, $r1, $g1, $b1 ));
				break;
			case 'square':
			case 'rectangle':
				$width = imagesx($im);
				$height = imagesy($im);
				$line_numbers = max($width,$height)/2;
				list($r1,$g1,$b1) = $this->hex2rgb($end);
				list($r2,$g2,$b2) = $this->hex2rgb($start);
				break;
			case 'diamond':
				list($r1,$g1,$b1) = $this->hex2rgb($end);
				list($r2,$g2,$b2) = $this->hex2rgb($start);
				$width = imagesx($im);
				$height = imagesy($im);
				$rh=$height>$width?1:$width/$height;
				$rw=$width>$height?1:$height/$width;
				$line_numbers = min($width,$height);
				break;
			default:
		}
		
		for ( $i = 0; $i < $line_numbers; $i=$i+1+$this->step ) {
			// old values :
			$old_r=$r;
			$old_g=$g;
			$old_b=$b;
			// new values :
			$r = ( $r2 - $r1 != 0 ) ? intval( $r1 + ( $r2 - $r1 ) * ( $i / $line_numbers ) ): $r1;
			$g = ( $g2 - $g1 != 0 ) ? intval( $g1 + ( $g2 - $g1 ) * ( $i / $line_numbers ) ): $g1;
			$b = ( $b2 - $b1 != 0 ) ? intval( $b1 + ( $b2 - $b1 ) * ( $i / $line_numbers ) ): $b1;
			if ( "$old_r,$old_g,$old_b" != "$r,$g,$b") 
				$fill = imagecolorallocate( $im, $r, $g, $b );
			switch($direction) {
				case 'vertical':
					imagefilledrectangle($im, 0, $i, $line_width, $i+$this->step, $fill);
					break;
				case 'horizontal':
					imagefilledrectangle( $im, $i, 0, $i+$this->step, $line_width, $fill );
					break;
				case 'ellipse':
				case 'ellipse2':
				case 'circle':
				case 'circle2':
					imagefilledellipse ($im,$center_x, $center_y, ($line_numbers-$i)*$rh, ($line_numbers-$i)*$rw,$fill);
					break;
				case 'square':
				case 'rectangle':
					imagefilledrectangle ($im,$i*$width/$height,$i*$height/$width,$width-($i*$width/$height), $height-($i*$height/$width),$fill);
					break;
				case 'diamond':
					imagefilledpolygon($im, array (
						$width/2, $i*$rw-0.5*$height,
						$i*$rh-0.5*$width, $height/2,
						$width/2,1.5*$height-$i*$rw,
						1.5*$width-$i*$rh, $height/2 ), 4, $fill);
					break;
				default:	
			}		
		}
	}
	function hex2rgb($color) {
		$color = str_replace('#','',$color);
		$s = strlen($color) / 3;
		$rgb[]=hexdec(str_repeat(substr($color,0,$s),2/$s));
		$rgb[]=hexdec(str_repeat(substr($color,$s,$s),2/$s));
		$rgb[]=hexdec(str_repeat(substr($color,2*$s,$s),2/$s));
		return $rgb;
	}
}
?>