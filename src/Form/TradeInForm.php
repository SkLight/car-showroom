<?php declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Validator\Constraints as Assert;

final class TradeInForm
{
    /**
     * @Assert\NotBlank()
     */
    public ?int $clientId = null;

    /**
     * @Assert\NotBlank()
     */
    public ?string $brand = null;

    /**
     * @Assert\NotBlank()
     */
    public ?string $model = null;

    /**
     * @Assert\NotBlank()
     */
    public ?string $class = null;

    /**
     * @Assert\NotBlank()
     */
    public ?string $price = null;

    /**
     * @Assert\NotBlank()
     */
    public ?int $showroomId = null;
}
