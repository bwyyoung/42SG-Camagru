<?php

namespace loader;

class Media
{
    public static function image_site_svg($filename) {
        $image    = WEB_ROOT.'/media/images-site/'.$filename.'.svg';
        return 'data:image/svg+xml;base64,'.base64_encode(file_get_contents($image));
    }
    public static function image_site_png($filename) {
        $image    = WEB_ROOT.'/media/images-site/'.$filename.'.png';
        return 'data:image/png;base64,'.base64_encode(file_get_contents($image));
    }
}