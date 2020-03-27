<?php

namespace Hacklabs\Trends\Traits;

use Hacklabs\Trends\Jobs\EnergyDecay;
use Hacklabs\Trends\Models\Energy;
use Illuminate\Support\Facades\DB;

trait HasEnergy {

    protected $decayTime = '24';

    protected $ipBlacklist = [];

    public function addEnergy($amount = 1) {
        $this->energy()->updateOrCreate([
            'amount' => DB::raw("amount += {$amount} ")
        ]);
        EnergyDecay::dispatch($this, 0.25)->delay(now()->addHours($this->decayTime));
        EnergyDecay::dispatch($this, 0.45)->delay(now()->addHours($this->decayTime * 2));
        EnergyDecay::dispatch($this, 0.30)->delay(now()->addHours($this->decayTime * 3));
        return $this->energy;
    }

    public function energy() {
        return $this->morphOne(Energy::class, 'energisable');
    }

    public function decayEnergy($amount) {
        $this->energy()->update([
            'amount' => DB::raw("amount -= {$amount}")
        ]);
    }

    public function getEntityName() {
        return str_slug(get_class($this).' '.$this->id);
    }
}
