<?php
// app/Services/NotificationUrlGenerator.php

namespace App\Services;

use Illuminate\Support\Facades\Route;

// use App\Services\NotificationUrlGenerator;

class NotificationUrlGenerator
{
    public function generateUrl($notificationId, $routeName, $routeParameters = [])
    {
        $url = route($routeName, $routeParameters);
        return $url . '?notification_id=' . $notificationId;
    }
}
