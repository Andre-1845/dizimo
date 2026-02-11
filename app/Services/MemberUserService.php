<?php

namespace App\Services;

use App\Models\Member;
use App\Models\User;
use App\Notifications\InviteUserNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class MemberUserService
{
    /**
     * Cria um USER a partir de um MEMBER, se necessário,
     * e envia e-mail de verificação.
     */
    public function createUserIfNeeded(Member $member, ?string $email, ?string $userName = null): void
    {
        if ($member->user) {
            return;
        }

        $user = User::create([
            'name' => $member->name,
            'email' => $email,
            'password' => bcrypt(Str::random(16)), // senha temporária
            'status_id' => 2, // ATIVO
            // Email is considered verified because access is granted via secure invite link
            'email_verified_at' => now(),
        ]);

        $user->assignRole('membro');

        $member->user()->associate($user);
        $member->save();

        // 🔑 ENVIA LINK DE DEFINIÇÃO DE SENHA (convite)
        Password::sendResetLink(['email' => $user->email]);
    }
}
