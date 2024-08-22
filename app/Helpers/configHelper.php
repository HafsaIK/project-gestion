<?php

namespace App\Helpers;

use App\Models\Configuration;

class configHelper {

    public static function getAppName(){
        
        $appName = Configuration::where("type","APP_NAME")->value('value');
        return $appName;
    }
}

