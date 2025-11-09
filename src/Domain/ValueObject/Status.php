<?php declare(strict_types=1);

namespace Alumni\Domain\ValueObject;

enum Status: string {
    case Student = 'S';
    case Representative = 'R';
    case Teacher = 'T';
    case Director = 'D';
}