<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    // Carregar a view
    public function showLinkRequestForm()
    {

        return view('auth.forgot_password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // validar o formulario
        $request->validate(
            [
                'email' => 'required|email',
            ],
            [
                'email.required' => 'Campo EMAIL é obrigatório',
                'email.email' => 'Insira um EMAIL válido',
            ]
        );
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            Log::notice('Tentativa de recuperação de senha com e-mail não cadastrado.', ['email' => $request->email]);
            return back()->withInput()->with('error', 'E-mail não encontrado.');
        }

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            Log::info('Recuperar senha.', ['status' => $status, 'email' => $request->email]);

            return redirect()->route('login')->with('success', 'Foi enviado um e-mail com instruções para recuperar a senha. Acesse sua caixa de e-mail.');
        } catch (Exception $e) {
            Log::notice('Erro recuperar senha.', ['error' => $e->getMessage(), 'email' => $request->email]);

            return back()->withInput()->with('error', 'ERRO !! Tente novamente.');
        }
    }

    public function showRequestForm(Request $request)
    {

        // Recuperar os dados do usuario no BD atraves do email
        $user = User::where('email', $request->email)->first();
        //dd($request);
        // Verificar se encontrou o usuario no BD e se o TOKEN e valido
        if (!$user || !Password::tokenExists($user, $request->token)) {
            // Salvar LOG
            // dd($request->token);
            Log::notice('Token inválido ou expirado.', ['email' => $request->email ? $request->email : 'VAZIO']);

            // Redirecionar o usuario enviar MSG de sucesso
            return redirect()->route('login')->with('error', 'Token inválido ou expirado.');
        }

        // Carrega a VIEW
        return view('auth.reset_password', ['token' => $request->token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        // Validar o formulario
        $request->validate(
            [
                'email' => 'required|email|exists:users',
                'password' => 'required|confirmed|min:6',
            ],
            [
                'email.required' => 'Campo EMAIL é obrigatório',
                'email.email' => 'Insira o EMAIL cadastrado',
                'password.required' => 'Campo SENHA é obrigatório',
                'password.confirmed' => 'As SENHAS não são iguais !',
                'password.min' => 'Campo SENHA deve ter :min caracteres ou mais',
            ]
        );
        try {
            // RESET - redefinir a senha
            $status = Password::reset(
                //only - retorna APENAS os campos especificados
                $request->only('email', 'password', 'password_confirmation', 'token'),

                // Retornar o CALLBACK se a redefinicao de senha for bem-sucedida
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => $password
                    ]);

                    // Salvar as alteracoes
                    $user->save();
                }
            );

            // Salvar LOG
            Log::info('Senha atualizada', ['status' => $status, 'email' => $request->email]);

            // Redirecionar o Usuario e enviar as mensagens(sucesso ou erro)
            return $status === Password::PASSWORD_RESET ? redirect()->route('login')->with('success', 'Senha atualizada com sucesso!') : redirect()->route('login')->with('error', 'ERRO - Senha NÃO atualizada!');
        } catch (Exception $e) {
            // Salvar LOG
            Log::notice('Erro ao atualizar a senha.', ['error' => $e->getMessage(), 'email' => $request->email]);
            // Redirecionar o usuario
            return back()->withInput()->with('error', 'ERRO - Tente novamente.');
        };
    }
}
