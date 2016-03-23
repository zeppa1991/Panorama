<?php

/**
 * Created by PhpStorm.
 * User: i02401202
 * Date: 18.03.2016
 * Time: 14:12
 */
class Methods
{
    function GetPictureSize()
    {
        $bildGroesse = getimagesize("../../Image/Baum.jpg");
        //print_r($bildGroesse);
        return $bildGroesse;
    }

    function CreatePanoramaPicture()
    {
        $pictureSize = $this->GetPictureSize();
        $leinwand = imagecreatetruecolor($pictureSize[0]+$pictureSize[0]+$pictureSize[0],$pictureSize[1]);
        $this->CreatePanorama($leinwand);
        imagepng($leinwand,"C:/xampp/htdocs/KNW1/Image/Panorama/Test.jpg");
    }

    function CreatePanorama($bild)
    {
        $pic = imagecreatefromjpeg('C:/xampp/htdocs/KNW1/Image/Baum.jpg');
        $picture = getimagesize('C:/xampp/htdocs/KNW1/Image/Baum.jpg');
        imagecopy($bild,$pic,0,0,0,0,$picture[1],$picture[0]);
        imagecopy($bild,$pic,400,0,0,0,$picture[1],$picture[0]);
        imagecopy($bild,$pic,800,0,0,0,$picture[1],$picture[0]);
    }
}