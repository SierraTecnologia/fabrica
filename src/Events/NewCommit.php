<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Fabrica\Events;

use Fabrica\Models\Code\Commit;
use Fabrica\Models\Infra\Pipeline;

class NewCommit
{
    public function __construct(Commit $commit)
    {

        // $pipeline = Pipeline::create([

        // ]);

        // Analisa o Commit

        $analyser = $commit;
    }
}
