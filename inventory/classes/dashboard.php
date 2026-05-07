<?php
require_once("classes/produk.php");
require_once("classes/transaksi.php");

class dashboard {
    private $produk;
    private $transaksi;

    public function __construct() {
        $this->produk = new produk();
        $this->transaksi = new transaksi();
    }

    public function getStockSummary() {
        return $this->produk->readAll();
    }

    public function getLowStockAlerts() {
        return $this->produk->getLowStock();
    }

    public function getTransactionSummary() {
        return $this->transaksi->readAll();
    }
}