<?php

namespace App\Traits;

trait NotificationTrait
{
    public function notify(?string $type = 'success', ?string $header, string $body)
    {
        session()->flash('notify', [
            'type' => $type,
            'header' => $header,
            'body' => $body,
        ]);
    }
}
