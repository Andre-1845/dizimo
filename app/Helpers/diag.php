<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

$user = User::find(1);

echo "=== DIAGNOSTICO COMPLETO ===\n\n";

// 1. Usuário
echo "1. USUÁRIO:\n";
echo "   ID: {$user->id}\n";
echo "   Email: {$user->email}\n";
echo "   Roles: " . implode(', ', $user->getRoleNames()->toArray()) . "\n\n";

// 2. Permissões críticas
echo "2. PERMISSÕES CRÍTICAS:\n";
$critical = ['permissions.view', 'permissions.manage', 'roles.view'];
foreach ($critical as $perm) {
    $hasPerm = $user->can($perm);
    echo "   " . str_pad($perm, 20) . ": " . ($hasPerm ? '✓' : '✗') . "\n";
}

// 3. Todas permissões
echo "\n3. TOTAL DE PERMISSÕES:\n";
echo "   Usuário tem: " . $user->getAllPermissions()->count() . " permissões\n";

// 4. Role superadmin
echo "\n4. ROLE SUPERADMIN:\n";
$superadminRole = Role::where('name', 'superadmin')->first();
if ($superadminRole) {
    echo "   Existe? ✓\n";
    echo "   Permissões: " . $superadminRole->permissions->count() . "\n";
} else {
    echo "   ✗ NÃO ENCONTRADO!\n";
}

echo "\n=== FIM DIAGNOSTICO ===\n";