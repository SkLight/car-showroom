<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;

/**
 * @ORM\Entity
 * @ORM\Table(name="showroom", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="car_idx", columns={"car_id"})
 * })
 * @ORM\HasLifecycleCallbacks()
 */
class Showroom implements JsonSerializable
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Car", fetch="EAGER")
     */
    private Car $car;

    /**
     * @ORM\Column(type="integer")
     */
    private int $count;

    /**
     * @ORM\Column(type="bigint")
     */
    private int $price;

    /**
     * @ORM\Column(type="string")
     */
    private string $currency;

    public function __construct(Car $car, int $count, int $price, string $currency)
    {
        $this->car      = $car;
        $this->count    = $count;
        $this->price    = $price;
        $this->currency = $currency;
    }

    public function getCar(): Car
    {
        return $this->car;
    }

    public function setCar(Car $car): void
    {
        $this->car = $car;
    }

    public function decCount(): void
    {
        $this->count--;
    }

    public function getPrice(): Money
    {
        return new Money($this->price, new Currency($this->currency));
    }

    public function jsonSerialize()
    {
        $numberFormatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        $moneyFormatter  = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

        return [
            'id'    => $this->id,
            'car'   => $this->car,
            'count' => $this->count,
            'price' => $moneyFormatter->format($this->getPrice()),
        ];
    }
}
