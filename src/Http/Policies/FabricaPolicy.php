<?php

namespace Fabrica\Http\Policies;

use App\Models\User;

/**
 * Class FabricaPolicy.
 *
 * @package Finder\Http\Policies
 */
class FabricaPolicy
{
    /**
     * Create a fabrica.
     *
     * @param  User   $authUser
     * @param  string $fabricaClass
     * @return bool
     */
    public function create(User $authUser, string $fabricaClass)
    {
        if ($authUser->toEntity()->isAdministrator()) {
            return true;
        }

        return false;
    }

    /**
     * Get a fabrica.
     *
     * @param  User  $authUser
     * @param  mixed $fabrica
     * @return bool
     */
    public function get(User $authUser, $fabrica)
    {
        return $this->hasAccessToFabrica($authUser, $fabrica);
    }

    /**
     * Determine if an authenticated user has access to a fabrica.
     *
     * @param  User $authUser
     * @param  $fabrica
     * @return bool
     */
    private function hasAccessToFabrica(User $authUser, $fabrica): bool
    {
        if ($authUser->toEntity()->isAdministrator()) {
            return true;
        }

        if ($fabrica instanceof User && $authUser->id === optional($fabrica)->id) {
            return true;
        }

        if ($authUser->id === optional($fabrica)->created_by_user_id) {
            return true;
        }

        return false;
    }

    /**
     * Update a fabrica.
     *
     * @param  User  $authUser
     * @param  mixed $fabrica
     * @return bool
     */
    public function update(User $authUser, $fabrica)
    {
        return $this->hasAccessToFabrica($authUser, $fabrica);
    }

    /**
     * Delete a fabrica.
     *
     * @param  User  $authUser
     * @param  mixed $fabrica
     * @return bool
     */
    public function delete(User $authUser, $fabrica)
    {
        return $this->hasAccessToFabrica($authUser, $fabrica);
    }
}
