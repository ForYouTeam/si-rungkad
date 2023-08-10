<?php

namespace App\Interfaces;

interface DoctorProfileInterfaces {

  public function getAllPayload(array $params);
  public function getPayloadById(int $idPayload);
  public function upsertPayload($idPayload, array $payload);
  public function deletePayload(int $idPayload);
}