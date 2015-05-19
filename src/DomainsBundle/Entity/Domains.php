<?php

namespace DomainsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Domains
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Domains
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
     * @ORM\Column(name="url", type="string", length=150)
     */
    private $url;

    /**
     * @var float
     *
     * @ORM\Column(name="linking", type="float")
     */
    private $linking;

    /**
     * @var float
     *
     * @ORM\Column(name="external", type="float")
     */
    private $external;

    /**
     * @var float
     *
     * @ORM\Column(name="mozrank", type="float")
     */
    private $mozrank;

    /**
     * @var float
     *
     * @ORM\Column(name="moztrust", type="float")
     */
    private $moztrust;


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
     * @return Domains
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
     * Set linking
     *
     * @param float $linking
     * @return Domains
     */
    public function setLinking($linking)
    {
        $this->linking = $linking;

        return $this;
    }

    /**
     * Get linking
     *
     * @return float 
     */
    public function getLinking()
    {
        return $this->linking;
    }

    /**
     * Set external
     *
     * @param float $external
     * @return Domains
     */
    public function setExternal($external)
    {
        $this->external = $external;

        return $this;
    }

    /**
     * Get external
     *
     * @return float 
     */
    public function getExternal()
    {
        return $this->external;
    }

    /**
     * Set mozrank
     *
     * @param float $mozrank
     * @return Domains
     */
    public function setMozrank($mozrank)
    {
        $this->mozrank = $mozrank;

        return $this;
    }

    /**
     * Get mozrank
     *
     * @return float 
     */
    public function getMozrank()
    {
        return $this->mozrank;
    }

    /**
     * Set moztrust
     *
     * @param float $moztrust
     * @return Domains
     */
    public function setMoztrust($moztrust)
    {
        $this->moztrust = $moztrust;

        return $this;
    }

    /**
     * Get moztrust
     *
     * @return float 
     */
    public function getMoztrust()
    {
        return $this->moztrust;
    }
}
