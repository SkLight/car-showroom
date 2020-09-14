<?php declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="client")
 * @ORM\HasLifecycleCallbacks()
 */
class Client
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
    private string $lastName;

    /**
     * @ORM\Column(type="string")
     */
    private string $firstName;

    public function __construct(string $lastName, string $firstName)
    {
        $this->lastName  = $lastName;
        $this->firstName = $firstName;
    }
}
