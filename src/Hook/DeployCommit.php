<?php
/**
 * Estatisticas Rodadas Diariamente
 */

namespace Fabrica\Hook;

use Operador\Actions\Action;
use Operador\Actions\ActionCollection;

use Finder\Models\Code\Commit;

class DeployCommit extends ActionCollection
{

    /**
     * Avisa se precisa de Alvos Externos ou nao e descreve eles
     */
    public $externalTargetCounts = 1;
    
    /**
     * Avisa se precisa de Alvos Externos ou nao e descreve eles
     */
    public $externalTargetZeroClass = Commit::class;
    
    /**
     * Avisa se precisa de Alvos Externos ou nao e descreve eles
     */
    public $externalTargetZeroInstance = false;

    public function prepare()
    {
        if ($this->isPrepared) {
            return true;
        }

        $this->prepareAction();

        return parent::prepare();
    }

    public function execute()
    {
        if (!$this->hasTargets()) {
            return false;
        }

        return parent::execute();
    }

    public function prepareTargets(Commit $sshKey): void
    {
        $externalTargetZeroClass = $sshKey;
    }

    public function hasTargets(): bool
    {
        if ($this->externalTargetZeroInstance === false) {
            return false;
        }
        return true;
    }
    
    public function prepareAction(): void
    {
        $stage = 0;
        $action = Action::getActionByCode('updateBusinessAmbiente');
        $this->newAction($action, $stage, 0);
    }

}
