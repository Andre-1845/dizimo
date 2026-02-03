<?php

namespace App\Services;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberUserService
{
    /**
     * Cria um USER a partir de um MEMBER, se necessário,
     * e envia e-mail de verificação.
     */
    public function createUserIfNeeded(Member $member, ?string $email, ?string $userName = null): void
    {
        // Já é USER → não faz nada
        if ($member->user) {
            return;
        }

        // Ainda não virou USER
        if (!$email) {
            return;
        }

        $initialPassword = config('auth.default_user_password');
        $user = User::create([
            'name'     => $userName ?? $member->name,
            'email'    => $email,
            'password' => Hash::make($initialPassword), // senha temporária
        ]);

        /**
         *  Atribui papel MEMBRO
         */
        $user->assignRole('MEMBRO');


        $member->user()->associate($user);
        $member->save();

        // Envia e-mail de confirmação
        $user->sendEmailVerificationNotification();
    }
}
