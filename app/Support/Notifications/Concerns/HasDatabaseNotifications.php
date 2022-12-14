<?php

namespace App\Support\Notifications\Concerns;

use App\Support\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Query\Builder;

trait HasDatabaseNotifications
{
    /**
     * Get the entity's notifications.
     *
     * @return MorphMany
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->latest();
    }

    /**
     * Get the entity's read notifications.
     *
     * @return Builder
     */
    public function readNotifications(): Builder
    {
        return $this->notifications()->read();
    }

    /**
     * Get the entity's unread notifications.
     *
     * @return Builder
     */
    public function unreadNotifications(): Builder
    {
        return $this->notifications()->unread();
    }
}
