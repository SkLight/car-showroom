<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="'transaction'")
 * @ORM\HasLifecycleCallbacks()
 */
class Transaction
{
    use CreatedAtTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client")
     */
    private Client $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Car")
     */
    private Car $tradeInCar;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Car")
     */
    private Car $newCar;

    /**
     * @ORM\Column(type="bigint")
     */
    private int $price;

    /**
     * @ORM\Column(type="string")
     */
    private string $currency;

    public function __construct(Client $client, Car $tradeInCar, Car $newCar, int $price, string $currency)
    {
        $this->client     = $client;
        $this->tradeInCar = $tradeInCar;
        $this->newCar     = $newCar;
        $this->price      = $price;
        $this->currency   = $currency;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
