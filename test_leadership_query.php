<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\DB;

$query = DB::table('members as m')
    ->leftJoin('chapters as c', 'm.chapter_id', '=', 'c.id')
    ->leftJoin('councils as co', 'm.council_id', '=', 'co.id')
    ->leftJoin('member_roles as r', 'm.role_id', '=', 'r.id')
    ->select('m.name', 'r.role_name', 'r.show_in_leadership', 'm.status')
    ->whereIn('m.status', ['Vetted', 'Active']);

$count = $query->count();
echo "Total Leaders Found: " . $count . "\n";

if ($count > 0) {
    $leaders = $query->limit(5)->get();
    foreach ($leaders as $leader) {
        echo "Name: {$leader->name}, Role: {$leader->role_name}, Show: {$leader->show_in_leadership}\n";
    }
} else {
    echo "No leaders found matching criteria.\n";
}
