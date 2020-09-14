<?php declare(strict_types=1);

namespace App\Entity\Traits;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait CreatedAtTrait
{
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private ?DateTimeImmutable $createdAt = null;

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getCreatedAtTimestamp(): int
    {
        return $this->createdAt ? $this->createdAt->getTimestamp() : 0;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist(): void
    {
        $this->createdAt ??= new DateTimeImmutable();
    }
}
