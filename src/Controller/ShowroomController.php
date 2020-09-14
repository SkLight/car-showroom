<?php declare(strict_types=1);

namespace App\Controller;

use App\Form\TradeInForm;
use App\Form\Traits\FormErrorsTrait;
use App\Form\Type\TradeInType;
use App\Manager\ShowroomManager;
use App\Repository\ShowroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShowroomController extends AbstractController
{
    use FormErrorsTrait;

    /**
     * @Route("/showroom/{brand}", name="showroom_index")
     *
     * @param ShowroomRepository $showroomRepository
     * @param string|null $brand
     *
     * @return JsonResponse
     */
    public function index(ShowroomRepository $showroomRepository, string $brand): JsonResponse
    {
        return new JsonResponse($showroomRepository->findAllByBrand($brand));
    }

    /**
     * @Route("/trade-in", name="showroom_trade_in")
     *
     * @param Request $request
     * @param ShowroomManager $showroomManager
     *
     * @return JsonResponse
     */
    public function tradeIn(Request $request, ShowroomManager $showroomManager): JsonResponse
    {
        $tradeInForm = new TradeInForm();

        $form = $this->createForm(TradeInType::class, $tradeInForm);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $answer = ['success' => false, 'errors' => $this->getFormErrors($form)];
            return new JsonResponse($answer, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $transactionId = $showroomManager->tradeIn($tradeInForm);

        return new JsonResponse(['success' => (bool)$transactionId, 'transactionId' => $transactionId]);
    }
}
