<?php

include "FaceDetector.php";

$imageSource = array(
	'name' => 'lena512color.jpg',
	'type' => 'jpeg'
);
$imageSource['size'] = getimagesize($imageSource['name']);
$imageOverlay = array(
	'name' => 'goathead.png',
	'type' => 'png'
);
$imageOverlay['size'] = getimagesize($imageOverlay['name']);
$detector = new svay\FaceDetector('detection.dat');

$detector->faceDetect($imageSource['name']);
$face = $detector->getFace();
$faceOffset = array(
	'x' => -50,
	'y' => -100
);
$facePos = array(
	'x' => $face['x'] + $faceOffset['x'],
	'y' => $face['y'] + $faceOffset['y'],
);

header('Content-Type: image/png');
$canvas = imagecreatetruecolor(512, 512);

$imageSource['func'] = 'imagecreatefrom' . $imageSource['type'];
$imageOverlay['func'] = 'imagecreatefrom' . $imageOverlay['type'];
$imageSource['img'] = $imageSource['func']($imageSource['name']);
$imageOverlay['img'] = $imageOverlay['func']($imageOverlay['name']);

imagecopy($canvas, $imageSource['img'], 0, 0, 0, 0, $imageSource['size'][0], $imageSource['size'][1]);
imagecopy($canvas, $imageOverlay['img'], $facePos['x'], $facePos['y'], 0, 0, $imageOverlay['size'][0], $imageOverlay['size'][1]);
imagejpeg($canvas);
