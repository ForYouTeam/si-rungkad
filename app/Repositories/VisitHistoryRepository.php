<?php

namespace App\Repositories;

use App\Interfaces\VisitHistoryInterfaces;
use App\Models\History;
use App\Models\visit_history;

class VisitHistoryRepository implements VisitHistoryInterfaces
{
  private History $historyModel;
  public function __construct(History $historyModel)
  {
    $this->historyModel = $historyModel;
  }

  public function getAllPayload(array $params)
  {
    try {
      $payloadList = $this->historyModel->getHistoryByVisit()->get();
      $responseJson = array(
        'code'    => 200,
        'message' => 'success get data',
        'data'    => $payloadList,
        'meta'    => [
          'total' => $payloadList->count()
        ]
      );
    } catch (\Exception $th) {
      $responseJson = array(
        'code'    => 500,
        'message' => $th->getMessage(),
        'meta'    => [
          'function' => 'VisitHistoryRepository - getAllPayload'
        ]
      );
    }
    return $responseJson;
  }

  public function getPayloadById(int $idPayload)
  {
    try {

      $whereData = $this->historyModel->where('visit_id', $idPayload)->get();

      if ($whereData) {
        $responseJson = array(
          'code'    => 200,
          'message' => 'success get data',
          'data'    => $whereData
        );
      } else {
        $responseJson = array(
          'code'    => 404,
          'message' => 'not found'
        );
      }
    } catch (\Throwable $th) {
      $responseJson = array(
        'code'    => $th->getCode(),
        'message' => $th->getMessage(),
        'meta'    => [
          'function' => 'VisitHistoryRepository - getPayloadById'
        ]
      );
    }

    return $responseJson;
  }

  public function getDataHistory()
  {
    try {
      $payloadList = $this->historyModel->joinList()->get();
      $responseJson = array(
        'code'    => 200,
        'message' => 'success get data',
        'data'    => $payloadList,
        'meta'    => [
          'total' => $payloadList->count()
        ]
      );
    } catch (\Exception $th) {
      $responseJson = array(
        'code'    => 500,
        'message' => $th->getMessage(),
        'meta'    => [
          'function' => 'VisitHistoryRepository - getAllPayload'
        ]
      );
    }
    return $responseJson;
  }
}
