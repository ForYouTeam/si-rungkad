<?php

namespace App\Repositories;

use App\Interfaces\PolyInterfaces;
use App\Models\Poly;

class PolyRepository implements PolyInterfaces
{ 
  private Poly $polyModel;
  public function __construct(Poly $polyModel)
  {
    $this->polyModel = $polyModel;
  }

  public function getAllPayload(array $params)
  {
    try {
      $payloadList = $this->polyModel->all();
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
          'function' => 'PolyInterfaces - getAllPayload'
        ]
      );
    }
    return $responseJson;
  }
  
  public function getPayloadById(int $idPayload)
  {
    try {

      $whereData = $this->polyModel->whereId($idPayload)->first();

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
          'function' => 'PolyInterfaces - getPayloadById'
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
  
          $whereData = $this->polyModel->whereId($idPayload);
          $responseJson = array(
            'code'    => 200,
            'message' => 'success update data',
            'data'    => $whereData->update($payload)
          );
        } else {
          $responseJson = array(
            'code'    => 200,
            'message' => 'success create data',
            'data'    => $this->polyModel->create($payload)
          );
        }
        
      } catch (\Throwable $th) {
        $responseJson = array(
          'code'    => $th->getCode(),
          'message' => $th->getMessage(),
          'meta'    => [
            'function' => 'PolyInterfaces - upsertPayload'
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

      $whereData = $this->polyModel->whereId($idPayload);
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
          'function' => 'PolyInterfaces - deletePayload'
        ]
      );
    }

    return $responseJson;
  }
}
