<?php

declare(strict_types=1);

namespace App\Domain\Stablecoin\Repositories;

use App\Domain\Stablecoin\Snapshots\StablecoinSnapshot;
use Spatie\EventSourcing\AggregateRoots\Exceptions\InvalidEloquentStoredEventModel;
use Spatie\EventSourcing\Snapshots\EloquentSnapshot;
use Spatie\EventSourcing\Snapshots\EloquentSnapshotRepository;

final class StablecoinSnapshotRepository extends EloquentSnapshotRepository
{
    /**
     * @param string $snapshotModel
     *
     * @throws InvalidEloquentStoredEventModel
     */
    public function __construct(
        protected string $snapshotModel = StablecoinSnapshot::class
    )
    {
        if (! new $this->snapshotModel() instanceof EloquentSnapshot) {
            throw new InvalidEloquentStoredEventModel("The class {$this->snapshotModel} must extend EloquentSnapshot");
        }
    }
}