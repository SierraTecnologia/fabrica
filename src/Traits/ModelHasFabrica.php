<?php

namespace Fabrica\Traits;

trait ModelHasFabrica
{
    /**
     * Join a fabrica
     *
     * @param  integer $fabricaId
     * @param  integer $userId
     * @return void
     */
    public function joinFabrica($fabricaId, $userId)
    {
        $fabrica = $this->fabrica->find($fabricaId);
        $user = $this->model->find($userId);

        $user->fabrica()->attach($fabrica);
    }

    /**
     * Leave a fabrica
     *
     * @param  integer $fabricaId
     * @param  integer $userId
     * @return void
     */
    public function leaveFabrica($fabricaId, $userId)
    {
        $fabrica = $this->fabrica->find($fabricaId);
        $user = $this->model->find($userId);

        $user->fabrica()->detach($fabrica);
    }

    /**
     * Leave all fabrica
     *
     * @param  integer $fabricaId
     * @param  integer $userId
     * @return void
     */
    public function leaveAllFabrica($userId)
    {
        $user = $this->model->find($userId);
        $user->fabrica()->detach();
    }
}
