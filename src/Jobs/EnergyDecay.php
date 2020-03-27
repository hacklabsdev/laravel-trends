<?php

namespace Hacklabs\Trends\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class EnergyDecay implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $entity;

    protected $amount;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($entity, $amount)
    {
        $this->entity = $entity;
        $this->amount = $amount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->entity->decayEnergy($this->amount);
    }
}
