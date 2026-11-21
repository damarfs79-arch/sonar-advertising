<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Portfolios:\n";
$portfolios = App\Models\Portfolio::all(['main_image', 'gallery_images']);
echo json_encode($portfolios, JSON_PRETTY_PRINT) . "\n\n";

echo "Galleries:\n";
$galleries = App\Models\Gallery::all(['image_path']);
echo json_encode($galleries, JSON_PRETTY_PRINT) . "\n\n";
