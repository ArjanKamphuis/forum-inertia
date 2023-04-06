<?php

namespace App\Models\Traits;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use ReflectionClass;

trait RecordsActivity
{
    protected static function bootRecordsActivity(): void
    {
        foreach (static::getActivitiesToRecord() as $activity) {
            static::$activity(function (Model $model) use ($activity) {
                $model->recordActivity($activity);
            });
        }

        static::deleting(function(Model $model) {
            $model->activity()->delete();
        });
    }

    protected static function getActivitiesToRecord(): array
    {
        return ['created'];
    }

    public function activity(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    protected function recordActivity(string $event): void
    {
        $this->activity()->create([
            'type' => $this->getActivityType($event),
            'user_id' => $this->user_id
        ]);
    }

    protected function getActivityType(string $event): string
    {
        $type = strtolower((new ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }
}
