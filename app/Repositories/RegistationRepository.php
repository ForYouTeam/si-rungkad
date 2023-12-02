<?php

namespace App\Repositories;

use App\Interfaces\RegistationInterfaces;
use App\Models\registation;
use App\Models\schedule;

class RegistationRepository implements RegistationInterfaces
{ 
    private registation $registationModel;
    public function __construct(registation $registationModel)
    {
      $this->registationModel = $registationModel;
    }
  
    public function getAllPayload(array $params)
    {
      try {
        $payloadList = $this->registationModel->joinList()->get();
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
            'function' => 'RegistationRepository - getAllPayload'
          ]
        );
      }
      return $responseJson;
    }
    
    public function getPayloadById(int $idPayload)
    {
      try {
  
        $whereData = $this->registationModel->whereId($idPayload)->first();
  
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
            'function' => 'RegistationRepository - getPayloadById'
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
    
            $whereData = $this->registationModel->whereId($idPayload);
            $responseJson = array(
              'code'    => 200,
              'message' => 'success update data',
              'data'    => $whereData->update($payload)
            );
          } else {
            $responseJson = array(
              'code'    => 200,
              'message' => 'success create data',
              'data'    => $this->registationModel->create($payload)
            );
          }
          
        } catch (\Throwable $th) {
          $responseJson = array(
            'code'    => $th->getCode(),
            'message' => $th->getMessage(),
            'meta'    => [
              'function' => 'RegistationRepository - upsertPayload'
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
  
        $whereData = $this->registationModel->whereId($idPayload);
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
            'function' => 'RegistationRepository - deletePayload'
          ]
        );
      }
  
      return $responseJson;
    }
}
