<?php

namespace App\Repositories;

use App\Interfaces\ProfileInterfaces;
use App\Models\Profile;

class ProfileRepository implements ProfileInterfaces
{ 
    private Profile $profileModel;
    public function __construct(Profile $profileModel)
    {
      $this->profileModel = $profileModel;
    }
  
    public function getAllPayload(array $params)
    {
      try {
        $payloadList = $this->profileModel->all();
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
            'function' => 'ProfileRepository - getAllPayload'
          ]
        );
      }
      return $responseJson;
    }
    
    public function getPayloadById(int $idPayload)
    {
      try {
  
        $whereData = $this->profileModel->whereId($idPayload)->first();
  
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
            'function' => 'ProfileRepository - getPayloadById'
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
    
            $whereData = $this->profileModel->whereId($idPayload);
            $responseJson = array(
              'code'    => 200,
              'message' => 'success update data',
              'data'    => $whereData->update($payload)
            );
          } else {
            $responseJson = array(
              'code'    => 200,
              'message' => 'success create data',
              'data'    => $this->profileModel->create($payload)
            );
          }
          
        } catch (\Throwable $th) {
          $responseJson = array(
            'code'    => $th->getCode(),
            'message' => $th->getMessage(),
            'meta'    => [
              'function' => 'ProfileRepository - upsertPayload'
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
  
        $whereData = $this->profileModel->whereId($idPayload);
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
            'function' => 'ProfileRepository - deletePayload'
          ]
        );
      }
  
      return $responseJson;
    }
}
