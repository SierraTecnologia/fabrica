<?php
/**
 * 
 */

namespace Fabrica\Tasks;

use Fabrica\Tools\Databases\Mysql\Mysql as MysqlTool;
use Integrations\Models\Token;
use Integrations\Connectors\Sentry\Sentry;
use Integrations\Connectors\Jira\Jira;
use Integrations\Connectors\Gitlab\Gitlab;
use Log;
use Operador\Contracts\ActionInterface;

use Finder\Actions\Action as ActionBase;

class ImportFromToken extends ActionBase implements ActionInterface
{
    const CODE = 'importIntegrationToken';
    CONST MODEL = \Integrations\Models\Token::class;
    const TYPE = \Finder\Actions\Action::ROUTINE;
    
    protected $token = false;

    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    public function execute()
    {
        if (!$this->token->account || !$this->token->account->status) {
            dd($this->token);
            return false;
        }
        Log::channel('sitec-finder')->info('Tratando Token .. '.print_r($this->token, true));

        if ($this->token->account->integration_id == Sentry::getCodeForPrimaryKey()) {
            // (new \Integrations\Connectors\Sentry\Import($this->token))->bundle();
        } else if ($this->token->account->integration_id == Jira::getCodeForPrimaryKey()) {
            // (new \Integrations\Connectors\Jira\Import($this->token))->bundle();
        } else if ($this->token->account->integration_id == Gitlab::getCodeForPrimaryKey()) {
            (new \Integrations\Connectors\Gitlab\Import($this->token))->bundle();
        }

        return true;
    }
}
