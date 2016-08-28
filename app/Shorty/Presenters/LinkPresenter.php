<?php

/* 
 * Copyright (C) 2016 Harun R Rayhan
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Shorty\Presenters;

use Slim\Slim;
use Shorty\Models\Link;

class LinkPresenter extends BasePresenter{
    protected $link;
    
    public function __construct(Link $link) {
        $this->link = $link;
    }
    
    public function __toString() {
        return $this->encodeOutput([
             'url' => $this->link->url,
            'generated' => [
                'url' => Slim::getInstance()->config('baseUrl').'/'.$this->link->code,
                'code' => $this->link->code
            ]
        ]);
    }
}