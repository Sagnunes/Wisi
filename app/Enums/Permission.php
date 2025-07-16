<?php

declare(strict_types=1);

namespace App\Enums;

enum Permission: string
{
    public const VIEW = 'ver-permissoes';

    public const CREATE = 'criar-permissoes';

    public const UPDATE = 'atualizar-permissoes';

    public const DELETE = 'apagar-permissoes';

    public const ASSIGN = 'atribuir-permissao';
}
