try {
$u = App\Models\User::withTrashed()->firstOrNew(['email' => 'prod_test@ulasis.site']);
$u->name = 'Prod Tester';
$u->password = bcrypt('password');
$u->email_verified_at = now();
$u->tenant_id = null;
$u->deleted_at = null; // Restore if trashed
$u->save();
echo "RESET_SUCCESS";
} catch (\Exception $e) {
echo "ERROR: " . $e->getMessage();
}
exit();