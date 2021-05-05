<pre><?php                      
$css = '
#banner {
    background-image: url("http://alpha.brick-hill.com/winter-theme/snow_head.png");
}
body {
    background-image: url("http://alpha.brick-hill.com/winter-theme/snow.png'), url('http://alpha.brick-hill.com/assets/bkg.png");
    background-size: 25%, contain;
    background-repeat: repeat, repeat-y;
}
/*
#box {
	background-image: url("http://alpha.brick-hill.com/winter-theme/snow-box.png")
}
*/
#navbar {
	background-image: url("http://alpha.brick-hill.com/winter-theme/snow.png");
}
/* body {
    background-image: url("http://alpha.brick-hill.com/winter-theme/snow.png"), url("http://alpha.brick-hill.com/winter-theme/snow-foot.png"), url("http://alpha.brick-hill.com/assets/bkg.png")!important;
    background-size: 25%, 21% ,cover;
    background-repeat: repeat,repeat-x ,repeat-y;
    background-position: center, bottom, center;
}
*/
';
preg_match_all( '/(?ims)([a-z0-9\s\,\.\:#_\-@]+)\{([^\}]*)\}/', $css, $arr);

$result = array();
foreach ($arr[0] as $i => $x)
{
    $selector = trim($arr[1][$i]);
    $rules = explode(';', trim($arr[2][$i]));
    $result[$selector] = array();
    foreach ($rules as $strRule)
    {
        if (!empty($strRule))
        {
            $rule = explode(":", $strRule);
            $result[$selector][][trim($rule[0])] = trim($rule[1]);
        }
    }
}   

var_dump($result);
?></pre>