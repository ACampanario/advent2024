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

namespace App\View;

use Cake\View\View;

/**
 * Renders view with provided view vars
 */
class ViteView extends View
{
    public function initialize(): void
    {
        $this->loadHelper('Vite');
    }
}
