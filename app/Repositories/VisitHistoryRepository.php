<?php

namespace App\Repositories;

use App\Interfaces\VisitHistoryInterfaces;
use App\Models\visit_history;

class VisitHistoryRepository implements VisitHistoryInterfaces
{ 
    private visit_history $visithistoryModel;
    public function __construct(visit_history $visithistoryModel)
    {
      $this->visithistoryModel = $visithistoryModel;
    }
  
    public function getAllPayload(array $params)
    {
      try {
        $payloadList = $this->visithistoryModel->joinList()->get();
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
  
        $whereData = $this->visithistoryModel->whereId($idPayload)->first();
  
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
  
    public function upsertPayload($idPayload, array $payload)
    {
        try {
          if ($idPayload) {
            $findData = $this->getPayloadById($idPayload);
    
            if ($findData['code'] == 404) {
              return $findData;
            }
    
            $whereData = $this->visithistoryModel->whereId($idPayload);
            $responseJson = array(
              'code'    => 200,
              'message' => 'success update data',
              'data'    => $whereData->update($payload)
            );
          } else {
            $responseJson = array(
              'code'    => 200,
              'message' => 'success create data',
              'data'    => $this->visithistoryModel->create($payload)
            );
          }
          
        } catch (\Throwable $th) {
          $responseJson = array(
            'code'    => $th->getCode(),
            'message' => $th->getMessage(),
            'meta'    => [
              'function' => 'VisitHistoryRepository - upsertPayload'
            ]
          );
        }
    
        return $responseJson;
    }
  
    public function deletePayload(int $idPayload)
    {
      try {
        $findData = $this->getPayloadById($idPayload);
        if ($findData['code'] == 404) {
          return $findData;
        }
  
        $whereData = $this->visithistoryModel->whereId($idPayload);
        $responseJson = array(
          'code'    => 200,
          'message' => 'success delete data',
          'data'    => $whereData->delete()
        );
      } catch (\Throwable $th) {
        $responseJson = array(
          'code'    => $th->getCode(),
          'message' => $th->getMessage(),
          'meta'    => [
            'function' => 'VisitHistoryRepository - deletePayload'
          ]
        );
      }
  
      return $responseJson;
    }
}
