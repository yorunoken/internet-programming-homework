<?php

function imageToAscii($imagePath, $width = 100, $height = 100)
{
    $asciiChars = "@%#*+=-:. ";

    // Creating the image component
    $image = imagecreatefromjpeg($imagePath);
    $imageWidth = imagesx($image);
    $imageHeight = imagesy($image);

    $asciiImage = "";

    // Start looping from the y coords.
    for ($y = 0; $y < $height; $y++) {
        // Start looping from the x coords inside y, this means the image processing will go left to right, top to bottom.
        for ($x = 0; $x < $width; $x++) {
            // Take the image's colors at the specific coords we're at right now, and extract its rgb and brightness values
            $pixelColor = imagecolorat($image, ($x * $imageWidth) / $width, ($y * $imageHeight) / $height);
            $r = ($pixelColor >> 16) & 0xff;
            $g = ($pixelColor >> 8) & 0xff;
            $b = $pixelColor & 0xff;
            $brightness = $r * 0.2126 + $g * 0.7152 + $b * 0.0722;

            // Convert the brightness into ASCII characters and add it to asciiImage
            $asciiImage .= $asciiChars[intval($brightness / 25)];
        }

        // Go to the next line because we're done with the row
        $asciiImage .= PHP_EOL; // Essentially same as "\n"
    }

    return $asciiImage;
}

$imagePaths = array_map("basename", glob("./imgs/*"));

$asciiFrames = [];
foreach ($imagePaths as $imagePath) {
    $ascii = imageToAscii("./imgs/" . $imagePath);
    array_push($asciiFrames, $ascii);
}

echo json_encode($asciiFrames);

?>
