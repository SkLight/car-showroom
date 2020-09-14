<?php declare(strict_types=1);

namespace App\Entity\Traits;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait TimestampableTrait
{
    /**
     * @ORM\Column(name="created_at", type="datetime_immutable")
     */
    private ?DateTimeImmutable $createdAt = null;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private ?DateTime $updatedAt = null;

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAtTimestamp(): int
    {
        return $this->createdAt ? $this->createdAt->getTimestamp() : 0;
    }

    public function getUpdatedAtTimestamp(): int
    {
        return $this->updatedAt ? $this->updatedAt->getTimestamp() : 0;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist(): void
    {
        $this->createdAt ??= new DateTimeImmutable();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate(): void
    {
        $this->updatedAt = new DateTime();
    }
}
