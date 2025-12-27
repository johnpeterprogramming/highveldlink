<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.marketing')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255',
                function($attribute, $value, $fail) {
                    $user = User::where('email', $value)->first();
                    if ($user?->is_guest === false)
                        $fail('This email has already been taken.');
                }],
            'phone' => ['required', 'string', 'max:11', 'min:10'], // TODO: add advanced validation for phone numbers
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::firstOrCreate(
            [
                'email' => $validated['email']
            ],
            [
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'password' => $validated['password'],
                'is_guest' => false
            ]
        );

        if (!$user->wasRecentlyCreated) {
            $user->update(['is_guest' => false]);
        }

        event(new Registered($user));

        Auth::login($user);

        Session::regenerate();

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }
}
