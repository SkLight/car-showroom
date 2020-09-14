<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Table(name="car")
 * @ORM\HasLifecycleCallbacks()
 */
class Car implements JsonSerializable
{
    use CreatedAtTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $brand;

    /**
     * @ORM\Column(type="string")
     */
    private string $model;

    /**
     * @ORM\Column(type="string")
     */
    private string $class;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $new;

    public function __construct(string $brand, string $model, string $class, bool $new = true)
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->class = $class;
        $this->new   = $new;
    }

    public function jsonSerialize()
    {
        return [
            'brand'     => $this->brand,
            'model'     => $this->model,
            'class'     => $this->class,
            'createdAt' => $this->createdAt,
        ];
    }
}
