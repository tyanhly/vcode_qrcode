<?php
namespace Vcode\Qrcode;

class Image
{

    const JPG = "image/jpg";

    const PNG = "image/png";

    const GIF = "image/gif";

    const JPEG = "image/jpeg";

    /**
     * @var string
     */
    protected $_path;

    /**
     * @var string
     */
    protected $_binaryContent;

    /**
     * @var resource
     */
    protected $_resource;

    /**
     * @var array
     */
    protected $_info;

    /**
     * @var string
     */
    protected $_tmpPath;

    /**
     * @param string $path
     * @throws QrcodeException
     * @author Tung Ly
     */
    public function __construct($path)
    {
        $this->_tmpPath = sys_get_temp_dir() .'/' . uniqid('qrcode_') . '.png';
        $this->_path = $path;
        $this->_info = getimagesize($path);

        if ($this->_info) {
            $this->_binaryContent = file_get_contents($path);
            if (file_put_contents($this->_tmpPath, $this->_binaryContent)) {
                $this->_resource = self::getImageResource($this->_tmpPath, $this->getMimeType());
            }else{
                throw new QrcodeException(QrcodeException::CANNOT_CREATE_TMP_IMAGE);
            }
        }else{
            throw new QrcodeException(QrcodeException::CANNOT_INIT_IMAGE);
        }
    }

    /**
     * @return string
     * @author Tung Ly
     */
    public function getBinaryContent()
    {
        return $this->_binaryContent;
    }

    /**
     * @return string
     * @author Tung Ly
     */
    public function getTmpPath()
    {
        return $this->_tmpPath;
    }

    /**
     * @return string
     * @author Tung Ly
     */
    public function getPath()
    {
        return $this->_path;
    }

    /**
     * @return Ambigous <NULL, resource>
     * @author Tung Ly
     */
    public function getResource()
    {
        return $this->_resource;
    }

    /**
     * @return array
     * @author Tung Ly
     */
    public function getInfo()
    {
        return $this->_info;
    }

    /**
     * @return number
     * @author Tung Ly
     */
    public function getHeight()
    {
        return $this->_info[1];
    }

    /**
     * @return number
     * @author Tung Ly
     */
    public function getWidth()
    {
        return $this->_info[0];
    }

    /**
     * @return string
     * @author Tung Ly
     */
    public function getMimeType()
    {
        return $this->_info['mime'];
    }

    /**
     * @return string
     * @author Tung Ly
     */
    public function getBase64()
    {
        return base64_encode($this->_binaryContent);
    }

    /**
     * @param Image $srcImg
     * @param real $ratio
     * @author Tung Ly
     */
    public function mergeInCenter(Image $srcImg, $ratio = 0.3)
    {
        $ratio = ($ratio > 1) ? 1 : $ratio;

        $srcHeight = $srcImg->getHeight();
        $srcWidth = $srcImg->getWidth();

        $ratioWidth = $srcWidth / $this->getWidth();
        $ratioHeight = $srcHeight / $this->getHeight();

        $maxRatio = max(array(
            $ratioWidth,
            $ratioHeight
        ));
        $usedRatio = min(array(
            $maxRatio,
            $ratio
        ));

        $ratioHeightWidth = $srcHeight / $srcWidth;

        $scaleWidth = round($this->getWidth() * $usedRatio);
        $scaleHeight = round($scaleWidth * $ratioHeightWidth);

        $srcResource = $srcImg->getResource();
        if ($usedRatio != $maxRatio) {
            $tmpImageResource = imagecreatetruecolor($scaleWidth, $scaleHeight);
            imagecopyresized($tmpImageResource, $srcResource, 0, 0, 0, 0, $scaleWidth, $scaleHeight, $srcWidth, $srcHeight);
            $srcResource = $tmpImageResource;
        }

        $startHeight = round($this->getHeight() / 2 - $scaleHeight / 2);
        $startWidth = round($this->getWidth() / 2 - $scaleWidth / 2);

        imagecopymerge($this->_resource, $srcResource, $startWidth, $startHeight, 0, 0, $scaleWidth, $scaleHeight, 100);

        $this->storageImageTo($this->_tmpPath);
        $this->_binaryContent = file_get_contents($this->_tmpPath);
    }

    /**
     * @param string $destination
     * @author Tung Ly
     */
    public function storageImageTo($destination)
    {
        self::createImageFromResource($this->getResource(), $destination, $this->getMimeType());
    }

    /**
     * @param string $destination
     * @author Tung Ly
     */
    public function copyImageFromTmpTo($destination)
    {
        if (! copy($this->_tmpPath, $destination)) {
            throw  new \QrcodeException(QrcodeException::QRCODE_CANNOT_COPY);
        }
    }
    /**
     *
     * @author Tung Ly
     */
    public function destroy(){
        unset($this->_tmpPath);
        imagedestroy($this->_resource);
        die('destroy');
    }
    /**
     * @param string $path
     * @param string $type
     * @throws QrcodeException
     * @return Ambigous <NULL, resource>
     * @author Tung Ly
     */
    public static function getImageResource($path, $type)
    {
        $img = null;

        switch ($type) {
            case self::JPG:
                $img = imagecreatefromjpg($path);
                break;
            case self::PNG:
                $img = imagecreatefrompng($path);
                break;
            case self::GIF:
                $img = imagecreatefromgif($path);
                break;
            case self::JPEG:
                $img = imagecreatefromjpeg($path);
                break;
            default:
                throw new QrcodeException(QrcodeException::IMAGE_EXTENSION_NOT_SUPPORT);
        }
        return $img;
    }

    /**
     * @param resource $source
     * @param string $path
     * @param string $mimeType
     * @throws QrcodeException
     * @return Ambigous <NULL, boolean>
     * @author Tung Ly
     */
    public static function createImageFromResource($source, $path, $mimeType = self::PNG)
    {
        $img = null;
        switch ($mimeType) {
            case self::JPG:
                $img = imagejpg($source, $path);
                break;
            case self::PNG:
                $img = imagepng($source, $path);
                break;
            case self::GIF:
                $img = imagegif($source, $path);
                break;
            case self::JPEG:
                $img = imagejpeg($source, $path);
                break;
            default:
                throw new QrcodeException(QrcodeException::IMAGE_EXTENSION_NOT_SUPPORT);
        }
        return $img;
    }
}