<?php

namespace EliaPc\CptManager;

use EliaPc\CptManager\Api\Actions;
use EliaPc\CptManager\Base\AddCustomPostTypes;
use EliaPc\CptManager\Base\AddCustomTaxonomies;
use EliaPc\CptManager\Pages\Dashboard;
use EliaPc\CptManager\Pages\taxDashboard;
use EliaPc\CptManager\Base\Enqueue;

final class CptManagerInit{
    public static function get_services():array{
        return [
            Dashboard::class,
            TaxDashboard::class,
            Enqueue::class,
            Actions::class,
            AddCustomPostTypes::class,
            //AddCustomTaxonomies::class
        ];
    }

    public static function register_services():void{
        foreach (self::get_services() as $class){
            $service = new $class;
            if (method_exists($service , 'register')){
                $service->register();
            }
        }
    }
}









