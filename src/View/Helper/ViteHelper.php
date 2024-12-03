<?php
/*
 *  Copyright 2010 - 2024, Cake Development Corporation (https://www.cakedc.com)
 *
 *  Licensed under The MIT License
 *  Redistributions of files must retain the above copyright notice.
 *
 *  @copyright Copyright 2010 - 2024, Cake Development Corporation (https://www.cakedc.com)
 *  @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

declare(strict_types=1);

namespace App\View\Helper;

use Cake\Routing\Router;
use Cake\View\Helper;

/**
 * helpers
 * @property \App\View\Helper\HtmlHelper $Html
 * @property \Cake\View\Helper\FormHelper $Form
 * /

/**
 * Vite helper
 */
class ViteHelper extends Helper
{
    public array $helpers = ['Html'];

    public function loadAssets(): string
    {
       if (!file_exists(WWW_ROOT . 'hot')) {
           $manifest = json_decode(
               file_get_contents(WWW_ROOT . 'js' . DS . 'manifest.json'),
               true
           );
           $path = Router::fullBaseUrl() . DS . 'js' . DS;
           $firstBlock = [];
           $secondBlock = [];
           foreach($manifest as $key => $data){
               $part = explode('.', $key);
               $part = $part[count($part) - 1];
               if ($part == 'css') {
                   $firstBlock[] = $this->Html->tag(
                       'link',
                       '',
                       ['as' => 'style', 'rel' => 'preload', 'href' => $path . $data['file']]
                   );
                   $secondBlock[] = $this->Html->tag(
                       'link',
                       '',
                       ['as' => 'style', 'rel' => 'stylesheet', 'href' => $path . $data['file']]
                   );
               }
               if ($part == 'js') {
                   $firstBlock[] = $this->Html->tag(
                       'link',
                       '',
                       ['as' => 'style', 'rel' => 'preload', 'href' => $path . $data['css'][0]]
                   );
                   $secondBlock[] = $this->Html->tag(
                       'link',
                       '',
                       ['as' => 'style', 'rel' => 'stylesheet', 'href' => $path . $data['css'][0]]
                   );
                   $firstBlock[] = $this->Html->tag(
                       'link',
                       '',
                       ['rel' => 'modulepreload', 'href' => $path . $data['file']]
                   );
                   $secondBlock[] = $this->Html->tag(
                       'script',
                       '',
                       ['type' => 'module', 'src' => $path . $data['file']]
                   );
               }
           }

           return implode('', $firstBlock) . implode('', $secondBlock);
       } else {
           $domain = file_get_contents(WWW_ROOT . 'hot');
           $head = $this->Html->script($domain . '/@vite/client', ['rel' => 'preload', 'type' => 'module']);
           $head .= $this->Html->css($domain . '/resources/css/app.css');
           $head .= $this->Html->script($domain . '/resources/js/app.js', ['rel' => 'preload', 'type' => 'module']);

           return $head;
       }
    }
}
