<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Password;

$user = User::first();
if (!$user) {
    echo "No user found.\n";
    exit;
}

echo "Attempting to send reset link to: " . $user->email . "\n";

try {
    $status = Password::sendResetLink(['email' => $user->email]);
    echo "Status: " . $status . " (" . __($status) . ")\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
