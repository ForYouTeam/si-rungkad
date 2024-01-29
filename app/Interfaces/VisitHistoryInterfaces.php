<?php

namespace App\Interfaces;

interface VisitHistoryInterfaces {

  public function getAllPayload(array $params);
  public function getPayloadById(int $idPayload);
}