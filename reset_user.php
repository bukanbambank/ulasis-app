$email = 'prod_test@ulasis.site';
$password = 'password';

$user = \App\Models\User::withTrashed()->where('email', $email)->first();

if (!$user) {
$user = new \App\Models\User();
$user->name = 'Prod Tester';
$user->email = $email;
$user->tenant_id = null;
echo "Creating new user...\n";
} else {
echo "Updating existing user...\n";
if ($user->trashed()) {
$user->restore();
}
}

$user->password = \Illuminate\Support\Facades\Hash::make($password);
$user->email_verified_at = now();
$user->save();

echo "User {$email} has been reset. Password: {$password}\n";
exit();