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

namespace App\Traits;

use App\View\ViteView;
use Cake\Event\EventInterface;

trait ViteResponseTrait
{
    /**
     * @inheritDoc
     */
    public function beforeRender(EventInterface $event)
    {
        $this->viewBuilder()->setClassName(ViteView::class);
    }
}
