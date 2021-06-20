<?php
namespace App\Interfaces;

/**
 * This is generic interface for all "generator" like objects
 */
interface CampervanGenerator
{
    /**
     * All "generators" should implement public generate method
     */
    public function generate(): void;
}