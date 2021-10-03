<?php

/**
 * This file is part of Fabrica.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the GPL license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Fabrica\Bundle\JobBundle;

use Fabrica\Bundle\JobBundle\Hydrator\JobHydrator;
use Fabrica\Bundle\JobBundle\Job\Job;
use Fabrica\Bundle\JobBundle\Storage\StorageInterface;
use Symfony\Component\Console\Output\OutputInterface;

class JobManager
{
    private $storage;
    private $hydrator;
    private $currentJob;

    public function __construct(JobHydrator $hydrator, StorageInterface $storage)
    {
        $this->hydrator = $hydrator;
        $this->storage  = $storage;
    }

    public function stop(): void
    {
        if ($this->currentJob) {
            $this->storage->finish($this->currentJob->getId(), false, "Stopped");
        }

        $this->currentJob = null;
    }

    public function delegate(Job $job): Job
    {
        $name = $this->hydrator->getName(get_class($job));
        $id = $this->storage->store($name, $job->getParameters());

        $job->setId($id);

        return $job;
    }

    /**
     * @return int|string
     */
    public function getStatus($id)
    {
        return $this->storage->getStatus($id);
    }

    public function runBackground(OutputInterface $output, $pollInterval = 5, $iterations = 100): void
    {
        $output->writeln(sprintf('<comment>Job manager started (poll every %s seconds, %s iterations)</comment>', $pollInterval, $iterations));

        while ($iterations > 0) {
            $iterations--;
            $row = $this->storage->find();

            if (!$row) {
                $output->writeln(sprintf('<comment>- found no job to process... (%s iterations left)', $iterations));
                sleep($pollInterval);

                continue;
            }

            $this->currentJob = $this->hydrator->hydrateJob($row[1], $row[2]);
            $this->currentJob->setId($row[0]);

            try {
                $output->writeln(sprintf('- executing job <info>#%s</info> (%s iterations left)...', $this->currentJob->getId(), $iterations));
                $res = $this->currentJob->execute();
                $this->storage->finish($this->currentJob->getId(), true, $res);
                $output->writeln('  <info>OK</info> - job succeeded');
            } catch (\Exception $e) {
                $this->storage->finish($this->currentJob->getId(), false, $e->getMessage());
                $output->writeln(sprintf('  <error>KO</error> - error: %s', $e->getMessage()));
            }

            $this->currentJob = null;
        }

        $output->writeln('<comment>Job manager job finished</comment>');
    }
}
