<?php

namespace App\DTO;

use App\Models\RowModel;

class RowDTO
{
    public static function toRowModel(string $row): RowModel
    {
        $inputRow = json_decode($row);
        $binModel = new RowModel();
        $binModel->setBin($inputRow->bin);
        $binModel->setAmount($inputRow->amount);
        $binModel->setCurrency($inputRow->currency);
        return $binModel;
    }
}
