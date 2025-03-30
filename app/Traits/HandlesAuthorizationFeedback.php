<?php

namespace App\Traits;

use Illuminate\Auth\Access\AuthorizationException;

trait HandlesAuthorizationFeedback
{
    public bool $showAuthorizationModal = false;

    public function authorizeWithMessage(string $ability, $arguments = []): bool
    {
        try {
            $this->authorize($ability, $arguments);

            return true;
        } catch (AuthorizationException $e) {
            if (property_exists($this, 'showAuthorizationModal')) {
                $this->showAuthorizationModal = true;
            }

            return false;
        }
    }
}
