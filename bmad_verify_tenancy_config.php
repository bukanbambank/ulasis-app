<?php
if (!file_exists(__DIR__ . '/config/tenancy.php')) {
    echo "FAIL: config/tenancy.php missing\n";
    exit(1);
}
$config = file_get_contents(__DIR__ . '/config/tenancy.php');
if (
    strpos($config, 'Stancl\Tenancy\Bootstrappers\DatabaseTenancyBootstrapper::class') !== false &&
    strpos($config, '// Stancl\Tenancy\Bootstrappers\DatabaseTenancyBootstrapper::class') === false
) {
    echo "PASS: Database Bootstrapper is ENABLED (Red Phase for Single DB)\n";
    exit(0);
}
echo "FAIL: Database Bootstrapper already disabled or missing\n";
exit(1);
