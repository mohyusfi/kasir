<?php


namespace App\Services;

interface ProductService {
    public function create(): bool;
    public function update(): bool;
    public function delete(): bool;
}