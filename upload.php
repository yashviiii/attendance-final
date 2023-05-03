<?php

require_once "vendor/autoload.php";

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;

// Configure Azure Blob Storage credentials


// Create a new Blob REST proxy using the Azure Blob Storage credentials
$blobRestProxy = BlobRestProxy::createBlobService("DefaultEndpointsProtocol=https;AccountName=yashvicontainer;AccountKey=2zP6LiWR2ye+uGe2hQK0D+0uTn0LLUgQiiiKYW0xcZx2R+IWkOYZArBbrXcWTzaFNz0qpic73f9C+AStaqyRQw==;EndpointSuffix=core.windows.net");

// Capture an image using the web cam
$image = $_FILES['image']['tmp_name'];


// Generate a unique blob name
$blobName = 'image_' . uniqid() . '.jpg';



// Upload the image to Azure Blob Storage
$createBlobOptions = new CreateBlockBlobOptions();
$createBlobOptions->setContentType("image/jpeg");
$blobRestProxy->createBlockBlob("yashvicontainer", $blobName, fopen($image, "r"), $createBlobOptions);
// Output a link to the uploaded image
echo "Image uploaded to Azure Blob Storage";


?>
