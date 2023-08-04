<?php

namespace App\Repositories;

use App\Interfaces\AttachmentInterfaces;
use App\Models\attachment;
use App\Models\poly;

class AttachmentRepository implements AttachmentInterfaces
{ 
  private attachment $attachmentModel;
  public function __construct(attachment $attachmentModel)
  {
    $this->attachmentModel = $attachmentModel;
  }

  public function getAllPayload(array $params)
  {
    try {
      $payloadList = $this->attachmentModel->all();
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
          'function' => 'AttachmentRepository - getAllPayload'
        ]
      );
    }
    return $responseJson;
  }
  
  public function getPayloadById(int $idPayload)
  {
    try {

      $whereData = $this->attachmentModel->whereId($idPayload)->first();

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
          'function' => 'AttachmentRepository - getPayloadById'
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
  
          $whereData = $this->attachmentModel->whereId($idPayload);
          $responseJson = array(
            'code'    => 200,
            'message' => 'success update data',
            'data'    => $whereData->update($payload)
          );
        } else {
          $responseJson = array(
            'code'    => 200,
            'message' => 'success create data',
            'data'    => $this->attachmentModel->create($payload)
          );
        }
        
      } catch (\Throwable $th) {
        $responseJson = array(
          'code'    => $th->getCode(),
          'message' => $th->getMessage(),
          'meta'    => [
            'function' => 'AttachmentRepository - upsertPayload'
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

      $whereData = $this->attachmentModel->whereId($idPayload);
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
          'function' => 'AttachmentRepository - deletePayload'
        ]
      );
    }

    return $responseJson;
  }
}
