<?php

namespace App\Interfaces;

interface ScheduleInterfaces {

  public function getAllPayload(array $params);
  public function getPayloadById(int $idPayload);
  public function upsertPayload(array $payload);
  public function deletePayload(int $idPayload);
}