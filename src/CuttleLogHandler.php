<?php

namespace Cuttle;

use Monolog\Handler\HandlerInterface;

class CuttleLogHandler implements HandlerInterface
{
    /**
     * Handle the event
     *
     * @param array $record
     * @return boolean
     */
    public function handle(array $record): bool
    {
        if (isset($record['context'])) {
            if (isset($record['context']['exception'])) {
                $event = new Cuttle($record);
                $event->report();
            }
        }

        return true;
    }

    /**
     * Handle a batch log.
     *
     * @param array $records
     * @return void
     */
    public function handleBatch(array $records): void
    {
        return;
    }

    /**
     * Ends a log cycle and frees all resources used by the handler.
     *
     * @return void
     */
    public function close(): void
    {
        return;
    }

    /**
     * Checks whether the given record will be handled by this handler.
     *
     * @param array $record
     * @return boolean
     */
    public function isHandling(array $record): bool
    {
        return true;
    }
}
