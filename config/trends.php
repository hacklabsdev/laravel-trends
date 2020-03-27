<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Energy Decay Time
    |--------------------------------------------------------------------------
    |
    | Defines how long your energy starts to decay in hours. The energy decays 
    | three times until it returns to 0. For example if value is set to 24 hours 
    | it would take 3 days to energy return to zero.
    |
    */
    'energy_decay' => env('TRENDS_DECAY_TIME', 24),

    /*
    |--------------------------------------------------------------------------
    | IP Blacklist
    |--------------------------------------------------------------------------
    |
    | Sometimes you may want to prevent an IP to add energy to a model.
    | You can add as many IPs as you want to.
    |
    */
    'ip_blacklist' => [
        // 
    ]

];