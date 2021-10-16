<?php

namespace Hacklabs\Trends\Traits;

use Illuminate\Http\Request;
use Hacklabs\Trends\Jobs\EnergyDecay;
use Hacklabs\Trends\Models\Energy;
use Illuminate\Support\Facades\DB;

trait HasEnergy 
{
    public function addEnergy($amount = 1) {
        if(!$this->energy) {
            $this->createEnergy();
        }
        $entity = $this->fresh();
        if(!in_array(request()->ip(), config('trends.ip_blacklist'))) {
            $this->energy()->update([
                'amount' => $entity->energy->amount += $amount
            ]);
            EnergyDecay::dispatch($entity, 0.25 * $amount)->delay(now()->addHours(config('trends.energy_decay')));
            EnergyDecay::dispatch($entity, 0.45 * $amount)->delay(now()->addHours(config('trends.energy_decay') * 2));
            EnergyDecay::dispatch($entity, 0.30 * $amount)->delay(now()->addHours(config('trends.energy_decay') * 3));
        }
    }

    public function energy() {
        return $this->morphOne(Energy::class, 'energisable');
    }

    public function getEnergyAmountAttribute() {
        return ($this->energy) ? (float) $this->energy->amount : 0;
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
