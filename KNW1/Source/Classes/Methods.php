<?php
/**
 * Created by PhpStorm.
 * User: i02401202
 * Date: 18.03.2016
 * Time: 14:12
 */
class Methods
{
    private $pictureSize;
    
    function GetPictureSize($picture)
    {
        $bildGroesse = getimagesize($picture);
        return $bildGroesse;
    }

    function CreatePanoramaLeinwand()
    {
        $this->pictureSize = $this->GetPictureSize('../../Image/pictureRight.jpg');
        $leinwand = imagecreatetruecolor($this->pictureSize[0]+$this->pictureSize[0]+$this->pictureSize[0],$this->pictureSize[1]);
        $this->CreatePanorama($leinwand);
        imagepng($leinwand,'../../Image/Panorama/Panorama.jpg');
    }

    function CreatePanorama($bild)
    {
        $pic3 = imagecreatefromjpeg('../../Image/pictureLeft.jpg');
        $pic2 = imagecreatefromjpeg('../../Image/pictureCenter.jpg');
        $pic1 = imagecreatefromjpeg('../../Image/pictureRight.jpg');
        //$pictureSize = $this->GetPictureSize('../../Image/Panorama.jpg');
        imagecopy($bild,$pic3,0,0,0,0,$this->pictureSize[0],$this->pictureSize[1]);
        imagecopy($bild,$pic2,640,0,0,0,$this->pictureSize[0],$this->pictureSize[1]);
        imagecopy($bild,$pic1,1280,0,0,0,$this->pictureSize[0],$this->pictureSize[1]);
    }

    function MoveCam()
    {
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=home','r');
        sleep(2);
        $imageCenter = file_get_contents('http://10.142.116.156/cgi-bin/video.jpg');
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=left','r');
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=left','r');
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=left','r');
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=left','r');
        sleep(2);
        $imageLeft = file_get_contents('http://10.142.116.156/cgi-bin/video.jpg');
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=home','r');
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=right','r');
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=right','r');
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=right','r');
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=right','r');
        sleep(2);
        $imageRight = file_get_contents('http://10.142.116.156/cgi-bin/video.jpg');

        file_put_contents('../../Image/pictureCenter.jpg',$imageCenter);
        file_put_contents('../../Image/pictureLeft.jpg',$imageLeft);
        file_put_contents('../../Image/pictureRight.jpg',$imageRight);
    }
}