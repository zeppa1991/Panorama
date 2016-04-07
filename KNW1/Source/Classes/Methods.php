<?php
/**
 * Created by PhpStorm.
 * User: i02401202
 * Date: 18.03.2016
 * Time: 14:12
 */
class Methods
{
    private $archiveArray;
    private $pictureSize;

    function GetPictureSize($picture)
    {
        $this->pictureSize = getimagesize($picture);
    }

    function CreatePanorama()
    {
        //To Do: Kamera bewegung hier einbauen
        $panoramaNumber = $this->CountFilesInArchive()+1;
        $this->GetPictureSize('../../Image/pictureRight.jpg');
        $screen = imagecreatetruecolor($this->pictureSize[0]+$this->pictureSize[0]+$this->pictureSize[0],$this->pictureSize[1]);
        $this->CreatePanoramaPicture($screen);

        if ($this->IsPanoramaFolderEmpty('../../Image/Panorama'))
        {
            imagepng($screen,'../../Image/Panorama/Panorama-'.$panoramaNumber.'.jpg');
        }
        else
        {
            if($this->IsArchiveFolderEmpty('../../Image/Archiv'))
            {
                $this->CopyCurrentPanoramaPictureToArchiv($screen,$panoramaNumber);
            }
            else
            {
                $this->CopyCurrentPanoramaPictureToArchiv($screen,$panoramaNumber);
            }
        }
    }

    function CopyCurrentPanoramaPictureToArchiv($screen,$panoramaNumber)
    {
        copy('../../Image/Panorama/Panorama-'.$panoramaNumber.'.jpg','../../Image/Archiv/Panorama-'.$panoramaNumber.'.jpg');
        unlink('../../Image/Panorama/Panorama-'.$panoramaNumber.'.jpg');
        $this->ConfigurateDateOfPanoramaPicture($panoramaNumber);
        imagepng($screen,'../../Image/Panorama/Panorama-'.($panoramaNumber+1).'.jpg');
    }

    function CreatePanoramaPicture($screen)
    {
        $picture3 = imagecreatefromjpeg('../../Image/pictureLeft.jpg');
        $picture2 = imagecreatefromjpeg('../../Image/pictureCenter.jpg');
        $picture1 = imagecreatefromjpeg('../../Image/pictureRight.jpg');
        imagecopy($screen,$picture3,0,0,0,0,$this->pictureSize[0],$this->pictureSize[1]);
        imagecopy($screen,$picture2,640,0,0,0,$this->pictureSize[0],$this->pictureSize[1]);
        imagecopy($screen,$picture1,1280,0,0,0,$this->pictureSize[0],$this->pictureSize[1]);
    }

    function TakePicturesWithCam() //TO DO: Bilder Richtig einstellen
    {
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=home','r');
        sleep(2);
        $imageCenter = file_get_contents('http://10.142.116.156/cgi-bin/video.jpg');
        $imageLeft = $this->MoveCamLeft();
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=home','r');
        $imageRight = $this->MoveCamRight();

        $this->SaveTakenPicturesFromCam($imageCenter, $imageLeft, $imageRight);
    }

    function IsPanoramaFolderEmpty($directory)
    {
        return (($files = @scandir($directory)) && count($files) <= 2);
    }

    function IsArchiveFolderEmpty($directory)
    {
        return (($files = @scandir($directory)) && count($files) <= 2);
    }

    function CountFilesInArchive()
    {
        $files = scandir('../../Image/Archiv');
        $files_count = count($files)-2;
        return $files_count;
    }

    /**
     * @return string
     */
    public function MoveCamLeft()
    {
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=left', 'r');
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=left', 'r');
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=left', 'r');
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=left', 'r');
        sleep(2);
        $imageLeft = file_get_contents('http://10.142.116.156/cgi-bin/video.jpg');
        return $imageLeft;
    }

    /**
     * @return string
     */
    public function MoveCamRight()
    {
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=right', 'r');
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=right', 'r');
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=right', 'r');
        fopen('http://10.142.116.156/cgi-bin/camctrl.cgi?move=right', 'r');
        sleep(2);
        $imageRight = file_get_contents('http://10.142.116.156/cgi-bin/video.jpg');
        return $imageRight;
    }

    /**
     * @param $imageCenter
     * @param $imageLeft
     * @param $imageRight
     */
    public function SaveTakenPicturesFromCam($imageCenter, $imageLeft, $imageRight)
    {
        file_put_contents('../../Image/pictureCenter.jpg', $imageCenter);
        file_put_contents('../../Image/pictureLeft.jpg', $imageLeft);
        file_put_contents('../../Image/pictureRight.jpg', $imageRight);
    }

    /**
     * @param $panoramaNumber
     */
    public function ConfigurateDateOfPanoramaPicture($panoramaNumber)
    {
        $createTime = filemtime('../../Image/Archiv/Panorama-' .$panoramaNumber.'.jpg');
        $newTime = $createTime - (5 * 60);
        touch('../../Image/Archiv/Panorama-'.$panoramaNumber.'.jpg', $newTime);
    }

    function GetDateOfArchiveFiles()
    {
        $files = scandir('../../Image/Archiv');
        $files_count = count($files);

        for($counter = 2; $counter<$files_count; $counter++)
        {
            $test = filemtime('../../Image/Archiv/'.$files[$counter]);
            $time = date ("d.m.Y H:i  ",$test);
            echo $time;
            echo '<br>';
        }
    }

    function SearcheForSelectedDateInFileArray($time)
    {
        $searchDate = $this->CreateSearchDate($time);

        $files = scandir('../../Image/Archiv');
        $files_count = count($files);

        for($counter = 2; $counter<$files_count; $counter++)
        {
            $test = filemtime('../../Image/Archiv/'.$files[$counter]);
            $file = date ("d.m.Y H:i  ",$test);

            if (strpos($file, $searchDate) !== FALSE)
            {
                $this->archiveArray[] = $files[$counter];
            }
        }
        return $this->archiveArray;
    }

    /**
     * @param $time
     * @return string
     */
    public function CreateSearchDate($time)
    {
        $day = substr($time, 8, -6);
        $month = substr($time, 5, -9);
        $year = substr($time, 0, -12);
        $hour = substr($time, 11, -3);
        $searchDate = $day . '.' . $month . '.' . $year . ' ' . $hour;
        return $searchDate;
    }
}