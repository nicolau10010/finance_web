<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AjaxController
 * @package AppBundle\Controller
 */
class TransactionController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/ajax/data.json", name="ajax_list")
     * @Method({"GET"})
     */
    public function ajaxAction(Request $request)
    {
        $text = $request->get('sSearch', '');
        $offset = $request->get('iDisplayStart');
        $limit = $request->get('iDisplayLength');
        $sortBy = $request->get('iSortCol_0', 0);
        $sortOrder = $request->get('sSortDir_0', 0);
        $table = $request->query->get('tableId');

        switch ($table) {
            case 'transactionsTable':
                $handler = $this->get('transaction_handler');

                return $handler->getAllTransactions(
                    $request,
                    [
                        'text' => $text,
                        'offset' => $offset,
                        'limit' => $limit,
                        'sortBy' => $sortBy,
                        'sortOrder' => $sortOrder,
                    ]
                );
                break;
            default:
                return new JsonResponse(['message' => 'Table id not found'], JsonResponse::HTTP_NOT_FOUND);
                break;
        }
    }
}
