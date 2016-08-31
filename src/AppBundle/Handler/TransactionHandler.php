<?php
namespace AppBundle\Handler;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TransactionHandler
 * @package AppBundle\Handler
 */
class TransactionHandler
{

    /**
     * @var ContainerInterface
     */
    private $serviceContainer;

    /**
     * @var \AppBundle\Repository\TransactionRepository
     */
    private $repo;

    /**
     * TransactionHandler constructor.
     * @param ContainerInterface $serviceContainer
     */
    public function __construct($serviceContainer)
    {

        $this->serviceContainer = $serviceContainer;
        $em = $this->serviceContainer->get('doctrine.orm.entity_manager');
        $this->repo = $em->getRepository('AppBundle:Transaction');
    }

    /**
     * @param Request $request
     * @param array   $options
     * @return JsonResponse
     */
    public function getAllTransactions(Request $request, $options = [])
    {
        switch ($options['sortBy']) {
            case 2:
                $options['sortBy'] = 'transaction.amount';
                break;
            default:
                $options['sortBy'] = 'transaction.date';
                break;
        }

        $count = $this->repo->getCount([]);
        $countFiltered = $this->repo->getCount(['text' => $options['text']]);
        $transactions  = $this->repo->getAll($options);

        $dataTableValues = [];
        foreach ($transactions as $transaction) {
            $date = $transaction->getDate();
            $category = $transaction->getCategory();
            $description = $transaction->getDescription();
            $amount = $transaction->getAmount();
            $amount = ($transaction->getType() == 'payment') ? $amount*(-1) : $amount;
            $dataTableValues[] = [
                $date,
                $category,
                $description,
                $amount,
            ];
        }

        return $this->returnJsonForDT($request, $dataTableValues, $count, $countFiltered);
    }

    /**
     * @param $request
     * @param array $dataTableValues
     * @param int $totalCount
     * @param int $filteredCount
     * @return JsonResponse
     */
    private function returnJsonForDT($request, $dataTableValues = [], $totalCount = 0, $filteredCount = 0)
    {
        $json = [];
        $json['sEcho'] =  $request->get('sEcho', 0);
        $json['aaData'] = $dataTableValues;
        $json['iTotalRecords'] =  $totalCount;
        $json['iTotalDisplayRecords'] = $filteredCount;

        return new JsonResponse($json);
    }

}
