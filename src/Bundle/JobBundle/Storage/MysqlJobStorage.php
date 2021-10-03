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

namespace Fabrica\Bundle\JobBundle\Storage;

use Doctrine\DBAL\Connection;

class MysqlJobStorage implements StorageInterface
{
    const TABLE_CREATE = 'CREATE TABLE %s (
        id          INTEGER     NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name        VARCHAR(32) NOT NULL,
        parameters  TEXT        NOT NULL,
        created_at  DATETIME    NOT NULL,
        fails       TINYINT     NOT NULL DEFAULT 0,
        locked      TINYINT     NOT NULL DEFAULT 0,
        message     TEXT        NULL
    );';

    /**
     * @var Connection
     */
    protected $connection;
    protected $tableName;

    public function __construct(Connection $connection, $tableName = '_jobs')
    {
        $this->connection = $connection;
        $this->tableName  = $tableName;
    }

    public function store($name, array $parameters): string
    {
        $this->runSql(
            sprintf('INSERT INTO %s (name, parameters, created_at) VALUES (:name, :parameters, NOW())', $this->tableName), array(
            'name'       => $name,
            'parameters' => json_encode($parameters),
            )
        );

        return $this->connection->lastInsertId();
    }

    /**
     * {@inheritdoc}
     *
     * @return (bool|int|mixed|null)[]
     *
     * @psalm-return array{finished: bool, running: false|int, fails: int, error_message: mixed|null}
     */
    public function getStatus($id): array
    {
        $stmt = $this->runSql(
            sprintf('SELECT fails, locked, message FROM %s WHERE id = :id', $this->tableName), array(
            'id' => $id
            )
        );

        $status = array(
            'finished'      => false,
            'running'       => false,
            'fails'         => 0,
            'error_message' => null
        );

        if (!$row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $status['finished'] = true;

            return $status;
        }

        $status['fails']         = (int) $row['fails'];
        $status['running']       = (int) $row['locked'];
        $status['error_message'] = $row['message'];

        return $status;
    }

    /**
     * @return array|null
     *
     * @psalm-return array{0: mixed, 1: mixed, 2: mixed}|null
     */
    public function find()
    {
        $stmt = $this->runSql(sprintf('SELECT id, name, parameters FROM %s WHERE locked = 0 AND fails < 10 ORDER BY created_at ASC', $this->tableName));

        if (!$row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return null;
        }

        $this->runSql(sprintf('UPDATE %s SET locked = 1 WHERE id = :id', $this->tableName), array('id' => $row['id']));

        return array($row['id'], $row['name'], json_decode($row['parameters'], true));
    }

    /**
     * @return void
     */
    public function finish($id, $success, $message)
    {
        if ($success) {
            $this->runSql(sprintf('DELETE FROM %s WHERE id = :id', $this->tableName), array('id' => $id));
        }

        $this->runSql(
            sprintf('UPDATE %s SET locked = 0, message = :message, fails = fails + 1 WHERE id = :id', $this->tableName), array(
            'message' => $message,
            'id'      => $id
            )
        );
    }

    /**
     * Proxy method to connection object. If an error occurred because of unfound table, tries to create table and rerun request.
     *
     * @param string $query      SQL query
     * @param array  $parameters query parameters
     *
     * @return \Doctrine\DBAL\Result
     */
    protected function runSQL($query, array $parameters = array()): \Doctrine\DBAL\Result
    {
        try {
            return $this->connection->executeQuery($query, $parameters);
        } catch (\Exception $e) {
            $this->connection->executeQuery(sprintf(self::TABLE_CREATE, $this->tableName));
        }

        return $this->connection->executeQuery($query, $parameters);
    }
}
