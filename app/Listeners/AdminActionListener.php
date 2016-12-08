<?php

namespace App\Listeners;

use App\Events\AdminActionEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class AdminActionListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AdminActionEvent  $event
     * @return void
     */
    public function handle(AdminActionEvent $event)
    {
        $str = '管理员:' . $event->adminName . '(id:' . $event->uid . ')' . '-ip('. \Request::ip().')' .$event->content;

        Log::info($str);
    }
}
