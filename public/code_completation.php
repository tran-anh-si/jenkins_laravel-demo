<?php     

/**
 * @method \DateTime datetime() Description
 */
class Baz5
{
    private $container;

    public function __get($name)
    {
        return $this->container[$name];
    }
}

$baz5 = new Baz5();
$datetime = $baz5->
        
/**
 * @property integer $id
 * @property string $title
 * @property string $body
 */
class Baz6
{
}

$baz6 = new Baz6();
$baz6->