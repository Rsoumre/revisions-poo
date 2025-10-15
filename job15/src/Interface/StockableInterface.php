<?php
namespace App\Interface;

// Interface pour gérer les stocks
interface StockableInterface
{
    public function addStocks(int $stock): self;
    public function removeStocks(int $stock): self;
}
