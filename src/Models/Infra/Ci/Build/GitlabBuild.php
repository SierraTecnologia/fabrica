<?php

namespace Fabrica\Models\Infra\Ci\Build;

/**
 * Gitlab Build Model
 *
 * @author André Cianfarani <a.cianfarani@c2is.fr>
 */
class GitlabBuild extends GitBuild
{
    /**
     * Get link to commit from another source (i.e. Github)
     *
     * @return string
     */
    public function getCommitLink()
    {
        if (is_null($this->getProject())) {
            return false;
        }
        
        $domain = $this->getProject()->getAccessInformation('domain');
        return '//' . $domain . '/' . $this->getProject()->getReference() . '/commit/' . $this->getCommitId();
    }

    /**
     * Get link to branch from another source (i.e. Github)
     *
     * @return string
     */
    public function getBranchLink()
    {
        if (is_null($this->getProject())) {
            return false;
        }
        
        $domain = $this->getProject()->getAccessInformation('domain');
        return '//' . $domain . '/' . $this->getProject()->getReference() . '/tree/' . $this->getBranch();
    }

    /**
     * Get link to specific file (and line) in a the repo's branch
     *
     * @return string|null
     */
    public function getFileLinkTemplate()
    {
        if (is_null($this->getProject())) {
            return false;
        }
        
        return sprintf(
            '//%s/%s/blob/%s/{FILE}#L{LINE}',
            $this->getProject()->getAccessInformation('domain'),
            $this->getProject()->getReference(),
            $this->getCommitId()
        );
    }

    /**
     * Get the URL to be used to clone this remote repository.
     */
    protected function getCloneUrl()
    {
        if (is_null($this->getProject())) {
            return false;
        }
        
        $key = trim($this->getProject()->getSshPrivateKey());

        $user   = $this->getProject()->getAccessInformation('user');
        $domain = $this->getProject()->getAccessInformation('domain');
        $port   = $this->getProject()->getAccessInformation('port');

        if (!empty($key)) {
            $url =  'ssh://' . $user . '@' . $domain;
        } else {
            $url = 'https://' . $domain;
        }

        if (!empty($port)) {
            $url .= ':' . $port;
        }

        return $url . '/' . $this->getProject()->getReference() . '.git';
    }
}
