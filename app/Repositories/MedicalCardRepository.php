<?php

namespace App\Repositories;

use App\Interfaces\MedicalCardInterfaces;
use App\Models\medical_card;

class MedicalCardRepository implements MedicalCardInterfaces
{ 
    private medical_card $medicalcardModel;
    public function __construct(medical_card $medicalcardModel)
    {
      $this->medicalcardModel = $medicalcardModel;
    }
  
    public function getAllPayload(array $params)
    {
      try {
        $payloadList = $this->medicalcardModel->joinList()->get();
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
            'function' => 'MedicalCardRepository - getAllPayload'
          ]
        );
      }
      return $responseJson;
    }
    
    public function getPayloadById(int $idPayload)
    {
      try {
  
        $whereData = $this->medicalcardModel->whereId($idPayload)->first();
  
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
            'function' => 'MedicalCardRepository - getPayloadById'
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
    
            $whereData = $this->medicalcardModel->whereId($idPayload);
            $responseJson = array(
              'code'    => 200,
              'message' => 'success update data',
              'data'    => $whereData->update($payload)
            );
          } else {
            $responseJson = array(
              'code'    => 200,
              'message' => 'success create data',
              'data'    => $this->medicalcardModel->create($payload)
            );
          }
          
        } catch (\Throwable $th) {
          $responseJson = array(
            'code'    => $th->getCode(),
            'message' => $th->getMessage(),
            'meta'    => [
              'function' => 'MedicalCardRepository - upsertPayload'
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
  
        $whereData = $this->medicalcardModel->whereId($idPayload);
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
            'function' => 'MedicalCardRepository - deletePayload'
          ]
        );
      }
  
      return $responseJson;
    }
}
