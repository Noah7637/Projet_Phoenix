<?php

declare(strict_types=1);

namespace ProjetA2Phoenix2026;

namespace ProjetA2Phoenix2026\Models;

use PHPUnit\Framework\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ProjetA2Phoenix2026\Models\UserManager;
use ProjetA2Phoenix2026\Models\phoenixManager;
use ProjetA2Phoenix2026\Email;

use function PHPUnit\Framework\assertEmpty;

include 'src/config/config.php';

final class EmailTest extends TestCase
{
    protected $tm;
    protected $t;

    /**
     * @before
     */
    public function initTestEnvironment()
    {
        // cette méthode est exécutée avant chaque test
        $this->tm = new UserManager();
        $this->t = new phoenixManager();
    }

    public function testLogin()
    {

        $this->assertEquals(
            '18',
            $this->tm->find2('nono', 18)
        );
    }

    public function testOrder()
    {

        $this->assertEquals(
            '1',
            $this->t->find1('Les Boucaniers', 1)
        );
    }


    //     public function testLogin()
    // {

    //     $result = $this->tm->find2('daran', 0);
    //     return $result;
    // }
}