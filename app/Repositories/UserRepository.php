<?php

namespace App\Repositories;

use App\Interfaces\UserInterfaces;
use App\Models\attachment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterfaces
{ 
  private User $userModel;
  public function __construct(User $userModel)
  {
    $this->userModel = $userModel;
  }

  public function getAllPayload(array $params)
  {
    try {
      $payloadList = $this->userModel->all();
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
          'function' => 'UserRepository - getAllPayload'
        ]
      );
    }
    return $responseJson;
  }
  
  public function getPayloadById(int $idPayload)
  {
    try {

      $whereData = $this->userModel->whereId($idPayload)->first();

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
          'function' => 'UserRepository - getPayloadById'
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

          $whereData = $this->userModel->whereId($idPayload);
          $responseJson = array(
            'code'    => 200,
            'message' => 'success update data',
            'data'    => $whereData->update($payload)
          );
        } else {
          $data = $this->userModel->create($payload);
          $responseJson = array(
            'code'    => 200,
            'message' => 'success create data',
            'data'    => $data
          );
          $data->assignRole('admin');
        }

      } catch (\Throwable $th) {
        $responseJson = array(
          'code'    => $th->getCode(),
          'message' => $th->getMessage(),
          'meta'    => [
            'function' => 'UserRepository - upsertPayload'
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

      $whereData = $this->userModel->whereId($idPayload);
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
          'function' => 'UserRepository - deletePayload'
        ]
      );
    }

    return $responseJson;
  }
}
