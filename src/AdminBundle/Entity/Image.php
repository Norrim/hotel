<?php

namespace AdminBundle\Entity;

use AdminBundle\Lib\Globals;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="image")
 * 
 * @author Vincent TIERTANT <vinz.tiertant@gmail.com>
 */
class Image
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @Assert\File(maxSize="1000k")
     */
    public $file;

    /**
     * @ORM\OneToMany(
     *   targetEntity = "ImageTranslation",
     *   mappedBy     = "image",
     *   cascade      = {"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * @ORM\ManyToOne(targetEntity="AdminBundle\Entity\Room", cascade={"persist"})
     * @ORM\JoinColumn(
     *     nullable = true
     * )
     */
    private $room;

    /**
     * @ORM\ManyToOne(targetEntity="Content", cascade={"persist"})
     * @ORM\JoinColumn(
     *     nullable = true
     * )
     */
    private $content;

    public function __construct(array $locales = [])
    {
        $this->translations = new ArrayCollection();

        foreach(Globals::getLocales() as $locale)
        {
            $imageTranslation = new ImageTranslation();
            $imageTranslation->setLocale($locale);
            $this->addTranslation($imageTranslation);
        }

    }

    /**
     * @param ImageTranslation $translation
     *
     * @return $this
     */
    public function addTranslation(ImageTranslation $translation)
    {
        $this->translations[] = $translation;
        $translation->setImage($this);

        return $this;
    }

    /**
     * @param ArrayCollection $translations
     */
    public function setTranslations($translations)
    {
        $this->translations->clear();
        foreach ($translations as $translation) {
            $this->addTranslation($translation);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param Room $room
     */
    public function setRoom(Room $room)
    {
        $this->room = $room;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getWebPath()
    {
        return null === $this->url ? null : $this->getUploadImageDir().'/'.$this->url;
    }

    protected function getUploadImageRootDir()
    {
//        dump(__DIR__.'/../../../../web/'.$this->getUploadImageDir());
//        dump(Globals::getUploadRootDir());die;
        // le chemin absolu du répertoire dans lequel sauvegarder les photos de profil
        return Globals::getUploadImageRootDir();
    }

    protected function getUploadImageDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
//        return 'uploads/images/';
        return Globals::getUploadImageDir();
    }

    public function uploadImage()
    {
        // Nous utilisons le nom de fichier original, donc il est dans la pratique
        // nécessaire de le nettoyer pour éviter les problèmes de sécurité
        $filename = $this->file->getClientOriginalName();
        $tabFileName = explode(".",$filename);

        $extension = $tabFileName[1];
        $filename = $this->slugify($this->getTitle())."-".time().".".$extension;

        if(strtolower($extension) == "jpg" || strtolower($extension) == "jpeg" || strtolower($extension) == "png" || strtolower($extension) == "gif") {
            // move copie le fichier présent chez le client dans le répertoire indiqué.
            $this->file->move($this->getUploadImageRootDir(), $filename);

            // On sauvegarde le nom de fichier
            $this->url = $this->getUploadImageDir().$filename;

            // La propriété file ne servira plus
            $this->file = null;
        }
        else {
            throw new Exception('Extension de fichier non autorisé (mettre une image jpg, png ou gif)');
        }
    }

    public function renameImage()
    {
        if(file_exists($this->url)) {
            $tabFileName = explode(".",$this->url);
            $extension = $tabFileName[1];
            $filename = $this->slugify($this->getTitle())."-".time().".".$extension;
            $filename = $this->getUploadImageDir().$filename;
            rename($this->url, $filename);
            $this->url = $filename;
        }
    }

    public function unlinkImage()
    {
        if(file_exists($this->url)) {
            unlink($this->url);
        }
    }

    /**
     * Transliteration (convert foreign and special characters to their ASCII equivalent)
     *
     * @access public static
     * @param string $string The to transliterate.
     * @return string The filtered text.
     */
    protected function translit($string) {
        $search = array(
            'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'A', 'A',
            'Ç', 'C', 'C',
            'D', 'Ð',
            'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'a', 'a',
            'ç', 'c', 'c',
            'd', 'd',
            'È', 'É', 'Ê', 'Ë', 'E', 'E',
            'G',
            'Ì', 'Í', 'Î', 'Ï', 'I',
            'L', 'L', 'L',
            'è', 'é', 'ê', 'ë', 'e', 'e',
            'g',
            'ì', 'í', 'î', 'ï', 'i',
            'l', 'l', 'l',
            'Ñ', 'N', 'N',
            'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'O', 'Œ',
            'R', 'R',
            'S', 'S', 'Š',
            'ñ', 'n', 'n',
            'ò', 'ó', 'ô', 'ö', 'ø', 'o', 'œ',
            'r', 'r',
            's', 's', 'š',
            'T', 'T',
            'Ù', 'Ú', 'Û', 'U', 'Ü', 'U', 'U',
            'Ý', 'ß',
            'Z', 'Z', 'Ž',
            't', 't',
            'ù', 'ú', 'û', 'u', 'ü', 'u', 'u',
            'ý', 'ÿ',
            'z', 'z', 'ž',
            '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?',
            '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?',
            '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?',
            '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?',
            '$', '€', '£'
        );

        $replace = array(
            'A', 'A', 'A', 'A', 'A', 'A', 'AE', 'A', 'A',
            'C', 'C', 'C',
            'D', 'D',
            'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'a', 'a',
            'c', 'c', 'c',
            'd', 'd',
            'E', 'E', 'E', 'E', 'E', 'E',
            'G',
            'I', 'I', 'I', 'I', 'I',
            'L', 'L', 'L',
            'e', 'e', 'e', 'e', 'e', 'e',
            'g',
            'i', 'i', 'i', 'i', 'i',
            'l', 'l', 'l',
            'N', 'N', 'N',
            'O', 'O', 'O', 'O', 'O', 'O', 'O', 'OE',
            'R', 'R',
            'S', 'S', 'S',
            'n', 'n', 'n',
            'o', 'o', 'o', 'o', 'o', 'o', 'oe',
            'r', 'r',
            's', 's', 's',
            'T', 'T',
            'U', 'U', 'U', 'U', 'U', 'U', 'U',
            'Y', 'Y',
            'Z', 'Z', 'Z',
            't', 't',
            'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'y', 'y',
            'z', 'z', 'z',
            'A', 'B', 'B', 'r', 'A', 'E', 'E', 'X', '3', 'N', 'N', 'K', 'N', 'M', 'H', 'O', 'N', 'P',
            'a', 'b', 'b', 'r', 'a', 'e', 'e', 'x', '3', 'n', 'n', 'k', 'n', 'm', 'h', 'o', 'p',
            'C', 'T', 'Y', 'O', 'X', 'U', 'u', 'W', 'W', 'b', 'b', 'b', 'E', 'O', 'R',
            'c', 't', 'y', 'o', 'x', 'u', 'u', 'w', 'w', 'b', 'b', 'b', 'e', 'o', 'r',
            'USD', 'EUR', 'GBP'
        );

        return str_replace($search, $replace, $string);
    }

    /**
     * Rewrite a text to its URL compatible equivalent.
     *
     * @access public static
     * @param string $string The text to convert.
     * @return string The converted URL.
     */
    protected function slugify($string) {
        $string = htmlspecialchars_decode($string); // ie: &amp; to &
        $string = $this->translit($string); // ie: é to e
        $string = preg_replace('/[^A-Za-z0-9]+/', '-', $string); // ie: _ to -
        $string = trim($string, '-'); // ie: -string- to string
        $string = mb_strtolower($string); // ie: E to e

        return $string;
    }

    /**
     * @return Content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param Content $content
     */
    public function setContent(Content $content)
    {
        $this->content = $content;
    }
}
