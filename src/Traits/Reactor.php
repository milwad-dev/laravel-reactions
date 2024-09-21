<?php

namespace Binafy\LaravelReactions\Traits;

use App\Models\Reaction;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;

trait Reactor
{
    use HasRelationships;

    /**
     * React to reactable.
     */
    public function react(string $type, $reactable): Reaction
    {
        $userForeignName = config('laravel-relations.user.foreign_key', 'user_id');

        $react = $reactable->reactions()
            ->where([
                $userForeignName => $this->getKey(),
                'type' => $type,
                'reactable_id' => $reactable->getKey(),
                'reactable_type' => $reactable::class,
            ])->first();

        if (! $react) {
            return $this->storeReact($type, $reactable);
        }

        return $react;
    }
}
