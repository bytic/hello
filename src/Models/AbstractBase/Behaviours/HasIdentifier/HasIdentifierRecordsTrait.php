<?php

declare(strict_types=1);

namespace ByTIC\Hello\Models\AbstractBase\Behaviours\HasIdentifier;

use Nip\Records\Record;

/**
 *
 */
trait HasIdentifierRecordsTrait
{
    /**
     * @param $record
     * @return Record|false|null
     * @throws \Exception
     */
    public function findByIdentifierOrFail($record): Record|null|false
    {
        $record = $this->findOneByField('identifier', $record);
        if (!$record) {
            throw new \Exception('No record find with provided identifier');
        }
        return $record;
    }
}