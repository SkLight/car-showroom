<?php declare(strict_types=1);

namespace App\Manager;

use App\Entity\Car;
use App\Entity\Transaction;
use App\Form\TradeInForm;
use App\Repository\ClientRepository;
use App\Repository\ShowroomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Money\Currencies\ISOCurrencies;
use Money\Money;
use Money\Parser\IntlMoneyParser;
use NumberFormatter;
use RuntimeException;

final class ShowroomManager
{
    private EntityManagerInterface $entityManager;
    private ClientRepository $clientRepository;
    private ShowroomRepository $showroomRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ClientRepository $clientRepository,
        ShowroomRepository $showroomRepository
    ) {
        $this->entityManager    = $entityManager;
        $this->clientRepository = $clientRepository;
        $this->showroomRepository    = $showroomRepository;
    }

    private function stringToMoney(string $str): Money
    {
        $currencies = new ISOCurrencies();

        $numberFormatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        $moneyParser = new IntlMoneyParser($numberFormatter, $currencies);

        return $moneyParser->parse($str);
    }

    public function tradeIn(TradeInForm $form): ?int
    {
        $tradeInCar = new Car($form->brand, $form->model, $form->class, false);

        if (!$client = $this->clientRepository->findOneById($form->clientId)) {
            throw new RuntimeException('Client not found');
        }

        if (!$showroom = $this->showroomRepository->findOneExistById($form->showroomId)) {
            throw new RuntimeException('Showroom not found');
        }

        $tradeInCarPrice = $this->stringToMoney($form->price);
        $showroomPrice   = $showroom->getPrice();

        if (!$tradeInCarPrice->getCurrency()->equals($showroomPrice->getCurrency())) {
            throw new RuntimeException('Currencies must be identical');
        }

        $differencePrice = $showroomPrice->subtract($tradeInCarPrice);

        if ($differencePrice->isNegative()) {
            throw new RuntimeException('Old car price is over then new car price');
        }

        $transaction = new Transaction($client, $tradeInCar, $showroom->getCar(), (int)$differencePrice->getAmount(), $differencePrice->getCurrency()->getCode());

        $showroom->decCount();

        $this->entityManager->beginTransaction();

        try {
            $this->entityManager->persist($tradeInCar);
            $this->entityManager->persist($transaction);
            $this->entityManager->persist($showroom);

            $this->entityManager->flush();
            $this->entityManager->commit();

            return $transaction->getId();
        } catch (Exception $exception) {
            $this->entityManager->rollback();

            return null;
        }
    }
}
