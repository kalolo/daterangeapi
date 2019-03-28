<?php

namespace App\Controllers;

use App\Repository\PriceRangeRepository;
use App\Entities\DateRangeEntity;
use App\DateRangeHelper;


class ApiController {

    private $request;

    public function __construct($request)
    {
        $request = $request;

    }

    private function json_response($data, $status=200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function index()
    {
        $records = PriceRangeRepository::getAll();
        return $this->json_response($records);
    }

    public function store()
    {
        $payload = file_get_contents("php://input");
        if ($payload = json_decode($payload)) {

            if ($payload->start >= $payload->end) return $this->json_response('Invalid date range', 500);
            
            $merged = DateRangeHelper::merge(PriceRangeRepository::getAll(), DateRangeEntity::build($payload));
            PriceRangeRepository::deleteAll();
            PriceRangeRepository::insertAll($merged);
        }

        return $this->json_response([
            $merged
         ]);
    }

    public function deleteAll()
    {
        PriceRangeRepository::deleteAll();
        return $this->json_response('Records deleted');
    }
}