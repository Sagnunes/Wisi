<?php

declare(strict_types=1);

namespace App\Enums;

enum Role: int
{
    case WATCHER = 1;

    public const VIEW = 'ver-perfis';

    public const CREATE = 'criar-perfis';

    public const UPDATE = 'atualizar-perfis';

    public const DELETE = 'apagar-perfis';

    public const ASSIGN = 'atribuir-perfil';

    public function getName(): string
    {
        return match ($this) {
            self::WATCHER => 'Watcher',
            default => 'Unknown',
        };
    }
}
