<?php

namespace App\Repositories;

use App\Interfaces\DoctorProfileInterfaces;
use App\Models\Doctor;

class DoctorProfileRepository implements DoctorProfileInterfaces
{ 
    private Doctor $doctorprofileModel;
    public function __construct(Doctor $doctorprofileModel)
    {
      $this->doctorprofileModel = $doctorprofileModel;
    }
  
    public function getAllPayload(array $params)
    {
      try {
        $payloadList = $this->doctorprofileModel->all();
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
            'function' => 'DoctorProfileRepository - getAllPayload'
          ]
        );
      }
      return $responseJson;
    }
    
    public function getPayloadById(int $idPayload)
    {
      try {
  
        $whereData = $this->doctorprofileModel->whereId($idPayload)->first();
  
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
            'function' => 'DoctorProfileRepository - getPayloadById'
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
    
            $whereData = $this->doctorprofileModel->whereId($idPayload);
            $responseJson = array(
              'code'    => 200,
              'message' => 'success update data',
              'data'    => $whereData->update($payload)
            );
          } else {
            $responseJson = array(
              'code'    => 200,
              'message' => 'success create data',
              'data'    => $this->doctorprofileModel->create($payload)
            );
          }
          
        } catch (\Throwable $th) {
          $responseJson = array(
            'code'    => $th->getCode(),
            'message' => $th->getMessage(),
            'meta'    => [
              'function' => 'DoctorProfileRepository - upsertPayload'
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
  
        $whereData = $this->doctorprofileModel->whereId($idPayload);
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
            'function' => 'DoctorProfileRepository - deletePayload'
          ]
        );
      }
  
      return $responseJson;
    }
}
