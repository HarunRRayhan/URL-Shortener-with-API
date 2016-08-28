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

use Shorty\Models\Link;
use Shorty\Presenters\ErrorPresenter;
use Shorty\Presenters\LinkPresenter;

$app->post('/api/generate', function() use ($app) {
    $payload = json_decode($app->request->getBody());
    
    if(empty($payload) || empty(trim($payload->url))) {
        $app->response->setStatus(400);
        
        return $app->response->write(
                new ErrorPresenter(1000, 'A URL is Required')
                );
    }
    
    if(!filter_var($payload->url, FILTER_VALIDATE_URL)){
       $app->response->setStatus(400);
        
        return $app->response->write(
                new ErrorPresenter(1001, 'A valid URL is Required')
        ); 
    }
    
    $link = Link::where('url', $payload->url)->first();
    
    if($link){
        // Return Current code
        $app->response->setStatus(201);
        
        return $app->response->write(
                new LinkPresenter($link)
         );
    }
    
    $newLink = Link::create([
        'url' => $payload->url,
        'code' => 'NULL'
        //'updated_at' => 'NOW()'
    ]);
    
    $newLink->update([
        'code' => $newLink->generateShortCode()
    ]);
    
    $app->response->setStatus(201);
    
    return $app->response->write(
         new LinkPresenter($newLink)   
    );
});