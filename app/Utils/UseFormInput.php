<?php

namespace App\Utils;

trait UseFormInput {
    public function updatedProductRequestPrice($value): void
    {
        $valueToNumber = $this->formatToNumber($value);
        if (is_numeric($valueToNumber)) {
            $this->productRequest->price = number_format($valueToNumber, 2);
        }
    }

    public function updatedProductRequestPurchasePrice($value): void
    {
        $valueToNumber = $this->formatToNumber($value);
        if (is_numeric($valueToNumber)) {
            $this->productRequest->purchasePrice = number_format($valueToNumber, 2);
        }
    }
    public function updatedProductVariantRequestPrice($value): void
    {
        $valueToNumber = $this->formatToNumber($value);
        if (is_numeric($valueToNumber)) {
            $this->productVariantRequest->price = number_format($valueToNumber, 2);
        }
    }

    public function updatedProductVariantRequestPurchasePrice($value): void
    {
        $valueToNumber = $this->formatToNumber($value);
        if (is_numeric($valueToNumber)) {
            $this->productVariantRequest->purchasePrice = number_format($valueToNumber, 2);
        }
    }
}