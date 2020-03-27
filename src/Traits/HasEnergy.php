<?php

namespace Hacklabs\Trends\Traits;

use Illuminate\Http\Request;
use Hacklabs\Trends\Jobs\EnergyDecay;
use Hacklabs\Trends\Models\Energy;
use Illuminate\Support\Facades\DB;

trait HasEnergy {

    public function addEnergy($amount = 1) {
        if(!$this->energy) {
            $this->createEnergy();
        }
        if(!in_array(request()->ip(), config('trends.ip_blacklist'))) {
            $this->energy()->update([
                'amount' => $this->energy->amount += $amount
            ]);
            EnergyDecay::dispatch($this, 0.25)->delay(now()->addHours(config('trends.energy_decay')));
            EnergyDecay::dispatch($this, 0.45)->delay(now()->addHours(config('trends.energy_decay') * 2));
            EnergyDecay::dispatch($this, 0.30)->delay(now()->addHours(config('trends.energy_decay') * 3));
        }
        return $this->energy;
    }

    public function energy() {
        return $this->morphOne(Energy::class, 'energisable');
    }

    public function getEnergyAmountAttribute() {
        return (float) $this->energy->amount;
    }

    public function decayEnergy($amount) {
        $this->energy()->update([
            'amount' => $this->energy->amount -= $amount
        ]);
    }

    public function getEntityName() {
        return str_slug(get_class($this).' '.$this->id);
    }

    public function createEnergy() {
        return $this->energy()->create([
            'amount' => 0
        ]);
    }
}
