<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Tests\Controller;

use SymEdit\Bundle\CoreBundle\Tests\WebTestCase;

class PageControllerTest extends WebTestCase
{
    /**
     * @dataProvider fixtureUrlProvider
     */
    public function testPages($url)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function fixtureUrlProvider()
    {
        return array(
            array('/'),                         // Home
            array('/about'),                    // About
            array('/blog/'),                    // Blog
            array('/blog/hello-world'),         //  - Hello World
            array('/blog/category/general'),    //  - Category: General
        );
    }
}