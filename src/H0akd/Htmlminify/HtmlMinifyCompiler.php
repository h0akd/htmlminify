<?php

namespace H0akd\Htmlminify;

use Illuminate\View\Compilers\BladeCompiler;

class HtmlMinifyCompiler extends BladeCompiler {

    public function __construct($files, $cachePath) {
        parent::__construct($files, $cachePath);
        $this->compilers[] = 'Minify';
    }

    public function shouldMinify($value) {
        if (preg_match('/<(pre|textarea)/', $value) || preg_match('/<script[^\??>]*>[^<\/script>]/', $value) || preg_match('/value=("|\')(.*)([ ]{2,})(.*)("|\')/', $value)
        ) {
            return false;
        } else {
            return true;
        }
    }

    protected function compileMinify($value) {
        if ($this->shouldMinify($value)) {
            $replace = array(
                '/<!--[^\[](.*?)[^\]]-->/s' => '',
                "/<\?php/" => '<?php ',
                "/\n/" => '',
                "/\r/" => '',
                "/\t/" => ' ',
                "/ +/" => ' ',
            );
            return preg_replace(
                    array_keys($replace), array_values($replace), $value
            );
        } else {
            return $value;
        }
    }

}
