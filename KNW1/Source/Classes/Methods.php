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
        echo $bildGroesse;
    }
}